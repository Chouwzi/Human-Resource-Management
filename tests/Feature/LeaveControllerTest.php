<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LeaveControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function nhan_vien_gui_don_nghi_phep_hop_le(): void
    {
        $user = $this->createEmployeeUser();

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('leaves.store'), [
            'leave_type' => 'annual',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'reason' => 'Nghỉ việc gia đình',
        ]);

        $response->assertRedirect(route('leaves.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('leaves', [
            'emp_id' => (string) $user->id,
            'leave_type' => 'annual',
            'days' => 3,
            'status' => 'pending',
        ]);
    }

    #[Test]
    public function khong_cho_gui_loai_nghi_khong_hop_le_hoac_ly_do_qua_dai(): void
    {
        $user = $this->createEmployeeUser();

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('leaves.store'), [
            'leave_type' => 'hack',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'reason' => str_repeat('a', 501),
        ]);

        $response->assertSessionHasErrors(['leave_type', 'reason']);
        $this->assertDatabaseCount('leaves', 0);
    }

    private function createEmployeeUser(): User
    {
        $role = Role::create([
            'name' => 'employee',
            'description' => 'Nhân viên',
        ]);

        $user = User::factory()->create([
            'role_id' => $role->id,
            'email' => 'employee@example.com',
            'password' => 'password',
        ]);

        $department = Department::create([
            'name' => 'Công nghệ',
            'description' => 'Phòng công nghệ',
        ]);

        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'Nhân viên thử nghiệm',
            'description' => 'Dữ liệu kiểm thử',
            'default_salary' => 10000000,
        ]);

        Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_code' => 'NVTEST',
            'full_name' => 'Nhân Viên Kiểm Thử',
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
            'phone' => '0900000000',
            'address' => 'TP. Hồ Chí Minh',
            'citizen_id' => '079200000099',
            'hire_date' => '2025-01-01',
            'status' => 'active',
        ]);

        return $user;
    }
}
