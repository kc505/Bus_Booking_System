<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $table = 'routes'; // Specify custom table name if needed

    protected $fillable = [
        'agency_id',
        'departure_city_id',
        'destination_city_id',
        'origin',
        'destination',
        'estimated_duration_minutes',
        'base_price',
        'distance_km',
        'is_active',
    ];

    protected $casts = [
        'estimated_duration_minutes' => 'integer',
        'base_price' => 'decimal:2',
        'distance_km' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the agency that owns this route
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    /**
     * Get the departure city (camelCase - Laravel standard)
     */
    public function departureCity()
    {
        return $this->belongsTo(City::class, 'departure_city_id');
    }

    /**
     * Get the destination city (camelCase - Laravel standard)
     */
    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    /**
     * Get all trips for this route
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get all bookings through trips
     */
    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Trip::class);
    }

    /**
     * Scope to get only active routes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by agency
     */
    public function scopeForAgency($query, $agencyId)
    {
        return $query->where('agency_id', $agencyId);
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->estimated_duration_minutes / 60);
        $minutes = $this->estimated_duration_minutes % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        } elseif ($hours > 0) {
            return "{$hours}h";
        } else {
            return "{$minutes}m";
        }
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->base_price, 0) . ' FCFA';
    }
}
