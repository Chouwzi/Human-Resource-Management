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

class SalaryExportTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_export_salaries_to_csv(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);

        $adminUser = User::factory()->create(['role_id' => $adminRole->id]);
        $devUser = User::factory()->create(['role_id' => $employeeRole->id, 'email' => 'export_dev@example.com']);

        $dept = Department::create(['name' => 'Công nghệ']);
        $pos = Position::create(['department_id' => $dept->id, 'name' => 'Kỹ sư', 'default_salary' => 15000000]);

        $employee = Employee::create([
            'user_id' => $devUser->id,
            'position_id' => $pos->id,
            'employee_code' => 'NV088',
            'full_name' => 'Nguyễn Export',
            'gender' => 'male',
            'date_of_birth' => '1996-06-06',
            'phone' => '0988888888',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789088',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);

        // Tạo bảng lương tháng 7/2026
        Salary::create([
            'employee_id' => $employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1000000,
            'bonus' => 500000,
            'deduction' => 100000,
            'gross_salary' => 16500000,
            'net_salary' => 16400000,
            'status' => 'paid',
        ]);

        $response = $this->withSession([
            'user_id' => $adminUser->id,
            'user_role' => 'admin',
        ])->get(route('admin.salaries.export', [
            'month' => 7,
            'year' => 2026,
        ]));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->assertHeader('Content-Disposition', 'attachment; filename="bang-luong-thang-7-2026.csv"');

        $content = $response->streamedContent();

        $this->assertStringContainsString('Tháng/Năm', $content);
        $this->assertStringContainsString('Nguyễn Export', $content);
        $this->assertStringContainsString('NV088', $content);
        $this->assertStringContainsString('15000000', $content);
        $this->assertStringContainsString('16400000', $content);
    }
}
