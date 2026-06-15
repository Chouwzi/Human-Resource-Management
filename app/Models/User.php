<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Các cột được phép gán dữ liệu
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Các cột bị ẩn khi trả về JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Kiểu dữ liệu tự động chuyển đổi
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
}
