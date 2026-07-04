<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Department
 *
 * Phòng ban trong tổ chức.
 *
 * Relationships:
 *  - positions(): một Department có nhiều Position
 *  - employees(): một Department có nhiều Employee (thông qua positions)
 */
class Department extends Model
{
    use HasFactory;

    // -------------------------------------------------------------------------
    // Fillable
    // -------------------------------------------------------------------------

    protected $fillable = [
        'name',
        'description',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Danh sách vị trí / chức danh thuộc phòng ban.
     */
    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    /**
     * Tất cả nhân viên thuộc phòng ban (qua bảng positions).
     */
    public function employees(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Employee::class, Position::class);
    }
}
