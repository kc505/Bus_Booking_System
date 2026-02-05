@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="fw-bold mb-1">My Disputes</h2>
                        <p class="text-muted mb-0">Track and manage your dispute cases</p>
                    </div>
                    <a href="{{ route('bookings.index') }}" class="btn btn-outline-primary">
                        Back to Bookings
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        @forelse($disputes as $dispute)
                            <div class="border-bottom p-4 hover-bg-light" style="cursor: pointer;"
                                onclick="window.location='{{ route('disputes.show', $dispute) }}'">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h5 class="fw-bold mb-0 me-3">{{ $dispute->subject }}</h5>
                                            @if ($dispute->status === 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($dispute->status === 'in_progress')
                                                <span class="badge bg-info">In Progress</span>
                                            @elseif($dispute->status === 'resolved')
                                                <span class="badge bg-success">Resolved</span>
                                            @elseif($dispute->status === 'closed')
                                                <span class="badge bg-secondary">Closed</span>
                                            @endif
                                        </div>
                                        <p class="text-muted small mb-2">
                                            <svg width="16" height="16" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" class="me-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $dispute->agency->name }} • Booking #{{ $dispute->booking->booking_number }}
                                        </p>
                                        <p class="mb-0 text-truncate" style="max-width: 600px;">{{ $dispute->description }}
                                        </p>
                                    </div>
                                    <div class="text-end ms-3">
                                        <small
                                            class="text-muted d-block">{{ $dispute->created_at->diffForHumans() }}</small>
                                        <small class="text-muted">{{ $dispute->created_at->format('M j, Y') }}</small>
                                    </div>
                                </div>

                                @if ($dispute->admin_response)
                                    <div class="bg-light rounded p-3 mt-3">
                                        <p class="small fw-bold mb-1 text-success">
                                            <svg width="16" height="16" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" class="me-1">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                            Admin Response
                                        </p>
                                        <p class="small mb-0 text-truncate">{{ $dispute->admin_response }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <svg width="80" height="80" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    class="text-muted mb-3">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h5 class="text-muted mb-2">No Disputes</h5>
                                <p class="text-muted">You haven't filed any disputes yet.</p>
                                <a href="{{ route('bookings.index') }}" class="btn btn-primary mt-2">View My Bookings</a>
                            </div>
                        @endforelse
                    </div>

                    @if ($disputes->hasPages())
                        <div class="card-footer bg-white">
                            {{ $disputes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-bg-light:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }
    </style>
@endsection
