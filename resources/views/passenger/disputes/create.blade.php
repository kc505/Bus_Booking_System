@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card shadow border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary text-white py-4">
                        <h3 class="mb-0 fw-bold">Submit a New Dispute</h3>
                        <p class="mb-0 mt-1 opacity-90">Tell us about your issue — we'll review it as soon as possible.</p>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                <strong>Fix the following errors:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('disputes.store') }}">
                            @csrf

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Title *</label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                    required autofocus placeholder="Brief summary of your issue">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Agency Selection - REQUIRED -->
                            <div class="mb-4">
                                <label for="agency_id" class="form-label fw-bold">Agency Involved *</label>
                                <select name="agency_id" id="agency_id"
                                    class="form-select form-select-lg @error('agency_id') is-invalid @enderror" required>
                                    <option value="">-- Select the agency --</option>
                                    @foreach ($agencies as $agency)
                                        <option value="{{ $agency->id }}"
                                            {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                                            {{ $agency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agency_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Choose the bus agency this complaint is about.
                                </small>
                            </div>

                            <!-- Description -->
                            <div class="mb-5">
                                <label for="description" class="form-label fw-bold">Description *</label>
                                <textarea name="description" id="description" rows="6"
                                    class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted mt-2 d-block">
                                    Minimum 10 characters. Include as much detail as possible.
                                </small>
                            </div>

                            <!-- Optional Booking Selection -->
                            @if (isset($bookings) && $bookings->count() > 0)
                                <div class="mb-5">
                                    <label for="booking_id" class="form-label fw-bold fs-5">Related Booking
                                        (optional)</label>
                                    <select name="booking_id" id="booking_id" class="form-select form-select-lg">
                                        <option value="">-- Select a booking (if applicable) --</option>
                                        @foreach ($bookings as $booking)
                                            <option value="{{ $booking->id }}"
                                                {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                                #{{ $booking->id }} • {{ $booking->trip?->name ?? 'Trip' }} •
                                                {{ $booking->created_at->format('M d, Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Linking a booking helps us resolve your issue
                                        faster.</small>
                                </div>
                            @endif

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end gap-3 mt-5">
                                <a href="{{ route('disputes.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">
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
