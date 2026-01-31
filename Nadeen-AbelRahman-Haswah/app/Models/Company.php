<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'workspace_name',
        'slug',
        'company_name',
        'logo',
        'company_size',
        'industry',
        'other_industry',
        'current_subscription_id',
        'is_active',
        'activated_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function currentSubscription()
    {
        return $this->belongsTo(Subscription::class, 'current_subscription_id');
    }


    public function departments()
    {
        return $this->hasMany(Department::class);
    }
    public function knowledgeEntries()
    {
        return $this->hasMany(\App\Models\KnowledgeEntry::class);
    }
    public function owner()
    {
        return $this->hasOne(User::class)->where('role', 'company_owner');
    }
}
