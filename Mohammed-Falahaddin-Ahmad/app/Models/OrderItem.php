<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_time'
    ];

    protected $casts = [
        'price_at_time' => 'decimal:2',
    ];

    public function getPriceAttribute()
    {
        return $this->price_at_time;
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}