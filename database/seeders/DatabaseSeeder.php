<?php

namespace Database\Seeders;

use App\Models\Role;
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

        $admin    = Role::firstOrCreate(['name' => 'admin'],    ['description' => 'Quản trị viên hệ thống']);
        $hr       = Role::firstOrCreate(['name' => 'hr'],       ['description' => 'Nhân sự']);
        $employee = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);


        User::factory()->create([
            'role_id'  => $admin->id,
            'email'    => 'admin@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'role_id'  => $hr->id,
            'email'    => 'hr@example.com',
            'password' => 'password',
        ]);

        User::factory()->create([
            'role_id'  => $employee->id,
            'email'    => 'employee@example.com',
            'password' => 'password',
        ]);
    }
}
