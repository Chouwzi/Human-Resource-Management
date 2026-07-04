<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: LeaveType
 *
 * Loại nghỉ phép (nghỉ phép năm, nghỉ ốm, nghỉ thai sản...).
 *
 * Relationships:
 *  - leaveRequests(): một LeaveType có nhiều LeaveRequest
 */
class LeaveType extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'name',
        'max_days_per_year',
        'description',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'max_days_per_year' => 'integer',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Các đơn xin nghỉ phép thuộc loại nghỉ này.
     */
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
