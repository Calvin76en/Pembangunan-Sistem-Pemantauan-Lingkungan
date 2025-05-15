<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MaintainUserController2 extends Controller
{
    // Method untuk menampilkan daftar user
    public function index()
    {
        // Ambil semua data user dan kirim ke view
        $users = User::all();
        $roles = User::select('role')->distinct()->get();  // Ambil role yang unik
        return view('admin.maintainuser', compact('users', 'roles'));
    }

    // Method untuk menyimpan data user
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'NIK_user' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string',
            'status' => 'required|boolean',
        ]);

        // Membuat user baru
        $user = new User;
        $user->NIK_user = $request->NIK_user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Enkripsi password
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('admin.maintainuser')->with('success', 'User berhasil ditambahkan.');
    }
}
