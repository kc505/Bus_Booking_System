@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-2xl mx-auto px-4">

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-center animate-bounce">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="font-bold">{{ session('success') }}</p>
        </div>
        @endif

        <!-- Ticket Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border-t-8 border-blue-600" id="ticketContainer">
            <div class="p-8 text-center border-b border-dashed border-gray-200">
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-widest">BusCam Digital Ticket</h2>
                <p class="text-gray-500 text-sm mt-1 uppercase font-bold tracking-tighter">Booking #{{ $booking->booking_number }}</p>
            </div>

            <div class="p-8 grid md:grid-cols-2 gap-8 items-center">
                <!-- QR Code Section -->
                <div class="flex flex-col items-center bg-gray-50 p-6 rounded-2xl border-2 border-gray-100">
                    <div class="bg-white p-3 rounded-lg shadow-sm mb-4">
                        <!-- Generates QR Code instantly using your ticket number -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $booking->booking_number }}" alt="Ticket QR" class="w-40 h-40">
                    </div>
                    <p class="text-[10px] font-black text-gray-400 uppercase">Scan to Check-in</p>
                </div>

                <!-- Trip Details -->
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Passenger</p>
                        <p class="font-bold text-gray-800 text-lg">{{ $booking->passenger_name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Route</p>
                        <p class="font-bold text-gray-800">{{ $booking->origin }} → {{ $booking->destination }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase">Date</p>
                            <p class="font-bold text-gray-800 text-sm">{{ date('M d, Y', strtotime($booking->travel_date)) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase">Time</p>
                            <p class="font-bold text-gray-800 text-sm">{{ date('g:i A', strtotime($booking->departure_time)) }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Seats</p>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach(json_decode($booking->seats) as $seat)
                                <span class="bg-blue-600 text-white text-[10px] font-black px-3 py-1 rounded-full">Seat {{ $seat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Footer -->
            <div class="bg-gray-50 p-6 flex flex-col sm:flex-row gap-4">
                <button onclick="window.print()" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all flex items-center">
               <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
               </svg>
             Save as PDF / Print
                   </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-white border-2 border-gray-200 text-gray-500 text-center py-3 rounded-xl font-bold hover:bg-gray-50 transition-all">
                    Dashboard
                </a>
            </div>
        </div>

        <p class="text-center text-gray-400 text-xs mt-8">Please arrive 30 minutes before departure. Ticket is non-transferable.</p>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    #ticketContainer, #ticketContainer * { visibility: visible; }
    #ticketContainer { position: absolute; left: 0; top: 0; width: 100%; border: none; box-shadow: none; }
    button, a { display: none !important; }
}
</style>
@endsection
