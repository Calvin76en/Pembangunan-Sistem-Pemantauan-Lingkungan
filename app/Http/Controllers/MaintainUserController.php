<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MaintainUserController extends Controller
{
    public function index()
    {
        // Cek apakah pengguna yang login adalah admin
        if (Auth::user()->role_id !== 1) {
            return redirect()->route('admin.dashboard')->withErrors(['error' => 'You do not have permission to access this page.']);
        }

        // Ambil data pengguna berdasarkan NIK_user dan role_id
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id_role')
            ->select('users.NIK_user', 'users.name', 'users.email', 'roles.role_name', 'users.status', 'users.role_id')
            ->orderBy('users.NIK_user', 'asc')
            ->get();

        // Ambil data role dari tabel roles untuk dropdown pilihan role
        // Jika sudah ada admin, maka role admin tidak ditampilkan di dropdown untuk user baru
        $adminCount = DB::table('users')->where('role_id', 1)->where('status', 1)->count();
        
        if ($adminCount > 0) {
            // Jika sudah ada admin, exclude role admin dari dropdown
            $roles = DB::table('roles')
                ->select('id_role', 'role_name')
                ->where('id_role', '!=', 1) // Exclude admin role
                ->get();
        } else {
            // Jika belum ada admin, tampilkan semua role
            $roles = DB::table('roles')
                ->select('id_role', 'role_name')
                ->get();
        }

        // Kirimkan data pengguna dan roles ke view
        return view('admin.maintainuser', compact('users', 'roles'));
    }

    // Store the new user
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:6',
                'role' => 'required|exists:roles,id_role',
                'status' => 'required|in:0,1',
            ]);

            // Cek jika role yang dipilih adalah admin (role_id = 1)
            if ($request->role == 1) {
                // Cek apakah sudah ada admin aktif di sistem
                $activeAdminCount = DB::table('users')
                    ->where('role_id', 1)
                    ->where('status', 1)
                    ->count();

                if ($activeAdminCount > 0) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Tidak dapat menambahkan admin baru. Sistem hanya mengizinkan satu admin aktif.');
                }
            }

            // Generate NIK_user otomatis berdasarkan NIK terakhir
            $lastNIK = DB::table('users')->max('NIK_user');
            $newNIK = $lastNIK ? $lastNIK + 1 : 1; // Jika belum ada user, mulai dari 1

            // Insert user baru
            DB::table('users')->insert([
                'NIK_user' => $newNIK,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('admin.maintainuser')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan user: ' . $e->getMessage());
        }
    }

    // Edit user
    public function edit($NIK_user)
    {
        // Cek apakah pengguna yang login adalah admin
        if (Auth::user()->role_id !== 1) {
            return redirect()->route('home')->withErrors(['error' => 'You do not have permission to edit users.']);
        }

        // Ambil data user berdasarkan NIK_user
        $user = User::where('NIK_user', $NIK_user)->first();

        // Ambil data roles untuk pilihan role
        $roles = DB::table('roles')->get();
        
        return view('admin.edituser', compact('user', 'roles'));
    }

    // Update user data
    public function update(Request $request, $NIK_user)
    {
        $request->validate([
            'NIK_user' => 'required|string|max:255|unique:users,NIK_user,' . $NIK_user . ',NIK_user',
            'name' => 'required|string|max:255|unique:users,name,' . $NIK_user . ',NIK_user',
            'email' => 'required|email|max:255|unique:users,email,' . $NIK_user . ',NIK_user',
            'role' => 'required|exists:roles,id_role',
            'status' => 'required|in:0,1',
            'password' => 'nullable|string|min:6',
        ]);

        // Ambil data user berdasarkan NIK_user
        $user = User::where('NIK_user', $NIK_user)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Cek perubahan role
        $oldRole = $user->role_id;
        $newRole = $request->role;
        $oldStatus = $user->status;
        $newStatus = $request->status;

        // Jika user ini adalah admin, tidak boleh mengubah role
        if ($oldRole == 1 && $newRole != 1) {
            return redirect()->back()->with('error', 'Role admin tidak dapat diubah. Admin harus tetap sebagai admin.');
        }

        // Jika user ini adalah admin dan akan dinonaktifkan
        if ($oldRole == 1 && $newStatus == 0) {
            // Cek apakah ada admin aktif lainnya
            $otherActiveAdmins = DB::table('users')
                ->where('role_id', 1)
                ->where('status', 1)
                ->where('NIK_user', '!=', $NIK_user)
                ->count();

            if ($otherActiveAdmins == 0) {
                return redirect()->back()->with('error', 'Tidak dapat menonaktifkan admin terakhir. Sistem harus memiliki minimal satu admin aktif.');
            }
        }

        // Jika user bukan admin dan akan diubah menjadi admin
        if ($oldRole != 1 && $newRole == 1) {
            // Cek apakah sudah ada admin aktif
            $activeAdminCount = DB::table('users')
                ->where('role_id', 1)
                ->where('status', 1)
                ->count();

            if ($activeAdminCount > 0) {
                return redirect()->back()->with('error', 'Tidak dapat mengubah role menjadi admin. Sistem hanya mengizinkan satu admin aktif.');
            }
        }

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Hanya update role jika user bukan admin atau role tidak berubah
        if ($oldRole != 1 || $newRole == $oldRole) {
            $user->role_id = $request->role;
        }
        
        $user->status = $request->status;

        // Update password jika diberikan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan
        $user->save();

        // Jika status menjadi non-aktif dan user yang login adalah yang diubah, logout user
        if ($user->status == 0 && Auth::check() && Auth::user()->NIK_user == $user->NIK_user) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan.');
        }

        return redirect()->route('admin.maintainuser')->with('success', 'User berhasil diperbarui!');
    }

    // Delete user
    public function destroy($NIK_user)
    {
        // Cek apakah user yang akan dihapus adalah admin
        $user = DB::table('users')->where('NIK_user', $NIK_user)->first();
        
        if (!$user) {
            return redirect()->route('admin.maintainuser')->with('error', 'User tidak ditemukan.');
        }

        // Jika user adalah admin, cek apakah ada admin lain
        if ($user->role_id == 1) {
            $otherAdmins = DB::table('users')
                ->where('role_id', 1)
                ->where('status', 1)
                ->where('NIK_user', '!=', $NIK_user)
                ->count();

            if ($otherAdmins == 0) {
                return redirect()->route('admin.maintainuser')->with('error', 'Tidak dapat menghapus admin terakhir. Sistem harus memiliki minimal satu admin aktif.');
            }
        }

        // Delete user
        $deleted = DB::table('users')->where('NIK_user', $NIK_user)->delete();

        if ($deleted) {
            return redirect()->route('admin.maintainuser')->with('success', 'User berhasil dihapus!');
        } else {
            return redirect()->route('admin.maintainuser')->with('error', 'Gagal menghapus user.');
        }
    }
}