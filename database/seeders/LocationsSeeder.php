<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public function run()
    {
        // Data untuk Air Limbah Tambang (monitoring_id = 1)
        DB::table('locations')->insert([
            ['location_name' => 'SP 5 MTN', 'monitoring_id' => 1],
            ['location_name' => 'SP 6 MTN', 'monitoring_id' => 1],
            ['location_name' => 'SP 7 MTN', 'monitoring_id' => 1],
            ['location_name' => 'SP 8 MTN', 'monitoring_id' => 1],
            ['location_name' => 'SP 9 MTN', 'monitoring_id' => 1],
        ]);

        // Data untuk Curah Hujan (monitoring_id = 3)
        DB::table('locations')->insert([
            ['location_name' => 'SP W S MHA', 'monitoring_id' => 3],
            ['location_name' => 'SP W S MHB', 'monitoring_id' => 3],
            ['location_name' => 'SP W S MHC', 'monitoring_id' => 3],
            ['location_name' => 'SP W S MHD', 'monitoring_id' => 3],
            ['location_name' => 'SP W S MHE', 'monitoring_id' => 3],
        ]);

        // Data untuk Oil Trap & Fuel Trap (monitoring_id = 2)
        DB::table('locations')->insert([
            ['location_name' => 'Oil Trap A', 'monitoring_id' => 2],
            ['location_name' => 'Oil Trap B', 'monitoring_id' => 2],
            ['location_name' => 'Oil Trap C', 'monitoring_id' => 2],
            ['location_name' => 'Oil Trap D', 'monitoring_id' => 2],
            ['location_name' => 'Oil Trap E', 'monitoring_id' => 2],
        ]);

        // Data untuk Debu (monitoring_id = 4)
        DB::table('locations')->insert([
            ['location_name' => 'Debu Lokasi 1', 'monitoring_id' => 4],
            ['location_name' => 'Debu Lokasi 2', 'monitoring_id' => 4],
            ['location_name' => 'Debu Lokasi 3', 'monitoring_id' => 4],
            ['location_name' => 'Debu Lokasi 4', 'monitoring_id' => 4],
            ['location_name' => 'Debu Lokasi 5', 'monitoring_id' => 4],
        ]);

        // Data untuk Kebisingan (monitoring_id = 5)
        DB::table('locations')->insert([
            ['location_name' => 'Kebisingan Area 1', 'monitoring_id' => 5],
            ['location_name' => 'Kebisingan Area 2', 'monitoring_id' => 5],
            ['location_name' => 'Kebisingan Area 3', 'monitoring_id' => 5],
            ['location_name' => 'Kebisingan Area 4', 'monitoring_id' => 5],
            ['location_name' => 'Kebisingan Area 5', 'monitoring_id' => 5],
        ]);
    }
}