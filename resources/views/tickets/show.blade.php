<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Digital Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- CHANGED max-w-4xl TO max-w-2xl HERE -->
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <!-- Actions -->
            <div class="mb-6 flex justify-between print:hidden">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center transition text-sm font-medium">
                    &larr; Back to Dashboard
                </a>
                <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-2 rounded-full shadow hover:bg-blue-700 font-bold flex items-center gap-2 transition text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Ticket
                </button>
                <a href="{{ route('tickets.download', $ticket->id) }}" class="bg-gray-800 text-white px-5 py-2 rounded-full font-bold flex items-center gap-2 text-sm ml-4">
                    Download PDF
                </a>
            </div>

            <!-- TICKET CONTAINER -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200 flex flex-col md:flex-row print:shadow-none print:border-2 print:border-black">

                <!-- LEFT SIDE (Main Details) -->
                <div class="flex-1 p-6 relative">
                    <!-- Agency Header -->
                    <div class="flex justify-between items-start border-b-2 border-dashed border-gray-300 pb-4 mb-4">
                        <div>
                            <h1 class="text-2xl font-black text-blue-800 uppercase tracking-wide">
                                {{ $ticket->seat->bus->agency->name }}
                            </h1>
                            <p class="text-[10px] text-gray-500 tracking-widest uppercase mt-0.5">Bus Travel Pass</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] text-gray-400 uppercase">Ref</span>
                            <span class="font-mono font-bold text-sm text-gray-700">{{ $ticket->booking->booking_reference }}</span>
                        </div>
                    </div>

                    <!-- Route Info -->
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">From</span>
                            <span class="text-xl font-bold text-gray-800 leading-tight">{{ $ticket->booking->trip->route->origin }}</span>
                        </div>
                        <div class="flex-1 px-2 text-center">
                            <span class="text-gray-300 text-xl">&rarr;</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">To</span>
                            <span class="text-xl font-bold text-gray-800 leading-tight">{{ $ticket->booking->trip->route->destination }}</span>
                        </div>
                    </div>

                    <!-- Trip Details Grid -->
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Date</span>
                            <span class="text-sm font-bold text-gray-800">
                                {{ $ticket->booking->trip->travel_date->format('d M') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Time</span>
                            <span class="text-sm font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($ticket->booking->trip->departure_time)->format('H:i') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Plate</span>
                            <span class="text-sm font-bold text-gray-800">
                                {{ $ticket->seat->bus->plate_number }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Passenger</span>
                            <span class="text-sm font-bold text-gray-800 truncate">
                                {{ $ticket->passenger_name }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase tracking-wider">Class</span>
                            <span class="text-sm font-bold text-gray-800 uppercase">
                                {{ $ticket->seat->class }}
                            </span>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="absolute top-6 right-6">
                        @if($ticket->status === 'active')
                            <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase border border-green-200">Valid</span>
                        @elseif($ticket->status === 'used')
                            <span class="bg-gray-100 text-gray-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase border border-gray-200">Used</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase border border-red-200">Cancelled</span>
                        @endif
                    </div>
                </div>

                <!-- CUT LINE (Visual) -->
                <div class="relative hidden md:block w-0 border-l-2 border-dashed border-gray-300 my-4">
                    <div class="absolute -top-4 -left-2 w-4 h-4 bg-gray-100 rounded-full"></div>
                    <div class="absolute -bottom-4 -left-2 w-4 h-4 bg-gray-100 rounded-full"></div>
                </div>

                <!-- RIGHT SIDE (QR Code & Seat) -->
                <div class="bg-blue-50 w-full md:w-56 p-6 flex flex-col items-center justify-center border-l border-gray-100 relative">

                    <div class="text-center mb-4">
                        <span class="block text-[10px] text-blue-400 uppercase tracking-widest font-bold">Seat</span>
                        <span class="text-5xl font-black text-blue-600">{{ $ticket->seat->seat_number }}</span>
                    </div>

                    <!-- QR Code -->
                    <div class="bg-white p-2 rounded-lg shadow-sm">
                        <!-- Reduced QR size slightly to fit compact card -->
                        {!! QrCode::size(120)->generate($ticket->ticket_number) !!}
                    </div>
                    <p class="text-[9px] text-gray-400 mt-2 text-center">Scan at check-in</p>

                     <div class="mt-6 text-center">
        <span class="block text-[10px] text-gray-400 uppercase">Ticket No.</span>
        <span class="font-mono text-sm font-bold text-gray-600 break-all">{{ $ticket->ticket_number }}</span>
    </div>
                </div>

            </div>

            <!-- Print Instructions -->
            <p class="text-center text-gray-400 text-xs mt-6 print:hidden">
                Save on phone or print before travel.
            </p>

        </div>
    </div>
</x-app-layout>
