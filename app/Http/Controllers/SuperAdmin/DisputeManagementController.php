<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Dispute;
use Illuminate\Http\Request;

class DisputeManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Dispute::with(['user', 'agency', 'booking']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $disputes = $query->latest()->paginate(15);

        $stats = [
            'pending' => Dispute::where('status', 'pending')->count(),
            'in_progress' => Dispute::where('status', 'in_progress')->count(),
            'resolved' => Dispute::where('status', 'resolved')->count(),
            'rejected' => Dispute::where('status', 'rejected')->count(),
        ];

        return view('superadmin.disputes.index', compact('disputes', 'stats'));
    }

    public function show(Dispute $dispute)
    {
        $dispute->load(['user', 'agency', 'booking', 'resolver']);
        return view('superadmin.disputes.show', compact('dispute'));
    }

    public function update(Request $request, Dispute $dispute)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'admin_response' => 'required_if:status,resolved,rejected|string',
        ]);

        $dispute->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'resolved_at' => in_array($request->status, ['resolved', 'rejected']) ? now() : null,
            'resolved_by' => in_array($request->status, ['resolved', 'rejected']) ? auth()->id() : null,
        ]);

        return back()->with('success', 'Dispute updated successfully');
    }
}
