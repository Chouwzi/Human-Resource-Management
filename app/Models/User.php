<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model: User
 *
 * Tài khoản đăng nhập hệ thống, liên kết với một Role và một Employee.
 *
 * Relationships:
 *  - role():     User thuộc về một Role
 *  - employee(): User có một Employee tương ứng (1-1)
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // -------------------------------------------------------------------------
    // Fillable / Hidden
    // -------------------------------------------------------------------------

    /** @var list<string> */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'status',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'password'          => 'hashed',
            'email_verified_at' => 'datetime',
        ];
    }

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    /**
     * Role của user này (admin, hr, employee...).
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Thông tin nhân viên liên kết với user (1-1).
     */
    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Trả về tên role, dùng được trực tiếp trong Blade.
     */
    public function getRoleName(): string
    {
        return $this->role?->name ?? '';
    }
}
