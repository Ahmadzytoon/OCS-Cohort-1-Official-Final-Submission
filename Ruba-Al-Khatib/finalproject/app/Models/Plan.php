<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'for',
        'code',
        'name',
        'price_jod',
        'features',
        'is_active',
        'sort',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price_jod' => 'integer',
        'sort' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    
}
