@extends('layouts.admin')

@section('page-title', 'Reports & Analytics')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-6">Reports & Analytics</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-dark-500 mb-2">Total Revenue</p>
            <p class="text-3xl font-bold text-green-600">{{ number_format($stats['total_revenue']) }} FCFA</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-dark-500 mb-2">Total Bookings</p>
            <p class="text-3xl font-bold text-blue-600">{{ number_format($stats['total_bookings']) }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-dark-500 mb-2">Monthly Revenue</p>
            <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['monthly_revenue']) }} FCFA</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-sm text-dark-500 mb-2">Monthly Bookings</p>
            <p class="text-3xl font-bold text-yellow-600">{{ number_format($stats['monthly_bookings']) }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-bold mb-4">Report coming soon...</h2>
        <p class="text-dark-600">Detailed analytics and charts will be available here.</p>
    </div>
</div>
@endsection
