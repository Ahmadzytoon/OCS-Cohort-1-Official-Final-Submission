<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'image',
        'description',
        'category_id',
        'stock',
        'is_featured',
        'status',
        'aesthetic',
        'price_tier',
        'discover_score',
        'view_count',
        'wishlist_count',
        'recent_purchases',
        'brand_name',
        'occasions',
        'colors',
        'sizes',
        'color_stock',
        'discount_percentage',
    ];

    protected function casts(): array
    {
        return [
            'occasions' => 'array',
            'colors' => 'array',
            'sizes' => 'array',
            'color_stock' => 'array',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function scopeAesthetic($query, $aesthetic)
    {
        return $query->where('aesthetic', $aesthetic);
    }

    public static function getAestheticName($key)
    {
        return [
            'alt' => 'Alt Girly 🖤',
            'luxury' => 'Luxury Clean ✨',
            'soft' => 'Soft Femme 🌸',
            'mix' => 'Modern Mix 🎭'
        ][$key] ?? 'Modern Mix 🎭';
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getEffectiveDiscountAttribute()
    {
        $productDiscount = (float) $this->discount_percentage;
        $categoryDiscount = (float) ($this->category->discount_percentage ?? 0);

        // Persona discount
        $personaDiscount = 0;
        if ($this->aesthetic) {
            $personaDiscount = \Illuminate\Support\Facades\Cache::remember("pd_{$this->aesthetic}", 3600, function () {
                $pd = PersonaDiscount::where('aesthetic', $this->aesthetic)->first();
                return $pd ? (float) $pd->discount_percentage : 0.0;
            });
        }

        return max($productDiscount, $categoryDiscount, $personaDiscount);
    }

    public function getDiscountedPriceAttribute()
    {
        $discount = $this->effective_discount;
        if ($discount <= 0) {
            return $this->price;
        }

        return $this->price * (1 - ($discount / 100));
    }

    public function hasDiscount()
    {
        return $this->effective_discount > 0;
    }
}
