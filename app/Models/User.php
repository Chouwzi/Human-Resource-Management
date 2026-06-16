<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Các cột được phép gán dữ liệu
    protected $fillable = [
        'role_id',
        'email',
        'password',
    ];

    // Các cột bị ẩn khi trả về JSON
    protected $hidden = [
        'password',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Quan hệ: user thuộc về một role
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // Helper: lấy tên role
    public function getRoleName(): string
    {
        return $this->role->name;
    }
}
