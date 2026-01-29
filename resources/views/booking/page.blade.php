<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Your Seat') }}
        </h2>
    </x-slot>

    <!-- CUSTOM CSS -->
    <style>
        /* Hide the actual radio circle input */
        .seat-radio {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* Default Seat Style */
        .seat-box {
            height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 2px solid #60a5fa; /* Light Blue Border */
            background-color: white;
            color: #1f2937;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Hover Effect */
        .seat-box:hover {
            background-color: #eff6ff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* WHEN SELECTED (Turns Blue) */
        .seat-radio:checked + .seat-box {
            background-color: #2563eb !important; /* Blue-600 */
            color: white !important;
            border-color: #1d4ed8 !important;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.2);
        }

        /* WHEN TAKEN (Grey) */
        .seat-box.taken {
            background-color: #d1d5db; /* Grey-300 */
            border-color: #9ca3af;
            color: #6b7280;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.7;
        }

        /* OFFLINE SEATS (Static/Grey) */
        .seat-offline {
            height: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background-color: #e5e7eb;
            color: #9ca3af;
            border: 1px solid #d1d5db;
        }

        /* GRID ENFORCEMENT: Ensures exactly 2 seats per row */
        .bus-grid-2-cols {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            column-gap: 10px; /* Space between the two seats */
            row-gap: 15px;    /* Space between rows (legroom) */
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @php
                        $booked = $takenSeats ?? [];
                    @endphp

                    <!-- 1. TRIP INFO -->
                    <div class="mb-6 pb-4 border-b flex justify-between items-center flex-wrap gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Trip #{{ $trip->id }}</h3>
                            <p class="text-gray-600">
                                Agency: <span class="font-bold text-blue-700">{{ $trip->bus->agency->name ?? 'N/A' }}</span>
                            </p>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $trip->route->origin ?? 'Origin' }} &rarr; {{ $trip->route->destination ?? 'Destination' }}
                            </p>
                        </div>
                        <div class="text-right">
                             <div class="text-sm text-gray-500">Price</div>
                             <p class="text-3xl font-bold text-blue-600">{{ number_format($trip->price ?? 0) }} FCFA</p>
                        </div>
                    </div>

                    <!-- 2. LEGEND -->
                    <div class="flex flex-wrap gap-6 mb-8 text-sm font-medium justify-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="flex items-center"><div class="w-6 h-6 bg-white border-2 border-blue-400 rounded mr-2"></div> Available</div>
                        <div class="flex items-center"><div class="w-6 h-6 bg-gray-300 border border-gray-400 rounded mr-2"></div> Taken</div>
                        <div class="flex items-center"><div class="w-6 h-6 bg-blue-600 rounded mr-2 shadow-sm"></div> Selected</div>
                    </div>

                    <!-- 3. ERROR DISPLAY -->
                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded relative mb-6 shadow-sm">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- 4. MAIN FORM -->
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                        <!-- BUS CHASSIS CONTAINER -->
                        <div class="bg-slate-100 p-8 rounded-[30px] border-4 border-slate-800 relative max-w-6xl mx-auto shadow-2xl">

                            <!-- Driver Area -->
                            <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white px-8 py-2 rounded-lg text-sm font-bold uppercase tracking-widest shadow-lg border-b-4 border-slate-600">
                                Front (Driver)
                            </div>

                            <!-- MAIN LAYOUT: Left Side | Aisle | Right Side -->
                            <!-- We use 'flex-row' to keep them side by side -->
                            <div class="flex flex-row justify-between gap-6 sm:gap-16 mt-8">

                                <!-- === LEFT SIDE (ONLINE) === -->
                                <div class="flex-1">
                                    <div class="text-center mb-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full border border-blue-200">
                                            ONLINE (Seats 1-32)
                                        </span>
                                    </div>

                                    <!-- The Grid: 2 Columns Strict -->
                                    <div class="bus-grid-2-cols p-4 border-r-2 border-dashed border-gray-300">
                                        @for ($i = 1; $i <= 32; $i++)
                                            @php $isTaken = in_array($i, $booked); @endphp

                                            <label class="relative block w-full">
                                                <input type="radio"
                                                       name="seat_number"
                                                       value="{{ $i }}"
                                                       class="seat-radio"
                                                       {{ $isTaken ? 'disabled' : '' }}
                                                       required>

                                                <div class="seat-box {{ $isTaken ? 'taken' : '' }}">
                                                    <span class="text-[10px] uppercase font-bold opacity-60">Seat</span>
                                                    <span class="text-xl font-bold leading-none">{{ $i }}</span>
                                                </div>
                                            </label>
                                        @endfor
                                    </div>
                                </div>

                                <!-- === THE AISLE === -->
                                <div class="hidden sm:flex flex-col justify-center items-center opacity-10">
                                    <span class="writing-vertical font-bold text-4xl tracking-widest text-slate-400" style="writing-mode: vertical-rl; transform: rotate(180deg);">
                                        AISLE
                                    </span>
                                </div>

                                <!-- === RIGHT SIDE (OFFLINE) === -->
                                <div class="flex-1">
                                    <div class="text-center mb-4">
                                        <span class="bg-gray-200 text-gray-600 text-xs font-bold px-3 py-1 rounded-full border border-gray-300">
                                            OFFLINE (Counter)
                                        </span>
                                    </div>

                                    <!-- The Grid: 2 Columns Strict -->
                                    <div class="bus-grid-2-cols p-4 border-l-2 border-dashed border-gray-300">
                                        @for ($i = 33; $i <= 70; $i++)
                                            <div class="seat-offline">
                                                <span class="text-[9px] uppercase font-bold opacity-50">Counter</span>
                                                <span class="text-lg font-bold leading-none">{{ $i }}</span>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                            </div>

                            <!-- Back of Bus -->
                            <div class="mt-8 border-t-4 border-slate-300 pt-3 text-center text-slate-400 text-xs uppercase tracking-widest font-bold">
                                Back of Bus
                            </div>

                        </div>

                        <!-- SUBMIT BUTTON -->
                        <div class="mt-10 flex justify-center">
                            <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-4 px-16 rounded-full shadow-xl transform transition hover:scale-105 flex items-center gap-3 text-lg">
                                <span>Confirm Booking</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
