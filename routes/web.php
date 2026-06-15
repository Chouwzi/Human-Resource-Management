<?php

use App\Http\Controllers\AuthController;
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

Route::get('/admin', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    $role = $request->session()->get('user_role');

    if (! in_array($role, ['admin', 'hr'], true)) {
        abort(403, 'Không có quyền truy cập.');
    }

    return view('dashboard.admin', ['role' => $role]);
})->name('admin.home');

Route::get('/user', function (Request $request) {
    if (! $request->session()->has('user_id')) {
        return redirect()->route('login');
    }

    if ($request->session()->get('user_role') !== 'employee') {
        abort(403, 'Không có quyền truy cập.');
    }

    return view('dashboard.user', ['role' => 'employee']);
})->name('user.home');
