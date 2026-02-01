<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'previous_stock',
        'quantity_change',
        'new_stock',
        'reason'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
