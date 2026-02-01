<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookDiscount extends Model
{
    protected $table = 'book_discounts';
    
    protected $fillable = [
        'book_id',
        'discount_type',
        'discount_amount',
        'valid_until',
        'is_active'
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}