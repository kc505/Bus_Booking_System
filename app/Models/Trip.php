<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'route_id',
        'travel_date',
        'departure_time',
        'departure_datetime',
        'estimated_arrival_datetime',
        'price',
        'status',
        'is_available_online'
    ];

    protected $casts = [
        'travel_date' => 'date',
        'departure_datetime' => 'datetime',
        'estimated_arrival_datetime' => 'datetime',
        'is_available_online' => 'boolean',
    ];

    /**
     * A trip belongs to a bus
     */
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * A trip belongs to a route
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * A trip has many bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get all tickets for this trip through bookings
     * FIXED: Using correct table relationship
     */
    public function tickets()
    {
        // If you have a direct tickets table with trip_id
        return $this->hasMany(Ticket::class, 'trip_id');

        // OR if tickets are through bookings:
        // return $this->hasManyThrough(Ticket::class, Booking::class);
    }

    /**
     * Get available seats for this trip
     * FIXED: Removed reference to non-existent multi_agency_bookings table
     */
    public function availableSeats()
    {
        if (!$this->bus) {
            return collect([]);
        }

        // Get all seat IDs that are booked for this trip
        $bookedSeatIds = $this->tickets()
            ->whereNull('deleted_at') // Exclude cancelled tickets
            ->pluck('seat_id')
            ->toArray();

        // Return seats that are not booked and available online
        return $this->bus->seats()
            ->whereNotIn('id', $bookedSeatIds)
            ->where('is_available_online', true)
            ->get();
    }

    /**
     * Get count of available seats
     */
    public function availableSeatsCount()
    {
        return $this->availableSeats()->count();
    }

    /**
     * Get count of booked seats
     */
    public function bookedSeatsCount()
    {
        return $this->tickets()
            ->whereNull('deleted_at')
            ->count();
    }

    /**
     * Check if trip is bookable
     */
    public function isBookable()
    {
        return $this->status === 'scheduled'
            && $this->is_available_online
            && $this->availableSeatsCount() > 0
            && $this->departure_datetime > now();
    }

    /**
     * Scope for upcoming trips
     */
    public function scopeUpcoming($query)
    {
        return $query->where('travel_date', '>=', now()->toDateString())
                    ->where('status', 'scheduled');
    }

    /**
     * Scope for past trips
     */
    public function scopePast($query)
    {
        return $query->where('travel_date', '<', now()->toDateString())
                    ->orWhere('status', 'completed');
    }
}
