<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'provider_type',
        'provider_id',
        'session_type_id',
        'booking_date',
        'booking_time',
        'location_type',
        'location_address',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
    ];

    // الزبون
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // المصوّر
    public function photographer()
    {
        return $this->belongsTo(Photographer::class, 'provider_id');
    }

    // الاستديو
    public function studio()
    {
        return $this->belongsTo(Studio::class, 'provider_id');
    }

    // Booking.php
    public function provider()
    {
        return $this->morphTo(null, 'provider_type', 'provider_id');
    }
}
