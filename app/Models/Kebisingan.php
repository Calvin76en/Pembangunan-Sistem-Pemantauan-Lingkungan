<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebisingan extends Model
{
    protected $table = 'kebisingan';
    
    protected $primaryKey = 'id';
    
    // Penting: Set timestamps ke true karena kita menggunakan created_at dan updated_at
    public $timestamps = true;
    
    protected $fillable = [
        'second',
        'spl_db',
        'location_id',
        'monitoring_id',
        'created_at',
        'updated_at'
    ];
    
    // Cast dates untuk memudahkan manipulasi tanggal
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    // Relasi ke Location
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'location_id');
    }
    
    // Relasi ke MonitoringType
    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id', 'monitoring_id');
    }
}