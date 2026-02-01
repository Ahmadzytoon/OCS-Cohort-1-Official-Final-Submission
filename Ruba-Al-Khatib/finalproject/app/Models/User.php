<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Photographer;
use App\Models\PhotographerPortfolio;
use App\Models\Subscription;
use App\Models\Studio; 


class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'account_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ✅ Photographer Profile
    

    // ✅ Studio profile
    public function studioProfile()
    {
        return $this->hasOne(Studio::class, 'user_id');
    }

    public function photograph()
{
    return $this->hasOne(\App\Models\Photographer::class, 'user_id');
}


    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->status)) {
                $user->status = in_array($user->account_type, ['photographer', 'studio'])
                    ? 'pending'
                    : 'approved';
            }
        });
    }




public function photographerProfile()
{
    return $this->hasOne(Photographer::class, 'user_id');
}

// ✅ Portfolio via Photographer model (hasManyThrough)
public function portfolioItems()
{
    return $this->hasManyThrough(
        PhotographerPortfolio::class, // final
        Photographer::class,          // through
        'user_id',                    // photographers.user_id -> users.id
        'photographer_id',            // photographer_portfolio.photographer_id -> photographers.id
        'id',                         // users.id
        'id'                          // photographers.id
    );
}


public function subscriptions()
{
    return $this->hasMany(Subscription::class, 'user_id');
}

public function activeSubscription()
{
    return $this->hasOne(Subscription::class, 'user_id')
        ->where('status', 'active')
        ->where('payment_status', 'active')
        ->where(function ($q) {
            $q->whereNull('ends_at')
              ->orWhere('ends_at', '>', now());
        })
        ->latestOfMany();
}



// Helper methods for account type
public function isCustomer(): bool
{
    return $this->account_type === 'customer';
}

public function isPhotographer(): bool
{
    return $this->account_type === 'photographer';
}

public function isStudio(): bool
{
    return $this->account_type === 'studio';
}

public function hasActivePlanFor(string $for): bool
{
    $sub = $this->activeSubscription()->with('plan')->first();

    if (!$sub || !$sub->plan) return false;

    // لازم نفس نوع الحساب
    if ($sub->plan->for !== $for) return false;

    // لازم فعّال (depends on Subscription::isActive())
    return $sub->isActive();
}

public function canFeature(string $featureKey): bool
{
    $sub = $this->activeSubscription()->with('plan')->first();

    $features = $sub?->plan?->features ?? [];

    return (bool)($features[$featureKey] ?? false);
}

public function hasActiveSubscription(): bool
{
    $sub = $this->activeSubscription()->first();
    return $sub ? $sub->isActive() : false;
}



public function featureValue(string $featureKey, $default = null)
{
    $sub = $this->activeSubscription()->with('plan')->first();

    if (!$sub || !$sub->plan) return $default;

    $features = $sub->plan->features ?? [];

    return $features[$featureKey] ?? $default;
}


}
