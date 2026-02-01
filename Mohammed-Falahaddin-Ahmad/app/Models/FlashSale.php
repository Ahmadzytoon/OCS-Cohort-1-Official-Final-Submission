<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    protected $fillable = [
        'product_id',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function book()
    {
        return $this->belongsTo(Book::class, 'product_id');
    }

    // Accessor for sale status
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        
        $now = now();
        if ($this->start_date && $now < $this->start_date) {
            return 'upcoming';
        }
        
        if ($this->end_date && $now > $this->end_date) {
            return 'expired';
        }
        
        return 'active';
    }

    // Accessor for status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'active' => 'bg-success',
            'upcoming' => 'bg-info',
            'expired' => 'bg-warning',
            'inactive' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    // Accessor for status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'active' => 'Active',
            'upcoming' => 'Upcoming',
            'expired' => 'Expired',
            'inactive' => 'Inactive',
            default => 'Unknown'
        };
    }
}