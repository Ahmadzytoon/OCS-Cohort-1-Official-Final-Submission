<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Payment extends Model
{
    protected $fillable = [
    'booking_id',
    'payment_status',
    'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


}
