<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncidentVerification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = IncidentVerification::with(['user', 'incident']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('comment', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $verifications = $query->latest()->paginate(15);

        return view('admin.verifications.index', compact('verifications'));
    }

    public function show(IncidentVerification $verification)
    {
        $verification->load(['user', 'incident']);
        return view('admin.verifications.show', compact('verification'));
    }

    public function destroy(IncidentVerification $verification)
    {
        $verification->delete();

        return redirect()->route('admin.verifications.index')
            ->with('success', 'Verification deleted successfully.');
    }
}
