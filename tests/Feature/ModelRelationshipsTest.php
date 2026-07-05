<?php

namespace Tests\Feature;

use App\Models\AttendanceLog;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function cac_model_hrm_khai_bao_quan_he_chinh_xac(): void
    {
        $role = Role::create(['name' => 'employee', 'description' => 'Nhân viên']);
        $managerUser = User::factory()->create(['role_id' => $role->id, 'email' => 'manager@example.com']);
        $employeeUser = User::factory()->create(['role_id' => $role->id, 'email' => 'employee@example.com']);

        $department = Department::create(['name' => 'Công nghệ']);
        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'Lập trình viên',
            'default_salary' => 12000000,
        ]);

        $manager = $this->createEmployee($managerUser, $position, 'NVQL', 'Quản Lý');
        $employee = $this->createEmployee($employeeUser, $position, 'NV001', 'Nhân Viên', $manager);

        $contract = Contract::create([
            'employee_id' => $employee->id,
            'contract_code' => 'HD001',
            'contract_type' => 'fixed_term',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'salary' => 12000000,
            'working_hours_per_week' => 40,
            'status' => 'active',
        ]);

        $attendance = AttendanceLog::create([
            'employee_id' => $employee->id,
            'work_date' => '2026-07-05',
            'status' => 'present',
            'worked_minutes' => 480,
            'overtime_minutes' => 0,
        ]);

        $leaveType = LeaveType::create([
            'name' => 'Nghỉ phép năm',
            'default_days_per_year' => 12,
            'is_paid' => true,
        ]);

        $leaveRequest = LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'approver_id' => $manager->id,
            'start_date' => '2026-07-06',
            'end_date' => '2026-07-07',
            'total_days' => 2,
            'reason' => 'Nghỉ việc gia đình',
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $salary = Salary::create([
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

        $this->assertTrue($role->users->contains($employeeUser));
        $this->assertTrue($department->positions->contains($position));
        $this->assertTrue($department->employees->contains($employee));
        $this->assertTrue($position->employees->contains($employee));
        $this->assertTrue($manager->subordinates->contains($employee));
        $this->assertTrue($employeeUser->employee->is($employee));
        $this->assertTrue($employee->manager->is($manager));
        $this->assertTrue($employee->contracts->contains($contract));
        $this->assertTrue($employee->attendanceLogs->contains($attendance));
        $this->assertTrue($employee->leaveRequests->contains($leaveRequest));
        $this->assertTrue($manager->approvedLeaveRequests->contains($leaveRequest));
        $this->assertTrue($leaveType->leaveRequests->contains($leaveRequest));
        $this->assertTrue($leaveRequest->approver->is($manager));
        $this->assertTrue($employee->salaries->contains($salary));
    }

    private function createEmployee(User $user, Position $position, string $code, string $name, ?Employee $manager = null): Employee
    {
        return Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'manager_id' => $manager?->id,
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
    }
}
