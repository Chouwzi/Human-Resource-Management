<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SalaryFilteringTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Employee $devEmployee;
    private Employee $hrEmployee;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);

        $this->adminUser = User::factory()->create(['role_id' => $adminRole->id]);

        // Tạo phòng ban & chức vụ 1 (Kỹ thuật)
        $techDept = Department::create(['name' => 'Kỹ thuật']);
        $devPos = Position::create(['department_id' => $techDept->id, 'name' => 'Lập trình viên', 'default_salary' => 15000000]);
        $devUser = User::factory()->create(['role_id' => $employeeRole->id, 'email' => 'dev@example.com']);
        $this->devEmployee = Employee::create([
            'user_id' => $devUser->id,
            'position_id' => $devPos->id,
            'employee_code' => 'NV088',
            'full_name' => 'Nguyễn Developer',
            'gender' => 'male',
            'date_of_birth' => '1996-06-06',
            'phone' => '0988888888',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789088',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);

        // Tạo phòng ban & chức vụ 2 (Nhân sự)
        $hrDept = Department::create(['name' => 'Nhân sự']);
        $hrPos = Position::create(['department_id' => $hrDept->id, 'name' => 'Chuyên viên nhân sự', 'default_salary' => 10000000]);
        $hrUser = User::factory()->create(['role_id' => $employeeRole->id, 'email' => 'hr_staff@example.com']);
        $this->hrEmployee = Employee::create([
            'user_id' => $hrUser->id,
            'position_id' => $hrPos->id,
            'employee_code' => 'NV077',
            'full_name' => 'Lê HR Staff',
            'gender' => 'female',
            'date_of_birth' => '1997-07-07',
            'phone' => '0977777777',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789077',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);

        // Tạo bảng lương cho Developer (Tháng 7/2026)
        Salary::create([
            'employee_id' => $this->devEmployee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1000000,
            'bonus' => 500000,
            'deduction' => 0,
            'gross_salary' => 16500000,
            'net_salary' => 16500000,
            'status' => 'paid',
        ]);

        // Tạo bảng lương cho HR Staff (Tháng 6/2026)
        Salary::create([
            'employee_id' => $this->hrEmployee->id,
            'month' => 6,
            'year' => 2026,
            'base_salary' => 10000000,
            'allowance' => 500000,
            'bonus' => 0,
            'deduction' => 100000,
            'gross_salary' => 10500000,
            'net_salary' => 10400000,
            'status' => 'draft',
        ]);
    }

    #[Test]
    public function admin_loc_bang_luong_theo_phong_ban(): void
    {
        // Lọc theo phòng Kỹ thuật
        $techDept = Department::where('name', 'Kỹ thuật')->first();
        $response = $this->actingAsAdmin()->get(route('admin.salaries.index', [
            'department_id' => $techDept->id,
        ]));

        $response->assertOk();
        $salaries = $response->viewData('salaries');
        $this->assertCount(1, $salaries);
        $this->assertEquals($this->devEmployee->id, $salaries->first()->employee_id);
    }

    #[Test]
    public function admin_loc_bang_luong_theo_chuc_vu(): void
    {
        // Lọc theo chức vụ Chuyên viên nhân sự
        $hrPos = Position::where('name', 'Chuyên viên nhân sự')->first();
        $response = $this->actingAsAdmin()->get(route('admin.salaries.index', [
            'position_id' => $hrPos->id,
        ]));

        $response->assertOk();
        $salaries = $response->viewData('salaries');
        $this->assertCount(1, $salaries);
        $this->assertEquals($this->hrEmployee->id, $salaries->first()->employee_id);
    }

    #[Test]
    public function admin_loc_bang_luong_theo_thang_nam(): void
    {
        // Lọc theo tháng 7 năm 2026
        $response = $this->actingAsAdmin()->get(route('admin.salaries.index', [
            'month' => 7,
            'year' => 2026,
        ]));

        $response->assertOk();
        $salaries = $response->viewData('salaries');
        $this->assertCount(1, $salaries);
        $this->assertEquals($this->devEmployee->id, $salaries->first()->employee_id);
    }

    private function actingAsAdmin(): self
    {
        return $this->withSession([
            'user_id' => $this->adminUser->id,
            'user_role' => 'admin',
        ]);
    }
}
