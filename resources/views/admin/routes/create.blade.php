@extends('layouts.admin')

@section('page-title', 'Add New Route')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.routes.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Routes
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-dark-900 mb-6">Add New Route</h2>

            <form action="{{ route('admin.routes.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Agency Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Select Agency *</label>
                        <select name="agency_id" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <option value="">Choose an agency</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}" {{ old('agency_id') == $agency->id ? 'selected' : '' }}>
                                    {{ $agency->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('agency_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Origin -->
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Origin City *</label>
                            <select name="origin" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Select origin</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->name }}" {{ old('origin') == $city->name ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('origin')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Destination -->
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Destination City *</label>
                            <select name="destination" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Select destination</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->name }}" {{ old('destination') == $city->name ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Price (FCFA) *</label>
                            <input type="number" name="base_price" required min="0" step="100" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('base_price') }}">
                            @error('base_price')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-semibold text-dark-700 mb-2">Duration (minutes) *</label>
                            <input type="number" name="estimated_duration_minutes" required min="1" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('estimated_duration_minutes') }}">
                            @error('estimated_duration_minutes')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-dark-500 mt-1">Example: 240 minutes = 4 hours</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.routes.index') }}" class="px-6 py-3 border border-dark-300 rounded-lg font-semibold text-dark-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors">
                            Create Route
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
