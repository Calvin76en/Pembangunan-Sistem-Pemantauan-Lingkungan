<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Roles
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $userRole = Auth::user()->role; // Pastikan ini sesuai dengan kolom yang ada di tabel pengguna

        // Cek apakah role pengguna termasuk dalam salah satu role yang diberikan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, redirect ke halaman utama dengan pesan error
        return redirect('/')->with('error', "Anda Tidak Punya Akses Untuk Login");
    }
}
