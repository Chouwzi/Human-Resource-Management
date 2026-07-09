<?php

namespace Tests\Feature;

use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AttendanceExportTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_and_hr_can_export_attendance_to_csv(): void
    {
        // 1. Setup Role and Users
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị viên']);
        $hrRole = Role::firstOrCreate(['name' => 'hr'], ['description' => 'Quản lý nhân sự']);

        $adminUser = User::factory()->create(['role_id' => $adminRole->id]);
        $hrUser = User::factory()->create(['role_id' => $hrRole->id]);

        // 2. Setup Position/Department/Employee/AttendanceLog
        $department = Department::create(['name' => 'Kỹ thuật']);
        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'Kiểm thử viên',
            'default_salary' => 9000000,
        ]);
        $employee = Employee::create([
            'user_id' => $adminUser->id,
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

        // Attendance log in July 2026
        AttendanceLog::create([
            'employee_id' => $employee->id,
            'work_date' => '2026-07-10',
            'check_in_at' => '2026-07-10 08:15:00',
            'check_out_at' => '2026-07-10 17:30:00',
            'worked_minutes' => 555,
            'overtime_minutes' => 30,
            'status' => 'present',
            'note' => 'Điểm danh đầy đủ',
        ]);

        // 3. Test request with Admin role
        $responseAdmin = $this->withSession([
            'user_id' => $adminUser->id,
            'user_role' => 'admin',
        ])->get(route('admin.attendance.export', ['month' => '07', 'year' => '2026']));

        $responseAdmin->assertOk();
        $responseAdmin->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $responseAdmin->assertHeader('Content-Disposition', 'attachment; filename="cham-cong-07-2026.csv"');

        // Capture content
        ob_start();
        $responseAdmin->sendContent();
        $content = ob_get_clean();

        // Check BOM
        $bom = chr(0xEF) . chr(0xBB) . chr(0xBF);
        $this->assertStringStartsWith($bom, $content);

        // Check CSV structure and content
        $this->assertStringContainsString('Ngày', $content);
        $this->assertStringContainsString('Mã NV', $content);
        $this->assertStringContainsString('Họ tên', $content);
        $this->assertStringContainsString('Check-in', $content);
        $this->assertStringContainsString('Check-out', $content);
        $this->assertStringContainsString('Phút làm', $content);
        $this->assertStringContainsString('Tăng ca', $content);
        $this->assertStringContainsString('Trạng thái', $content);
        $this->assertStringContainsString('Ghi chú', $content);
        $this->assertStringContainsString('10/07/2026', $content);
        $this->assertStringContainsString('NVREAL', $content);
        $this->assertStringContainsString('Lê Dữ Liệu Thật', $content);
        $this->assertStringContainsString('08:15', $content);
        $this->assertStringContainsString('17:30', $content);
        $this->assertStringContainsString('555 phút', $content);
        $this->assertStringContainsString('30 phút', $content);
        $this->assertStringContainsString('Có mặt', $content);
        $this->assertStringContainsString('Điểm danh đầy đủ', $content);

        // 4. Test request with HR role
        $responseHr = $this->withSession([
            'user_id' => $hrUser->id,
            'user_role' => 'hr',
        ])->get(route('admin.attendance.export', ['month' => '07', 'year' => '2026']));

        $responseHr->assertOk();
    }

    #[Test]
    public function employee_cannot_export_attendance(): void
    {
        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);
        $employeeUser = User::factory()->create(['role_id' => $employeeRole->id]);

        $response = $this->withSession([
            'user_id' => $employeeUser->id,
            'user_role' => 'employee',
        ])->get(route('admin.attendance.export', ['month' => '07', 'year' => '2026']));

        $response->assertStatus(403);
    }

    #[Test]
    public function guests_are_redirected_to_login_on_export_attempt(): void
    {
        $response = $this->get(route('admin.attendance.export', ['month' => '07', 'year' => '2026']));

        $response->assertRedirect(route('login'));
    }
}
