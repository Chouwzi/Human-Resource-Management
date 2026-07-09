<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SidebarPositionsLinkTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_sidebar_contains_positions_link(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Admin']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'admin',
            'user_name' => 'Admin User',
        ])->get(route('admin.home'));

        $response->assertOk();
        $response->assertSee(route('admin.positions.index'));
        $response->assertSee('Chức vụ');
    }

    #[Test]
    public function hr_sidebar_contains_positions_link(): void
    {
        $role = Role::firstOrCreate(['name' => 'hr'], ['description' => 'HR']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'hr',
            'user_name' => 'HR User',
        ])->get(route('hr.home'));

        $response->assertOk();
        $response->assertSee(route('admin.positions.index'));
        $response->assertSee('Chức vụ');
    }

    #[Test]
    public function employee_sidebar_does_not_contain_positions_link(): void
    {
        $role = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
            'user_name' => 'Employee User',
        ])->get(route('user.home'));

        $response->assertOk();
        $response->assertDontSee(route('admin.positions.index'));
    }
}
