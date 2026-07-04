<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: Salary
 *
 * Bảng lương hằng tháng của nhân viên.
 *
 * Relationships:
 *  - employee(): Salary thuộc về một Employee
 */
class Salary extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'bonus',
        'deduction',
        'net_salary',
        'note',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'month'       => 'integer',
            'year'        => 'integer',
            'base_salary' => 'decimal:2',
            'bonus'       => 'decimal:2',
            'deduction'   => 'decimal:2',
            'net_salary'  => 'decimal:2',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Nhân viên nhận bảng lương này.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
