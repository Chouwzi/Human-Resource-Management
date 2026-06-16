<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin(Request $request): View|RedirectResponse
    {
        // Nếu đã đăng nhập thì chuyển về dashboard
        if ($request->session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request): RedirectResponse
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tìm user theo email, eager load role
        $user = User::with('role')->where('email', $request->input('email'))->first();

        // Kiểm tra user tồn tại và mật khẩu đúng
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng'])->withInput();
        }

        // Lưu thông tin đăng nhập vào session
        $request->session()->regenerate();
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_role', $user->getRoleName());

        // Chuyển hướng theo role
        $roleName = $user->getRoleName();

        if ($roleName === 'admin' || $roleName === 'hr') {
            return redirect()->route('admin.home');
        }

        if ($roleName === 'employee') {
            return redirect()->route('user.home');
        }

        return redirect()->route('dashboard');
    }

    // Xử lý đăng xuất
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
