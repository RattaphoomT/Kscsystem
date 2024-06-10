<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->user_status_user_status_id == 1) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'กรุณาเข้าสู่ระบบด้วยผู้ใช้ระดับ admin');
    }
}

