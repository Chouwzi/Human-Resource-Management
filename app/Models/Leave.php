<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'emp_id',
        'emp_name',
        'leave_type',
        'start_date',
        'end_date',
        'days',
        'reason',
        'status',
        'approved_by',
        'approved_at',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'user_id');
    }
}
