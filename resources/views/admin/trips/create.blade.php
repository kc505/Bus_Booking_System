@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-display font-bold text-dark-900">Schedule New Trip</h1>
                    <p class="text-dark-600 mt-2">{{ now()->format('l, F j, Y') }}</p>
                </div>
                <a href="{{ route('admin.trips.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Trips
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-display font-bold text-dark-900 mb-6">Schedule New Trip</h2>

            <form action="{{ route('admin.trips.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Select Route -->
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">
                        Select Route *
                    </label>
                    <select name="route_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <option value="">Choose a route</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                <!-- FIXED: Using null coalescing operators properly -->
                                {{ $route->departureCity->name ?? $route->origin ?? 'Unknown' }}
                                →
                                {{ $route->destinationCity->name ?? $route->destination ?? 'Unknown' }}
                                ({{ $route->agency->name ?? 'No Agency' }})
                            </option>
                        @endforeach
                    </select>
                    @error('route_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Select Bus -->
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">
                        Select Bus *
                    </label>
                    <select name="bus_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <option value="">Choose a bus</option>
                        @foreach($buses as $bus)
                            <option value="{{ $bus->id }}" {{ old('bus_id') == $bus->id ? 'selected' : '' }}>
                                {{ $bus->bus_number }} - {{ $bus->agency->name ?? 'No Agency' }} ({{ $bus->capacity }} seats)
                            </option>
                        @endforeach
                    </select>
                    @error('bus_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Travel Date (FIXED: Changed from departure_date) -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Travel Date *
                        </label>
                        <input
                            type="date"
                            name="travel_date"
                            value="{{ old('travel_date', now()->format('Y-m-d')) }}"
                            min="{{ now()->format('Y-m-d') }}"
                            required
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                        >
                        @error('travel_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Departure Time -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Departure Time *
                        </label>
                        <select name="departure_time" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                            <option value="">Select time</option>
                            <option value="07:00" {{ old('departure_time') == '07:00' ? 'selected' : '' }}>7:00 AM</option>
                            <option value="19:00" {{ old('departure_time') == '19:00' ? 'selected' : '' }}>7:00 PM</option>
                        </select>
                        @error('departure_time')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-dark-500 mt-1">
                            Seats 1-32 are for online booking. Maximum: 32
                        </p>
                    </div>
                </div>

                <!-- Available Seats (Info Display) -->
                <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-primary-700">
                            Seats 1-32 are available for online booking. Maximum: 32 seats per trip.
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Ticket Price (FCFA) *
                        </label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            min="0"
                            step="100"
                            required
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="5000"
                        >
                        @error('price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Status *
                        </label>
                        <select name="status" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                            <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="delayed" {{ old('status') == 'delayed' ? 'selected' : '' }}>Delayed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-dark-200">
                    <a href="{{ route('admin.trips.index') }}" class="text-dark-600 hover:text-dark-800 font-semibold">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105"
                    >
                        Schedule Trip
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
