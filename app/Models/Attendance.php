<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'employee_id',
        'work_date',
        'check_in',
        'check_out',
        'worked_minutes',
        'overtime_minutes',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'employee_id', 'id');
    }
}