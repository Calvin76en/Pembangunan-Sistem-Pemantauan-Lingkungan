<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login'); // Login view
    }

    // Handle login process
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'nik_user' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nik_user', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user account is active
            if ($user->status == 0) {
                return redirect()->route('login')
                    ->withErrors(['login_gagal' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
            }

            // Redirect based on the user role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'mip':
                    return redirect()->route('mip.dashboard');
                case 'mitra_kerja':
                    return redirect()->route('mitra_kerja.dashboard');
                case 'supervisor':
                    return redirect()->route('supervisor.dashboard');
                default:
                    // In case of an undefined role
                    abort(403, 'Unauthorized.');
            }
        }

        // If login failed, return with error message
        return redirect()->route('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Username atau Password Anda Salah!']);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash success message
        $request->session()->flash('success', 'Anda berhasil logout!');

        return redirect()->route('login');
    }
}

