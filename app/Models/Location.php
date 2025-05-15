<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';

    protected $primaryKey = 'location_id';  // Tambahkan ini

    protected $fillable = [
        'location_name',
        'monitoring_id',
        'status',
        'keterangan', // tambahkan jika ada kolom keterangan di tabel locations
    ];

    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id', 'monitoring_id');
    }
}
