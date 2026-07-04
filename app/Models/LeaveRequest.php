<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model: LeaveRequest
 *
 * Đơn xin nghỉ phép của nhân viên.
 *
 * Relationships:
 *  - employee():   LeaveRequest thuộc về một Employee (người xin nghỉ)
 *  - leaveType():  LeaveRequest thuộc về một LeaveType (loại nghỉ)
 *  - approvedBy(): LeaveRequest được duyệt bởi một Employee (quản lý / HR)
 */
class LeaveRequest extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'approved_by',
        'start_date',
        'end_date',
        'reason',
        'status',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Nhân viên gửi đơn nghỉ phép.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Loại nghỉ phép được áp dụng cho đơn này.
     */
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Người duyệt đơn nghỉ (thường là quản lý hoặc HR).
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
