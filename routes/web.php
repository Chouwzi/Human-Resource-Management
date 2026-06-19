<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin', function () {
    // 1. Giả lập dữ liệu mà sau này Backend sẽ lấy từ Database
    $mockData = [
        'userName'         => 'Nguyễn Văn Admin',
        'avatarUrl'        => null, // Trả về null để test ảnh mặc định
        'totalEmployees'   => 128,
        'totalDepartments' => 8,
        'pendingLeaves'    => 12,
        'todayAttendance'  => 115
    ];

    // 2. Bắn dữ liệu giả lập ra View
    return view('admin.dashboard', $mockData);
})-> name('admin.dashboard');