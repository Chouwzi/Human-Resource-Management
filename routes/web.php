<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveController;
use App\Models\Leave;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
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

    $userId = $request->session()->get('user_id');
    $recentLeaves = \App\Models\Leave::where('emp_id', $userId)
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    return view('dashboard.user', [
        'role'         => 'employee',
        'recentLeaves' => $recentLeaves,
    ]);
})->name('user.home');

// Phân hệ cho Nhân viên (User)
Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
Route::post('/leaves/store', [LeaveController::class, 'store'])->name('leaves.store');
Route::post('/leaves/cancel/{id}', [LeaveController::class, 'cancel'])->name('leaves.cancel');

// Phân hệ cho Quản lý (Admin/HR)
Route::get('/admin/leaves/pending', [LeaveController::class, 'pending'])->name('admin.leaves.pending');
Route::post('/admin/leaves/approve/{id}', [LeaveController::class, 'approve'])->name('admin.leaves.approve');
Route::post('/admin/leaves/reject/{id}', [LeaveController::class, 'reject'])->name('admin.leaves.reject');

Route::get('/api/leaves/pending-count', function() {
    return response()->json([
        'count' => Leave::where('status', 'pending')->count()
    ]);
});

// Route xóa đơn nghỉ phép
Route::delete('/leaves/delete/{id}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
