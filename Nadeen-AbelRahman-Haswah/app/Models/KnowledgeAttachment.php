<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeAttachment extends Model
{
    protected $fillable = [
        'knowledge_entry_id',
        'type',
        'path',
        'url',
        'original_name',
        'size',
        'mime',
        'uploaded_by',
    ];

    public function entry()
    {
        return $this->belongsTo(KnowledgeEntry::class, 'knowledge_entry_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
