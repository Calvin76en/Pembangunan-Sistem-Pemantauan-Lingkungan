<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menjalankan MonitoringTypesSeeder untuk menambahkan jenis pemantauan
        $this->call(MonitoringTypesSeeder::class);

        // Menjalankan LocationsSeeder untuk menambahkan lokasi
        $this->call(LocationsSeeder::class);
    }
}
