<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'agency_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Add to your existing User model
public function bookings()
{
    return $this->hasMany(Booking::class);
}

public function checkins()
{
    return $this->hasMany(Checkin::class, 'staff_id');
}

// Check if user is admin (for check-in staff)
public function isStaff()
{
    return $this->role === 'staff' || $this->role === 'admin';
}
public function agency()
{
    return $this->belongsTo(Agency::class, 'agency_id'); // adjust foreign key if different
}
public function disputes()
{
    return $this->hasMany(Dispute::class);
}
}
