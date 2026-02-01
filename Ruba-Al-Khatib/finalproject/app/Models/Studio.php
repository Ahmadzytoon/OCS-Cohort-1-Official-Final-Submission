<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = [
        'user_id',
        'studio_name',
        'description',
        'phone_number',
        'working_hours',
        'address',
        'location_lat',
        'location_lng',
        'services',
        'team_size',
        'equipment_tags',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'services' => 'array',
        'equipment_tags' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolio()
    {
        return $this->hasMany(StudioPortfolio::class);
    }
}
