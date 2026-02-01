<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'starts_at',
        'ends_at',
        'auto_renew',
        'provider',
        'provider_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'auto_renew' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function isActive(): bool
    {
        if ($this->status !== 'active') return false;

        // إذا ends_at null => اعتبريه فعّال (مثلاً Free أو lifetime)
        if (is_null($this->ends_at)) return true;

        return $this->ends_at->isFuture();
    }
   
    
}
