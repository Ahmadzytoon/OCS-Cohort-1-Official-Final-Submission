<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
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
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

       // ===== Teacher Profile (Teacher only) =====
    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    // ===== Student Requests =====
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'student_id');
    }

    // ===== Student Reviews =====
    public function reviews()
    {
        return $this->hasManyThrough(
        Review::class,
        ServiceRequest::class,
        'student_id',           // FK في service_requests
        'service_request_id',   // FK في reviews
        'id',                   // users.id
        'id'                    // service_requests.id
    );
    }

    // ===== Favorites =====
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'student_id');
    }

    public function reviewReports()
{
    return $this->hasMany(ReviewReport::class);
}

}
