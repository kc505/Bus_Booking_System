@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Back Button -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.checkin') }}"
                        class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold mb-3 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Check-in
                    </a>
                    <h1 class="text-3xl font-black text-slate-800">Booking Details</h1>
                    <p class="text-slate-500 font-medium">Complete information for booking #{{ $booking->booking_number }}
                    </p>
                </div>

                <!-- Status Badge -->
                <div>
                    @if ($booking->status === 'confirmed')
                        <span
                            class="px-4 py-2 text-sm font-black uppercase rounded-full bg-amber-100 text-amber-700">Pending</span>
                    @elseif($booking->status === 'checked_in')
                        <span
                            class="px-4 py-2 text-sm font-black uppercase rounded-full bg-green-100 text-green-700">Checked
                            In</span>
                    @elseif($booking->status === 'no_show')
                        <span class="px-4 py-2 text-sm font-black uppercase rounded-full bg-red-100 text-red-800">No
                            Show</span>
                    @elseif($booking->status === 'cancelled')
                        <span
                            class="px-4 py-2 text-sm font-black uppercase rounded-full bg-gray-100 text-gray-700">Cancelled</span>
                    @endif
                </div>
            </div>

            <div class="grid gap-6">
                <!-- Booking Information Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-black text-slate-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Booking Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Booking Number</p>
                            <p class="text-lg font-bold text-blue-600">#{{ $booking->booking_number }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Agency</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->agency->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Travel Date</p>
                            <p class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($booking->travel_date)->format('l, F j, Y') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Departure Time</p>
                            <p class="text-lg font-bold text-slate-800">
                                {{ \Carbon\Carbon::parse($booking->departure_time)->format('h:i A') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Booked On</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->created_at->format('M j, Y h:i A') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Total Amount</p>
                            <p class="text-lg font-bold text-green-600">{{ number_format($booking->total_price, 0) }} FCFA
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Route Information Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-black text-slate-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Route Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">From</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->departure_city }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">To</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->destination_city }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Seats</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($booking->seats as $seat)
                                    <span
                                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-black">{{ $seat }}</span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Number of Passengers</p>
                            <p class="text-lg font-bold text-slate-800">{{ count($booking->seats) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-black text-slate-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Passenger Information
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Full Name</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->passenger_name }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Phone Number</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->passenger_phone }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase mb-2">Email</p>
                            <p class="text-lg font-bold text-slate-800">{{ $booking->passenger_email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Check-in Information (if checked in) -->
                @if ($booking->status === 'checked_in' && $booking->checked_in_at)
                    <div class="bg-green-50 rounded-2xl shadow-sm border border-green-200 p-8">
                        <h2 class="text-xl font-black text-green-800 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Check-in Information
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-black text-green-600 uppercase mb-2">Checked In At</p>
                                <p class="text-lg font-bold text-green-800">
                                    {{ \Carbon\Carbon::parse($booking->checked_in_at)->format('M j, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- No Show Information (if no show) -->
                @if ($booking->status === 'no_show' && $booking->no_show_at)
                    <div class="bg-red-50 rounded-2xl shadow-sm border border-red-200 p-8">
                        <h2 class="text-xl font-black text-red-800 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            No Show Information
                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-xs font-black text-red-600 uppercase mb-2">Marked No Show At</p>
                                <p class="text-lg font-bold text-red-800">
                                    {{ \Carbon\Carbon::parse($booking->no_show_at)->format('M j, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                @if ($booking->status === 'confirmed')
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-black text-slate-800 mb-6">Actions</h2>
                        <div class="flex gap-4">
                            <button onclick="checkInBooking({{ $booking->id }})"
                                class="btn-blue px-6 py-3 rounded-xl font-black uppercase shadow-lg">
                                Check In Passenger
                            </button>
                            <button onclick="markNoShow({{ $booking->id }})"
                                class="px-6 py-3 border-2 border-red-200 text-red-600 rounded-xl font-black uppercase hover:bg-red-50 transition-all">
                                Mark as No Show
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .btn-blue {
            background-color: #2563eb;
            color: white;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-blue:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
    </style>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        async function checkInBooking(bookingId) {
            const confirmed = confirm('Confirm check-in for this passenger?');
            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/checkin/${bookingId}/check-in`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Check-in successful!');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to check in');
                }
            } catch (error) {
                console.error('Check-in error:', error);
                alert('Error processing check-in');
            }
        }

        async function markNoShow(bookingId) {
            const confirmed = confirm('Mark this booking as No Show? This action cannot be undone.');
            if (!confirmed) return;

            try {
                const response = await fetch(`/admin/checkin/${bookingId}/no-show`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('Marked as No Show');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to mark as no show');
                }
            } catch (error) {
                console.error('No show error:', error);
                alert('Error marking as no show');
            }
        }
    </script>
@endsection
