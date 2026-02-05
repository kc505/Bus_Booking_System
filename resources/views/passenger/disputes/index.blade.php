@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">My Disputes</h1>
            <a href="{{ route('disputes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> New Dispute
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($disputes->isEmpty())
            <div class="alert alert-info text-center py-5">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                You haven't submitted any disputes yet.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($disputes as $dispute)
                            <tr>
                                <td>{{ $dispute->title }}</td>
                                <td>
                                    @if ($dispute->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($dispute->status === 'resolved')
                                        <span class="badge bg-success">Resolved</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($dispute->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $dispute->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('disputes.show', $dispute) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $disputes->links() }}
            </div>
        @endif
    </div>
@endsection
