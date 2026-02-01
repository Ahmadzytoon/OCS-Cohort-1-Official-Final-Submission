<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    protected $fillable = ['author_id', 'order_item_id', 'amount', 'platform_commission'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
