<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Employee
 *
 * Thông tin nhân viên — trung tâm của hệ thống HRM.
 *
 * Relationships:
 *  - user():           Employee liên kết với một User (tài khoản đăng nhập)
 *  - position():       Employee thuộc về một Position (chức danh)
 *  - manager():        Self-reference — quản lý trực tiếp của nhân viên này
 *  - subordinates():   Self-reference — danh sách nhân viên dưới quyền
 *  - contracts():      Danh sách hợp đồng lao động
 *  - attendanceLogs(): Danh sách bản ghi chấm công
 *  - leaveRequests():  Danh sách đơn xin nghỉ phép
 *  - salaries():       Danh sách bảng lương
 */
class Employee extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'user_id',
        'position_id',
        'manager_id',
        'employee_code',
        'full_name',
        'gender',
        'date_of_birth',
        'phone',
        'address',
        'citizen_id',
        'hire_date',
        'status',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'hire_date'     => 'date',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Tài khoản người dùng liên kết với nhân viên này.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Chức danh / vị trí hiện tại của nhân viên.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Quản lý trực tiếp (self-reference).
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    /**
     * Danh sách nhân viên cấp dưới (self-reference).
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * Các hợp đồng lao động của nhân viên.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Lịch sử chấm công của nhân viên.
     */
    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class);
    }

    /**
     * Các đơn xin nghỉ phép của nhân viên.
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    /**
     * Lịch sử bảng lương của nhân viên.
     */
    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }
}
