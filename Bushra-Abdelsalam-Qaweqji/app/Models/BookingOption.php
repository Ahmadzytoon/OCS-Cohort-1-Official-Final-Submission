<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOption extends Model
{
    protected $fillable = [
        'booking_id',
        'service_option_id',
        'option_name',
        'option_price',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function serviceOption()
    {
        return $this->belongsTo(ServiceOption::class);
    }
}
