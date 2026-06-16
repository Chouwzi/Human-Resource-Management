<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'role_id'  => Role::firstOrCreate(['name' => 'employee'])->id,
            'email'    => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ];
    }
}
