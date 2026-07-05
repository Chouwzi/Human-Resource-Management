<?php

namespace Tests\Feature;

use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserDashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function dashboard_nhan_vien_hien_thi_du_lieu_that_cua_tai_khoan(): void
    {
        $role = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);
        $user = User::factory()->create(['role_id' => $role->id, 'email' => 'that@example.com']);
        $department = Department::create(['name' => 'Kỹ thuật']);
        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'Kiểm thử viên',
            'default_salary' => 9000000,
        ]);
        $employee = Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_code' => 'NVREAL',
            'full_name' => 'Lê Dữ Liệu Thật',
            'gender' => 'female',
            'date_of_birth' => '2001-01-01',
            'phone' => '0900000001',
            'address' => 'TP. Hồ Chí Minh',
            'citizen_id' => '079200000099',
            'hire_date' => '2026-02-15',
            'status' => 'active',
        ]);

        AttendanceLog::create([
            'employee_id' => $employee->id,
            'work_date' => Carbon::today()->toDateString(),
            'check_in_at' => Carbon::today()->setTime(8, 15),
            'status' => 'present',
        ]);

        Salary::create([
            'employee_id' => $employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 9000000,
            'allowance' => 500000,
            'bonus' => 0,
            'deduction' => 0,
            'gross_salary' => 9500000,
            'net_salary' => 9500000,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
            'user_name' => $employee->full_name,
        ])->get(route('user.home'));

        $response->assertOk();
        $response->assertSee('Lê Dữ Liệu Thật');
        $response->assertSee('NVREAL');
        $response->assertSee('Kiểm thử viên');
        $response->assertSee('08:15');
        $response->assertSee('Tháng 07/2026');
        $response->assertSee('Đã thanh toán');
        $response->assertDontSee('Nguyễn Trung Nguyên');
        $response->assertDontSee('Phép Năm Còn Lại');
    }
}
