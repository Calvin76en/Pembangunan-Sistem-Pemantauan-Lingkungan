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
        // Check if the logged-in user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->withErrors(['error' => 'You do not have permission to access this page.']);
        }

        $users = DB::table('users')
                    ->select('user_id', 'NIK_user', 'name', 'email', 'role', 'status')
                    ->orderBy('user_id', 'asc')
                    ->get();

        $totalData = $users->count();

        // Ambil data role yang ada dari database
        $roles = DB::table('users')
                    ->select('role')
                    ->distinct() // Menampilkan hanya role yang unik
                    ->get();

        // Kirimkan data users, totalData, dan roles ke view
        return view('admin.maintainuser', compact('users', 'totalData', 'roles'));
    }


    // Log informasi saat fungsi store dipanggil
    // Log::info('Store method called', [
    //     'NIK_user' => $request->NIK_user,
    //     'name' => $request->name,
    //     'email' => $request->email,
    // ]);

    // Validasi data yang diterima dari form
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'NIK_user' => 'required|string|max:255|unique:users',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:6', // Confirm password memastikan ada konfirmasi
        'role' => 'required|string|in:admin,mip,mitra_kerja,supervisor',
        'status' => 'required|in:0,1',
    ]);

    // Membuat user baru
    $user = User::create([
        'NIK_user' => $request->NIK_user,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Enkripsi password
        'role' => $request->role,
        'status' => $request->status,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Menambahkan data ke model JenisStatus terkait dengan User
    // Redirect ke halaman utama dengan pesan sukses jika berhasil
    return redirect()->route('admin.maintainuser')->with('success', 'User and JenisStatus added successfully!');
}

// Log jika validasi berhasil
// Log::info('User data validated successfully.');

// Menyimpan data ke database
// try {
//     DB::table('users')->insert([
//         'NIK_user' => $request->NIK_user,
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'role' => $request->role,
//         'status' => $request->status,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);

//     // Log::info('User added successfully', [
//     //     'user_id' => $request->NIK_user,
//     //     'role' => $request->role,
//     // ]);

//     return redirect()->route('admin.maintainuser')->with('success', 'User added successfully!');
// } catch (\Exception $e) {
//     // // Log error jika terjadi kesalahan saat memasukkan data
//     // Log::error('Error adding user: ' . $e->getMessage());
//     return back()->withErrors(['error' => 'Failed to add user.']);
// }

    public function edit($id)
    {
        // Check if the logged-in user is an admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->withErrors(['error' => 'You do not have permission to edit users.']);
        }

        $user = User::find($id);
        $roles = User::select('role')->distinct()->get();  // Fetch distinct roles from users table
        return view('admin.edituser', compact('user', 'roles'));  // Pass roles to the view
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NIK_user' => 'required|string|max:255|unique:users,NIK_user,' . $id . ',user_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id . ',user_id',
            'role' => 'required|string|in:admin,mip,mitra_kerja,supervisor',
            'password' => 'nullable|string|min:6',
            'status' => 'required|in:0,1',
        ]);

        // Ambil user berdasarkan user_id
        $user = User::where('user_id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Simpan data yang baru
        $user->NIK_user = $request->NIK_user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status = $request->status;

        // Jika password ada, hash dan update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();

        // Jika status berubah menjadi non-aktif dan user sedang login, logout user
        if ($user->status == 0 && Auth::check() && Auth::user()->user_id == $user->user_id) {
            Auth::logout(); // Logout user yang sedang login
            return redirect()->route('login')->with('error', 'Akun Anda dinonaktifkan.');
        }

        return redirect()->route('admin.maintainuser')->with('success', 'User berhasil diperbarui!');
    }



    public function destroy($user_id)
    {
        // Menghapus user berdasarkan user_id di tabel users
        $deleted = DB::table('users')->where('user_id', $user_id)->delete();
    
        // Redirect dengan pesan sukses atau error
        if ($deleted) {
            return redirect()->route('admin.maintainuser')->with('success', 'User berhasil dihapus');
        } else {
            return redirect()->route('admin.maintainuser')->with('error', 'User tidak ditemukan');
        }
    }
}
