<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AirLimbahTambang extends Model
{
    use HasFactory;

    protected $table = 'air_limbah_tambang';

    protected $fillable = [
        'ph_inlet', 'ph_outlet_1', 'ph_outlet_2', 'treatment_kapur', 
        'treatment_pac', 'treatment_tawas', 'tss_inlet', 'tss_outlet', 
        'fe_outlet', 'mn_outlet', 'debit', 'velocity', 'keterangan', 
        'monitoring_id', 'location_id'
    ];

<<<<<<< HEAD
    // Relasi ke Location
=======
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

<<<<<<< HEAD
    // Relasi ke MonitoringType
=======
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id');
    }
<<<<<<< HEAD
}
=======
}

>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
