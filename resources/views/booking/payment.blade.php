<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Complete Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-blue-600">
                <div class="p-8">

                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900">Payment Summary</h3>
                        <p class="text-gray-500">Please review your booking details below.</p>
                    </div>

                    <!-- ERROR DISPLAY BLOCK -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <p class="font-bold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                Please fix the following errors:
                            </p>
                            <ul class="list-disc ml-8 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <p class="font-bold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                Payment Error:
                            </p>
                            <p class="mt-1">{{ session('error') }}</p>
                        </div>
                    @endif

                    <!-- Ticket Summary Card -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200">
                        <div class="flex justify-between items-center mb-4 border-b pb-4">
                            <div>
                                <p class="text-sm text-gray-500">Agency</p>
                                <p class="font-bold text-lg text-blue-700">{{ $booking->trip->bus->agency->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Booking Ref</p>
                                <p class="font-mono font-bold text-gray-700">{{ $booking->booking_reference }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Route</p>
                                <p class="font-semibold">{{ $booking->trip->route->origin }} &rarr; {{ $booking->trip->route->destination }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date & Time</p>
                                <p class="font-semibold">
                                    {{ $booking->trip->travel_date->format('d M Y') }} at {{ \Carbon\Carbon::parse($booking->trip->departure_time)->format('H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-white p-4 rounded border border-blue-100">
                            <span class="text-gray-600 font-medium">Seat Number:</span>
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full font-bold text-sm">
                                {{ $booking->tickets->first()->seat->seat_number }}
                            </span>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="flex justify-between items-center mb-8 px-4">
                        <span class="text-xl font-bold text-gray-700">Total to Pay:</span>
                        <span class="text-3xl font-extrabold text-green-600">{{ number_format($booking->total_amount) }} FCFA</span>
                    </div>

                    <!-- PAYMENT FORM (Corrected) -->
                    <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                        @csrf

                        <div class="mb-6 bg-white p-4 rounded border border-gray-200 shadow-sm">
                            <label class="block text-gray-700 font-bold mb-2">Enter Mobile Money Number</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 font-bold text-lg border-r border-gray-300 pr-2">
                                    +237
                                </span>
                                <input type="text"
                                       name="phone_number"
                                       class="w-full pl-20 pr-4 py-3 border-none rounded-lg focus:ring-0 font-mono text-xl tracking-widest text-gray-800"
                                       placeholder="6XXXXXXXX"
                                       maxlength="9"
                                       autofocus
                                       required>
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Supports MTN Mobile Money & Orange Money
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-4 mt-8">
                            <a href="{{ route('dashboard') }}"
                               class="flex-1 py-4 text-center text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition font-bold">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="flex-1 py-4 text-white font-bold rounded-lg shadow-lg transition transform hover:scale-105"
                                    style="background-color: #16a34a;">
                                Pay Now
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
