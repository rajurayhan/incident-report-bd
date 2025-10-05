<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::with(['user', 'media', 'comments', 'verifications']);

        // Apply filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('verified')) {
            $query->where('is_verified', $request->boolean('verified'));
        }

        if ($request->has('latitude') && $request->has('longitude')) {
            $query->nearby($request->latitude, $request->longitude, $request->get('radius', 5));
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $incidents = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($incidents);
    }

    public function show($id)
    {
        $incident = Incident::with(['user', 'media', 'comments.user', 'verifications.user'])
            ->findOrFail($id);

        return response()->json($incident);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:theft_robbery,sexual_harassment,domestic_violence,suspicious_activities,traffic_accidents,drugs,cybercrime',
            'incident_date' => 'nullable|date',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'division' => 'nullable|string|max:255',
            'is_anonymous' => 'nullable|in:true,false,1,0,"true","false"',
            'reporter_name' => 'nullable|string|max:255',
            'reporter_phone' => 'nullable|string|max:20',
            'reporter_email' => 'nullable|email|max:255',
            'media' => 'nullable|array',
            'media.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,avi,mov|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $incidentData = $request->only([
            'title', 'description', 'category', 'incident_date',
            'latitude', 'longitude', 'address', 'city', 'district', 'division',
            'reporter_name', 'reporter_phone', 'reporter_email'
        ]);

        // Convert is_anonymous to proper boolean
        $incidentData['is_anonymous'] = filter_var($request->input('is_anonymous', false), FILTER_VALIDATE_BOOLEAN);

        // Set user_id if authenticated
        if ($request->user()) {
            $incidentData['user_id'] = $request->user()->id;
        }

        $incident = Incident::create($incidentData);

        // Handle media uploads
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('incidents/' . $incident->id, 'public');
                
                IncidentMedia::create([
                    'incident_id' => $incident->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video',
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Load relationships
        $incident->load(['user', 'media', 'comments', 'verifications']);

        return response()->json($incident, 201);
    }

    public function update(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);

        // Check if user can update this incident
        if ($request->user() && $incident->user_id !== $request->user()->id && !$request->user()->isModerator()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'category' => 'sometimes|in:theft_robbery,sexual_harassment,domestic_violence,suspicious_activities,traffic_accidents,drugs,cybercrime',
            'status' => 'sometimes|in:pending,in_progress,resolved',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'incident_date' => 'sometimes|date',
            'latitude' => 'sometimes|numeric|between:-90,90',
            'longitude' => 'sometimes|numeric|between:-180,180',
            'address' => 'sometimes|string|max:500',
            'city' => 'sometimes|string|max:255',
            'district' => 'sometimes|string|max:255',
            'division' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $incident->update($request->only([
            'title', 'description', 'category', 'status', 'priority',
            'incident_date', 'latitude', 'longitude', 'address',
            'city', 'district', 'division'
        ]));

        $incident->load(['user', 'media', 'comments', 'verifications']);

        return response()->json($incident);
    }

    public function destroy(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);

        // Check if user can delete this incident
        if ($request->user() && $incident->user_id !== $request->user()->id && !$request->user()->isModerator()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete associated media files
        foreach ($incident->media as $media) {
            Storage::disk('public')->delete($media->file_path);
        }

        $incident->delete();

        return response()->json(['message' => 'Incident deleted successfully']);
    }

    public function adminIndex(Request $request)
    {
        $query = Incident::with(['user', 'media', 'comments', 'verifications']);

        // Admin can see all incidents
        $perPage = $request->get('per_page', 15);
        $incidents = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($incidents);
    }

    public function updateStatus(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,in_progress,resolved',
            'priority' => 'sometimes|in:low,medium,high,urgent',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $incident->update($request->only(['status', 'priority']));

        return response()->json($incident);
    }

    public function mapData(Request $request)
    {
        $query = Incident::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with(['user', 'media']);

        // Apply filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('verified')) {
            $query->where('is_verified', $request->boolean('verified'));
        }

        if ($request->has('bounds')) {
            $bounds = $request->bounds;
            if (isset($bounds['north'], $bounds['south'], $bounds['east'], $bounds['west'])) {
                $query->whereBetween('latitude', [$bounds['south'], $bounds['north']])
                      ->whereBetween('longitude', [$bounds['west'], $bounds['east']]);
            }
        }

        // Get incidents with coordinates
        $incidents = $query->orderBy('created_at', 'desc')->get();

        // Format data for map
        $mapData = $incidents->map(function ($incident) {
            return [
                'id' => $incident->id,
                'title' => $incident->title,
                'description' => $incident->description,
                'category' => $incident->category,
                'category_label' => $incident->category_label,
                'status' => $incident->status,
                'status_label' => $incident->status_label,
                'priority' => $incident->priority,
                'priority_label' => $incident->priority_label,
                'is_verified' => $incident->is_verified,
                'verification_count' => $incident->verification_count,
                'dispute_count' => $incident->dispute_count,
                'verification_ratio' => $incident->verification_ratio,
                'latitude' => (float) $incident->latitude,
                'longitude' => (float) $incident->longitude,
                'address' => $incident->address,
                'city' => $incident->city,
                'district' => $incident->district,
                'division' => $incident->division,
                'incident_date' => $incident->incident_date,
                'created_at' => $incident->created_at,
                'media_count' => $incident->media->count(),
                'has_media' => $incident->media->count() > 0,
                'reporter_name' => $incident->is_anonymous ? 'Anonymous' : $incident->reporter_name,
            ];
        });

        return response()->json([
            'incidents' => $mapData,
            'total' => $mapData->count(),
            'bounds' => $this->calculateBounds($incidents)
        ]);
    }

    private function calculateBounds($incidents)
    {
        if ($incidents->isEmpty()) {
            return null;
        }

        $latitudes = $incidents->pluck('latitude')->filter();
        $longitudes = $incidents->pluck('longitude')->filter();

        if ($latitudes->isEmpty() || $longitudes->isEmpty()) {
            return null;
        }

        return [
            'north' => $latitudes->max(),
            'south' => $latitudes->min(),
            'east' => $longitudes->max(),
            'west' => $longitudes->min(),
        ];
    }
}
