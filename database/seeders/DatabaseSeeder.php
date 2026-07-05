<?php

namespace Database\Seeders;

use App\Models\AttendanceLog;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo các quyền (Roles)
        $admin = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị viên hệ thống']);
        $hr = Role::firstOrCreate(['name' => 'hr'], ['description' => 'Nhân sự']);
        $employee = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);

        // Tài khoản demo dùng chung mật khẩu: password.
        User::factory()->create([
            'role_id' => $admin->id,
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $hrUser = User::factory()->create([
            'role_id' => $hr->id,
            'email' => 'hr@example.com',
            'password' => 'password',
        ]);

        $tech = Department::create(['name' => 'Công nghệ', 'description' => 'Phát triển và vận hành hệ thống']);
        $hrDepartment = Department::create(['name' => 'Nhân sự', 'description' => 'Tuyển dụng và quản lý nhân sự']);
        $finance = Department::create(['name' => 'Tài chính', 'description' => 'Theo dõi lương và chi phí']);

        $backend = Position::create([
            'department_id' => $tech->id,
            'name' => 'Lập trình viên Backend',
            'description' => 'Xây dựng chức năng Laravel',
            'default_salary' => 12000000,
        ]);
        $hrPosition = Position::create([
            'department_id' => $hrDepartment->id,
            'name' => 'Chuyên viên nhân sự',
            'description' => 'Quản lý hồ sơ nhân viên',
            'default_salary' => 10000000,
        ]);
        $accountant = Position::create([
            'department_id' => $finance->id,
            'name' => 'Kế toán viên',
            'description' => 'Theo dõi bảng lương',
            'default_salary' => 11000000,
        ]);

        $employees = collect([
            [
                'user' => $hrUser,
                'position_id' => $hrPosition->id,
                'employee_code' => 'NV001',
                'full_name' => 'Nguyễn Trung Nguyên',
                'gender' => 'male',
                'phone' => '0901234567',
                'citizen_id' => '079200000001',
                'status' => 'active',
            ],
            [
                'user' => User::factory()->create(['role_id' => $employee->id, 'email' => 'employee@example.com', 'password' => 'password']),
                'position_id' => $backend->id,
                'employee_code' => 'NV002',
                'full_name' => 'Trần Nhật Minh',
                'gender' => 'male',
                'phone' => '0987654321',
                'citizen_id' => '079200000002',
                'status' => 'active',
            ],
            [
                'user' => User::factory()->create(['role_id' => $employee->id, 'email' => 'employee2@example.com', 'password' => 'password']),
                'position_id' => $accountant->id,
                'employee_code' => 'NV003',
                'full_name' => 'Hoàng Thế Đoàn',
                'gender' => 'male',
                'phone' => '0912345678',
                'citizen_id' => '079200000003',
                'status' => 'probation',
            ],
        ])->map(function (array $item) {
            return Employee::create([
                'user_id' => $item['user']->id,
                'position_id' => $item['position_id'],
                'employee_code' => $item['employee_code'],
                'full_name' => $item['full_name'],
                'gender' => $item['gender'],
                'date_of_birth' => '2000-01-01',
                'phone' => $item['phone'],
                'address' => 'TP. Hồ Chí Minh',
                'citizen_id' => $item['citizen_id'],
                'hire_date' => '2025-05-15',
                'status' => $item['status'],
            ]);
        });

        Leave::create([
            'emp_id' => (string) $employees[1]->user_id,
            'emp_name' => $employees[1]->full_name,
            'leave_type' => 'annual',
            'start_date' => now()->addDays(2)->toDateString(),
            'end_date' => now()->addDays(3)->toDateString(),
            'days' => 2,
            'reason' => 'Nghỉ việc gia đình',
            'status' => 'pending',
        ]);

        foreach ($employees as $index => $employeeModel) {
            Contract::create([
                'employee_id' => $employeeModel->id,
                'contract_code' => 'HD'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT),
                'contract_type' => $index === 2 ? 'probation' : 'fixed_term',
                'start_date' => '2026-01-01',
                'end_date' => $index === 2 ? '2026-03-31' : '2026-12-31',
                'salary' => (float) ($employeeModel->position->default_salary ?? 8000000),
                'working_hours_per_week' => 40,
                'status' => 'active',
            ]);

            $checkIn = Carbon::parse(now()->toDateString().' 08:0'.$index);
            $checkOut = Carbon::parse(now()->toDateString().' 17:15');
            $workedMinutes = $checkIn->diffInMinutes($checkOut);

            AttendanceLog::create([
                'employee_id' => $employeeModel->id,
                'work_date' => now()->toDateString(),
                'check_in_at' => $checkIn,
                'check_out_at' => $checkOut,
                'status' => $index === 2 ? 'late' : 'present',
                'worked_minutes' => $workedMinutes,
                'overtime_minutes' => max(0, $workedMinutes - 480),
                'note' => 'Dữ liệu demo',
            ]);

            $baseSalary = (float) ($employeeModel->position->default_salary ?? 8000000);
            Salary::create([
                'employee_id' => $employeeModel->id,
                'month' => now()->month,
                'year' => now()->year,
                'base_salary' => $baseSalary,
                'allowance' => 500000,
                'bonus' => 300000,
                'deduction' => 100000,
                'gross_salary' => $baseSalary + 800000,
                'net_salary' => $baseSalary + 700000,
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }
}
