@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 fw-bold">Dispute Details</h1>
                    <a href="{{ route('disputes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Back to My Disputes
                    </a>
                </div>

                <div class="card shadow border-0 rounded-3">
                    <div class="card-header bg-primary text-white py-4">
                        <h4 class="mb-0">{{ $dispute->title }}</h4>
                        <small class="opacity-75">Submitted on {{ $dispute->created_at->format('M d, Y \a\t H:i') }}</small>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="mb-5">
                            <h5 class="fw-bold mb-3">Description</h5>
                            <p class="text-dark-800" style="white-space: pre-wrap;">{{ $dispute->description }}</p>
                        </div>

                        <div class="row g-4 mb-5">
                            <div class="col-md-6">
                                <h5 class="fw-bold">Status</h5>
                                @if ($dispute->status === 'pending')
                                    <span class="badge bg-warning fs-6 px-4 py-2">Pending</span>
                                @elseif ($dispute->status === 'resolved')
                                    <span class="badge bg-success fs-6 px-4 py-2">Resolved</span>
                                @else
                                    <span class="badge bg-secondary fs-6 px-4 py-2">{{ ucfirst($dispute->status) }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-bold">Related Agency</h5>
                                <p class="mb-0">{{ $dispute->agency?->name ?? 'N/A' }}</p>
                            </div>

                            @if ($dispute->booking)
                                <div class="col-md-6">
                                    <h5 class="fw-bold">Related Booking</h5>
                                    <p class="mb-0">Booking #{{ $dispute->booking->id }} •
                                        {{ $dispute->booking->trip?->name ?? 'N/A' }}</p>
                                </div>
                            @endif
                        </div>

                        @if ($dispute->admin_response)
                            <div class="bg-light p-4 rounded-3 border">
                                <h5 class="fw-bold mb-3">Admin Response</h5>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $dispute->admin_response }}</p>
                                <small class="text-muted d-block mt-2">
                                    Responded on {{ $dispute->updated_at->format('M d, Y \a\t H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                No response from admin yet. We'll notify you when there's an update.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
