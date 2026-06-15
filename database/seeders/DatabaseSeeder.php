<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'HR Demo',
            'email' => 'hr@example.com',
            'role' => 'hr',
            'password' => 'password',
        ]);

        User::factory()->create([
            'name' => 'Employee Demo',
            'email' => 'employee@example.com',
            'role' => 'employee',
            'password' => 'password',
        ]);
    }
}
