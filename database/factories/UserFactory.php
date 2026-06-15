<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Tạo dữ liệu mẫu cho User khi test.
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'role'              => 'employee',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'), // mật khẩu mặc định khi test
            'remember_token'    => Str::random(10),
        ];
    }
}
