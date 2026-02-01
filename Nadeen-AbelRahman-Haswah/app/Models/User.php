<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;


    protected $fillable = [
        'name',
        'email',
        'password',

        'company_id',
        'department_id',

        'phone',
        'position',
        'avatar',

        'role',
        'status',

        'joined_at',
        'last_login_at',
        'email_verified_at',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'joined_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    /* ===================== Helpers ===================== */

    public function isCompanyOwner(): bool
    {
        return $this->role === 'company_owner';
    }

    public function isDepartmentManager(): bool
    {
        return $this->role === 'department_manager';
    }

    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
    public function getAvatarAttribute($value)
    {
        return $value
            ? asset('storage/' . $value)
            : asset('admin/assets/img/default-avatar.png.png');
    }
    public function knowledgeEntries()
    {
        return $this->hasMany(\App\Models\KnowledgeEntry::class, 'user_id');
    }
}
