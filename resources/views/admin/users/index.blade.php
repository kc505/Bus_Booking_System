@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4" style="color: #1e293b;">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-black mb-0">User Management</h2>
            <p class="text-secondary small">{{ date('l, F j, Y') }}</p>
        </div>
        <button class="btn btn-primary px-4 shadow-sm fw-bold">
            <i class="bi bi-person-plus-fill me-2"></i>Add New User
        </button>
    </div>

    <!-- Stats Cards - FIXED WITH INLINE BACKGROUNDS -->
    <div class="row g-3 mb-5 text-white">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(45deg, #2563eb, #3b82f6);">
                <div class="card-body p-4">
                    <p class="text-uppercase small fw-bold mb-1 opacity-75">Total Users</p>
                    <h2 class="display-6 fw-black mb-0">{{ $stats['total_users'] ?? 4 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(45deg, #059669, #10b981);">
                <div class="card-body p-4">
                    <p class="text-uppercase small fw-bold mb-1 opacity-75">Active Users</p>
                    <h2 class="display-6 fw-black mb-0">{{ $stats['active_users'] ?? 4 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(45deg, #dc2626, #ef4444);">
                <div class="card-body p-4">
                    <p class="text-uppercase small fw-bold mb-1 opacity-75">Admins</p>
                    <h2 class="display-6 fw-black mb-0">{{ $stats['admin_users'] ?? 1 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(45deg, #4f46e5, #6366f1);">
                <div class="card-body p-4">
                    <p class="text-uppercase small fw-bold mb-1 opacity-75">New Joins</p>
                    <h2 class="display-6 fw-black mb-0">{{ $stats['new_users'] ?? 4 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
        <div class="card-header bg-white py-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6 px-4">
                    <h5 class="mb-0 fw-bold">All Registered Users</h5>
                </div>
                <div class="col-md-6 text-md-end px-4">
                    <div class="input-group input-group-sm ms-auto" style="max-width: 300px;">
                        <input type="text" class="form-control" placeholder="Search users...">
                        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase">ID</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">User Profile</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">Contact</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">Role</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">Bookings</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">Joined</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase">Status</th>
                        <th class="text-end px-4 py-3 border-0 text-secondary small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="px-4 fw-bold text-primary">#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3 fw-black text-white" style="background: #2563eb;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold mb-0" style="font-size: 14px;">{{ $user->name }}</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="small"><i class="bi bi-phone me-1"></i>{{ $user->phone ?? 'N/A' }}</span></td>
                        <td>
                            <span class="badge rounded-pill fw-bold {{ $user->is_admin ? 'bg-danger text-white' : 'bg-light text-dark border' }}" style="font-size: 10px; padding: 5px 12px;">
                                {{ $user->is_admin ? 'ADMIN' : 'PASSENGER' }}
                            </span>
                        </td>
                        <td><span class="badge bg-secondary rounded-pill px-3 fw-bold">{{ $user->bookings_count ?? 0 }}</span></td>
                        <td class="small text-secondary fw-medium">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <span class="text-success small fw-bold">
                                <i class="bi bi-circle-fill me-1" style="font-size: 8px;"></i> Active
                            </span>
                        </td>
                        <td class="text-end px-4">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-light border" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-light border text-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center py-5">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 38px; height: 38px; border-radius: 50%; display: flex;
        align-items: center; justify-content: center; font-size: 14px;
    }
    .fw-black { font-weight: 900 !important; }
</style>
@endsection
