<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminAttendancePageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_xem_duoc_trang_quan_ly_cham_cong(): void
    {
        $role = Role::create([
            'name' => 'admin',
            'description' => 'Quản trị viên',
        ]);

        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->get(route('admin.attendance.index'));

        $response->assertOk();
        $response->assertSee('Quản Lý Chấm Công');
        $response->assertSee(route('attendance.finalize'), false);
    }
}
