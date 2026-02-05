@extends('layouts.superadmin')

@section('title', 'Add New Agency')
@section('page-title', 'Add New Agency')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Create New Agency</h5>
                        <a href="{{ route('superadmin.agencies.index') }}" class="btn btn-sm btn-outline-secondary">
                            <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Agencies
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('superadmin.agencies.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Agency Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Agency Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="e.g., Musango Express" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="agency@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone"
                                class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}" placeholder="+237 600 000 000" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Full address of the agency">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Brief description about the agency">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Agency Logo</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max: 2MB)</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commission Rate -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Commission Rate (%)</label>
                            <input type="number" name="commission_rate" step="0.01" min="0" max="100"
                                class="form-control @error('commission_rate') is-invalid @enderror"
                                value="{{ old('commission_rate', '10') }}" placeholder="10.00">
                            <small class="text-muted">Percentage commission per booking</small>
                            @error('commission_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Agency Admin Account</h6>

                        <!-- Admin Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Admin Name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_name"
                                class="form-control @error('admin_name') is-invalid @enderror"
                                value="{{ old('admin_name') }}" placeholder="Full name" required>
                            @error('admin_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Admin Email -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Admin Email <span class="text-danger">*</span></label>
                            <input type="email" name="admin_email"
                                class="form-control @error('admin_email') is-invalid @enderror"
                                value="{{ old('admin_email') }}" placeholder="admin@example.com" required>
                            @error('admin_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Admin Password -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Admin Password <span class="text-danger">*</span></label>
                            <input type="password" name="admin_password"
                                class="form-control @error('admin_password') is-invalid @enderror"
                                placeholder="Minimum 8 characters" required>
                            @error('admin_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <svg class="w-5 h-5 inline-block me-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Create Agency
                            </button>
                            <a href="{{ route('superadmin.agencies.index') }}"
                                class="btn btn-outline-secondary btn-lg px-5">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
