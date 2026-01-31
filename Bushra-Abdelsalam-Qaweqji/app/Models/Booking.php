<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ServiceCategory;
use App\Models\AvailabilitySlot;

class Booking extends Model
{
    protected $fillable = [
        'customer_user_id',
        'provider_user_id',
        'service_category_id',
        'availability_slot_id',
        'hours',
        'service_address',
        'zip_code',
        'customer_note',
        'hourly_rate',
        'base_cost',
        'options_cost',
        'total_cost',
        'status',
        'rejection_reason',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_user_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_user_id');
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function slot()
    {
        return $this->belongsTo(AvailabilitySlot::class, 'availability_slot_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function bookingOptions()
    {
        return $this->hasMany(BookingOption::class);
    }



}

