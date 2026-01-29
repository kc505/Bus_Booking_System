<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\Request;

class AgencyManagementController extends Controller
{
    public function index()
    {
        $agencies = Agency::withCount(['routes', 'bookings'])
            ->with('admin')
            ->paginate(15);

        return view('superadmin.agencies.index', compact('agencies'));
    }

    public function suspend(Request $request, Agency $agency)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $agency->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspension_reason' => $request->reason,
        ]);

        // Suspend agency admin
        User::where('agency_id', $agency->id)
            ->where('role', 'agency_admin')
            ->update(['status' => 'suspended']);

        return back()->with('success', 'Agency suspended successfully');
    }

    public function activate(Agency $agency)
    {
        $agency->update([
            'status' => 'active',
            'suspended_at' => null,
            'suspension_reason' => null,
        ]);

        // Activate agency admin
        User::where('agency_id', $agency->id)
            ->where('role', 'agency_admin')
            ->update(['status' => 'active']);

        return back()->with('success', 'Agency activated successfully');
    }

    public function destroy(Agency $agency)
    {
        $agency->delete();
        return back()->with('success', 'Agency deleted successfully');
    }
}
