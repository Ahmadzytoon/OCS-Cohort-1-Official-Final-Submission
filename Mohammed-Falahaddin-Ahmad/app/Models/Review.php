<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'customer_name',
        'customer_email',
        'comment',
        'rating',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRatingStarsAttribute()
    {
        $stars = '';
        $rating = (int)$this->rating;
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fa-solid fa-star"></i>';
            } else {
                $stars .= '<i class="fa-regular fa-star"></i>';
            }
        }
        return $stars;
    }
}