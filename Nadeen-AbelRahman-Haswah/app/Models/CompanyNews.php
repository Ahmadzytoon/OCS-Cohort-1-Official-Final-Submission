<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyNews extends Model
{
    protected $table = 'company_news';

    protected $fillable = [
        'company_id',
        'author_id',
        'title',
        'category',
        'custom_category',
        'image',
        'content',
        'status',
        'publish_at',
        'published_at',
        'send_notification',
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'published_at' => 'datetime',
        'send_notification' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
