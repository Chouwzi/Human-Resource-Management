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
        $response->assertSee('Quản lý chấm công');
        $response->assertSee(route('attendance.finalize'), false);
    }

    #[Test]
    public function loi_validate_cham_cong_hien_thi_chi_tiet_tren_giao_dien(): void
    {
        $role = Role::create([
            'name' => 'admin',
            'description' => 'Quản trị viên',
        ]);

        $admin = User::factory()->create(['role_id' => $role->id]);

        $response = $this->followingRedirects()->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->from(route('admin.attendance.index'))->post(route('admin.attendance.store'), [
            'employee_id' => 999,
            'work_date' => '2026-07-05',
            'check_in_at' => '09:00',
            'check_out_at' => '08:00',
            'status' => 'present',
        ]);

        $response->assertOk();
        $response->assertSee('Vui lòng kiểm tra lại dữ liệu nhập');
        $response->assertSee('Giờ ra phải sau giờ vào.', false);
    }
}
