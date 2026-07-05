<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: AttendanceLog
 *
 * Bản ghi chấm công hằng ngày của nhân viên.
 *
 * Relationships:
 *  - employee(): AttendanceLog thuộc về một Employee
 */
class AttendanceLog extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'employee_id',
        'work_date',
        'check_in_at',
        'check_out_at',
        'status',
        'worked_minutes',
        'overtime_minutes',
        'note',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'work_date'    => 'date',
            'check_in_at'  => 'datetime',
            'check_out_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Nhân viên sở hữu bản ghi chấm công này.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
