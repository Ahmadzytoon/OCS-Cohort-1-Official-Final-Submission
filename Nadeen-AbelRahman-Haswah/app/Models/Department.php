<?php

namespace App\Models;



use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Department extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'icon',
        'description',
        'manager_id',
        'is_active'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    // المدير (يوزر واحد)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // موظفين القسم (عدة users)
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function knowledgeEntries()
    {
        return $this->hasMany(\App\Models\KnowledgeEntry::class);
    }
}
