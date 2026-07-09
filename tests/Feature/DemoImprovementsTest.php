<?php

namespace Tests\Feature;

use App\Models\AttendanceLog;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DemoImprovementsTest extends TestCase
{
    use RefreshDatabase;

    private function createEmployeeUser(string $email = 'employee@example.com'): User
    {
        $role = Role::firstOrCreate(['name' => 'employee']);
        $user = User::factory()->create([
            'role_id' => $role->id,
            'email' => $email,
            'password' => 'password',
            'status' => 'active',
        ]);

        $department = Department::create([
            'name' => 'Phòng kỹ thuật',
        ]);

        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'Nhân viên kỹ thuật',
            'default_salary' => 8000000,
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'position_id' => $position->id,
            'employee_code' => 'NV' . rand(1000, 9999),
            'full_name' => 'Nhân Viên Demo',
            'gender' => 'male',
            'date_of_birth' => '1995-01-01',
            'phone' => '0848000000',
            'address' => 'Hà Nội, Việt Nam',
            'citizen_id' => '00120000' . rand(1000, 9999),
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);

        return $user;
    }

    private function createAdminUser(): User
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        return User::factory()->create([
            'role_id' => $role->id,
            'email' => 'admin@example.com',
            'password' => 'password',
            'status' => 'active',
        ]);
    }

    #[Test]
    public function test_khau_tru_gio_nghi_trua_khi_tinh_phut_lam_viec_va_ot(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $user->employee;

        // 1. Check-in ca sáng
        $today = Carbon::today()->toDateString();
        $checkInTime = Carbon::parse($today . ' 08:00:00');
        
        AttendanceLog::create([
            'employee_id' => $employee->id,
            'work_date' => $today,
            'check_in_at' => $checkInTime,
            'status' => 'present',
        ]);

        // Mock checkout lúc 17:00:00 (khoảng cách 9 tiếng = 540 phút, sau trừ 1h nghỉ trưa = 8 tiếng = 480 phút)
        $checkOutTime = Carbon::parse($today . ' 17:00:00');
        Carbon::setTestNow($checkOutTime);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('attendance.checkout'));

        $response->assertRedirect();
        
        $log = AttendanceLog::where('employee_id', $employee->id)->where('work_date', $today)->first();
        $this->assertEquals(480, $log->worked_minutes);
        $this->assertEquals(0, $log->overtime_minutes);
        
        Carbon::setTestNow(); // Reset test time
    }

    #[Test]
    public function test_tinh_ot_khi_lam_viec_qua_9_tieng_sau_khi_da_tru_gio_nghi_trua(): void
    {
        $user = $this->createEmployeeUser();
        $employee = $user->employee;

        $today = Carbon::today()->toDateString();
        $checkInTime = Carbon::parse($today . ' 08:00:00');
        
        AttendanceLog::create([
            'employee_id' => $employee->id,
            'work_date' => $today,
            'check_in_at' => $checkInTime,
            'status' => 'present',
        ]);

        // Mock checkout lúc 19:30:00 (khoảng cách 11.5 tiếng = 690 phút, trừ nghỉ trưa 60p = 630p. OT = 630 - 480 = 150 phút)
        $checkOutTime = Carbon::parse($today . ' 19:30:00');
        Carbon::setTestNow($checkOutTime);

        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('attendance.checkout'));

        $response->assertRedirect();
        
        $log = AttendanceLog::where('employee_id', $employee->id)->where('work_date', $today)->first();
        $this->assertEquals(480, $log->worked_minutes);
        $this->assertEquals(150, $log->overtime_minutes);
        
        Carbon::setTestNow();
    }

    #[Test]
    public function test_chot_cong_finalize_attendance_cho_ngay_hom_qua_tranh_lockout(): void
    {
        $admin = $this->createAdminUser();
        $employeeUser = $this->createEmployeeUser();

        // Chạy hàm chốt công
        $response = $this->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->post(route('attendance.finalize'));

        $response->assertRedirect();

        // Kiểm tra xem log vắng mặt có được tạo cho ngày HÔM QUA không
        $yesterday = Carbon::yesterday()->toDateString();
        $today = Carbon::today()->toDateString();

        $this->assertDatabaseHas('attendance_logs', [
            'employee_id' => $employeeUser->employee->id,
            'work_date' => $yesterday,
            'status' => 'absent',
        ]);

        // Và KHÔNG tạo cho ngày hôm nay
        $this->assertDatabaseMissing('attendance_logs', [
            'employee_id' => $employeeUser->employee->id,
            'work_date' => $today,
        ]);
    }

    #[Test]
    public function test_tinh_so_ngay_nghi_phep_loai_tru_thu_7_chu_nhat_khi_app_work_saturday_false(): void
    {
        $user = $this->createEmployeeUser();

        // Cấu hình không làm việc Thứ 7
        config(['app.work_saturday' => false]);

        // Gửi đơn từ thứ Sáu (2026-06-05) đến thứ Hai (2026-06-08)
        // Nghỉ: thứ Sáu (1 ngày), Thứ 7 (nghỉ), CN (nghỉ), Thứ Hai (1 ngày). Tổng: 2 ngày.
        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('leaves.store'), [
            'leave_type' => 'annual',
            'start_date' => '2026-06-05',
            'end_date' => '2026-06-08',
            'reason' => 'Đi du lịch',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('leaves', [
            'emp_id' => (string) $user->id,
            'days' => 2,
        ]);
    }

    #[Test]
    public function test_tinh_so_ngay_nghi_phep_tinh_ca_thu_7_khi_app_work_saturday_true(): void
    {
        $user = $this->createEmployeeUser();

        // Cấu hình CÓ làm việc Thứ 7
        config(['app.work_saturday' => true]);

        // Gửi đơn từ thứ Sáu (2026-06-05) đến thứ Hai (2026-06-08)
        // Nghỉ: thứ Sáu (1), Thứ 7 (1), CN (nghỉ), Thứ Hai (1). Tổng: 3 ngày.
        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->post(route('leaves.store'), [
            'leave_type' => 'annual',
            'start_date' => '2026-06-05',
            'end_date' => '2026-06-08',
            'reason' => 'Đi du lịch',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('leaves', [
            'emp_id' => (string) $user->id,
            'days' => 3,
        ]);
    }

    #[Test]
    public function test_hr_admin_khong_the_tu_duyet_hay_tu_choi_don_phep_cua_chinh_minh(): void
    {
        // Tạo tài khoản Admin có profile Employee
        $admin = $this->createAdminUser();
        $adminRole = Role::where('name', 'admin')->first();
        
        $department = Department::create(['name' => 'HR']);
        $position = Position::create([
            'department_id' => $department->id,
            'name' => 'HR Manager',
            'default_salary' => 15000000,
        ]);
        
        $employee = Employee::create([
            'user_id' => $admin->id,
            'position_id' => $position->id,
            'employee_code' => 'ADMIN01',
            'full_name' => 'Admin User',
            'gender' => 'male',
            'date_of_birth' => '1990-01-01',
            'phone' => '0999999999',
            'address' => 'Hà Nội',
            'citizen_id' => '001200001111',
            'hire_date' => '2025-01-01',
            'status' => 'active',
        ]);

        // Admin tự gửi đơn phép
        $leave = Leave::create([
            'emp_id' => (string) $admin->id,
            'emp_name' => 'Admin User',
            'leave_type' => 'annual',
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-03',
            'days' => 3,
            'reason' => 'Nghỉ cá nhân',
            'status' => 'pending',
        ]);

        // Cố duyệt đơn của chính mình
        $response = $this->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->post(route('admin.leaves.approve', $leave->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Bạn không thể tự phê duyệt đơn nghỉ phép của chính mình!');
        $this->assertEquals('pending', $leave->fresh()->status);

        // Cố từ chối đơn của chính mình
        $response2 = $this->withSession([
            'user_id' => $admin->id,
            'user_role' => 'admin',
        ])->post(route('admin.leaves.reject', $leave->id));

        $response2->assertRedirect();
        $response2->assertSessionHas('error', 'Bạn không thể tự từ chối đơn nghỉ phép của chính mình!');
        $this->assertEquals('pending', $leave->fresh()->status);
    }

    #[Test]
    public function test_khong_cho_phep_xoa_don_nghi_phep_da_xu_ly(): void
    {
        $user = $this->createEmployeeUser();

        // 1. Đơn đã được duyệt
        $approvedLeave = Leave::create([
            'emp_id' => (string) $user->id,
            'emp_name' => 'Nhân Viên Demo',
            'leave_type' => 'annual',
            'start_date' => '2026-06-01',
            'end_date' => '2026-06-03',
            'days' => 3,
            'reason' => 'Nghỉ phép',
            'status' => 'approved',
        ]);

        // Thử xóa
        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->delete(route('leaves.destroy', $approvedLeave->id));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Không thể xóa đơn nghỉ phép đã được xử lý!');
        $this->assertDatabaseHas('leaves', ['id' => $approvedLeave->id]);
    }

    #[Test]
    public function test_tai_khoan_bi_khoa_locked_bi_middleware_chan_truy_cap_ngay_lap_tuc(): void
    {
        $user = $this->createEmployeeUser();

        // Khóa tài khoản trong database
        $user->update(['status' => 'locked']);

        // Gửi request lên route được bảo vệ (ví dụ: xem lịch sử chấm công)
        $response = $this->withSession([
            'user_id' => $user->id,
            'user_role' => 'employee',
        ])->get(route('attendance.index'));

        $response->assertRedirect(route('login'));
        $response->assertSessionMissing('user_id'); // Session bị hủy
    }
}
