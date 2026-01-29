<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">

                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
                    <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Payment Completed!</h2>
                <p class="text-gray-500 mb-8">
                    Your booking for <span class="font-bold text-gray-800">{{ $booking->trip->route->origin }} to {{ $booking->trip->route->destination }}</span> is confirmed.
                </p>

                <!-- Ticket Details Card -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8 border border-gray-200 text-left">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Booking Ref:</span>
                        <span class="font-mono font-bold">{{ $booking->booking_reference }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500">Amount Paid:</span>
                        <span class="font-bold text-green-600">{{ number_format($booking->total_amount) }} FCFA</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Seat Number:</span>
                        <span class="font-bold bg-blue-100 text-blue-800 px-2 rounded">{{ $booking->tickets->first()->seat->seat_number }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <a href="{{ route('tickets.show', $booking->tickets->first()->id) }}" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-lg shadow transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        View & Download Ticket
                    </a>

                    <a href="{{ route('dashboard') }}" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition">
                        Go to Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
