<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncidentVerificationController extends Controller
{
    /**
     * Store a new verification for an incident
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'verification_type' => 'required|in:confirm,dispute',
            'comment' => 'nullable|string|max:500',
            'verification_source' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $incident = Incident::findOrFail($id);

        // Check if user has already verified this incident
        $existingVerification = IncidentVerification::where('incident_id', $incident->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingVerification) {
            return response()->json([
                'message' => 'You have already verified this incident'
            ], 409);
        }

        $verification = IncidentVerification::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'verification_type' => $request->verification_type,
            'comment' => $request->comment,
            'verifier_name' => $user->name,
            'verification_source' => $request->verification_source,
        ]);

        // Update incident verification counts
        if ($request->verification_type === 'confirm') {
            $incident->increment('verification_count');
        } else {
            $incident->increment('dispute_count');
        }

        // Auto-verify incident if it has 3 or more confirmations
        if ($incident->verification_count >= 3 && !$incident->is_verified) {
            $incident->update(['is_verified' => true]);
        }

        // Load relationships for response
        $verification->load('user', 'incident');

        return response()->json([
            'message' => 'Verification recorded successfully',
            'verification' => $verification
        ], 201);
    }

    /**
     * Update a verification
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        $verification = IncidentVerification::findOrFail($id);

        // Check if user owns the verification
        if ($verification->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized to update this verification'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'verification_type' => 'sometimes|in:confirm,dispute',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $oldType = $verification->verification_type;
        
        $verification->update($request->only(['verification_type', 'comment']));

        // Update incident counts if verification type changed
        if ($request->has('verification_type') && $oldType !== $request->verification_type) {
            $incident = $verification->incident;
            
            if ($oldType === 'confirm') {
                $incident->decrement('verification_count');
                $incident->increment('dispute_count');
            } else {
                $incident->decrement('dispute_count');
                $incident->increment('verification_count');
            }
        }

        $verification->load('user', 'incident');

        return response()->json([
            'message' => 'Verification updated successfully',
            'verification' => $verification
        ]);
    }

    /**
     * Delete a verification
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        
        $verification = IncidentVerification::findOrFail($id);

        // Check if user owns the verification or is admin
        if ($verification->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized to delete this verification'
            ], 403);
        }

        $incident = $verification->incident;
        
        // Update incident counts
        if ($verification->verification_type === 'confirm') {
            $incident->decrement('verification_count');
        } else {
            $incident->decrement('dispute_count');
        }

        $verification->delete();

        return response()->json([
            'message' => 'Verification deleted successfully'
        ]);
    }
}
