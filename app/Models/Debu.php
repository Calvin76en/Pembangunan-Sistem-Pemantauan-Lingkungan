<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debu extends Model
{
    protected $table = 'debu';

    // Tambahkan created_at dan updated_at ke fillable
    protected $fillable = [
        'waktu',
        'status_debu',
        'monitoring_id',
        'location_id',
        'created_at',
        'updated_at'
    ];

    // Jika ada relasi, tambahkan di sini
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }

    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id', 'monitoring_id');
    }
}