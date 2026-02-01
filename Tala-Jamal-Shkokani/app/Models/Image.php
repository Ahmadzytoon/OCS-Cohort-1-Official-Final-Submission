<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'url',
        'imageable_id',
        'imageable_type',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    /**
     * Get the parent imageable model (product, user, etc).
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
