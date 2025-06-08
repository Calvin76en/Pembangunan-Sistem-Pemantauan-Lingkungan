<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OilTrapFuelTrap extends Model
{
    use HasFactory;
    
    // Tentukan nama tabel yang digunakan
    protected $table = 'oil_trap_fuel_trap';

    // Tentukan kolom yang bisa diisi secara massal
    protected $fillable = [
        'ph', 'monitoring_id', 'location_id'
    ];

    // Menentukan bahwa tabel ini memiliki timestamps
    public $timestamps = true;

    /**
     * Relasi belongsTo dengan model Location
     * Setiap OilTrapFuelTrap memiliki satu lokasi
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Relasi belongsTo dengan model MonitoringType
     * Setiap OilTrapFuelTrap memiliki satu monitoring type
     */
    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id');
    }

    /**
     * Aksesori untuk mendapatkan status berdasarkan nilai pH
     * Jika ph terisi, statusnya "completed", jika tidak "empty"
     */
    public function getStatusAttribute()
    {
        return $this->ph ? 'completed' : 'empty';
    }
}
