<div class="max-w-7xl mx-auto py-8 px-4">
    <h2 class="text-3xl font-bold text-gray-900 mb-8">Search Available Trips</h2>

    <!-- Search Form Container -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <!-- Added wire:submit to handle the Enter key on text inputs -->
        <form wire:submit.prevent="searchTrips" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

            <!-- Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Travel Date</label>
                <input type="date"
                       wire:model.live="date"
                       min="{{ $minDate }}"
                       max="{{ $maxDate }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Departure Time -->
            <div>
                   <label class="block text-sm font-medium text-gray-700 mb-1">Departure Time</label>
                   <!-- wire:model.live ensures it updates immediately on change -->
                   <select wire:model.live="time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">All Times</option>
                        <option value="07:00">07:00 AM</option>
                        <option value="19:00">07:00 PM</option>
                    </select>
            </div>

            <!-- From -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From</label>
                <!-- wire:model.defer waits for "Search" button press -->
                <input type="text" wire:model.defer="from" placeholder="e.g. Yaoundé"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- To -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To</label>
                <input type="text" wire:model.defer="to" placeholder="e.g. Douala"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Agency -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agency</label>
                <select wire:model.defer="agency_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Agencies</option>
                    @foreach($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Search Button -->
            <div class="lg:col-span-5 flex justify-end">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-md transition duration-150 ease-in-out shadow-md">
                    🔍 Search Trips
                </button>
            </div>
        </form>
    </div>

    <!-- Results Grid -->
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($trips as $trip)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition border border-gray-100">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-700 to-blue-500 text-white p-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold truncate">
                            {{ $trip->route->origin }} <span class="text-blue-200">→</span> {{ $trip->route->destination }}
                        </h3>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-2 py-1 text-xs font-bold bg-blue-100 text-blue-800 rounded-full">
                            {{ $trip->bus->agency->name }}
                        </span>
                        <span class="text-sm text-gray-500 font-medium">
                            Bus: {{ $trip->bus->plate_number ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="border-t border-gray-100 pt-3">
                        <p class="text-gray-700 flex items-center gap-2">
                            📅 {{ \Carbon\Carbon::parse($trip->travel_date)->format('D, M d, Y') }}
                        </p>
                        <p class="text-gray-700 flex items-center gap-2 mt-1">
                            <!-- FIXED: Using parse() handles 07:00:00 correctly -->
                            ⏰ {{ \Carbon\Carbon::parse($trip->departure_time)->format('g:i A') }}
                        </p>
                    </div>

                    <p class="text-2xl font-bold text-gray-900 pt-2">
                        {{ number_format($trip->price) }} <span class="text-sm font-normal text-gray-500">FCFA</span>
                    </p>
                </div>

                <!-- Card Footer -->
                <div class="bg-gray-50 px-5 py-4 border-t">
                    <div class="mt-4">
                     <!-- Check if user is logged in -->
                        @auth
                            <a href="{{ route('trips.book', $trip->id) }}"
                            class="inline-block w-full text-center bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 font-bold transition duration-150 ease-in-out">
                            Select Seats
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                            class="inline-block w-full text-center bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 font-bold transition duration-150 ease-in-out">
                            Login to Book
                            </a>
                        @endauth
                    </div>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-lg shadow text-center">
                <div class="text-gray-400 text-6xl mb-4">🚌</div>
                <h3 class="text-xl font-medium text-gray-900">No trips found</h3>
                <p class="text-gray-500 mt-2">Try changing the date or removing some filters.</p>
            </div>
        @endforelse
    </div>

    <!-- Loading Indicator (Optional UX Improvement) -->
    <div wire:loading wire:target="searchTrips, date, time" class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center gap-3">
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="font-medium text-gray-700">Finding Buses...</span>
        </div>
    </div>
</div>
