@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Agency</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.agencies.update', $agency->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Agency Name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agency Name *</label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $agency->name) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Email *</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $agency->email) }}" required>
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Phone -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Phone *</label>
                                <input type="tel" name="phone" class="form-control"
                                       value="{{ old('phone', $agency->phone) }}" required>
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control"
                                       value="{{ old('address', $agency->address) }}">
                                @error('address')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Logo Upload -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agency Logo</label>
                                @if($agency->logo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $agency->logo) }}" alt="Current Logo" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                @endif
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                <small class="text-muted">Leave empty to keep current logo</small>
                                @error('logo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="is_active" class="form-select" required>
                                    <option value="1" {{ $agency->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$agency->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('is_active')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4">{{ old('description', $agency->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.agencies.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Agency
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
