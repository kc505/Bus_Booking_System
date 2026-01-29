@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Steps -->
        <div class="mb-12">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold">
                        ✓
                    </div>
                    <span class="ml-2 text-sm font-semibold text-primary-600">Agency</span>
                </div>
                <div class="w-16 h-1 bg-primary-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-primary-600 text-white rounded-full flex items-center justify-center font-bold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-semibold text-primary-600">Route</span>
                </div>
                <div class="w-16 h-1 bg-dark-200"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-dark-200 text-dark-500 rounded-full flex items-center justify-center font-bold">
                        3
                    </div>
                    <span class="ml-2 text-sm text-dark-500">Seat</span>
                </div>
                <div class="w-16 h-1 bg-dark-200"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-dark-200 text-dark-500 rounded-full flex items-center justify-center font-bold">
                        4
                    </div>
                    <span class="ml-2 text-sm text-dark-500">Payment</span>
                </div>
            </div>
        </div>

        <!-- Selected Agency Info -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if($agency->logo)
                        <img src="{{ asset('storage/' . $agency->logo) }}" alt="{{ $agency->name }}" class="h-16 w-16 object-contain">
                    @else
                        <div class="w-16 h-16 bg-primary-100 rounded-lg flex items-center justify-center">
                            <span class="text-2xl font-display font-bold text-primary-600">{{ substr($agency->name, 0, 1) }}</span>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-dark-500">Selected Agency</p>
                        <h2 class="text-2xl font-display font-bold text-dark-900">{{ $agency->name }}</h2>
                    </div>
                </div>
                <a href="{{ route('agencies.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold">
                    Change Agency
                </a>
            </div>
        </div>

        <!-- Route Selection Form -->
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-3xl font-display font-bold text-dark-900 mb-6">Select Your Route & Travel Date</h2>

            <form action="{{ route('seats.select') }}" method="GET" id="routeForm">
                <input type="hidden" name="agency_id" value="{{ $agency->id }}">

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <!-- Departure City -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Departure City *
                        </label>
                        <div class="relative">
                            <select name="departure_city" id="departureCity" required
                                class="w-full px-4 py-3 pr-10 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white text-dark-900">
                                <option value="">Select departure city</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Destination City -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Destination City *
                        </label>
                        <div class="relative">
                            <select name="destination_city" id="destinationCity" required
                                class="w-full px-4 py-3 pr-10 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white text-dark-900">
                                <option value="">Select destination city</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Route Info Display -->
                <div id="routeInfo" class="hidden bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-primary-700 mb-1">Estimated Journey Duration</p>
                            <p class="text-2xl font-bold text-primary-900" id="duration">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-primary-700 mb-1">Ticket Price</p>
                            <p class="text-2xl font-bold text-primary-900" id="price">-</p>
                        </div>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <!-- Travel Date -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Travel Date *
                        </label>
                        <div class="relative">
                            <select name="travel_date" id="travelDate" required
                                class="w-full px-4 py-3 pr-10 border border-dark-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all bg-white text-dark-900">
                                <option value="">Select travel date</option>
                                @foreach($availableDates as $date)
                                    <option value="{{ $date['value'] }}" {{ $date['is_past'] ? 'disabled' : '' }}>
                                        {{ $date['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-dark-500 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            New week unlocks every Saturday at 7:05 PM
                        </p>
                    </div>

                    <!-- Departure Time -->
                    <div>
                        <label class="block text-sm font-semibold text-dark-700 mb-2">
                            Departure Time *
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Morning Option -->
                            <div class="relative">
                                <input type="radio" name="departure_time" value="07:00" id="time_morning" required class="hidden time-radio" data-time="07:00">
                                <label for="time_morning" class="block cursor-pointer time-option">
                                    <div class="time-card border-2 border-dark-300 rounded-lg p-4 text-center transition-all hover:border-primary-400 hover:shadow-md">
                                        <svg class="w-8 h-8 mx-auto text-dark-400 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <p class="text-lg font-bold text-dark-700 transition-colors">7:00 AM</p>
                                        <p class="text-xs text-dark-500 time-label">Morning Departure</p>
                                    </div>
                                </label>
                            </div>

                            <!-- Evening Option -->
                            <div class="relative">
                                <input type="radio" name="departure_time" value="19:00" id="time_evening" required class="hidden time-radio" data-time="19:00">
                                <label for="time_evening" class="block cursor-pointer time-option">
                                    <div class="time-card border-2 border-dark-300 rounded-lg p-4 text-center transition-all hover:border-primary-400 hover:shadow-md">
                                        <svg class="w-8 h-8 mx-auto text-dark-400 mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                        </svg>
                                        <p class="text-lg font-bold text-dark-700 transition-colors">7:00 PM</p>
                                        <p class="text-xs text-dark-500 time-label">Evening Departure</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <p class="text-xs text-dark-500 mt-2">
                            All buses depart at exactly 7:00 AM or 7:00 PM daily
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-dark-200">
                    <a href="{{ route('agencies.index') }}" class="text-dark-600 hover:text-dark-800 font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to Agencies
                    </a>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 flex items-center">
                        Continue to Seat Selection
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Popular Routes -->
        @if(isset($popularRoutes) && $popularRoutes->count() > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-display font-bold text-dark-900 mb-6">Popular Routes with {{ $agency->name }}</h3>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($popularRoutes as $route)
                <button type="button" onclick="selectRoute('{{ $route['departure_city_id'] }}', '{{ $route['destination_city_id'] }}')" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-all text-left border border-dark-200 hover:border-primary-400">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold text-dark-900">{{ $route['departure_city'] }}</span>
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                        <span class="font-semibold text-dark-900">{{ $route['destination_city'] }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-dark-500">{{ $route['duration'] }}</span>
                        <span class="font-bold text-primary-600">{{ number_format($route['price']) }} FCFA</span>
                    </div>
                </button>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Custom styling for time selection cards */
.time-radio:checked + label .time-card {
    border-color: #2563eb;
    background-color: #eff6ff;
}

.time-radio:checked + label .time-card svg {
    color: #2563eb;
}

.time-radio:checked + label .time-card p {
    color: #2563eb;
}

/* Disabled time slots */
.time-radio:disabled + label {
    cursor: not-allowed;
    opacity: 0.5;
}

.time-radio:disabled + label .time-card {
    background-color: #f3f4f6;
    border-color: #d1d5db;
}

.time-radio:disabled + label:hover .time-card {
    border-color: #d1d5db;
    box-shadow: none;
}

.time-radio:disabled + label .time-label::after {
    content: ' (Passed)';
    color: #ef4444;
    font-weight: 600;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departureSelect = document.getElementById('departureCity');
    const destinationSelect = document.getElementById('destinationCity');
    const travelDateSelect = document.getElementById('travelDate');
    const routeInfo = document.getElementById('routeInfo');
    const durationEl = document.getElementById('duration');
    const priceEl = document.getElementById('price');
    const routeForm = document.getElementById('routeForm');

    // Debug: Log cities on page load
    console.log('Cities loaded:', {
        departure: departureSelect.options.length,
        destination: destinationSelect.options.length
    });

    // Function to check and disable past times
    function updateTimeAvailability() {
        const selectedDate = travelDateSelect.value;
        if (!selectedDate) return;

        const today = new Date().toISOString().split('T')[0];
        const currentHour = new Date().getHours();

        const morningRadio = document.getElementById('time_morning');
        const eveningRadio = document.getElementById('time_evening');

        // If selected date is today
        if (selectedDate === today) {
            // Disable 7:00 AM if current time is >= 7:00 AM
            if (currentHour >= 7) {
                morningRadio.disabled = true;
                if (morningRadio.checked) {
                    morningRadio.checked = false;
                    eveningRadio.checked = true; // Auto-select evening
                }
            } else {
                morningRadio.disabled = false;
            }

            // Disable 7:00 PM if current time is >= 7:00 PM (19:00)
            if (currentHour >= 19) {
                eveningRadio.disabled = true;
                if (eveningRadio.checked) {
                    eveningRadio.checked = false;
                }
            } else {
                eveningRadio.disabled = false;
            }
        } else {
            // Future dates: enable all times
            morningRadio.disabled = false;
            eveningRadio.disabled = false;
        }
    }

    // Update time availability when date changes
    travelDateSelect.addEventListener('change', updateTimeAvailability);

    // Check on page load
    updateTimeAvailability();

    // Prevent selecting same city for departure and destination
    function updateCityOptions() {
        const departureValue = departureSelect.value;
        const destinationValue = destinationSelect.value;

        // Disable selected departure in destination
        Array.from(destinationSelect.options).forEach(option => {
            option.disabled = option.value === departureValue && option.value !== '';
        });

        // Disable selected destination in departure
        Array.from(departureSelect.options).forEach(option => {
            option.disabled = option.value === destinationValue && option.value !== '';
        });
    }

    // Fetch route information
    async function fetchRouteInfo() {
        const departure = departureSelect.value;
        const destination = destinationSelect.value;

        if (departure && destination && departure !== destination) {
            try {
                const response = await fetch(`/api/routes/info?departure=${departure}&destination=${destination}&agency={{ $agency->id }}`);
                const data = await response.json();

                console.log('Route fetch response:', data); // Debug log

                if (data.success) {
                    routeInfo.classList.remove('hidden');
                    durationEl.textContent = data.duration;
                    priceEl.textContent = data.price + ' FCFA';

                    // Store route_id in hidden input
                    let routeIdInput = document.getElementById('route_id');
                    if (!routeIdInput) {
                        routeIdInput = document.createElement('input');
                        routeIdInput.type = 'hidden';
                        routeIdInput.name = 'route_id';
                        routeIdInput.id = 'route_id';
                        routeForm.appendChild(routeIdInput);
                    }
                    routeIdInput.value = data.route_id;

                    console.log('Route ID set to:', data.route_id); // Debug log
                } else {
                    routeInfo.classList.add('hidden');
                    console.error('Route fetch failed:', data.message);

                    // Don't alert immediately, just log the error
                    // User might be changing cities
                }
            } catch (error) {
                console.error('Error fetching route info:', error);
                routeInfo.classList.add('hidden');
            }
        } else {
            routeInfo.classList.add('hidden');
        }
    }

    departureSelect.addEventListener('change', function() {
        updateCityOptions();
        fetchRouteInfo();
    });

    destinationSelect.addEventListener('change', function() {
        updateCityOptions();
        fetchRouteInfo();
    });

    // Form validation
    routeForm.addEventListener('submit', function(e) {
        const departure = departureSelect.value;
        const destination = destinationSelect.value;
        const travelDate = travelDateSelect.value;
        const departureTime = document.querySelector('input[name="departure_time"]:checked');

        console.log('Form submission started...'); // Debug
        console.log('Departure:', departure);
        console.log('Destination:', destination);
        console.log('Travel Date:', travelDate);
        console.log('Departure Time:', departureTime?.value);

        // Validate all required fields
        if (!departure) {
            e.preventDefault();
            alert('Please select a departure city');
            departureSelect.focus();
            return false;
        }

        if (!destination) {
            e.preventDefault();
            alert('Please select a destination city');
            destinationSelect.focus();
            return false;
        }

        if (departure === destination) {
            e.preventDefault();
            alert('Departure and destination cities cannot be the same!');
            return false;
        }

        if (!travelDate) {
            e.preventDefault();
            alert('Please select a travel date');
            travelDateSelect.focus();
            return false;
        }

        if (!departureTime) {
            e.preventDefault();
            alert('Please select a departure time (7:00 AM or 7:00 PM)');
            return false;
        }

        // Check if route exists
        const routeId = document.getElementById('route_id');
        console.log('Route ID element:', routeId);
        console.log('Route ID value:', routeId?.value);

        if (!routeId || !routeId.value) {
            e.preventDefault();
            alert('Please wait while we fetch route information, or select different cities.');

            // Try to fetch route info one more time
            fetchRouteInfo();
            return false;
        }

        // All validations passed
        console.log('Form is valid, submitting...');
        return true;
    });
});

// Function to select popular route
function selectRoute(departureId, destinationId) {
    const departureSelect = document.getElementById('departureCity');
    const destinationSelect = document.getElementById('destinationCity');

    if (departureSelect && destinationSelect) {
        departureSelect.value = departureId;
        destinationSelect.value = destinationId;

        // Trigger change events
        departureSelect.dispatchEvent(new Event('change'));
        destinationSelect.dispatchEvent(new Event('change'));

        // Scroll to form
        document.getElementById('routeForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>
@endpush
@endsection
