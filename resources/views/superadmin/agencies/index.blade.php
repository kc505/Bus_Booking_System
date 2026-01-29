@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1 fw-bold">Agency Management</h2>
                <p class="text-muted">Manage all bus agencies on the platform</p>
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

        <!-- Agencies Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">All Agencies ({{ $agencies->total() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Agency</th>
                                <th class="py-3">Contact</th>
                                <th class="py-3">Routes</th>
                                <th class="py-3">Bookings</th>
                                <th class="py-3">Status</th>
                                <th class="py-3">Registered</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agencies as $agency)
                                <tr>
                                    <td class="px-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @if ($agency->logo)
                                                <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name }}"
                                                    class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; font-weight: bold;">
                                                    {{ substr($agency->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $agency->name }}</div>
                                                <small class="text-muted">{{ $agency->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <i class="bi bi-telephone me-1"></i>{{ $agency->phone }}<br>
                                            <i class="bi bi-geo-alt me-1"></i>{{ $agency->address ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td><span class="fw-semibold">{{ $agency->routes_count }}</span></td>
                                    <td><span class="fw-semibold">{{ $agency->bookings_count }}</span></td>
                                    <td>
                                        @if ($agency->status == 'active')
                                            <span class="badge bg-success px-3">Active</span>
                                        @elseif($agency->status == 'suspended')
                                            <span class="badge bg-danger px-3">Suspended</span>
                                        @else
                                            <span class="badge bg-secondary px-3">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="small text-muted">{{ $agency->created_at->format('M d, Y') }}</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            @if ($agency->status == 'active')
                                                <button class="btn btn-outline-warning" data-bs-toggle="modal"
                                                    data-bs-target="#suspendModal{{ $agency->id }}">
                                                    <i class="bi bi-pause-circle"></i> Suspend
                                                </button>
                                            @else
                                                <form action="{{ route('superadmin.agencies.activate', $agency) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success"
                                                        onclick="return confirm('Activate this agency?')">
                                                        <i class="bi bi-check-circle"></i> Activate
                                                    </button>
                                                </form>
                                            @endif
                                            <button class="btn btn-outline-danger"
                                                onclick="deleteAgency({{ $agency->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Suspend Modal -->
                                <div class="modal fade" id="suspendModal{{ $agency->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('superadmin.agencies.suspend', $agency) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Suspend {{ $agency->name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="alert alert-warning">
                                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                                        This will also suspend the agency admin and prevent new bookings.
                                                    </div>
                                                    <label class="form-label fw-semibold">Reason for Suspension *</label>
                                                    <textarea name="reason" class="form-control" rows="4" required placeholder="Enter reason for suspension..."></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Suspend Agency</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox d-block mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                            <p class="mb-0">No agencies found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($agencies->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    {{ $agencies->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteAgency(agencyId) {
            if (confirm('Are you sure you want to delete this agency? This action cannot be undone!')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/superadmin/agencies/${agencyId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
