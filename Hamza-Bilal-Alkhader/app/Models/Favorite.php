<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    //
     protected $fillable = [
        'student_id',
        'teacher_profile_id',
    ];

    public function student()

    {
        return $this->belongsTo(User::class,'student_id');
    }

    public function teacherProfile()
    {
        return $this->belongsTo(TeacherProfile::class);
    }

    
}
