<?php

namespace Tests\Feature;

use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContractControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_co_the_them_sua_va_xoa_hop_dong(): void
    {
        $admin = $this->createUserWithRole('admin');
        $employee = $this->createEmployee();

        $session = [
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ];

        $createResponse = $this->withSession($session)->post(route('admin.contracts.store'), [
            'employee_id' => $employee->id,
            'contract_code' => 'HDTEST',
            'contract_type' => 'fixed_term',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'salary' => 12000000,
            'working_hours_per_week' => 40,
            'status' => 'active',
        ]);

        $createResponse->assertRedirect();
        $createResponse->assertSessionHas('success');
        $contract = Contract::where('contract_code', 'HDTEST')->firstOrFail();

        $updateResponse = $this->withSession($session)->put(route('admin.contracts.update', $contract), [
            'employee_id' => $employee->id,
            'contract_code' => 'HDTEST-EDIT',
            'contract_type' => 'indefinite',
            'start_date' => '2026-02-01',
            'end_date' => null,
            'salary' => 15000000,
            'working_hours_per_week' => 42,
            'status' => 'active',
        ]);

        $updateResponse->assertRedirect(route('admin.contracts.index'));
        $this->assertDatabaseHas('contracts', [
            'id' => $contract->id,
            'contract_code' => 'HDTEST-EDIT',
            'contract_type' => 'indefinite',
            'salary' => 15000000,
        ]);

        $deleteResponse = $this->withSession($session)->delete(route('admin.contracts.destroy', $contract));

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('contracts', ['id' => $contract->id]);
    }

    #[Test]
    public function nhan_vien_khong_duoc_truy_cap_quan_ly_hop_dong(): void
    {
        $employeeUser = $this->createUserWithRole('employee');

        $response = $this->withSession([
            'user_id' => $employeeUser->id,
            'user_role' => 'employee',
        ])->get(route('admin.contracts.index'));

        $response->assertForbidden();
    }

    #[Test]
    public function hr_khong_duoc_truy_cap_quan_ly_hop_dong(): void
    {
        $hrUser = $this->createUserWithRole('hr');

        $response = $this->withSession([
            'user_id' => $hrUser->id,
            'user_role' => 'hr',
        ])->get(route('admin.contracts.index'));

        $response->assertForbidden();
    }

    #[Test]
    public function khong_cho_luu_hop_dong_co_ngay_ket_thuc_truoc_ngay_bat_dau(): void
    {
        $admin = $this->createUserWithRole('admin');
        $employee = $this->createEmployee();

        $response = $this->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->post(route('admin.contracts.store'), [
            'employee_id' => $employee->id,
            'contract_code' => 'HD-BAD',
            'contract_type' => 'fixed_term',
            'start_date' => '2026-12-31',
            'end_date' => '2026-01-01',
            'salary' => 12000000,
            'working_hours_per_week' => 40,
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors('end_date');
        $this->assertDatabaseMissing('contracts', ['contract_code' => 'HD-BAD']);
    }

    private function createUserWithRole(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName], ['description' => $roleName]);

        return User::factory()->create(['role_id' => $role->id]);
    }

    private function createEmployee(): Employee
    {
        $user = $this->createUserWithRole('employee');
        $department = Department::firstOrCreate(['name' => 'Công nghệ']);
        $position = Position::firstOrCreate(
            ['department_id' => $department->id, 'name' => 'Lập trình viên'],
            ['default_salary' => 12000000]
        );

        return Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_code' => 'NVHD',
            'full_name' => 'Nhân Viên Hợp Đồng',
            'gender' => 'male',
            'date_of_birth' => '2000-01-01',
            'phone' => '0900000000',
            'address' => 'TP. Hồ Chí Minh',
            'citizen_id' => '079HD',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);
    }
}
