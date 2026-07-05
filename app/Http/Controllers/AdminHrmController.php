<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Contract;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminHrmController extends Controller
{
    public function departments(Request $request): View
    {
        $departments = Department::withCount('positions')
            ->orderBy('name')
            ->get();
        $editingDepartment = $request->filled('edit_department')
            ? Department::find($request->integer('edit_department'))
            : null;

        return view('admin.hrm.departments', compact('departments', 'editingDepartment'));
    }

    public function storeDepartment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:departments,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ], $this->validationMessages(), $this->validationAttributes());

        Department::create($data);

        return back()->with('success', 'Đã thêm phòng ban.');
    }

    public function updateDepartment(Request $request, Department $department): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('departments', 'name')->ignore($department->id)],
            'description' => ['nullable', 'string', 'max:255'],
        ], $this->validationMessages(), $this->validationAttributes());

        $department->update($data);

        return redirect()->route('admin.departments.index')->with('success', 'Đã cập nhật phòng ban.');
    }

    public function destroyDepartment(Department $department): RedirectResponse
    {
        if ($department->positions()->exists()) {
            return back()->with('error', 'Không thể xóa phòng ban đang có chức vụ.');
        }

        $department->delete();

        return back()->with('success', 'Đã xóa phòng ban.');
    }

    public function positions(Request $request): View
    {
        $departments = Department::orderBy('name')->get();
        $positions = Position::with('department')
            ->orderBy('department_id')
            ->orderBy('name')
            ->get();
        $editingPosition = $request->filled('edit_position')
            ? Position::find($request->integer('edit_position'))
            : null;

        return view('admin.hrm.positions', compact('departments', 'positions', 'editingPosition'));
    }

    public function storePosition(Request $request): RedirectResponse
    {
        $data = $request->validate($this->positionRules(), $this->validationMessages(), $this->validationAttributes());
        Position::create($data);

        return back()->with('success', 'Đã thêm chức vụ.');
    }

    public function updatePosition(Request $request, Position $position): RedirectResponse
    {
        $data = $request->validate($this->positionRules($position), $this->validationMessages(), $this->validationAttributes());
        $position->update($data);

        return redirect()->route('admin.positions.index')->with('success', 'Đã cập nhật chức vụ.');
    }

    public function destroyPosition(Position $position): RedirectResponse
    {
        if ($position->employees()->exists()) {
            return back()->with('error', 'Không thể xóa chức vụ đang có nhân viên.');
        }

        $position->delete();

        return back()->with('success', 'Đã xóa chức vụ.');
    }

    public function employees(Request $request): View
    {
        $query = Employee::with(['position.department', 'user', 'manager']);

        if ($request->filled('keyword')) {
            $keyword = $request->string('keyword')->trim()->toString();
            $query->where(function ($builder) use ($keyword) {
                $builder->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('employee_code', 'like', "%{$keyword}%")
                    ->orWhere('citizen_id', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->whereHas('position', fn ($builder) => $builder->where('department_id', $request->integer('department_id')));
        }

        $employees = $query->orderBy('employee_code')->paginate(10)->withQueryString();
        $positions = Position::with('department')->orderBy('name')->get();
        $departments = Department::orderBy('name')->get();
        $managers = Employee::orderBy('full_name')->get();
        $editingEmployee = $request->filled('edit_employee')
            ? Employee::with('user')->find($request->integer('edit_employee'))
            : null;

        return view('admin.hrm.employees', compact('employees', 'positions', 'departments', 'managers', 'editingEmployee'));
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $data = $request->validate($this->employeeRules(), $this->validationMessages(), $this->validationAttributes());
        $role = Role::where('name', 'employee')->firstOrFail();

        // Tạo user cùng lúc để nhân viên đăng nhập được ngay.
        $user = User::create([
            'role_id' => $role->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password'] ?? 'password'),
        ]);

        $data['user_id'] = $user->id;
        unset($data['email'], $data['password']);

        Employee::create($data);

        return back()->with('success', 'Đã thêm nhân viên.');
    }

    public function updateEmployee(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate($this->employeeRules($employee), $this->validationMessages(), $this->validationAttributes());

        $userData = ['email' => $data['email']];
        if (! empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        $employee->user->update($userData);
        unset($data['email'], $data['password']);
        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Đã cập nhật nhân viên.');
    }

    public function destroyEmployee(Employee $employee): RedirectResponse
    {
        $employee->update(['status' => 'resigned']);
        $employee->user?->update(['status' => 'locked']);

        return back()->with('success', 'Đã vô hiệu hóa nhân viên và giữ lại lịch sử liên quan.');
    }

    public function attendance(Request $request): View
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $logs = AttendanceLog::with('employee')
            ->whereMonth('work_date', $month)
            ->whereYear('work_date', $year)
            ->orderByDesc('work_date')
            ->orderBy('employee_id')
            ->get();
        $employees = Employee::orderBy('full_name')->get();

        return view('admin.hrm.attendance', compact('logs', 'employees', 'month', 'year'));
    }

    public function storeAttendance(Request $request): RedirectResponse
    {
        $data = $request->validate($this->attendanceRules(), $this->validationMessages(), $this->validationAttributes());
        $data = $this->calculateAttendance($data);

        AttendanceLog::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'work_date' => $data['work_date']],
            $data
        );

        return back()->with('success', 'Đã lưu chấm công.');
    }

    public function salaries(): View
    {
        $salaries = Salary::with('employee')
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
        $employees = Employee::with('position')->orderBy('full_name')->get();

        return view('admin.hrm.salaries', compact('salaries', 'employees'));
    }

    public function storeSalary(Request $request): RedirectResponse
    {
        $data = $request->validate($this->salaryRules(), $this->validationMessages(), $this->validationAttributes());
        $data = $this->calculateSalary($data);

        Salary::updateOrCreate(
            ['employee_id' => $data['employee_id'], 'month' => $data['month'], 'year' => $data['year']],
            $data
        );

        return back()->with('success', 'Đã lưu bảng lương.');
    }

    public function contracts(Request $request): View
    {
        $contracts = Contract::with('employee')
            ->orderByDesc('start_date')
            ->orderBy('contract_code')
            ->get();
        $employees = Employee::orderBy('full_name')->get();
        $editingContract = $request->filled('edit_contract')
            ? Contract::find($request->integer('edit_contract'))
            : null;

        return view('admin.hrm.contracts', compact('contracts', 'employees', 'editingContract'));
    }

    public function storeContract(Request $request): RedirectResponse
    {
        $data = $request->validate($this->contractRules(), $this->validationMessages(), $this->validationAttributes());
        Contract::create($data);

        return back()->with('success', 'Đã thêm hợp đồng.');
    }

    public function updateContract(Request $request, Contract $contract): RedirectResponse
    {
        $data = $request->validate($this->contractRules($contract), $this->validationMessages(), $this->validationAttributes());
        $contract->update($data);

        return redirect()->route('admin.contracts.index')->with('success', 'Đã cập nhật hợp đồng.');
    }

    public function destroyContract(Contract $contract): RedirectResponse
    {
        $contract->delete();

        return back()->with('success', 'Đã xóa hợp đồng.');
    }

    private function positionRules(?Position $position = null): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('positions', 'name')
                    ->where('department_id', request('department_id'))
                    ->ignore($position?->id),
            ],
            'description' => ['nullable', 'string', 'max:255'],
            'default_salary' => ['required', 'numeric', 'min:0'],
        ];
    }

    private function employeeRules(?Employee $employee = null): array
    {
        $userId = $employee?->user_id;

        return [
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => [$employee ? 'nullable' : 'required', 'string', 'min:6'],
            'position_id' => ['required', 'exists:positions,id'],
            'manager_id' => ['nullable', 'exists:employees,id'],
            'employee_code' => ['required', 'string', 'max:30', Rule::unique('employees', 'employee_code')->ignore($employee?->id)],
            'full_name' => ['required', 'string', 'max:150'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'date_of_birth' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'citizen_id' => ['required', 'string', 'max:30', Rule::unique('employees', 'citizen_id')->ignore($employee?->id)],
            'hire_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['probation', 'active', 'resigned'])],
        ];
    }

    private function attendanceRules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'work_date' => ['required', 'date'],
            'check_in_at' => ['nullable', 'date_format:H:i'],
            'check_out_at' => ['nullable', 'date_format:H:i', 'after:check_in_at'],
            'status' => ['required', Rule::in(['present', 'late', 'absent', 'leave'])],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }

    private function salaryRules(): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'between:2020,2100'],
            'base_salary' => ['required', 'numeric', 'min:0'],
            'allowance' => ['nullable', 'numeric', 'min:0'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'deduction' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['draft', 'paid'])],
        ];
    }

    private function contractRules(?Contract $contract = null): array
    {
        return [
            'employee_id' => ['required', 'exists:employees,id'],
            'contract_code' => ['required', 'string', 'max:50', Rule::unique('contracts', 'contract_code')->ignore($contract?->id)],
            'contract_type' => ['required', Rule::in(['probation', 'fixed_term', 'indefinite'])],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'salary' => ['required', 'numeric', 'min:0'],
            'working_hours_per_week' => ['required', 'numeric', 'min:0', 'max:168'],
            'status' => ['required', Rule::in(['active', 'expired', 'terminated'])],
        ];
    }

    private function validationAttributes(): array
    {
        return [
            'name' => 'tên',
            'description' => 'mô tả',
            'department_id' => 'phòng ban',
            'default_salary' => 'lương mặc định',
            'email' => 'email',
            'password' => 'mật khẩu',
            'position_id' => 'chức vụ',
            'manager_id' => 'quản lý trực tiếp',
            'employee_code' => 'mã nhân viên',
            'full_name' => 'họ tên',
            'gender' => 'giới tính',
            'date_of_birth' => 'ngày sinh',
            'phone' => 'số điện thoại',
            'address' => 'địa chỉ',
            'citizen_id' => 'CCCD/CMND',
            'hire_date' => 'ngày vào làm',
            'employee_id' => 'nhân viên',
            'work_date' => 'ngày làm việc',
            'check_in_at' => 'giờ vào',
            'check_out_at' => 'giờ ra',
            'note' => 'ghi chú',
            'month' => 'tháng',
            'year' => 'năm',
            'base_salary' => 'lương cơ bản',
            'allowance' => 'phụ cấp',
            'bonus' => 'thưởng',
            'deduction' => 'khấu trừ',
            'contract_code' => 'mã hợp đồng',
            'contract_type' => 'loại hợp đồng',
            'start_date' => 'ngày bắt đầu',
            'end_date' => 'ngày kết thúc',
            'salary' => 'lương thỏa thuận',
            'working_hours_per_week' => 'giờ làm mỗi tuần',
            'status' => 'trạng thái',
        ];
    }

    private function validationMessages(): array
    {
        return [
            'check_out_at.after' => 'Giờ ra phải sau giờ vào.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'required' => ':attribute là bắt buộc.',
            'email' => ':attribute không đúng định dạng.',
            'unique' => ':attribute đã tồn tại.',
            'exists' => ':attribute không hợp lệ.',
            'in' => ':attribute không hợp lệ.',
            'date' => ':attribute không đúng định dạng ngày.',
            'date_format' => ':attribute không đúng định dạng giờ.',
            'after' => ':attribute phải sau mốc được chọn.',
            'after_or_equal' => ':attribute phải sau hoặc bằng mốc được chọn.',
            'integer' => ':attribute phải là số nguyên.',
            'numeric' => ':attribute phải là số.',
            'string' => ':attribute phải là chuỗi.',
            'min' => ':attribute không được nhỏ hơn :min.',
            'max' => ':attribute không được lớn hơn :max.',
            'between' => ':attribute phải nằm trong khoảng :min đến :max.',
        ];
    }

    private function calculateAttendance(array $data): array
    {
        $data['worked_minutes'] = 0;
        $data['overtime_minutes'] = 0;

        if (! empty($data['check_in_at']) && ! empty($data['check_out_at'])) {
            $workDate = $data['work_date'];
            $checkIn = Carbon::parse("{$workDate} {$data['check_in_at']}");
            $checkOut = Carbon::parse("{$workDate} {$data['check_out_at']}");
            $worked = max(0, $checkIn->diffInMinutes($checkOut));
            $data['check_in_at'] = $checkIn;
            $data['check_out_at'] = $checkOut;
            $data['worked_minutes'] = $worked;
            $data['overtime_minutes'] = max(0, $worked - 480);
        }

        if (empty($data['check_in_at'])) {
            $data['check_in_at'] = null;
        }

        if (empty($data['check_out_at'])) {
            $data['check_out_at'] = null;
        }

        return $data;
    }

    private function calculateSalary(array $data): array
    {
        $data['allowance'] = $data['allowance'] ?? 0;
        $data['bonus'] = $data['bonus'] ?? 0;
        $data['deduction'] = $data['deduction'] ?? 0;
        $data['gross_salary'] = $data['base_salary'] + $data['allowance'] + $data['bonus'];
        $data['net_salary'] = max(0, $data['gross_salary'] - $data['deduction']);
        $data['paid_at'] = $data['status'] === 'paid' ? now() : null;

        return $data;
    }
}
