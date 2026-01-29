<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'seat_id', 'ticket_number', 'qr_code',
        'passenger_name', 'passenger_phone', 'status',
        'checked_in_at', 'expires_at'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // A ticket belongs to a booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // A ticket belongs to a seat
    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

    // A ticket has many checkins
    public function checkins()
    {
        return $this->hasMany(Checkin::class);
    }

    // Generate ticket number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_number)) {
                $ticket->ticket_number = 'TKT' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
            }
        });
    }

    // Check if ticket is valid for check-in
    public function isValidForCheckin()
    {
        return $this->status === 'active' &&
               $this->expires_at->isFuture() &&
               $this->checked_in_at === null;
    }
}
