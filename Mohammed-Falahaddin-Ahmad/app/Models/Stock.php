<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'isbn',
        'author_id',
        'category_id',
        'price',
        'stock_quantity',
        'status',
        'cover_image',
        'description'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id'); // or 'book_id'
    }

   public function stockAdjustments()
{
    return $this->hasMany(StockAdjustment::class);
}

// Accessor for stock status
public function getStockStatusAttribute()
{
    if ($this->stock_quantity <= 0) return 'out_of_stock';
    elseif ($this->stock_quantity <= 50) return 'low_stock';
    else return 'in_stock';
}

// Accessor for badge class
public function getStockStatusBadgeClassAttribute()
{
    return match($this->stock_status) {
        'out_of_stock' => 'bg-danger',
        'low_stock' => 'bg-warning',
        'in_stock' => 'bg-success',
        default => 'bg-secondary'
    };
}

// Accessor for label
public function getStockStatusLabelAttribute()
{
    return match($this->stock_status) {
        'out_of_stock' => 'Out of Stock',
        'low_stock' => 'Low Stock',
        'in_stock' => 'In Stock',
        default => 'Unknown'
    };
}

}