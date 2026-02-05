@extends('layouts.superadmin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">Dispute Management</h2>
                <p class="text-muted">Manage passenger disputes and complaints</p>
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
                <div class="card shadow-sm border-0 {{ request('status') == 'pending' ? 'border-warning border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Pending</h6>
                        <h3 class="mb-0 fw-bold text-warning">{{ $stats['pending'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 {{ request('status') == 'in_progress' ? 'border-info border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">In Progress</h6>
                        <h3 class="mb-0 fw-bold text-info">{{ $stats['in_progress'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 {{ request('status') == 'resolved' ? 'border-success border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Resolved</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ $stats['resolved'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 {{ request('status') == 'rejected' ? 'border-danger border-2' : '' }}">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">Rejected</h6>
                        <h3 class="mb-0 fw-bold text-danger">{{ $stats['rejected'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form action="{{ route('superadmin.disputes.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Filter by Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Filter by Priority</label>
                            <select name="priority" class="form-select">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium
                                </option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-funnel me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Disputes Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">All Disputes ({{ $disputes->total() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="py-3">Passenger</th>
                                <th class="py-3">Agency</th>
                                <th class="py-3">Subject</th>
                                <th class="py-3">Priority</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Date</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($disputes as $dispute)
                                <tr>
                                    <td class="px-4 fw-semibold">#{{ $dispute->id }}</td>
                                    <td>
                                        <div class="small">
                                            <div class="fw-semibold">{{ $dispute->user->name }}</div>
                                            <div class="text-muted">{{ $dispute->user->email }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $dispute->agency->name }}</span>
                                    </td>
                                    <td>
                                        <div class="small" style="max-width: 200px;">
                                            {{ Str::limit($dispute->subject, 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($dispute->priority == 'urgent')
                                            <span class="badge bg-danger">Urgent</span>
                                        @elseif($dispute->priority == 'high')
                                            <span class="badge bg-warning">High</span>
                                        @elseif($dispute->priority == 'medium')
                                            <span class="badge bg-info">Medium</span>
                                        @else
                                            <span class="badge bg-secondary">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($dispute->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($dispute->status == 'in_progress')
                                            <span class="badge bg-info">In Progress</span>
                                        @elseif($dispute->status == 'resolved')
                                            <span class="badge bg-success">Resolved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $dispute->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('superadmin.disputes.show', $dispute) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox d-block mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mb-0">No disputes found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($disputes->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    {{ $disputes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
