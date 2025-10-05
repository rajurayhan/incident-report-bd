<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\IncidentComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IncidentCommentController extends Controller
{
    /**
     * Get paginated comments for an incident
     */
    public function index(Request $request, $id)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);
        
        $comments = IncidentComment::where('incident_id', $id)
            ->whereNull('parent_id') // Only top-level comments
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($comments);
    }

    /**
     * Store a new comment on an incident
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|uuid|exists:incident_comments,id',
            'mentioned_users' => 'nullable|array',
            'mentioned_users.*' => 'uuid|exists:users,id',
            'is_anonymous' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $incident = Incident::findOrFail($id);

        $comment = IncidentComment::create([
            'incident_id' => $incident->id,
            'parent_id' => $request->parent_id,
            'user_id' => $user->id,
            'content' => $request->content,
            'mentioned_users' => $request->mentioned_users,
            'is_anonymous' => $request->is_anonymous ?? false,
            'commenter_name' => $request->is_anonymous ? 'Anonymous User' : $user->name,
        ]);

        // Load relationships for response
        $comment->load('user', 'incident');

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment
        ], 201);
    }

    /**
     * Update a comment
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        $comment = IncidentComment::findOrFail($id);

        // Check if user owns the comment
        if ($comment->user_id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized to update this comment'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update([
            'content' => $request->content,
        ]);

        $comment->load('user', 'incident');

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment
        ]);
    }

    /**
     * Delete a comment
     */
    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        
        $comment = IncidentComment::findOrFail($id);

        // Check if user owns the comment or is admin
        if ($comment->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized to delete this comment'
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * Upvote a comment
     */
    public function upvote(Request $request, $id)
    {
        $comment = IncidentComment::findOrFail($id);
        $comment->increment('likes_count');

        return response()->json([
            'message' => 'Comment upvoted',
            'likes_count' => $comment->likes_count
        ]);
    }

    /**
     * Downvote a comment
     */
    public function downvote(Request $request, $id)
    {
        $comment = IncidentComment::findOrFail($id);
        $comment->increment('dislikes_count');

        return response()->json([
            'message' => 'Comment downvoted',
            'dislikes_count' => $comment->dislikes_count
        ]);
    }
}
