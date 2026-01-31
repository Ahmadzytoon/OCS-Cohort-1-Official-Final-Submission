<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'service_request_id',
        'rating',
        'comment',
    ];

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function reports()
{
    return $this->hasMany(ReviewReport::class);
}

}
