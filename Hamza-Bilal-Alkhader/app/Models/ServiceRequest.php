<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    //
      protected $fillable = [
        'student_id',
        'teacher_profile_id',
        'status', // pending | accepted | rejected | completed
    ];

    // ===== Student =====
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // ===== Teacher Profile =====
    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    // ===== Review =====
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
