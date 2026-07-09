<?php
 
namespace Tests\Feature;

use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SalaryCalculationTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Employee $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['description' => 'Quản trị viên']);
        $this->adminUser = User::factory()->create(['role_id' => $adminRole->id]);

        $employeeRole = Role::firstOrCreate(['name' => 'employee'], ['description' => 'Nhân viên']);
        $empUser = User::factory()->create(['role_id' => $employeeRole->id, 'email' => 'nv@example.com']);
        $dept = Department::create(['name' => 'Kỹ thuật']);
        $pos = Position::create(['department_id' => $dept->id, 'name' => 'Kỹ sư', 'default_salary' => 15000000]);
        $this->employee = Employee::create([
            'user_id' => $empUser->id,
            'position_id' => $pos->id,
            'employee_code' => 'NV123',
            'full_name' => 'Nguyễn Văn Test',
            'gender' => 'male',
            'date_of_birth' => '1995-05-05',
            'phone' => '0912345678',
            'address' => 'Hà Nội',
            'citizen_id' => '123456789012',
            'hire_date' => '2026-01-01',
            'status' => 'active',
        ]);
    }

    #[Test]
    public function tinh_luong_co_ban_khong_phu_cap_khong_khau_tru(): void
    {
        $response = $this->actingAsAdmin()->post(route('admin.salaries.store'), [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 0,
            'status' => 'draft',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('salaries', [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 0,
            'gross_salary' => 15000000,
            'net_salary' => 15000000,
            'status' => 'draft',
            'paid_at' => null,
        ]);
    }

    #[Test]
    public function tinh_luong_co_phu_cap_va_thuong_khong_khau_tru(): void
    {
        $response = $this->actingAsAdmin()->post(route('admin.salaries.store'), [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1500000,
            'bonus' => 2500000,
            'deduction' => 0,
            'status' => 'draft',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('salaries', [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1500000,
            'bonus' => 2500000,
            'deduction' => 0,
            'gross_salary' => 19000000,
            'net_salary' => 19000000,
        ]);
    }

    #[Test]
    public function tinh_luong_co_khau_tru(): void
    {
        $response = $this->actingAsAdmin()->post(route('admin.salaries.store'), [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1500000,
            'bonus' => 2500000,
            'deduction' => 1200000,
            'status' => 'draft',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('salaries', [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 1500000,
            'bonus' => 2500000,
            'deduction' => 1200000,
            'gross_salary' => 19000000,
            'net_salary' => 17800000,
        ]);
    }

    #[Test]
    public function tinh_luong_khi_khau_tru_vuot_qua_tong_thu_nhap(): void
    {
        // Gross = 15,000,000. Deduction = 20,000,000. Net should be 0, not negative.
        $response = $this->actingAsAdmin()->post(route('admin.salaries.store'), [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 20000000,
            'status' => 'draft',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('salaries', [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 20000000,
            'gross_salary' => 15000000,
            'net_salary' => 0,
        ]);
    }

    #[Test]
    public function ghi_nhan_paid_at_khi_trang_thai_la_paid(): void
    {
        $response = $this->actingAsAdmin()->post(route('admin.salaries.store'), [
            'employee_id' => $this->employee->id,
            'month' => 7,
            'year' => 2026,
            'base_salary' => 15000000,
            'allowance' => 0,
            'bonus' => 0,
            'deduction' => 0,
            'status' => 'paid',
        ]);

        $response->assertRedirect();
        
        $salary = Salary::where('employee_id', $this->employee->id)->where('month', 7)->where('year', 2026)->first();
        $this->assertNotNull($salary);
        $this->assertEquals('paid', $salary->status);
        $this->assertNotNull($salary->paid_at);
    }

    #[Test]
    public function chot_cong_tu_dong_khi_co_don_phep_duoc_duyet(): void
    {
        $yesterday = Carbon::yesterday();

        // Tạo đơn xin nghỉ phép đã được duyệt cho hôm qua
        Leave::create([
            'emp_id' => $this->employee->user_id, // Bảng leaves cũ dùng emp_id liên kết users.id
            'emp_name' => $this->employee->full_name,
            'leave_type' => 'annual',
            'start_date' => $yesterday->toDateString(),
            'end_date' => $yesterday->toDateString(),
            'days' => 1,
            'reason' => 'Đi du lịch',
            'status' => 'approved',
        ]);

        // Gửi yêu cầu chốt công ngày hôm qua
        $response = $this->actingAsAdmin()->post(route('attendance.finalize'));
        $response->assertRedirect();

        // Phải tạo bản ghi chấm công có status là 'leave'
        $this->assertDatabaseHas('attendance_logs', [
            'employee_id' => $this->employee->id,
            'work_date' => $yesterday->toDateString(),
            'status' => 'leave',
            'worked_minutes' => 0,
            'overtime_minutes' => 0,
            'check_in_at' => null,
            'check_out_at' => null,
        ]);
    }

    #[Test]
    public function chot_cong_tu_dong_khi_khong_di_lam_va_khong_co_phep(): void
    {
        $yesterday = Carbon::yesterday();

        // Không tạo đơn phép và không chấm công.
        // Gửi yêu cầu chốt công ngày hôm qua
        $response = $this->actingAsAdmin()->post(route('attendance.finalize'));
        $response->assertRedirect();

        // Phải tạo bản ghi chấm công có status là 'absent'
        $this->assertDatabaseHas('attendance_logs', [
            'employee_id' => $this->employee->id,
            'work_date' => $yesterday->toDateString(),
            'status' => 'absent',
            'worked_minutes' => 0,
            'overtime_minutes' => 0,
            'check_in_at' => null,
            'check_out_at' => null,
        ]);
    }

    private function actingAsAdmin(): self
    {
        return $this->withSession([
            'user_id' => $this->adminUser->id,
            'user_role' => 'admin',
        ]);
    }
}
