<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model: Role
 *
 * Đại diện cho vai trò / quyền hạn trong hệ thống (admin, hr, employee...).
 *
 * Relationships:
 *  - users(): một Role có nhiều User
 */
class Role extends Model
{
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
     * Danh sách user thuộc role này.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
