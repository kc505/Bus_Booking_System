@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Trip</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.trips.update', $trip->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <!-- Route Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Route *</label>
                                <select name="route_id" class="form-select" required>
                                    <option value="">Select Route</option>
                                    @foreach($routes as $route)
                                        <option value="{{ $route->id }}" {{ $trip->route_id == $route->id ? 'selected' : '' }}>
                                            {{ $route->origin }} → {{ $route->destination }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bus Selection -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bus *</label>
                                <select name="bus_id" class="form-select" required>
                                    <option value="">Select Bus</option>
                                    @foreach($buses as $bus)
                                        <option value="{{ $bus->id }}" {{ $trip->bus_id == $bus->id ? 'selected' : '' }}>
                                            {{ $bus->name }} ({{ $bus->agency->name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Departure Date -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departure Date *</label>
                                <input type="date" name="departure_date" class="form-control"
                                       value="{{ $trip->departure_date }}" required>
                            </div>

                            <!-- Departure Time -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Departure Time *</label>
                                <select name="departure_time" class="form-select" required>
                                    <option value="07:00" {{ $trip->departure_time == '07:00:00' ? 'selected' : '' }}>7:00 AM</option>
                                    <option value="19:00" {{ $trip->departure_time == '19:00:00' ? 'selected' : '' }}>7:00 PM</option>
                                </select>
                            </div>

                            <!-- Available Seats -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Available Seats *</label>
                                <input type="number" name="available_seats" class="form-control"
                                       value="{{ $trip->available_seats }}" min="1" max="64" required>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (FCFA) *</label>
                                <input type="number" name="price" class="form-control"
                                       value="{{ $trip->price }}" min="0" step="0.01" required>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select" required>
                                    <option value="scheduled" {{ $trip->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="completed" {{ $trip->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $trip->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Trip
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
