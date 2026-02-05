@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold">File a Dispute</h4>
                            <a href="{{ route('bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                                Back to Bookings
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops! Something went wrong.</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <!-- Booking Information -->
                        <div class="bg-light rounded p-4 mb-4">
                            <h6 class="fw-bold mb-3">Booking Details</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Booking Number</small>
                                    <p class="mb-0 fw-bold text-primary">#{{ $booking->booking_number }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Agency</small>
                                    <p class="mb-0 fw-bold">{{ $booking->agency->name }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Route</small>
                                    <p class="mb-0">{{ $booking->route->departureCity->name ?? 'N/A' }} →
                                        {{ $booking->route->destinationCity->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <small class="text-muted">Travel Date</small>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($booking->travel_date)->format('M j, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('disputes.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                            <!-- Subject -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <select name="subject"
                                    class="form-select form-select-lg @error('subject') is-invalid @enderror" required>
                                    <option value="">Select a subject</option>
                                    <option value="Late Departure"
                                        {{ old('subject') == 'Late Departure' ? 'selected' : '' }}>Late Departure</option>
                                    <option value="Poor Service" {{ old('subject') == 'Poor Service' ? 'selected' : '' }}>
                                        Poor Service</option>
                                    <option value="Vehicle Condition"
                                        {{ old('subject') == 'Vehicle Condition' ? 'selected' : '' }}>Vehicle Condition
                                    </option>
                                    <option value="Overcharging" {{ old('subject') == 'Overcharging' ? 'selected' : '' }}>
                                        Overcharging</option>
                                    <option value="Lost Items" {{ old('subject') == 'Lost Items' ? 'selected' : '' }}>Lost
                                        Items</option>
                                    <option value="Refund Request"
                                        {{ old('subject') == 'Refund Request' ? 'selected' : '' }}>Refund Request</option>
                                    <option value="Safety Concerns"
                                        {{ old('subject') == 'Safety Concerns' ? 'selected' : '' }}>Safety Concerns
                                    </option>
                                    <option value="Driver Behavior"
                                        {{ old('subject') == 'Driver Behavior' ? 'selected' : '' }}>Driver Behavior
                                    </option>
                                    <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Please provide detailed information about your complaint..." required>{{ old('description') }}</textarea>
                                <small class="text-muted">Provide as much detail as possible to help us resolve your issue
                                    quickly.</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Important Notice -->
                            <div class="alert alert-info d-flex align-items-start">
                                <svg class="me-3 mt-1" width="20" height="20" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <strong>Important:</strong> Once submitted, your dispute will be reviewed by our support
                                    team. You will receive updates via email and can track the status in your account.
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end gap-3 mt-5">
                                <a href="{{ route('disputes.index') }}" class="btn btn-outline-secondary btn-lg px-5 py-3">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-3">
                                    Submit Dispute
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
