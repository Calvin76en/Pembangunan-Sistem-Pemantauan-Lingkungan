<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CurahHujan extends Model
{
    use HasFactory;

    protected $table = 'curah_hujan';

    protected $fillable = [
        'CH', 'jam_mulai', 'jam_selesai', 'monitoring_id', 'location_id'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id');
    }
}
