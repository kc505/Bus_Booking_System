@extends('layouts.superadmin')

@section('title', 'Edit Agency')
@section('page-title', 'Edit Agency')

@section('content')
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">Edit Agency: {{ $agency->name }}</h5>
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
                    <form action="{{ route('superadmin.agencies.update', $agency) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Agency Name -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Agency Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                value="{{ old('name', $agency->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email', $agency->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone"
                                class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $agency->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $agency->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $agency->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Logo -->
                        @if ($agency->logo)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Logo</label>
                                <div>
                                    <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name }}"
                                        class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Logo Upload -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Update Logo (Optional)</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                accept="image/*">
                            <small class="text-muted">Leave empty to keep current logo</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Commission Rate -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Commission Rate (%)</label>
                            <input type="number" name="commission_rate" step="0.01" min="0" max="100"
                                class="form-control @error('commission_rate') is-invalid @enderror"
                                value="{{ old('commission_rate', $agency->commission_rate) }}">
                            @error('commission_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $agency->status) == 'active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="suspended"
                                    {{ old('status', $agency->status) == 'suspended' ? 'selected' : '' }}>Suspended
                                </option>
                            </select>
                            @error('status')
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
                                Update Agency
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
