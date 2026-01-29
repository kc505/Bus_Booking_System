@extends('layouts.admin')

@section('page-title', 'Add New Agency')

@section('content')
<div class="p-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.agencies.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Agencies
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-2xl font-bold text-dark-900 mb-6">Add New Agency</h2>

            <form action="{{ route('admin.agencies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <!-- Agency Name -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Agency Name *</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Email</label>
                        <input type="email" name="email" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Logo Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">Logo (Optional)</label>
                        <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('logo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-dark-500 mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <a href="{{ route('admin.agencies.index') }}" class="px-6 py-3 border border-dark-300 rounded-lg font-semibold text-dark-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-semibold transition-colors">
                            Create Agency
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
