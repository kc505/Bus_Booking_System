@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-12">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                    <span class="ml-2 text-sm font-semibold text-blue-600">Agency</span>
                </div>
                <div class="w-16 h-1 bg-blue-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                    <span class="ml-2 text-sm font-semibold text-blue-600">Route</span>
                </div>
                <div class="w-16 h-1 bg-blue-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">✓</div>
                    <span class="ml-2 text-sm font-semibold text-blue-600">Seat</span>
                </div>
                <div class="w-16 h-1 bg-blue-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">4</div>
                    <span class="ml-2 text-sm font-semibold text-blue-600">Payment</span>
                </div>
            </div>
        </div>

        <!-- FORM STARTS HERE - WRAPS EVERYTHING -->
        <form action="{{ route('booking.process') }}" method="POST" id="paymentForm">
            @csrf
            <input type="hidden" name="booking_data" value="{{ json_encode($bookingData) }}">

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Payment Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-md p-8 mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Information</h2>


                        @if(session('error'))
                        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                          {{ session('error') }}
                         </div>
                        @endif

                        <!-- Passenger Details - NOW INSIDE FORM -->
                        <div class="mb-8 pb-8 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Passenger Details</h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="passenger_name" value="{{ Auth::user()->name }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" name="passenger_phone" value="{{ Auth::user()->phone }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="passenger_email" value="{{ Auth::user()->email }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h3>

                        <div class="space-y-4 mb-6">
                            <!-- Mobile Money -->
                            <label class="block cursor-pointer">
                                <input type="radio" name="payment_method" value="momo" checked class="peer sr-only">
                                <div class="border-2 border-gray-300 rounded-lg p-6 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">Mobile Money</p>
                                                <p class="text-sm text-gray-500">MTN/Orange Money</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-200 momo-fields">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Provider</label>
                                                <select name="momo_provider" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                                                    <option value="mtn">MTN Mobile Money</option>
                                                    <option value="orange">Orange Money</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                                <input type="tel" name="momo_phone" placeholder="6XXXXXXXX" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Card Payment -->
                            <label class="block cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="peer sr-only">
                                <div class="border-2 border-gray-300 rounded-lg p-6 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">Credit/Debit Card</p>
                                                <p class="text-sm text-gray-500">Visa, Mastercard</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-start space-x-3 cursor-pointer">
                                <input type="checkbox" name="terms" required class="mt-1 w-5 h-5 text-blue-600 border-gray-300 rounded">
                                <span class="text-sm text-gray-600">I agree to the Terms and Conditions</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-bold text-lg transition-all flex items-center justify-center">
                            Complete Payment - {{ number_format($bookingData['total_amount'] ?? 0) }} FCFA
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md p-6 sticky top-20">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h3>

                        <div class="space-y-4 mb-6 pb-6 border-b border-gray-200 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Agency</p>
                                <p class="font-bold text-gray-900">{{ $bookingData['agency_name'] ?? 'Not Specified' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Route</p>
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-gray-900">{{ $bookingData['departure_city'] ?? '' }}</span>
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    <span class="font-bold text-gray-900">{{ $bookingData['destination_city'] ?? '' }}</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Date</p>
                                    <p class="font-bold text-gray-900">{{ date('M d, Y', strtotime($bookingData['travel_date'] ?? today())) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Time</p>
                                    <p class="font-bold text-gray-900">{{ date('g:i A', strtotime($bookingData['departure_time'] ?? '00:00')) }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Selected Seats</p>
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $seats = [];
                                        if (isset($bookingData['seats'])) {
                                            $seats = is_array($bookingData['seats'])
                                                ? $bookingData['seats']
                                                : json_decode($bookingData['seats'], true);
                                            if (!is_array($seats)) $seats = [];
                                        }
                                    @endphp

                                    @foreach($seats as $seat)
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                            Seat {{ $seat }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tickets</span>
                                <span class="font-bold text-gray-900">{{ number_format($bookingData['subtotal'] ?? 0) }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Service fee</span>
                                <span class="font-bold text-gray-900">500 FCFA</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3 flex justify-between">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="font-bold text-2xl text-blue-600">{{ number_format($bookingData['total_amount'] ?? 0) }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- FORM ENDS HERE -->
    </div>
</div>

@push('scripts')
<script>
// Debug form submission
document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
    console.log('Form submitting...');
    const formData = new FormData(this);
    console.log('Form data:', Object.fromEntries(formData));
});
</script>
@endpush
@endsection
