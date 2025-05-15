<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Periksa apakah user sudah login dan memiliki role yang sesuai
        if (Auth::check() && Auth::user()->role == $role) {
            return $next($request); // Lanjutkan jika role sesuai
        }

        // Jika tidak, redirect ke halaman login atau halaman lain sesuai kebutuhan
        return redirect('/login')->withErrors(['role' => 'Access Denied']);
    }
}
