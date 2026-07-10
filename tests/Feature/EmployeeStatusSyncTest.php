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

class EmployeeStatusSyncTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Employee $employee;
    private User $employeeUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Cài đặt roles
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);

        // Tạo tài khoản admin
        $this->adminUser = User::factory()->create(['role_id' => $adminRole->id]);

        // Tạo tài khoản nhân viên ban đầu
        $this->employeeUser = User::factory()->create([
            'role_id' => $employeeRole->id,
            'email' => 'test_employee@example.com',
            'status' => 'active',
        ]);

        $dept = Department::create(['name' => 'Công nghệ']);
        $pos = Position::create(['department_id' => $dept->id, 'name' => 'Kỹ sư', 'default_salary' => 10000000]);

        $this->employee = Employee::create([
            'user_id' => $this->employeeUser->id,
            'position_id' => $pos->id,
            'employee_code' => 'NV099',
            'full_name' => 'Nguyễn Văn A',
            'gender' => 'male',
            'date_of_birth' => '1998-08-08',
            'phone' => '0988888888',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789099',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);
    }

    #[Test]
    public function dong_bo_trang_thai_khoa_va_mo_khoa_tai_khoan_khi_cap_nhat_nhan_su(): void
    {
        // 1. Bước đầu: Nhân viên đang 'active'
        $this->assertEquals('active', $this->employee->status);
        $this->assertEquals('active', $this->employeeUser->fresh()->status);

        // 2. Thực hiện vô hiệu hóa (Xóa nhân sự)
        $response = $this->withSession([
            'user_id' => $this->adminUser->id,
            'user_role' => 'admin',
        ])->delete(route('admin.employees.destroy', $this->employee));

        $response->assertRedirect();
        $this->assertEquals('resigned', $this->employee->fresh()->status);
        $this->assertEquals('locked', $this->employeeUser->fresh()->status);

        // 3. Thực hiện sửa đổi trạng thái quay lại 'active' thông qua Edit/Update
        $responseUpdate = $this->withSession([
            'user_id' => $this->adminUser->id,
            'user_role' => 'admin',
        ])->put(route('admin.employees.update', $this->employee), [
            'email' => 'test_employee@example.com',
            'position_id' => $this->employee->position_id,
            'employee_code' => 'NV099',
            'full_name' => 'Nguyễn Văn A',
            'gender' => 'male',
            'date_of_birth' => '1998-08-08',
            'phone' => '0988888888',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789099',
            'hire_date' => '2026-01-01',
            'status' => 'active', // Đổi về active
        ]);

        $responseUpdate->assertRedirect();

        // Trạng thái nhân sự và tài khoản đăng nhập PHẢI tự động mở khóa về 'active'
        $this->assertEquals('active', $this->employee->fresh()->status);
        $this->assertEquals('active', $this->employeeUser->fresh()->status);
    }
}
