@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-display font-bold text-dark-900">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-dark-600 mt-2">Manage your bookings and view your travel history</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-dark-500 mb-1">Total Bookings</p>
                            <p class="text-3xl font-display font-bold text-dark-900">{{ $stats['total_bookings'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-dark-500 mb-1">Upcoming Trips</p>
                            <p class="text-3xl font-display font-bold text-dark-900">{{ $stats['upcoming_trips'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-dark-500 mb-1">Completed Trips</p>
                            <p class="text-3xl font-display font-bold text-dark-900">{{ $stats['completed_trips'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-dark-500 mb-1">Total Spent</p>
                            <p class="text-2xl font-display font-bold text-dark-900">
                                {{ number_format($stats['total_spent']) }} <span class="text-sm">FCFA</span></p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-md p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white mb-2">Ready for your next trip?</h2>
                        <p class="text-primary-100">Book your bus ticket now and travel with ease</p>
                    </div>
                    <a href="{{ route('agencies.index') }}"
                        class="bg-white hover:bg-gray-100 text-primary-700 px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Book New Ticket
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b border-dark-200">
                    <nav class="-mb-px flex space-x-8">
                        <button
                            class="tab-btn active border-b-2 border-primary-600 py-4 px-1 text-sm font-semibold text-primary-600"
                            data-tab="upcoming">
                            Upcoming Trips
                        </button>
                        <button
                            class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-semibold text-dark-500 hover:text-dark-700 hover:border-dark-300"
                            data-tab="past">
                            Past Trips
                        </button>
                        <button
                            class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-semibold text-dark-500 hover:text-dark-700 hover:border-dark-300"
                            data-tab="cancelled">
                            Cancelled
                        </button>
                        <a href="{{ route('disputes.index') }}" class="block px-4 py-2 text-dark-700 hover:bg-gray-100">
                            <button
                                class="tab-btn border-b-2 border-transparent py-4 px-1 text-sm font-semibold text-dark-500 hover:text-dark-700 hover:border-dark-300"
                                data-tab="disputes">
                                Disputes
                            </button>
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Upcoming Trips -->
            <div id="upcoming-tab" class="tab-content">
                <div class="space-y-4">
                    @forelse($upcomingBookings as $booking)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4">
                                        @if ($booking->agency->logo)
                                            <img src="{{ asset('storage/' . $booking->agency->logo) }}"
                                                alt="{{ $booking->agency->name }}" class="h-12 w-12 object-contain">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-lg font-display font-bold text-primary-600">{{ substr($booking->agency->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-bold text-dark-900">{{ $booking->agency->name }}</h3>
                                            <p class="text-sm text-dark-500">Booking #{{ $booking->booking_number }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Confirmed</span>
                                </div>

                                <div class="grid md:grid-cols-4 gap-6 mb-6">
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">From</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->departure_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">To</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->destination_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Date & Time</p>
                                        <p class="font-semibold text-dark-900">
                                            {{ date('M d, Y', strtotime($booking->travel_date)) }}</p>
                                        <p class="text-sm text-dark-600">
                                            {{ date('g:i A', strtotime($booking->departure_time)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Seats</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach (json_decode($booking->seats) as $seat)
                                                <span
                                                    class="bg-primary-100 text-primary-700 px-2 py-0.5 rounded text-xs font-semibold">{{ $seat }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-dark-200">
                                    <div>
                                        <p class="text-2xl font-bold text-dark-900">
                                            {{ number_format($booking->total_amount) }} FCFA</p>
                                        <p class="text-sm text-dark-500">{{ count(json_decode($booking->seats)) }} seat(s)
                                        </p>
                                    </div>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('bookings.ticket', $booking->id) }}"
                                            class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg font-semibold transition-all flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                            View Ticket
                                        </a>
                                        <button onclick="cancelBooking({{ $booking->id }})"
                                            class="border border-red-300 text-red-600 hover:bg-red-50 px-6 py-2 rounded-lg font-semibold transition-all">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <svg class="w-24 h-24 text-dark-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-dark-700 mb-2">No Upcoming Trips</h3>
                            <p class="text-dark-500 mb-6">You don't have any upcoming bookings yet</p>
                            <a href="{{ route('agencies.index') }}"
                                class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-all">
                                Book Your First Trip
                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Past Trips -->
            <div id="past-tab" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($pastBookings as $booking)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden opacity-90">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4">
                                        @if ($booking->agency->logo)
                                            <img src="{{ asset('storage/' . $booking->agency->logo) }}"
                                                alt="{{ $booking->agency->name }}" class="h-12 w-12 object-contain">
                                        @else
                                            <div
                                                class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-lg font-display font-bold text-primary-600">{{ substr($booking->agency->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-bold text-dark-900">{{ $booking->agency->name }}</h3>
                                            <p class="text-sm text-dark-500">Booking #{{ $booking->booking_number }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">Completed</span>
                                </div>

                                <div class="grid md:grid-cols-4 gap-6">
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">From</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->departure_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">To</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->destination_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Date & Time</p>
                                        <p class="font-semibold text-dark-900">
                                            {{ date('M d, Y', strtotime($booking->travel_date)) }}</p>
                                        <p class="text-sm text-dark-600">
                                            {{ date('g:i A', strtotime($booking->departure_time)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Amount Paid</p>
                                        <p class="text-xl font-bold text-dark-900">
                                            {{ number_format($booking->total_amount) }} FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <svg class="w-24 h-24 text-dark-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-dark-700 mb-2">No Past Trips</h3>
                            <p class="text-dark-500">Your travel history will appear here</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cancelled Trips -->
            <div id="cancelled-tab" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($cancelledBookings as $booking)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden opacity-75">
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4">
                                        @if ($booking->agency->logo)
                                            <img src="{{ asset('storage/' . $booking->agency->logo) }}"
                                                alt="{{ $booking->agency->name }}"
                                                class="h-12 w-12 object-contain grayscale">
                                        @else
                                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-lg font-display font-bold text-red-600">{{ substr($booking->agency->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-bold text-dark-900">{{ $booking->agency->name }}</h3>
                                            <p class="text-sm text-dark-500">Booking #{{ $booking->booking_number }}</p>
                                        </div>
                                    </div>
                                    <span
                                        class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Cancelled</span>
                                </div>

                                <div class="grid md:grid-cols-4 gap-6">
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">From</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->departure_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">To</p>
                                        <p class="font-semibold text-dark-900">{{ $booking->destination_city }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Was scheduled for</p>
                                        <p class="font-semibold text-dark-900">
                                            {{ date('M d, Y', strtotime($booking->travel_date)) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-dark-500 mb-1">Refund Status</p>
                                        <p class="text-sm font-semibold text-green-600">
                                            {{ $booking->refund_status ?? 'Processed' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-xl shadow-md p-12 text-center">
                            <svg class="w-24 h-24 text-dark-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <h3 class="text-xl font-semibold text-dark-700 mb-2">No Cancelled Bookings</h3>
                            <p class="text-dark-500">You haven't cancelled any bookings</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Tab switching
            document.querySelectorAll('.tab-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const tab = this.dataset.tab;

                    // Update buttons
                    document.querySelectorAll('.tab-btn').forEach(btn => {
                        btn.classList.remove('active', 'border-primary-600', 'text-primary-600');
                        btn.classList.add('border-transparent', 'text-dark-500');
                    });
                    this.classList.add('active', 'border-primary-600', 'text-primary-600');
                    this.classList.remove('border-transparent', 'text-dark-500');

                    // Update content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(tab + '-tab').classList.remove('hidden');
                });
            });

            // Cancel booking function
            function cancelBooking(bookingId) {
                if (confirm('Are you sure you want to cancel this booking? A cancellation fee may apply.')) {
                    // Submit cancellation form
                    fetch(`/bookings/${bookingId}/cancel`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Booking cancelled successfully!');
                                window.location.reload();
                            } else {
                                alert('Failed to cancel booking. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        });
                }
            }
        </script>
    @endpush
@endsection
