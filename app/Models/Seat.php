<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id', 'seat_number', 'side', 'class', 'is_available_online'
    ];

    // A seat belongs to a bus
    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    // A seat has many tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Check if seat is available for a trip
    public function isAvailableForTrip($tripId)
    {
        return !$this->tickets()
            ->whereHas('booking', function($query) use ($tripId) {
                $query->where('trip_id', $tripId)
                      ->whereIn('status', ['confirmed', 'pending']);
            })
            ->exists();
    }
}
