<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'area',
        'street_address',
        'building_no',
        'apartment_no',
        'phone',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
