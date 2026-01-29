<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirm Payment') }}
        </h2>
    </x-slot>

    <div class="py-12 text-center">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">

            <!-- Animated Icon -->
           <!-- Animated Icon -->
            <div class="animate-pulse mb-6">
                <div class="h-20 w-20 bg-gray-100 rounded-full mx-auto flex items-center justify-center">
                    <!-- Added ID here -->
                    <svg id="status-icon" class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Added ID here -->
            <h3 id="status-text" class="text-2xl font-bold text-gray-800 mb-2">Check your Phone!</h3>
            <p class="text-gray-600 mb-6">
                Please enter your PIN code on your phone to confirm the payment of <br>
                <span class="text-xl font-bold text-blue-600">{{ number_format($booking->total_amount) }} FCFA</span>
            </p>

            <!-- Check Status Button -->
            <form action="{{ route('bookings.check-status', $reference) }}" method="POST">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 shadow transition transform hover:scale-105">
                    I have approved the payment
                </button>
            </form>

            <p class="text-xs text-gray-400 mt-4">
                Did not receive the prompt? <a href="{{ route('bookings.payment', $booking->id) }}" class="underline text-blue-500">Try again</a>
            </p>

        </div>
    </div>

    <!-- ... existing code ... -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookingId = "{{ $booking->id }}";
        const reference = "{{ $reference }}";

        // This URL matches the Route we created in Step 1
        const checkUrl = `/payment/poll/${bookingId}/${reference}`;

        console.log("Starting polling to:", checkUrl);

        // Check every 3 seconds
        const poller = setInterval(function() {
            fetch(checkUrl)
                .then(response => response.json())
                .then(data => {
                    console.log("Status:", data.status);

                    if (data.status === 'SUCCESSFUL') {
                        clearInterval(poller); // Stop asking

                        // 1. Update UI
                        document.getElementById('status-text').innerText = "Payment Confirmed!";
                        document.getElementById('status-icon').classList.remove('text-yellow-600');
                        document.getElementById('status-icon').classList.add('text-green-600');

                        // 2. Redirect to Success Page
                        window.location.href = "{{ route('bookings.success', $booking->id) }}";
                    }
                    else if (data.status === 'FAILED') {
                        clearInterval(poller);
                        // ALERT THE EXACT REASON FROM THE SERVER
                        alert("Error: " + (data.reason || "Payment Failed"));
                        window.location.href = "{{ route('bookings.payment', $booking->id) }}";
                    }
                })
                .catch(err => console.error(err));
        }, 3000);
    });
</script>

<!-- IMPORTANT: Add an ID to your existing form so JS can find it -->
<!-- Find your existing form tag and add id="manualCheckForm" -->
<form id="manualCheckForm" action="{{ route('bookings.check-status', $reference) }}" method="POST">
    @csrf
    <!-- ... inputs ... -->
</form>
</x-app-layout>
