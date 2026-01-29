<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cameroon Bus Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Book Your Bus Ticket</h3>
                    <form action="{{ route('search.submit') }}" method="POST" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">From</label>
                            <input type="text" name="origin" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Departure city" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">To</label>
                            <input type="text" name="destination" class="mt-1 block w-full border border-gray-300 rounded-md p-2" placeholder="Arrival city" required>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="travel_date" class="mt-1 block w-full border border-gray-300 rounded-md p-2" min="{{ now()->format('Y-m-d') }}" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                                Search Buses
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Featured Agencies -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4">Trusted Bus Agencies</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($agencies as $agency)
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <h4 class="font-semibold text-lg">{{ $agency->name }}</h4>
                        <p class="text-gray-600">{{ $agency->phone }}</p>
                        <p class="text-sm text-gray-500">{{ $agency->address }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Featured Trips -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Available Trips</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($featuredTrips as $trip)
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold">{{ $trip->bus->agency->name }}</h4>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">XAF{{ number_format($trip->price) }}</span>
                        </div>
                        <p class="text-gray-600">{{ $trip->route->origin }} → {{ $trip->route->destination }}</p>
                        <p class="text-sm text-gray-500">{{ $trip->travel_date->format('D, M j') }} at {{ $trip->departure_time }}</p>
                        <a href="{{ route('trips.show', $trip) }}" class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                            View Details
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
