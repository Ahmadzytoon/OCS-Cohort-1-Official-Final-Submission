<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ServiceRequest;
use App\Models\Review;

class TeacherProfile extends Model

{
    //
    protected $fillable = [
        'user_id',
    'display_name',
    'subject_id',
    'branch_id',
    'experience_years',
    'phone',
    'bio',
    'image_path',
    'status',
    'is_featured',
    ];

       // ===== Owner (Teacher User) =====
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ===== Subject =====
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // ===== Branch =====
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // ===== Service Requests =====
    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    // ===== Reviews (through requests) =====
    public function reviews()
{
    return $this->hasManyThrough(
        Review::class,
        ServiceRequest::class,
        'teacher_profile_id',   // service_requests.teacher_profile_id
        'service_request_id',   // reviews.service_request_id
        'id',                   // teacher_profiles.id
        'id'                    // service_requests.id
    );
}

public function favorites()
{
    return $this->hasMany(\App\Models\Favorite::class);
}


}
