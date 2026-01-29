<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    // If using separate table for multi-agency bookings
    protected $table = 'multi_agency_bookings';

   protected $fillable = [
    'user_id',
    'agency_id',
    'route_id',
    'booking_number',
    'passenger_name',
    'passenger_phone',
    'passenger_email',
    'origin',
    'destination',
    'travel_date',
    'departure_time',
    'seats',
    'total_amount',
    'payment_method',
    'payment_status',
    'status',
    'refund_amount',
    'refund_status',
    'cancelled_at',
];


    protected $casts = [
        'seats' => 'array',
        'travel_date' => 'date',
        'departure_time' => 'datetime:H:i',
        'total_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'checked_in_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'no_show_at' => 'datetime',
    ];

    /**
     * Get the user that owns the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the agency for this booking
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get the route for this booking
     */
    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('travel_date', '>=', now()->toDateString())
                    ->whereIn('status', ['confirmed', 'checked_in']);
    }

    /**
     * Scope for past bookings
     */
    public function scopePast($query)
    {
        return $query->where('travel_date', '<', now()->toDateString());
    }

    /**
     * Scope for today's bookings
     */
    public function scopeToday($query)
    {
        return $query->whereDate('travel_date', today());
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled()
    {
        if (!in_array($this->status, ['confirmed', 'pending'])) {
            return false;
        }

        $travelDateTime = \Carbon\Carbon::parse($this->travel_date . ' ' . $this->departure_time);
        return now()->lt($travelDateTime);
    }

    /**
     * Get refund percentage based on cancellation time
     */
    public function getRefundPercentage()
    {
        $travelDateTime = \Carbon\Carbon::parse($this->travel_date . ' ' . $this->departure_time);
        $hoursUntilTravel = now()->diffInHours($travelDateTime, false);

        if ($hoursUntilTravel >= 24) {
            return 90;
        } elseif ($hoursUntilTravel >= 12) {
            return 50;
        }

        return 0;
    }
}
