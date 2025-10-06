<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('verified')) {
            $query->where('is_verified', $request->verified === 'yes');
        }

        $incidents = $query->latest()->paginate(15);

        $categories = Incident::select('category')->distinct()->pluck('category');
        $statuses = ['pending', 'in_progress', 'resolved'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        return view('admin.incidents.index', compact('incidents', 'categories', 'statuses', 'priorities'));
    }

    public function create()
    {
        return view('admin.incidents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved',
            'priority' => 'required|in:low,medium,high,urgent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'division' => 'required|string',
            'incident_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        Incident::create($request->all());

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident created successfully.');
    }

    public function show(Incident $incident)
    {
        $incident->load(['user', 'comments.user', 'verifications.user', 'media']);
        return view('admin.incidents.show', compact('incident'));
    }

    public function edit(Incident $incident)
    {
        return view('admin.incidents.edit', compact('incident'));
    }

    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|in:pending,in_progress,resolved',
            'priority' => 'required|in:low,medium,high,urgent',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'division' => 'required|string',
            'incident_date' => 'required|date',
        ]);

        $incident->update($request->all());

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident updated successfully.');
    }

    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->route('admin.incidents.index')
            ->with('success', 'Incident deleted successfully.');
    }

    public function toggleVerification(Incident $incident)
    {
        $incident->update(['is_verified' => !$incident->is_verified]);

        return response()->json([
            'success' => true,
            'is_verified' => $incident->is_verified,
            'message' => 'Incident verification status updated successfully.'
        ]);
    }

    public function updateStatus(Request $request, Incident $incident)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $incident->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status' => $incident->status,
            'message' => 'Incident status updated successfully.'
        ]);
    }
}
