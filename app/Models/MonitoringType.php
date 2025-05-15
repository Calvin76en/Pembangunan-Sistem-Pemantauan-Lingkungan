<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MonitoringType extends Model
{
    use HasFactory;

    protected $table = 'monitoring_types';  // Pastikan nama tabel sesuai

    protected $fillable = [
        'monitoring_types',
    ];

    // Relasi ke tabel locations (one-to-many)
    public function locations()
    {
<<<<<<< HEAD
        return $this->hasMany(Location::class, 'monitoring_id', 'monitoring_id');  // Relasi dengan monitoring_id
    }
}
=======
        return $this->hasMany(Location::class, 'monitoring_id', 'id');  // Ganti 'monitoring_id' menjadi 'id'
    }
}
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e
