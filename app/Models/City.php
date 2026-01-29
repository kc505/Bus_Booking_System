<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region',
    ];

    /**
     * Get routes departing from this city
     */
    public function departingRoutes()
    {
        return $this->hasMany(Route::class, 'departure_city_id');
    }

    /**
     * Get routes arriving at this city
     */
    public function arrivingRoutes()
    {
        return $this->hasMany(Route::class, 'destination_city_id');
    }
}
