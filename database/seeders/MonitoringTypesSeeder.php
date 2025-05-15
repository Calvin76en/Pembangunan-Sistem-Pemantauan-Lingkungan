<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; 

class MonitoringTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('monitoring_types')->insert([
            [
                'monitoring_types' => 'Air Limbah Tambang',
            ],
            [
                'monitoring_types' => 'Oil Trap & Fuel Trap',
            ],
            [
                'monitoring_types' => 'Curah Hujan',
            ],
            [
                'monitoring_types' => 'Debu',
            ],
            [
                'monitoring_types' => 'Kebisingan',
            ],
        ]);
    }
}
