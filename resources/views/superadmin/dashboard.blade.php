@extends('layouts.superadmin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="mb-4">
            <h2 class="mb-1 fw-bold">Super Admin Dashboard</h2>
            <p class="text-muted">{{ date('l, F j, Y') }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <!-- Total Users -->
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-2">Total Users</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['total_users'] }}</h2>
                            </div>
                            <div class="opacity-75">
                                <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-3 small opacity-75">
                            <i class="bi bi-person me-1"></i>Passengers: {{ $stats['total_passengers'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agency Admins -->
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-2">Agency Admins</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['agency_admins'] }}</h2>
                            </div>
                            <div class="opacity-75">
                                <i class="bi bi-shield-check" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-3 small opacity-75">
                            <i class="bi bi-person-badge me-1"></i>Check-in Staff: {{ $stats['checkin_staff'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Agencies -->
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 bg-info text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-2">Total Agencies</h6>
                                <h2 class="mb-0 fw-bold">{{ $stats['total_agencies'] }}</h2>
                            </div>
                            <div class="opacity-75">
                                <i class="bi bi-building" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-3 small opacity-75">
                            <i class="bi bi-check-circle me-1"></i>Active: {{ $stats['active_agencies'] }} |
                            <i class="bi bi-x-circle ms-2 me-1"></i>Suspended: {{ $stats['suspended_agencies'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="opacity-75 mb-2">Total Revenue</h6>
                                <h2 class="mb-0 fw-bold">{{ number_format($stats['total_revenue']) }} FCFA</h2>
                            </div>
                            <div class="opacity-75">
                                <i class="bi bi-cash-stack" style="font-size: 2.5rem;"></i>
                            </div>
                        </div>
                        <div class="mt-3 small opacity-75">
                            <i class="bi bi-ticket me-1"></i>Total Bookings: {{ $stats['total_bookings'] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Pending Disputes</h6>
                                <h3 class="mb-0 fw-bold text-danger">{{ $stats['pending_disputes'] }}</h3>
                            </div>
                            <div class="text-danger">
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Disputes</h6>
                                <h3 class="mb-0 fw-bold text-primary">{{ $stats['total_disputes'] }}</h3>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-file-earmark-text-fill" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Disputes & Agencies -->
        <div class="row g-4">
            <!-- Recent Disputes -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Recent Disputes</h5>
                            <a href="{{ route('superadmin.disputes.index') }}" class="btn btn-sm btn-outline-primary">View
                                All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">Passenger</th>
                                        <th class="py-3">Agency</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentDisputes as $dispute)
                                        <tr>
                                            <td class="px-4">{{ $dispute->user->name }}</td>
                                            <td>{{ $dispute->agency->name }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $dispute->status == 'pending' ? 'warning' : ($dispute->status == 'resolved' ? 'success' : 'info') }}">
                                                    {{ ucfirst($dispute->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $dispute->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">No disputes found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Agencies -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Recent Agencies</h5>
                            <a href="{{ route('superadmin.agencies.index') }}" class="btn btn-sm btn-outline-primary">View
                                All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3">Agency Name</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3">Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAgencies as $agency)
                                        <tr>
                                            <td class="px-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($agency->logo)
                                                        <img src="{{ asset('storage/' . $agency->logo) }}"
                                                            alt="{{ $agency->name }}" class="rounded"
                                                            style="width: 30px; height: 30px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary text-white rounded d-flex align-items-center justify-center"
                                                            style="width: 30px; height: 30px; font-size: 0.8rem; font-weight: bold;">
                                                            {{ substr($agency->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="fw-semibold">{{ $agency->name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $agency->status == 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($agency->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $agency->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">No agencies found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
