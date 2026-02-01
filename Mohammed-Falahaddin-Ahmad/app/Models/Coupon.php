<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'expires_at',
        'is_active'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
    ];

    // Accessor for status badge class
    public function getStatusBadgeClassAttribute()
    {
        if (!$this->is_active) return 'bg-danger';
        if ($this->is_expired) return 'bg-warning';
        if ($this->has_reached_limit) return 'bg-warning';
        return 'bg-success';
    }

    // Accessor for status label
    public function getStatusLabelAttribute()
    {
        if (!$this->is_active) return 'Inactive';
        if ($this->is_expired) return 'Expired';
        if ($this->has_reached_limit) return 'Limit Reached';
        return 'Active';
    }

    // Check if coupon is expired
    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    // Check if coupon has reached usage limit
    public function getHasReachedLimitAttribute()
    {
        return $this->usage_limit && $this->used_count >= $this->usage_limit;
    }

    // Check if coupon is valid
    public function isValid($cartTotal)
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        if ($this->min_order_amount && $cartTotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    // Calculate discount amount
    public function calculateDiscount($cartTotal)
    {
        if ($this->discount_type === 'percentage') {
            return min($cartTotal * ($this->discount_value / 100), $cartTotal);
        }
        return min($this->discount_value, $cartTotal);
    }
}