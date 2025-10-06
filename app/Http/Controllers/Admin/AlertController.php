<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserAlert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index(Request $request)
    {
        $query = UserAlert::with(['user', 'incident']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('message', 'like', "%{$search}%");
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alerts = $query->latest()->paginate(15);

        return view('admin.alerts.index', compact('alerts'));
    }

    public function show(UserAlert $alert)
    {
        $alert->load(['user', 'incident']);
        return view('admin.alerts.show', compact('alert'));
    }

    public function destroy(UserAlert $alert)
    {
        $alert->delete();

        return redirect()->route('admin.alerts.index')
            ->with('success', 'Alert deleted successfully.');
    }
}
