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

class SalaryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function nhan_vien_chi_xem_duoc_bang_luong_cua_minh(): void
    {
        [$employeeUser, $employee] = $this->createEmployee('employee@example.com', 'NV001', 'Nhân Viên Một');
        [, $otherEmployee] = $this->createEmployee('other@example.com', 'NV002', 'Nhân Viên Hai');

        Salary::create([
            'employee_id' => $employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 12000000,
            'allowance' => 500000,
            'bonus' => 300000,
            'deduction' => 100000,
            'gross_salary' => 12800000,
            'net_salary' => 12700000,
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        Salary::create([
            'employee_id' => $otherEmployee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 9000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 0,
            'gross_salary' => 9000000,
            'net_salary' => 9000000,
            'status' => 'draft',
        ]);

        $response = $this->withSession([
            'user_id' => $employeeUser->id,
            'user_role' => 'employee',
            'user_name' => $employee->full_name,
        ])->get(route('salaries.index'));

        $response->assertOk();
        $response->assertSee('Nhân Viên Một');
        $response->assertSee('12,700,000 VND');
        $response->assertDontSee('9,000,000 VND');
        $response->assertDontSee('Nhân Viên Hai');
    }

    private function createEmployee(string $email, string $code, string $name): array
    {
        $role = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);
        $user = User::factory()->create(['role_id' => $role->id, 'email' => $email]);
        $department = Department::firstOrCreate(['name' => 'Công nghệ']);
        $position = Position::firstOrCreate(
            ['department_id' => $department->id, 'name' => 'Lập trình viên'],
            ['default_salary' => 12000000]
        );

        $employee = Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_code' => $code,
            'full_name' => $name,
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
            'phone' => '0900000000',
            'address' => 'TP. Hồ Chí Minh',
            'citizen_id' => '079'.$code,
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);

        return [$user, $employee];
    }
}
