<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Chuyển hướng nếu chưa đăng nhập
            return redirect()->route('login'); 
        }

        if (Auth::user()->role === 'user') {
            return $next($request);
        }

        // Đã đăng nhập nhưng không phải user
        abort(403, 'Access denied');
    }
}
