<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Author;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\StockAdjustment;
use App\Models\Review;
use App\Models\BookDiscount; // Critical for discount relationship

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
        'description',
        'long_description',
        'language',
        'format',
        'pages',
        'country',
        'publish_year',
        'publish_date',
        'dimensions',
        'weight',
        'tags'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'pages' => 'integer',
        'weight' => 'decimal:2',
        'publish_date' => 'date',
        'publish_year' => 'integer',
    ];

    // ===== RELATIONSHIPS =====
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function activeDiscount()
    {
        return $this->hasOne(BookDiscount::class)->where('is_active', true);
    }

    public function stockAdjustments(): HasMany
    {
        return $this->hasMany(StockAdjustment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

  
    public function getFinalPriceAttribute()
    {
        if (!$this->activeDiscount) return (float) $this->price;
        
        $discount = $this->activeDiscount;
        if ($discount->discount_type === 'percentage') {
            return max(0, $this->price - ($this->price * $discount->discount_amount / 100));
        }
        return max(0, $this->price - $discount->discount_amount);
    }
    

public function getDiscountDisplayAttribute()
    {
        if (!$this->activeDiscount) return null;
        
        $discount = $this->activeDiscount;
        $amount = $discount->discount_type === 'percentage' 
            ? "{$discount->discount_amount}%"
            : '$' . number_format($discount->discount_amount, 2);
        
        $expires = $discount->valid_until 
            ? ' (Expires: ' . $discount->valid_until->format('M d, Y') . ')'
            : '';
        
        return "{$amount} off{$expires}";
    }

    // ===== RATING & REVIEWS LOGIC =====
    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->where('is_approved', true)->avg('rating') ?: 0, 1);
    }

    public function getApprovedReviewsCountAttribute()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    public function getRatingStarsHtmlAttribute()
    {
        $rating = $this->average_rating;
        $html = '<div class="rating-stars-wrapper d-flex align-items-center gap-1">';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($rating)) {
                $html .= '<i class="fa-solid fa-star text-warning"></i>';
            } elseif ($i == ceil($rating) && ($rating - floor($rating) >= 0.3)) {
                $html .= '<i class="fa-solid fa-star-half-stroke text-warning"></i>';
            } else {
                $html .= '<i class="fa-regular fa-star text-muted"></i>';
            }
        }
        
        $html .= '<span class="rating-text ms-2">(' . $rating . ' from ' . $this->approved_reviews_count . ' reviews)</span>';
        $html .= '</div>';
        
        return $html;
    }

    public function getShortRatingStarsHtmlAttribute()
    {
        $rating = $this->average_rating;
        $html = '<div class="rating-stars-short d-flex align-items-center gap-1" style="font-size: 0.85rem;">';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($rating)) {
                $html .= '<i class="fa-solid fa-star text-warning"></i>';
            } elseif ($i == ceil($rating) && ($rating - floor($rating) >= 0.3)) {
                $html .= '<i class="fa-solid fa-star-half-stroke text-warning"></i>';
            } else {
                $html .= '<i class="fa-regular fa-star text-muted"></i>';
            }
        }
        $html .= ' <span class="ms-1 fw-bold text-dark">' . $rating . '</span>';
        $html .= '</div>';
        
        return $html;
    }

    public function getStarsOnlyHtmlAttribute()
    {
        $rating = $this->average_rating;
        $html = '<div class="stars-only d-flex align-items-center gap-1">';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= floor($rating)) {
                $html .= '<i class="fa-solid fa-star"></i>';
            } elseif ($i == ceil($rating) && ($rating - floor($rating) >= 0.3)) {
                $html .= '<i class="fa-solid fa-star-half-stroke"></i>';
            } else {
                $html .= '<i class="fa-regular fa-star"></i>';
            }
        }
        
        $html .= '</div>';
        
        return $html;
    }

    public function getSingleStarRatingHtmlAttribute()
    {
        $rating = $this->average_rating;
        return '<div class="single-star-rating d-flex align-items-center gap-1" style="color: #ff7b6b; font-weight: 700; font-size: 14px;">
                    <i class="fa-solid fa-star"></i>
                    <span>' . $rating . '</span>
                </div>';
    }

    // ===== EXISTING STOCK ACCESSORS =====
    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock_quantity <= 10) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    public function getStockStatusBadgeClassAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'bg-danger',
            'low_stock' => 'bg-warning',
            'in_stock' => 'bg-success',
            default => 'bg-secondary'
        };
    }

    public function getStockStatusLabelAttribute(): string
    {
        return match($this->stock_status) {
            'out_of_stock' => 'Out of Stock',
            'low_stock' => 'Low Stock',
            'in_stock' => 'In Stock',
            default => 'Unknown'
        };
    }
}