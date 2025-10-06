<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentMedia::with(['incident']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('filename', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $media = $query->latest()->paginate(15);

        return view('admin.media.index', compact('media'));
    }

    public function show(IncidentMedia $media)
    {
        $media->load(['incident']);
        return view('admin.media.show', compact('media'));
    }

    public function destroy(IncidentMedia $media)
    {
        // Delete the actual file from storage
        if (Storage::exists($media->file_path)) {
            Storage::delete($media->file_path);
        }

        $media->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media deleted successfully.');
    }

    public function forceDelete(IncidentMedia $media)
    {
        // Force delete the media record
        $media->forceDelete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Media permanently deleted.');
    }
}
