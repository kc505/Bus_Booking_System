@extends('layouts.superadmin')

@section('title', 'Agency Details')
@section('page-title', 'Agency Details')

@section('content')
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <!-- Header Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('superadmin.agencies.index') }}" class="btn btn-outline-secondary">
                    <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="width: 16px; height: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Agencies
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('superadmin.agencies.edit', $agency) }}" class="btn btn-primary">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Agency
                    </a>
                    @if ($agency->status === 'active')
                        <form action="{{ route('superadmin.agencies.suspend', $agency) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning"
                                onclick="return confirm('Are you sure you want to suspend this agency?')">
                                Suspend Agency
                            </button>
                        </form>
                    @else
                        <form action="{{ route('superadmin.agencies.activate', $agency) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Activate Agency
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Agency Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Agency Information</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            @if ($agency->logo)
                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name }}"
                                    class="img-fluid rounded" style="max-width: 200px;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="width: 200px; height: 200px; margin: 0 auto;">
                                    <svg class="text-muted" width="80" height="80" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            @endif
                            <div class="mt-3">
                                @if ($agency->status === 'active')
                                    <span class="badge bg-success px-3 py-2">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Suspended</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h3 class="fw-bold mb-4">{{ $agency->name }}</h3>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Email</p>
                                    <p class="fw-bold">{{ $agency->email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Phone</p>
                                    <p class="fw-bold">{{ $agency->phone }}</p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Commission Rate</p>
                                    <p class="fw-bold">{{ $agency->commission_rate ?? 10 }}%</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-muted small mb-1">Joined</p>
                                    <p class="fw-bold">{{ $agency->created_at->format('F j, Y') }}</p>
                                </div>
                            </div>

                            @if ($agency->address)
                                <div class="mb-3">
                                    <p class="text-muted small mb-1">Address</p>
                                    <p class="fw-bold">{{ $agency->address }}</p>
                                </div>
                            @endif

                            @if ($agency->description)
                                <div>
                                    <p class="text-muted small mb-1">Description</p>
                                    <p>{{ $agency->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-primary">{{ $agency->routes->count() }}</h3>
                            <p class="text-muted mb-0">Routes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-success">{{ $agency->bookings->count() }}</h3>
                            <p class="text-muted mb-0">Total Bookings</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-info">{{ $agency->users->count() }}</h3>
                            <p class="text-muted mb-0">Staff Members</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="fw-bold text-warning">{{ $agency->disputes->count() }}</h3>
                            <p class="text-muted mb-0">Disputes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Recent Bookings</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Booking #</th>
                                    <th>Passenger</th>
                                    <th>Route</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agency->bookings()->latest()->take(10)->get() as $booking)
                                    <tr>
                                        <td class="fw-bold text-primary">#{{ $booking->booking_number }}</td>
                                        <td>{{ $booking->passenger_name }}</td>
                                        <td>{{ $booking->route->departureCity->name ?? 'N/A' }} →
                                            {{ $booking->route->destinationCity->name ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->travel_date)->format('M j, Y') }}</td>
                                        <td>
                                            @if ($booking->status === 'confirmed')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($booking->status === 'checked_in')
                                                <span class="badge bg-success">Checked In</span>
                                            @elseif($booking->status === 'no_show')
                                                <span class="badge bg-danger">No Show</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold">{{ number_format($booking->total_price) }} FCFA</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">No bookings yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Staff Members -->
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Staff Members</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($agency->users as $user)
                                    <tr>
                                        <td class="fw-bold">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role === 'agency_admin')
                                                <span class="badge bg-primary">Agency Admin</span>
                                            @elseif($user->role === 'check_in_staff')
                                                <span class="badge bg-info">Check-in Staff</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->status === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Suspended</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M j, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">No staff members</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
