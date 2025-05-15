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
        return $this->hasMany(Location::class, 'monitoring_id', 'monitoring_id');  // Relasi dengan monitoring_id
    }
}