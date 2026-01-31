<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KnowledgeEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'department_id',
        'user_id',
        'type',
        'title',
        'summary',
        'content',
        'extra',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'views_count',
    ];

    protected $casts = [
        'extra' => 'array',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function attachments()
    {
        return $this->hasMany(\App\Models\KnowledgeAttachment::class, 'knowledge_entry_id');
    }
    public function tags()
    {
        return $this->belongsToMany(KnowledgeTag::class, 'knowledge_entry_tag');
    }
}
