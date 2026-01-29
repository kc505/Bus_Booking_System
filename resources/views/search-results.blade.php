<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Trips') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold">
                        Trips from {{ request('origin') }} to {{ request('destination') }}
                    </h3>
                    <p class="text-gray-600">{{ $trips->count() }} trips found</p>
                </div>
            </div>

            <!-- Trip Results -->
            @if($trips->count() > 0)
                <div class="space-y-4">
                    @foreach($trips as $trip)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-xl font-semibold text-gray-900">{{ $trip->bus->agency->name ?? 'Agency' }}</h4>
                                    <p class="text-gray-600 mt-1">
                                        {{ $trip->route->origin ?? 'Origin' }} → {{ $trip->route->destination ?? 'Destination' }}
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Departure: {{ $trip->departure_time }}
                                        @if(isset($trip->route->estimated_duration_minutes))
                                        | Duration: {{ floor($trip->route->estimated_duration_minutes / 60) }}h {{ $trip->route->estimated_duration_minutes % 60 }}m
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Bus: {{ $trip->bus->brand ?? 'Bus' }} ({{ $trip->bus->plate_number ?? 'N/A' }})
                                    </p>
                                </div>

                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600">
                                        XAF {{ number_format($trip->price) }}
                                    </div>
                                    <p class="text-sm text-gray-500">per seat</p>

                                    <div class="mt-3">
                                        @auth
                                            <!-- This button links to the route named 'trips.book' -->
                                            <a href="{{ route('trips.book', $trip->id) }}"
                                               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-semibold">
                                                Select Seats
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}"
                                               class="inline-block bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700 font-semibold">
                                                Login to Book
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <h3 class="text-lg font-semibold text-gray-900">No trips found</h3>
                        <p class="text-gray-600 mt-2">Sorry, no buses are available for your selected route and date.</p>
                        <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
