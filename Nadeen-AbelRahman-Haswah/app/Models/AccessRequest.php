<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    protected $fillable = [
        'company_id','department_id',
        'name','email','phone','message',
        'requested_role','status',
        'rejection_reason','rejection_message',
        'approved_role','position',
        'processed_by','processed_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
