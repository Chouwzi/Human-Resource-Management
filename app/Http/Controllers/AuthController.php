<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('user_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {

        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::with(['role', 'employee'])->where('email', $request->input('email'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng'])->withInput();
        }

        if ($user->status === 'locked') {
            return back()->withErrors(['email' => 'Tài khoản đã bị khóa'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_role', $user->getRoleName());
        // Lưu tên hiển thị để layout dùng được với cơ chế đăng nhập bằng session.
        $request->session()->put('user_name', $user->employee?->full_name ?? $user->email);

        $roleName = $user->getRoleName();

        if ($roleName === 'admin') {
            return redirect()->route('admin.home');
        }

        if ($roleName === 'hr') {
            return redirect()->route('hr.home');
        }

        if ($roleName === 'employee') {
            return redirect()->route('user.home');
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
