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

        if (! in_array($request->session()->get('user_role'), $roles, true)) {
            abort(403, 'Không có quyền truy cập.');
        }

        return $next($request);
    }
}
