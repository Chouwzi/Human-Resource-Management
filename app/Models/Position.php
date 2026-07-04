<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Position
 *
 * Chức danh / vị trí công việc thuộc một phòng ban.
 *
 * Relationships:
 *  - department(): Position thuộc về một Department
 *  - employees():  một Position có nhiều Employee
 */
class Position extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'department_id',
        'name',
        'description',
        'default_salary',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    protected function casts(): array
    {
        return [
            'default_salary' => 'decimal:2',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Phòng ban chứa chức danh này.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Nhân viên đang giữ chức danh này.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
