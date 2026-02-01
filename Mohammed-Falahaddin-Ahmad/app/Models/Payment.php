<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'currency',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function getStatusAttribute()
    {
        return $this->payment_status;
    }


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Status badge helper
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->payment_status) {
            'succeeded' => 'bg-success',
            'pending' => 'bg-warning',
            'failed' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            'succeeded' => 'Succeeded',
            'pending' => 'Pending',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
            default => 'Unknown'
        };
    }
}