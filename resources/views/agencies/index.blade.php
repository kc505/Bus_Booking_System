@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-display font-bold text-dark-900 mb-4">Choose Your Bus Agency</h1>
            <p class="text-xl text-dark-600">Select from our trusted partners for your journey across Cameroon</p>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Search Agency</label>
                    <input type="text" id="searchAgency" placeholder="Search by name..." class="w-full px-4 py-2.5 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Departure City</label>
                    <select id="departureCity" class="w-full px-4 py-2.5 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <option value="">All Cities</option>
                        <option value="yaounde">Yaoundé</option>
                        <option value="douala">Douala</option>
                        <option value="bamenda">Bamenda</option>
                        <option value="bafoussam">Bafoussam</option>
                        <option value="garoua">Garoua</option>
                        <option value="maroua">Maroua</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-dark-700 mb-2">Destination</label>
                    <select id="destination" class="w-full px-4 py-2.5 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">
                        <option value="">All Cities</option>
                        <option value="yaounde">Yaoundé</option>
                        <option value="douala">Douala</option>
                        <option value="bamenda">Bamenda</option>
                        <option value="bafoussam">Bafoussam</option>
                        <option value="garoua">Garoua</option>
                        <option value="maroua">Maroua</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="filterBtn" class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-2.5 rounded-lg font-semibold transition-all transform hover:scale-105">
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Agency Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="agencyGrid">
            @forelse($agencies as $agency)
            <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group agency-card" data-agency="{{ strtolower($agency->name) }}">
                <!-- Agency Header with Logo -->
                <div class="relative h-48 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                    @if($agency->logo)
                        <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name }}" class="h-24 w-24 object-contain">
                    @else
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center">
                            <span class="text-4xl font-display font-bold text-primary-600">{{ substr($agency->name, 0, 1) }}</span>
                        </div>
                    @endif

                    <!-- Rating Badge -->
                    <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full flex items-center space-x-1">
                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-sm font-semibold text-dark-700">{{ number_format($agency->rating, 1) }}</span>
                    </div>
                </div>

                <!-- Agency Info -->
                <div class="p-6">
                    <h3 class="text-2xl font-display font-bold text-dark-900 mb-2">{{ $agency->name }}</h3>
                    <p class="text-dark-600 mb-4 line-clamp-2">{{ $agency->description }}</p>

                    <!-- Features -->
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-dark-600">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>{{ $agency->routes_count }} Routes Available</span>
                        </div>
                        <div class="flex items-center text-sm text-dark-600">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>7:00 AM & 7:00 PM Departures</span>
                        </div>
                        <div class="flex items-center text-sm text-dark-600">
                            <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $agency->total_buses }} Modern Buses</span>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="flex items-center justify-between mb-6 pb-6 border-b border-dark-200">
                        <div>
                            <p class="text-xs text-dark-500 mb-1">Starting from</p>
                            <p class="text-2xl font-display font-bold text-primary-600">{{ number_format($agency->min_price) }} FCFA</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-dark-500 mb-1">Available Seats</p>
                            <p class="text-lg font-semibold text-dark-700">32 seats/bus</p>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('routes.select', $agency->id) }}" class="block w-full bg-primary-600 hover:bg-primary-700 text-white text-center px-6 py-3 rounded-lg font-semibold transition-all transform group-hover:scale-105">
                        Select & Continue
                        <svg class="inline-block ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <svg class="w-24 h-24 text-dark-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-dark-700 mb-2">No Agencies Found</h3>
                <p class="text-dark-500">Try adjusting your search filters</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($agencies->hasPages())
        <div class="mt-8">
            {{ $agencies->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchAgency');
    const filterBtn = document.getElementById('filterBtn');
    const agencyCards = document.querySelectorAll('.agency-card');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        agencyCards.forEach(card => {
            const agencyName = card.dataset.agency;
            if (agencyName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter button (you can expand this for AJAX filtering)
    filterBtn.addEventListener('click', function() {
        // This would typically make an AJAX call to filter results
        console.log('Filtering agencies...');
    });
});
</script>
@endpush
@endsection
