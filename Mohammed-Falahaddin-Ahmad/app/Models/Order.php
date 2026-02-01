<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'address_id',
        'order_status',
        'total_amount'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function getStatusAttribute()
    {
        return $this->order_status;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    // Accessor for formatted order ID
    public function getOrderIdAttribute()
    {
        return 'ORD-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    // Accessor for status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->order_status) {
            'pending' => 'bg-warning',
            'delivered' => 'bg-success',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }


      // 🔥 ADD THIS RELATIONSHIP 🔥
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
    // Accessor for status label
    public function getStatusLabelAttribute()
    {
        return match($this->order_status) {
            'pending' => 'Pending',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
            default => 'Unknown'
        };
    }
}