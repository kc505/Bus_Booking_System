@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="mb-4">
                    <a href="{{ route('disputes.index') }}" class="btn btn-outline-secondary">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            class="me-1">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Disputes
                    </a>
                </div>

                <!-- Dispute Header -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h3 class="fw-bold mb-2">{{ $dispute->subject }}</h3>
                                <p class="text-muted mb-0">
                                    Submitted on {{ $dispute->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                            <div>
                                @if ($dispute->status === 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending Review</span>
                                @elseif($dispute->status === 'in_progress')
                                    <span class="badge bg-info px-3 py-2">In Progress</span>
                                @elseif($dispute->status === 'resolved')
                                    <span class="badge bg-success px-3 py-2">Resolved</span>
                                @elseif($dispute->status === 'closed')
                                    <span class="badge bg-secondary px-3 py-2">Closed</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Booking Number</small>
                                <p class="fw-bold text-primary">#{{ $dispute->booking->booking_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Agency</small>
                                <p class="fw-bold">{{ $dispute->agency->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Travel Route</small>
                                <p>{{ $dispute->booking->route->departureCity->name ?? 'N/A' }} →
                                    {{ $dispute->booking->route->destinationCity->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mb-1">Travel Date</small>
                                <p>{{ \Carbon\Carbon::parse($dispute->booking->travel_date)->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Your Complaint -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Your Complaint</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="mb-0" style="white-space: pre-line;">{{ $dispute->description }}</p>
                    </div>
                </div>

                <!-- Admin Response -->
                @if ($dispute->admin_response)
                    <div class="card shadow-sm mb-4 border-success">
                        <div class="card-header bg-success bg-opacity-10 py-3">
                            <div class="d-flex align-items-center">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    class="text-success me-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <h5 class="mb-0 fw-bold text-success">Admin Response</h5>
                            </div>
                        </div>
                        <div class="card-body p-4 bg-light">
                            <p class="mb-0" style="white-space: pre-line;">{{ $dispute->admin_response }}</p>
                            @if ($dispute->resolved_at)
                                <hr>
                                <small class="text-muted">
                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" class="me-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Responded on {{ $dispute->resolved_at->format('F j, Y \a\t g:i A') }}
                                </small>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-info d-flex align-items-center">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            class="me-3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong>Awaiting Response</strong>
                            <p class="mb-0 small">Our support team is reviewing your dispute. You will receive an email
                                notification when we respond.</p>
                        </div>
                    </div>
                @endif

                <!-- Resolution Status -->
                @if ($dispute->status === 'resolved')
                    <div class="card shadow-sm border-success">
                        <div class="card-body p-4 text-center">
                            <svg width="60" height="60" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                class="text-success mb-3">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h5 class="fw-bold text-success mb-2">Dispute Resolved</h5>
                            <p class="text-muted mb-0">This dispute has been marked as resolved. If you have any further
                                concerns, please contact support.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
