<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'allowance',
        'bonus',
        'deduction',
        'gross_salary',
        'net_salary',
        'status',
        'paid_at',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
