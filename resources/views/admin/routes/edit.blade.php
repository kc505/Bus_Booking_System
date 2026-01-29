@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-display font-bold text-dark-900">Edit Route</h1>
                    <p class="text-dark-600 mt-2">Update route information</p>
                </div>
                <a href="{{ route('admin.routes.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Routes
                </a>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <form action="{{ route('admin.routes.update', $route->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Agency Selection -->
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">
                        Agency *
                    </label>
                    <select name="agency_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <option value="">Select an agency</option>
                        @foreach($agencies as $agency)
                            <option value="{{ $agency->id }}" {{ old('agency_id', $route->agency_id) == $agency->id ? 'selected' : '' }}>
                                {{ $agency->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('agency_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Departure City -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Departure City *
                        </label>
                        <select name="departure_city_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                            <option value="">Select departure city</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('departure_city_id', $route->departure_city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('departure_city_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Destination City -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Destination City *
                        </label>
                        <select name="destination_city_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                            <option value="">Select destination city</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('destination_city_id', $route->destination_city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('destination_city_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Duration (minutes) *
                        </label>
                        <input
                            type="number"
                            name="estimated_duration_minutes"
                            value="{{ old('estimated_duration_minutes', $route->estimated_duration_minutes) }}"
                            min="0"
                            required
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="180"
                        >
                        @error('estimated_duration_minutes')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Base Price (FCFA) *
                        </label>
                        <input
                            type="number"
                            name="base_price"
                            value="{{ old('base_price', $route->base_price) }}"
                            min="0"
                            step="100"
                            required
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="5000"
                        >
                        @error('base_price')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Distance -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Distance (km)
                        </label>
                        <input
                            type="number"
                            name="distance_km"
                            value="{{ old('distance_km', $route->distance_km ?? $route->distance) }}"
                            min="0"
                            class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                            placeholder="250"
                        >
                        @error('distance_km')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $route->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-600 border-dark-300 rounded focus:ring-primary-500"
                        >
                        <span class="ml-2 text-sm font-semibold text-dark-700">Route is active</span>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-dark-200">
                    <a href="{{ route('admin.routes.index') }}" class="text-dark-600 hover:text-dark-800 font-semibold">
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105"
                    >
                        Update Route
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
