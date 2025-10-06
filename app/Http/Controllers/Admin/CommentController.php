<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentComment::with(['user', 'incident']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('content', 'like', "%{$search}%");
        }

        $comments = $query->latest()->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    public function show(IncidentComment $comment)
    {
        $comment->load(['user', 'incident', 'parent', 'replies']);
        return view('admin.comments.show', compact('comment'));
    }

    public function destroy(IncidentComment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment deleted successfully.');
    }

    public function toggleStatus(IncidentComment $comment)
    {
        $comment->update(['is_active' => !$comment->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $comment->is_active,
            'message' => 'Comment status updated successfully.'
        ]);
    }
}
