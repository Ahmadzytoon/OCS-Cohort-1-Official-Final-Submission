<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProviderService;
use App\Models\AvailabilitySlot;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;

class ProviderProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
       'user_id',
        'zip_code',
        'bio',
        'profile_image',
        'avg_rating',
        'rating_count',
    ];

    public $timestamps = false;

    public function services() {
        return $this->hasMany(ProviderService::class, 'provider_user_id', 'user_id');
    }

    public function availabilitySlots() {
        return $this->hasMany(AvailabilitySlot::class, 'provider_user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'provider_user_id', 'user_id');
    }

    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,   
            Booking::class, 
            'provider_user_id',       
            'booking_id',
            'user_id',    
            'id'
        );
    }


}
