<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'billing_cycle',
        'trial_days',
        'max_users',
        'max_departments',
        'max_knowledge_cards',
        'ai_requests_limit',
        'is_active',
        'sort_order'
    ];

    public function features()
    {
        return $this->hasMany(PlanFeature::class)->orderBy('sort_order');
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
