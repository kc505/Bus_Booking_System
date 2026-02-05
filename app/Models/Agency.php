<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agency extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'logo',
        'rating',
        'phone',
        'email',
        'total_buses',
        'admin_id',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'total_buses' => 'integer',
    ];

    /**
     * Get the routes for this agency
     */
   public function routes()
{
    return $this->hasMany(\App\Models\Route::class, 'agency_id');
}

    /**
     * Get the bookings for this agency
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get minimum price for this agency
     */
    public function getMinPriceAttribute()
    {
        return $this->routes()->min('base_price') ?? 0;
    }

    public function getRoutesCountAttribute()
    {
        return $this->routes()->count();
    }
    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');   // adjust foreign key if it's different (e.g. 'user_id' or 'agency_admin_id')
}
}
