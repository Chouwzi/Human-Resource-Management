<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

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
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::with('role')->where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng'])->withInput();
        }


        $request->session()->regenerate();
        $request->session()->put('user_id', $user->id);
        $request->session()->put('user_role', $user->getRoleName());


        $roleName = $user->getRoleName();

        if ($roleName === 'admin' || $roleName === 'hr') {
            return redirect()->route('admin.home');
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
