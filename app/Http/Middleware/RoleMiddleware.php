<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Kiểm tra vai trò của user hiện tại.
     * Sử dụng: ->middleware('role:ADMIN') hoặc 'role:GV,ADMIN'
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Nếu chưa đăng nhập hoặc không có role hợp lệ
        if (!$user || !in_array($user->role, $roles, true)) {
            abort(403, 'Bạn không có quyền truy cập khu vực này.');
        }

        return $next($request);
    }
}
