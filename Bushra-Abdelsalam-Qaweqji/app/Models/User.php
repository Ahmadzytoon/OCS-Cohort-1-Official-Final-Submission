<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\CustomerProfile;
use App\Models\ProviderProfile;
use App\Models\AvailabilitySlot;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_PROVIDER = 'provider';
    public const ROLE_ADMIN    = 'admin';

    public const STATUS_ACTIVE  = 'active';
    public const STATUS_DEACTIVATED = 'deactivated';
    
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function customerProfile(): HasOne {
        return $this->hasOne(CustomerProfile::class, 'user_id');
    }

    public function providerProfile() {
        return $this->hasOne(ProviderProfile::class, 'user_id');
    }

    public function availabilitySlots() {
        return $this->hasMany(AvailabilitySlot::class, 'provider_user_id');
    }

    public function bookingsAsCustomer()
    {
        return $this->hasMany(Booking::class, 'customer_user_id');
    }

    public function bookingsAsProvider()
    {
        return $this->hasMany(Booking::class, 'provider_user_id');
    }

}
