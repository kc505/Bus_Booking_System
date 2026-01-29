<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->with('agency')->paginate(20);

        $stats = [
            'total' => User::count(),
            'passengers' => User::where('role', 'passenger')->count(),
            'agency_admins' => User::where('role', 'agency_admin')->count(),
            'checkin_staff' => User::where('role', 'checkin_staff')->count(),
            'active' => User::where('status', 'active')->count(),
            'suspended' => User::where('status', 'suspended')->count(),
        ];

        return view('superadmin.users.index', compact('users', 'stats'));
    }

    public function suspend(Request $request, User $user)
    {
        $user->update(['status' => 'suspended']);
        return back()->with('success', 'User suspended successfully');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success', 'User activated successfully');
    }
}
