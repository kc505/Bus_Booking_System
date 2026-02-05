@extends('layouts.superadmin')

@section('title', 'Profile Settings - BusCam')

@section('page-title', 'Profile Settings')

@section('content')
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <!-- Profile Information Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                    <div class="card-header bg-gradient-primary text-white py-4">
                        <h4 class="mb-0 fw-bold">Profile Information</h4>
                        <p class="mb-0 opacity-75">Manage your account details</p>
                    </div>

                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">Full Name *</label>
                                <input id="name" name="name" type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email Address *</label>
                                <input id="email" name="email" type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input id="phone" name="phone" type="tel" class="form-control form-control-lg"
                                    value="{{ old('phone', $user->phone ?? '') }}">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-gradient-danger text-white py-4">
                        <h4 class="mb-0 fw-bold">Change Password</h4>
                    </div>

                    <div class="card-body p-4 p-lg-5">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="current_password" class="form-label fw-semibold">Current Password *</label>
                                <input id="current_password" name="current_password" type="password"
                                    class="form-control form-control-lg @error('current_password') is-invalid @enderror"
                                    required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">New Password *</label>
                                <input id="password" name="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror" required
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password
                                    *</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control form-control-lg" required autocomplete="new-password">
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-danger btn-lg px-5">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
