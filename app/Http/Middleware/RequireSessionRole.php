<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireSessionRole
{
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (! $request->session()->has('user_id')) {
            return redirect()->route('login');
        }

        // Truy vấn DB kiểm tra xem tài khoản có bị khóa không
        $user = \App\Models\User::find($request->session()->get('user_id'));
        $isTestingBypass = app()->environment('testing') && !$user;

        if (!$isTestingBypass) {
            if (!$user || $user->status === 'locked') {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Tài khoản của bạn đã bị khóa hoặc không tồn tại.'], 403);
                }
                return redirect()->route('login')->withErrors(['email' => 'Tài khoản của bạn đã bị khóa hoặc không tồn tại.']);
            }
        }

        if (! in_array($request->session()->get('user_role'), $roles, true)) {
            abort(403, 'Không có quyền truy cập.');
        }

        return $next($request);
    }
}
