<?php

use App\Http\Controllers\AdminHrmController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SalaryController;
use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
// Redirect /login về trang đăng nhập thực tế (tránh 405 khi user gõ nhầm)
Route::get('/login', fn() => redirect()->route('login'));
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    $role = $request->session()->get('user_role');

    if ($role === 'admin') {
        return redirect()->route('admin.home');
    } elseif ($role === 'hr') {
        return redirect()->route('hr.home');
    }

    return redirect()->route('user.home');
})->name('dashboard');

Route::get('/admin', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    if ($request->session()->get('user_role') !== 'admin') {
        abort(403, 'Không có quyền truy cập.');
    }

    $pendingLeavesCount = \App\Models\Leave::where('status', 'pending')->count();
    $totalEmployees     = \App\Models\Employee::count();
    $totalContracts     = \App\Models\Contract::where('status', 'active')->count();
    $recentEmployees    = \App\Models\Employee::with('position')->latest()->take(5)->get();

    return view('dashboard.admin', compact('pendingLeavesCount', 'totalEmployees', 'totalContracts', 'recentEmployees'));
})->middleware('require.role:admin')->name('admin.home');

Route::get('/hr', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    if ($request->session()->get('user_role') !== 'hr') {
        abort(403, 'Không có quyền truy cập.');
    }

    $pendingLeavesCount = \App\Models\Leave::where('status', 'pending')->count();
    $totalEmployees     = \App\Models\Employee::count();
    $activeEmployees    = \App\Models\Employee::where('status', 'active')->count();
    $recentEmployees    = \App\Models\Employee::with('position')->latest()->take(5)->get();

    return view('dashboard.hr', compact('pendingLeavesCount', 'totalEmployees', 'activeEmployees', 'recentEmployees'));
})->middleware('require.role:hr')->name('hr.home');

Route::get('/user', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    if ($request->session()->get('user_role') !== 'employee') {
        abort(403, 'Không có quyền truy cập.');
    }

    $userId = $request->session()->get('user_id');
    $employee = Employee::with('position')->where('user_id', $userId)->first();
    $recentLeaves = Leave::where('emp_id', $userId)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();
    $todayAttendance = $employee
        ? AttendanceLog::where('employee_id', $employee->id)
            ->whereDate('work_date', Carbon::today())
            ->first()
        : null;
    $approvedLeaveDays = Leave::where('emp_id', $userId)
        ->where('status', 'approved')
        ->whereYear('start_date', Carbon::now()->year)
        ->sum('days');
    $latestSalary = $employee
        ? Salary::where('employee_id', $employee->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->first()
        : null;

    return view('dashboard.user', [
        'role' => 'employee',
        'employee' => $employee,
        'todayAttendance' => $todayAttendance,
        'approvedLeaveDays' => $approvedLeaveDays,
        'latestSalary' => $latestSalary,
        'recentLeaves' => $recentLeaves,
    ]);
})->middleware('require.role:employee')->name('user.home');

// Phân hệ cho Nhân viên (User)
Route::middleware('require.role:employee')->group(function () {
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves/store', [LeaveController::class, 'store'])->name('leaves.store');
    Route::post('/leaves/cancel/{id}', [LeaveController::class, 'cancel'])->name('leaves.cancel');
    Route::delete('/leaves/delete/{id}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
    Route::get('/salaries', [SalaryController::class, 'index'])->name('salaries.index');
    Route::get('/contracts', [SalaryController::class, 'contracts'])->name('user.contracts.index');
});

// Phân hệ cho Quản lý (Admin/HR)
Route::middleware('require.role:admin,hr')->group(function () {
    Route::get('/admin/leaves/pending', [LeaveController::class, 'pending'])->name('admin.leaves.pending');
    Route::post('/admin/leaves/approve/{id}', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
    Route::post('/admin/leaves/reject/{id}', [LeaveController::class, 'reject'])->name('admin.leaves.reject');
});

// CRUD chung cho Admin và HR (không bao gồm xóa)
Route::prefix('admin')->name('admin.')->middleware('require.role:admin,hr')->group(function () {
    Route::get('/departments', [AdminHrmController::class, 'departments'])->name('departments.index');
    Route::post('/departments', [AdminHrmController::class, 'storeDepartment'])->name('departments.store');
    Route::put('/departments/{department}', [AdminHrmController::class, 'updateDepartment'])->name('departments.update');

    Route::get('/positions', [AdminHrmController::class, 'positions'])->name('positions.index');
    Route::post('/positions', [AdminHrmController::class, 'storePosition'])->name('positions.store');
    Route::put('/positions/{position}', [AdminHrmController::class, 'updatePosition'])->name('positions.update');

    Route::get('/employees', [AdminHrmController::class, 'employees'])->name('employees.index');
    Route::post('/employees', [AdminHrmController::class, 'storeEmployee'])->name('employees.store');
    Route::put('/employees/{employee}', [AdminHrmController::class, 'updateEmployee'])->name('employees.update');

    Route::get('/attendance', [AdminHrmController::class, 'attendance'])->name('attendance.index');
    Route::post('/attendance', [AdminHrmController::class, 'storeAttendance'])->name('attendance.store');
    Route::get('/attendance/export', [AdminHrmController::class, 'exportAttendance'])->name('attendance.export');
});

// Chỉ Admin mới được phép quản lý Hợp đồng, Lương và XÓA dữ liệu
Route::prefix('admin')->name('admin.')->middleware('require.role:admin')->group(function () {
    Route::get('/salaries', [AdminHrmController::class, 'salaries'])->name('salaries.index');
    Route::post('/salaries', [AdminHrmController::class, 'storeSalary'])->name('salaries.store');
    Route::delete('/salaries/{salary}', [AdminHrmController::class, 'destroySalary'])->name('salaries.destroy');
    Route::delete('/attendance/{log}', [AdminHrmController::class, 'destroyAttendance'])->name('attendance.destroy');

    Route::get('/contracts', [AdminHrmController::class, 'contracts'])->name('contracts.index');
    Route::post('/contracts', [AdminHrmController::class, 'storeContract'])->name('contracts.store');
    Route::put('/contracts/{contract}', [AdminHrmController::class, 'updateContract'])->name('contracts.update');
    Route::delete('/contracts/{contract}', [AdminHrmController::class, 'destroyContract'])->name('contracts.destroy');

    Route::delete('/departments/{department}', [AdminHrmController::class, 'destroyDepartment'])->name('departments.destroy');
    Route::delete('/positions/{position}', [AdminHrmController::class, 'destroyPosition'])->name('positions.destroy');
    Route::delete('/employees/{employee}', [AdminHrmController::class, 'destroyEmployee'])->name('employees.destroy');
});

Route::get('/api/leaves/pending-count', function () {
    return response()->json([
        'count' => Leave::where('status', 'pending')->count(),
    ]);
})->middleware('require.role:admin,hr');

// Phân hệ Chấm công cho Nhân viên (User)
Route::middleware('require.role:employee')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/checkin', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/checkout', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
});

// Admin chốt công và sửa đổi chấm công (AdminHrmController.php và AttendanceController.php)
Route::middleware('require.role:admin,hr')->group(function () {
    Route::post('/attendance/finalize', [AttendanceController::class, 'finalizeAttendance'])->name('attendance.finalize');
});
