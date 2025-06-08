<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Menampilkan tampilan login
    }

    // Menangani proses login
    public function login(Request $request)
    {
        // Validasi kredensial login
        $request->validate([
            'nik_user' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nik_user', 'password');

        // Mencoba mengautentikasi pengguna
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Memeriksa apakah akun pengguna aktif
            if ($user->status == 0) {
                return redirect()->route('login')
                    ->withErrors(['login_gagal' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
            }

            // Pengalihan berdasarkan role_id
            switch ($user->role_id) {
                case 1:
                    return redirect()->route('admin.dashboard');
                case 2:
                    return redirect()->route('mip.dashboard');
                case 3:
                    return redirect()->route('mitra_kerja.dashboard');
                case 4:
                    return redirect()->route('supervisor.dashboard');
                default:
                    // Jika peran tidak terdefinisi
                    abort(403, 'Unauthorized.');
            }
        }

        // Jika login gagal, kembali dengan pesan error
        return redirect()->route('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Username atau Password Anda Salah!']);
    }

    // Menangani proses logout
    public function logout(Request $request)
    {
        Auth::logout(); // Mengeluarkan pengguna

        // Menghapus sesi dan menghasilkan token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Menampilkan pesan sukses
        $request->session()->flash('success', 'Anda berhasil logout!');

        return redirect()->route('login');
    }
}

