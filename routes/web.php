<?php

use App\Http\Controllers\AuthController;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    $role = $request->session()->get('user_role');

    return in_array($role, ['admin', 'hr'], true)
        ? redirect()->route('admin.home')
        : redirect()->route('user.home');
})->name('dashboard');

// SỬA ROUTE ADMIN
Route::get('/admin', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    $role = $request->session()->get('user_role');

    if (! in_array($role, ['admin', 'hr'], true)) {
        abort(403, 'Không có quyền truy cập.');
    }

    // Truy vấn thông tin người dùng từ Database dựa vào Session
    $user = User::find($request->session()->get('user_id'));

    // Truyền biến $user sang cho View
    return view('leaves.admin', ['user' => $user]); 
})->name('admin.home');

// SỬA ROUTE USER
Route::get('/user', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    if ($request->session()->get('user_role') !== 'employee') {
        abort(403, 'Không có quyền truy cập.');
    }

    // Truy vấn thông tin người dùng từ Database dựa vào Session
    $user = User::find($request->session()->get('user_id'));

    // Truyền biến $user sang cho View
    return view('leaves.employee', ['user' => $user]);
})->name('user.home');
// Route tạm để test UI Task 8
Route::get('/ui-nghi-phep', function () {
    return view('leaves.employee');
});

Route::get('/ui-duyet-phep', function () {
    return view('leaves.admin');
});