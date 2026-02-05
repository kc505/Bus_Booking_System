@extends('layouts.superadmin')

@section('title', 'Reports')

@section('page-title', 'Reports')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4 fw-bold">Platform Reports</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5>Total Bookings</h5>
                        <h3 class="text-primary fw-bold">{{ $stats['total_bookings'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5>Total Revenue</h5>
                        <h3 class="text-success fw-bold">{{ number_format($stats['total_revenue']) }} FCFA</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h5>Total Disputes</h5>
                        <h3 class="text-warning fw-bold">{{ $stats['total_disputes'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add charts/tables later here -->
    </div>
@endsection
