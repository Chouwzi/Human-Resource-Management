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

    /** @var list<string> */
    protected $fillable = [
        'role_id',
        'email',
        'password',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    public function getRoleName(): string
    {
        return $this->role->name;
    }
}
