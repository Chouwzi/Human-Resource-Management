<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/* --- ROUTE HIỂN THỊ GIAO DIỆN (Frontend phụ trách) --- */

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


/* --- ROUTE XỬ LÝ FORM (Chờ Backend cung cấp Controller) --- */

// Chỉ khai báo tên route để HTML gán vào thuộc tính action="", giữ trống hoàn toàn logic bên trong.
Route::post('/forgot-password', function () {
    // [CẦN BACKEND CUNG CẤP] Xử lý logic gửi email khôi phục mật khẩu
})->name('password.email');

Route::post('/login', function () {
    // [CẦN BACKEND CUNG CẤP] Xử lý logic đối chiếu Database và xác thực người dùng
})->name('login.post');

/* --- TRANG XÁC THỰC OTP & ĐẶT LẠI MẬT KHẨU --- */
Route::get('/verify-otp', function () {
    // Truyền thử email giả định để test giao diện
    return view('auth.otp-reset', ['email' => 'nhanvien@team6.com']);
})->name('password.otp.view');

Route::post('/verify-otp', function () {
    // [CẦN BACKEND CUNG CẤP] Xử lý logic kiểm tra OTP và cập nhật mật khẩu
})->name('password.otp.verify');

// ==========================================
// KÊNH 1: DÀNH CHO QUẢN TRỊ VIÊN (ADMIN)
// ==========================================
Route::get('/admin', function () {
    return view('admin.dashboard', [
        'total_employees' => 128,
        'total_departments' => 8,
        'pending_leaves' => 12,
        'attendance_today' => 115,
    ]);
})->name('admin.dashboard');

// 1. Quản lý Nhân sự
Route::get('/admin/employees', function () {
    return view('admin.employees');
})->name('admin.employees');

// 2. Quản lý Phòng ban
Route::get('/admin/departments', function () {
    return view('admin.departments');
})->name('admin.departments');

// 3. Quản lý Đơn nghỉ chờ duyệt
Route::get('/admin/leaves', function () {
    return view('admin.leaves');
})->name('admin.leaves');

// 4. Chấm công hôm nay
Route::get('/admin/attendance', function () {
    return view('admin.attendance');
})->name('admin.attendance');


// ==========================================
// KÊNH 2: DÀNH CHO NHÂN VIÊN (EMPLOYEE)
// ==========================================
Route::get('/employee', function () {
    return view('employee.dashboard', [
        'myWorkDays' => 22,
        'myLeaves' => 1,
        'today_status' => 'Đã check-in (07:55 AM)', 
        'today_class' => 'text-success', 
        
        'employee_info' => [
            'code' => 'NV-066206017698',
            'name' => 'Nguyen Trung Nguyen',
            'department' => 'Công nghệ Thông tin',
            'position' => 'Chuyên viên Phát triển',
            'email' => 'nguyennt7698@ut.edu.vn'
        ],

        'recent_leave' => [
            'code' => 'ĐNP001',
            'reason' => 'Nghỉ phép năm',
            'date' => '25/06/2026',
            'status' => 'Chờ duyệt',
            'status_class' => 'badge-warning'
        ]
    ]);
})->name('employee.dashboard');

// 1. Xem Đơn nghỉ cá nhân
Route::get('/employee/leaves', function () {
    return view('employee.leaves');
})->name('employee.leaves');

// 2. Lịch sử chấm công cá nhân
Route::get('/employee/attendance', function () {
    return view('employee.attendance');
})->name('employee.attendance');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

?>