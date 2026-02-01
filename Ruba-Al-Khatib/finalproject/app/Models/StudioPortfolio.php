<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudioPortfolio extends Model
{
    protected $table = 'studio_portfolio';

    protected $fillable = [
        'studio_id',
        'image_path',
    ];

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }
}
