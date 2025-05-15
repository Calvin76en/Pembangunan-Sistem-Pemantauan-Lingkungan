<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'id' => '10',
            'nik' => '1001',
            'name' => 'Admin SIPALING',
            'email' => 'admin@sipaling.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // MIP
        User::create(attributes: [
            'id' => '11',
            'nik' => '1002',
            'name' => 'MIP SIPALING',
            'email' => 'mip@sipaling.com',
            'password' => Hash::make('mip123'),
            'role' => 'mip',
        ]);

        // Mitra Kerja
        User::create([
            'id' => '12',
            'nik' => '1003',
            'name' => 'Mitra Kerja SIPALING',
            'email' => 'mitra@sipaling.com',
            'password' => Hash::make('mitra123'),
            'role' => 'mitra_kerja',
        ]);

        // Supervisor
        User::create([
            'id' => '13',
            'nik' => '1004',
            'name' => 'Supervisor SIPALING',
            'email' => 'supervisor@sipaling.com',
            'password' => Hash::make('supervisor123'),
            'role' => 'supervisor',
        ]);
    }
}
