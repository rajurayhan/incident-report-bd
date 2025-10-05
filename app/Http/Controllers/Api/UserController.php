<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentComment;
use App\Models\IncidentVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Get user statistics
     */
    public function stats(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $totalReports = Incident::where('user_id', $user->id)->count();
        $verifiedReports = Incident::where('user_id', $user->id)
            ->where('is_verified', true)
            ->count();

        return response()->json([
            'totalReports' => $totalReports,
            'verifiedReports' => $verifiedReports
        ]);
    }

    /**
     * Get user's incidents
     */
    public function incidents(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $incidents = Incident::where('user_id', $user->id)
            ->with(['user', 'media'])
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($incidents);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only(['name', 'email', 'phone', 'city']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if current password is correct
        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
                'errors' => ['current_password' => ['The current password is incorrect']]
            ], 422);
        }

        // Update password
        $user->update([
            'password' => \Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Get user's comments with related incidents
     */
    public function userComments(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comments = IncidentComment::where('user_id', $user->id)
            ->with(['incident' => function($query) {
                $query->select('id', 'title', 'category', 'status', 'created_at');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    /**
     * Get user's verifications with related incidents
     */
    public function userVerifications(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $verifications = IncidentVerification::where('user_id', $user->id)
            ->with(['incident' => function($query) {
                $query->select('id', 'title', 'category', 'status', 'created_at');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($verifications);
    }
}

