<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ServiceCategory;
use App\Models\ProviderProfile;

class AvailabilitySlot extends Model
{
    protected $fillable = [
        'provider_user_id',
        'service_category_id',
        'start_time',
        'end_time',
        'is_booked',
    ];

    protected $casts = [
        'start_time' => 'string',
        'end_time'   => 'string',
        'is_booked'      => 'boolean',
    ];

    public $timestamps = false;

    public function provider() {
        return $this->belongsTo(ProviderProfile::class, 'provider_user_id', 'user_id');
    }

    public function category() {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
}
