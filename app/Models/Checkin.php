<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id', 'staff_id', 'checked_in_at', 'checkin_method', 'notes'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    // A checkin belongs to a ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // A checkin belongs to a staff member (user)
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
