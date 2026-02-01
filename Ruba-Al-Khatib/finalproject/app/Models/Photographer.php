<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
  use App\Models\PhotographerPortfolio;

class Photographer extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'years_of_experience',
        'photography_types',
        'starting_price',
        'city',
        'instagram_url',
        'website_url',
        'behance_url',
        'profile_image_path',
    ];
    

    protected $casts = [
        'photography_types' => 'array',
    ];

     

    public function portfolio()
    {
        return $this->hasMany(PhotographerPortfolio::class, 'photographer_id');
    }

    public function getPhotographyTypesTextAttribute(): string
    {
        $types = $this->photography_types;

        if (is_array($types)) return implode(', ', $types);

        return $types ?: '—';
    }

    public function getAvatarUrlAttribute(): string
{
    if ($this->avatar) {
        return asset('storage/' . $this->avatar);
    }

    // صورة افتراضية
    return asset('images/Userprofile.png');
}

}

