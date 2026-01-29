<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Agency;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TripSearch extends Component
{
    // Search Filters
    public $date;
    public $time = ''; // Empty string means 'All'
    public $agency_id = '';
    public $from = '';
    public $to = '';

    // Data containers
    public $agencies = [];
    public $trips;

    // Date Limits for UI
    public $minDate;
    public $maxDate;

    public function mount()
    {
        $this->agencies = Agency::all();

        // 1. SET TIMEZONE: Ensure we are using Cameroon time (WAT)
        // If your app config is not set to 'Africa/Douala', we force it here for calculations.
        $now = Carbon::now('Africa/Douala');

        // 2. LOGIC CHANGE: Allow booking starting from Today, not tomorrow.
        $this->minDate = $now->toDateString();

        // Logic for "Saturday evening opens next week" would usually control the maxDate
        // For now, we set a reasonable window (e.g., 2 weeks out).
        $this->maxDate = $now->copy()->addDays(14)->toDateString();

        // Default search date to Today
        $this->date = $this->minDate;

        // Initialize empty trip collection
        $this->trips = collect();

        // Run an initial search
        $this->searchTrips();
    }

    // Listen for changes in Date or Time to auto-refresh
    public function updated($property)
    {
        if (in_array($property, ['date', 'time', 'agency_id', 'from', 'to'])) {
            $this->searchTrips();
        }
    }

    public function searchTrips()
    {
        $this->validate([
            'date'      => 'required|date',
            'time'      => 'nullable|string',
            'agency_id' => 'nullable|exists:agencies,id',
            'from'      => 'nullable|string',
            'to'        => 'nullable|string',
        ]);

        try {
            // Get current time in Cameroon
            $now = Carbon::now('Africa/Douala');

            // Start Query
            $query = Trip::query()
                ->with(['bus.agency', 'route'])
                ->where('travel_date', $this->date)
                ->where('status', 'scheduled')
                ->where('is_available_online', true);

            // 3. LOGIC CHANGE: Filter expired times if the date is Today
            // If the user searches for TODAY, we must hide trips that already left.
            if ($this->date === $now->toDateString()) {
                // Determine current time (H:i:s)
                $currentTimeString = $now->toTimeString();

                // Only show trips where departure_time is greater than NOW
                // Example: If now is 07:01, a 07:00 bus will be excluded.
                $query->where('departure_time', '>', $currentTimeString);
            }

            // Filter by Time (if specific time selected by user)
            if (!empty($this->time)) {
                $query->where('departure_time', 'LIKE', $this->time . '%');
            }

            // Filter by Agency
            if (!empty($this->agency_id)) {
                $query->whereHas('bus', function ($q) {
                    $q->where('agency_id', $this->agency_id);
                });
            }

            // Filter by Origin (Case insensitive)
            if (!empty($this->from)) {
                $query->whereHas('route', function ($q) {
                    $q->where('origin', 'LIKE', '%' . $this->from . '%');
                });
            }

            // Filter by Destination (Case insensitive)
            if (!empty($this->to)) {
                $query->whereHas('route', function ($q) {
                    $q->where('destination', 'LIKE', '%' . $this->to . '%');
                });
            }

            $this->trips = $query->get();

        } catch (\Exception $e) {
            Log::error("Search Error: " . $e->getMessage());
            $this->trips = collect();
        }
    }

    public function render()
{
    $query = \App\Models\Trip::with(['bus.agency', 'route']);

    // 1. Filter by Origin
    if (!empty($this->from)) {
        $query->whereHas('route', function ($q) {
            $q->where('origin', 'like', '%' . $this->from . '%');
        });
    }

    // 2. Filter by Destination
    if (!empty($this->to)) {
        $query->whereHas('route', function ($q) {
            $q->where('destination', 'like', '%' . $this->to . '%');
        });
    }

    // 3. Filter by Agency (THE FIX)
    // Assuming your dropdown passes the agency ID or Name
    if (!empty($this->agency) && $this->agency !== 'All Agencies') {
        $query->whereHas('bus.agency', function ($q) {
            $q->where('name', $this->agency)
              ->orWhere('id', $this->agency);
        });
    }

    // 4. Filter by Date
    if (!empty($this->date)) {
        $query->whereDate('travel_date', $this->date);
    }

    return view('livewire.trip-search', [
        'trips' => $query->get()
    ]);
}
}
