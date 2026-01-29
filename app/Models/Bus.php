<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'agency_id', 'plate_number', 'brand', 'capacity',
        'amenities', 'is_active'
    ];

    protected $casts = [
        'amenities' => 'array',
    ];

    // A bus belongs to an agency
    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    // A bus has many seats
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    // A bus has many trips
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    // Get only online available seats
    public function onlineSeats()
    {
        return $this->seats()->where('is_available_online', true);
    }
}
