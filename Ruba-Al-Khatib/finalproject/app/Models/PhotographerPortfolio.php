<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotographerPortfolio extends Model
{
    protected $table = 'photographer_portfolio';

    protected $fillable = [
        'photographer_id',
        'image_path',
        'category',
        'title',
        'description',
    ];

    public function photographer()
    {
        return $this->belongsTo(Photographer::class);
    }

    
}

