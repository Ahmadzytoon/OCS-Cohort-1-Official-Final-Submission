<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeTag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function entries()
    {
        return $this->belongsToMany(KnowledgeEntry::class, 'knowledge_entry_tag');
    }
}
