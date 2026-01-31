<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceOption;
use App\Models\ProviderService;

class ProviderOptionPricing extends Model
{
    protected $fillable = [
        'provider_service_id',
        'service_option_id',
        'price',
    ];

    public function providerService()
{
    return $this->belongsTo(ProviderService::class,
        'provider_service_id'
    );
}

public function serviceOption()
{
    return $this->belongsTo(ServiceOption::class,
        'service_option_id'
    );
}

}
