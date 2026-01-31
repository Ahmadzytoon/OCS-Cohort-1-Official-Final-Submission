<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;
use App\Models\ProviderOptionPricing;
use App\Models\Booking;

class ServiceOption extends Model
{
    protected $fillable = [
        'service_category_id',
        'name',
        'pricing_type',
    ];

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function providerPrices() {
        return $this->hasMany(ProviderOptionPricing::class, 'service_option_id');
    }

    public function bookingOptions()
    {
        return $this->hasMany(BookingOption::class);
    }

}
