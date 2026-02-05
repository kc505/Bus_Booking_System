@extends('layouts.superadmin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">Dispute #{{ $dispute->id }}</h2>
                <p class="text-muted">Review and manage dispute details</p>
            </div>
            <a href="{{ route('superadmin.disputes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Disputes
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Dispute Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Dispute Information</h5>
                            <div>
                                @if ($dispute->priority == 'urgent')
                                    <span class="badge bg-danger me-2">Urgent</span>
                                @elseif($dispute->priority == 'high')
                                    <span class="badge bg-warning me-2">High Priority</span>
                                @elseif($dispute->priority == 'medium')
                                    <span class="badge bg-info me-2">Medium</span>
                                @else
                                    <span class="badge bg-secondary me-2">Low</span>
                                @endif

                                @if ($dispute->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($dispute->status == 'in_progress')
                                    <span class="badge bg-info">In Progress</span>
                                @elseif($dispute->status == 'resolved')
                                    <span class="badge bg-success">Resolved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Title</h6>
                            <h5 class="fw-bold">{{ $dispute->title }}</h5>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Description</h6>
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $dispute->description }}</p>
                        </div>

                        @if ($dispute->booking)
                            <div class="alert alert-info">
                                <h6 class="mb-2"><i class="bi bi-ticket-fill me-2"></i>Related Booking</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">Booking Number:</small>
                                        <div class="fw-semibold">{{ $dispute->booking->booking_number }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Travel Date:</small>
                                        <div class="fw-semibold">{{ $dispute->booking->travel_date->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($dispute->admin_response)
                            <div class="mt-4 p-3 bg-light rounded">
                                <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text me-2"></i>Admin Response</h6>
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $dispute->admin_response }}</p>
                                @if ($dispute->resolver)
                                    <div class="mt-2 small text-muted">
                                        Resolved by: {{ $dispute->resolver->name }} on
                                        {{ $dispute->resolved_at->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Update Dispute Form -->
                @if ($dispute->status != 'resolved' && $dispute->status != 'rejected')
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="mb-0 fw-bold">Update Dispute Status</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('superadmin.disputes.update', $dispute) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status *</label>
                                    <select name="status" class="form-select" required>
                                        <option value="pending" {{ $dispute->status == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="in_progress"
                                            {{ $dispute->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved">Resolved</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Admin Response *</label>
                                    <textarea name="admin_response" class="form-control" rows="6" required
                                        placeholder="Provide your response to the passenger...">{{ old('admin_response', $dispute->admin_response) }}</textarea>
                                    @error('admin_response')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Dispute
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Passenger Info -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold">Passenger Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 50px; height: 50px; font-weight: bold; font-size: 1.2rem;">
                                {{ strtoupper(substr($dispute->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $dispute->user->name }}</div>
                                <small class="text-muted">Passenger</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-envelope me-2 text-muted"></i>{{ $dispute->user->email }}
                        </div>
                        <div>
                            <i class="bi bi-telephone me-2 text-muted"></i>{{ $dispute->user->phone ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Agency Info -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold">Agency Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if ($dispute->agency->logo)
                                <img src="{{ asset('storage/' . $dispute->agency->logo) }}"
                                    alt="{{ $dispute->agency->name }}" class="rounded"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-success text-white rounded d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px; font-weight: bold;">
                                    {{ substr($dispute->agency->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $dispute->agency->name }}</div>
                                <small class="text-muted">Bus Agency</small>
                            </div>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-envelope me-2 text-muted"></i>{{ $dispute->agency->email }}
                        </div>
                        <div>
                            <i class="bi bi-telephone me-2 text-muted"></i>{{ $dispute->agency->phone }}
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 fw-bold">Timeline</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="mb-3">
                                <div class="small text-muted mb-1">Created</div>
                                <div class="fw-semibold">{{ $dispute->created_at->format('M d, Y H:i') }}</div>
                            </div>
                            @if ($dispute->resolved_at)
                                <div>
                                    <div class="small text-muted mb-1">
                                        {{ $dispute->status == 'resolved' ? 'Resolved' : 'Updated' }}</div>
                                    <div class="fw-semibold">{{ $dispute->resolved_at->format('M d, Y H:i') }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
