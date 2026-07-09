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

    #[Test]
    public function admin_xem_duoc_don_cho_duyet_va_lich_su_da_xu_ly(): void
    {
        $user = $this->createEmployeeUser();

        // 1. Chờ duyệt
        \App\Models\Leave::create([
            'emp_id' => (string) $user->id,
            'emp_name' => 'Nhân Viên Kiểm Thử',
            'leave_type' => 'annual',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'days' => 2,
            'reason' => 'Nghỉ phép thường',
            'status' => 'pending',
        ]);

        // 2. Đã duyệt
        \App\Models\Leave::create([
            'emp_id' => (string) $user->id,
            'emp_name' => 'Nhân Viên Kiểm Thử',
            'leave_type' => 'sick',
            'start_date' => now()->addDays(5)->toDateString(),
            'end_date' => now()->addDays(6)->toDateString(),
            'days' => 2,
            'reason' => 'Nghỉ ốm đau',
            'status' => 'approved',
            'approved_by' => 'admin@example.com',
            'approved_at' => now(),
        ]);

        // 3. Từ chối
        \App\Models\Leave::create([
            'emp_id' => (string) $user->id,
            'emp_name' => 'Nhân Viên Kiểm Thử',
            'leave_type' => 'unpaid',
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(11)->toDateString(),
            'days' => 2,
            'reason' => 'Nghỉ việc cá nhân',
            'status' => 'rejected',
            'approved_by' => 'admin@example.com',
            'approved_at' => now(),
        ]);

        $response = $this->withSession([
            'user_id' => 999,
            'user_role' => 'admin',
        ])->get(route('admin.leaves.pending'));

        $response->assertOk();
        $response->assertSee('Nghỉ phép thường');
        $response->assertSee('Nghỉ ốm đau');
        $response->assertSee('Nghỉ việc cá nhân');
        $response->assertSee('Đã duyệt');
        $response->assertSee('Từ chối');
    }

    #[Test]
    public function unit_leave_relationship_employee(): void
    {
        $user = $this->createEmployeeUser();
        $leave = \App\Models\Leave::create([
            'emp_id' => (string) $user->id,
            'emp_name' => 'Nhân Viên Kiểm Thử',
            'leave_type' => 'annual',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'days' => 2,
            'reason' => 'Nghỉ phép thường',
            'status' => 'pending',
        ]);

        $this->assertNotNull($leave->employee);
        $this->assertEquals('Nhân Viên Kiểm Thử', $leave->employee->full_name);
    }
}
