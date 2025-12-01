<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login.form');
        }
        if (strtoupper(auth()->user()->role) !== 'ADMIN') {
            abort(403, 'Bạn không có quyền truy cập khu vực quản trị.');
        }
        return $next($request);
    }
}
