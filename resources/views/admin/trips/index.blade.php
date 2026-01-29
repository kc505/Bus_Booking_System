@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-display font-bold text-dark-900">Manage Trips</h1>
                    <p class="text-dark-600 mt-2">View and manage all scheduled trips</p>
                </div>
                <a href="{{ route('admin.trips.create') }}" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-lg font-semibold transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Schedule New Trip
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Trips Table -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-dark-50 border-b border-dark-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Route</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Agency</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Date & Time</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Departure</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Price</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Available Seats</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-dark-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-dark-100">
                        @forelse($trips as $trip)
                            <tr class="hover:bg-dark-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-dark-900">
                                        {{ $trip->route->departureCity->name ?? $trip->route->origin ?? 'N/A' }}
                                        →
                                        {{ $trip->route->destinationCity->name ?? $trip->route->destination ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-dark-500">
                                        {{ $trip->route->agency->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-dark-500">
                                        {{ $trip->route->agency->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <!-- FIXED: Using travel_date instead of departure_date -->
                                    <div class="font-semibold text-dark-900">
                                        {{ $trip->travel_date ? $trip->travel_date->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div class="text-sm text-dark-500">
                                        {{ $trip->departure_time ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-dark-700">
                                    {{ $trip->departure_time ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-primary-600">
                                        {{ number_format($trip->price ?? 0) }} FCFA
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        try {
                                            $availableCount = $trip->availableSeats()->count();
                                            $totalSeats = $trip->bus ? $trip->bus->capacity : 64;
                                        } catch (\Exception $e) {
                                            $availableCount = 0;
                                            $totalSeats = 64;
                                            \Log::error('Error counting available seats for trip ' . $trip->id . ': ' . $e->getMessage());
                                        }
                                    @endphp
                                    <span class="font-semibold text-dark-700">
                                        {{ $availableCount }}/{{ $totalSeats }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColors = [
                                            'scheduled' => 'bg-blue-100 text-blue-800',
                                            'delayed' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                        ];
                                        $color = $statusColors[$trip->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.trips.edit', $trip->id) }}" class="text-primary-600 hover:text-primary-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.trips.delete', $trip->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-dark-400">
                                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        <p class="text-lg font-semibold text-dark-700 mb-2">No trips scheduled yet</p>
                                        <p class="text-dark-500">Click "Schedule New Trip" to create your first trip</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($trips->hasPages())
                <div class="px-6 py-4 border-t border-dark-200">
                    {{ $trips->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
