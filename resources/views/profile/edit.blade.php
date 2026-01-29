@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-display font-bold text-dark-900">Profile Settings</h1>
            <p class="text-dark-600 mt-2">Manage your account information and preferences</p>
        </div>

        <!-- Success Message -->
        @if (session('status') === 'profile-updated')
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Profile updated successfully!
                </div>
            </div>
        @endif

        <!-- Profile Information Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-display font-bold text-dark-900 mb-6">Profile Information</h2>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-dark-700 mb-2">
                        Full Name *
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-dark-700 mb-2">
                        Email Address *
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-2 text-sm">
                            <p class="text-yellow-600">
                                Your email address is unverified.
                                <button form="send-verification" class="underline text-yellow-700 hover:text-yellow-800">
                                    Click here to re-send the verification email.
                                </button>
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Phone (Optional) -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-dark-700 mb-2">
                        Phone Number
                    </label>
                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $user->phone ?? '') }}"
                        placeholder="+237 XXX XXX XXX"
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="flex items-center justify-end pt-4 border-t border-dark-200">
                    <button
                        type="submit"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-xl font-display font-bold text-dark-900 mb-6">Change Password</h2>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-dark-700 mb-2">
                        Current Password *
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-dark-700 mb-2">
                        New Password *
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-dark-700 mb-2">
                        Confirm New Password *
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all"
                    >
                </div>

                <!-- Save Button -->
                <div class="flex items-center justify-end pt-4 border-t border-dark-200">
                    <button
                        type="submit"
                        class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-all transform hover:scale-105"
                    >
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <h2 class="text-xl font-display font-bold text-red-900 mb-4">Delete Account</h2>
            <p class="text-red-700 mb-4">
                Once your account is deleted, all of its resources and data will be permanently deleted.
                Before deleting your account, please download any data or information that you wish to retain.
            </p>

            <button
                type="button"
                onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all"
            >
                Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-dark-900 mb-4">Are you sure?</h3>
        <p class="text-dark-600 mb-6">
            Once your account is deleted, all of its resources and data will be permanently deleted.
            Please enter your password to confirm you would like to permanently delete your account.
        </p>

        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')

            <div class="mb-6">
                <label for="password_delete" class="block text-sm font-semibold text-dark-700 mb-2">
                    Password *
                </label>
                <input
                    type="password"
                    id="password_delete"
                    name="password"
                    required
                    class="w-full px-4 py-3 border border-dark-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all"
                >
            </div>

            <div class="flex items-center space-x-4">
                <button
                    type="button"
                    onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
                    class="flex-1 bg-dark-200 hover:bg-dark-300 text-dark-700 px-6 py-3 rounded-lg font-semibold transition-all"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-all"
                >
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Verification Email Form (hidden) -->
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif
@endsection
