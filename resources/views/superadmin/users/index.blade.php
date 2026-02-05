@extends('layouts.superadmin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">User Management</h2>
                <p class="text-muted">Manage all users on the platform</p>
            </div>
            <a href="{{ route('superadmin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 {{ request('role') == '' ? 'border-primary border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Total Users</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 {{ request('role') == 'passenger' ? 'border-primary border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Passengers</h6>
                        <h3 class="mb-0 fw-bold text-primary">{{ $stats['passengers'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card shadow-sm border-0 {{ request('role') == 'agency_admin' ? 'border-primary border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Agency Admins</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ $stats['agency_admins'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card shadow-sm border-0 {{ request('role') == 'checkin_staff' ? 'border-primary border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Check-in Staff</h6>
                        <h3 class="mb-0 fw-bold text-info">{{ $stats['checkin_staff'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('superadmin.users.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Role</label>
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                <option value="passenger" {{ request('role') == 'passenger' ? 'selected' : '' }}>Passengers
                                </option>
                                <option value="agency_admin" {{ request('role') == 'agency_admin' ? 'selected' : '' }}>
                                    Agency Admins</option>
                                <option value="checkin_staff" {{ request('role') == 'checkin_staff' ? 'selected' : '' }}>
                                    Check-in Staff</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Filter by Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>
                                    Suspended</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-2"></i>Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">All Users ({{ $users->total() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">User</th>
                                <th class="py-3">Contact</th>
                                <th class="py-3">Role</th>
                                <th class="py-3">Agency</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Joined</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 35px; height: 35px; font-weight: bold; font-size: 0.9rem;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $user->name }}</div>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="small">
                                        <i class="bi bi-telephone me-1"></i>{{ $user->phone ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @switch(strtolower($user->role))
                                            @case('super_admin')
                                                <span class="badge bg-danger">Super Admin</span>
                                            @break

                                            @case('agency_admin')
                                                <span class="badge bg-primary">Agency Admin</span>
                                            @break

                                            @case('checkin_staff')
                                            @case('staff')
                                                <span class="badge bg-info">Staff / Conductor</span>
                                            @break

                                            @case('passenger')
                                                <span class="badge bg-success">Passenger</span>
                                            @break

                                            @default
                                                <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if ($user->agency)
                                            <span class="small fw-semibold">{{ $user->agency->name }}</span>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->status == 'active')
                                            <span class="badge bg-success-subtle text-success">Active</span>
                                        @elseif($user->status == 'suspended')
                                            <span class="badge bg-danger-subtle text-danger">Suspended</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $user->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-4 onhover-show">
                                        @if ($user->role != 'super_admin')
                                            <div class="btn-group btn-group-sm" role="group">
                                                @if ($user->status == 'active')
                                                    <form action="{{ route('superadmin.users.suspend', $user) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-warning"
                                                            onclick="return confirm('Suspend this user?')">
                                                            <i class="bi bi-pause-circle"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('superadmin.users.activate', $user) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success"
                                                            onclick="return confirm('Activate this user?')">
                                                            <i class="bi bi-check-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-secondary">Protected</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox d-block mb-3"
                                                    style="font-size: 3rem; opacity: 0.3;"></i>
                                                <p class="mb-0">No users found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endsection
