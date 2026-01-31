<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceOption;
use App\Models\Booking;

class ServiceCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'is_active',
    ];

    public function options() {
        return $this->hasMany(ServiceOption::class, 'service_category_id');
    }

    public function services() {
        return $this->hasMany(ProviderService::class, 'service_category_id');
    }

    public function availabilitySlots() {
        return $this->hasMany(AvailabilitySlot::class, 'service_category_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_category_id');
    }
}
