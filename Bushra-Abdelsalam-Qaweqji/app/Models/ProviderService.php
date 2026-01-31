<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;
use App\Models\ProviderProfile;
use App\Models\ProviderOptionPricing;

class ProviderService extends Model
{
    protected $fillable = [
        'provider_user_id',
        'service_category_id',
        'hourly_rate',
        'is_active',
    ];

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }

    public function providerProfile() {
        return $this->belongsTo(ProviderProfile::class, 'provider_user_id', 'user_id');
    }

    public function optionPricings(){
        return $this->hasMany(ProviderOptionPricing::class,'provider_service_id');
    }

}
