<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OilTrapFuelTrap extends Model
{
    use HasFactory;
    
    protected $table = 'oil_trap_fuel_trap';


    protected $fillable = [
        'ph', 'monitoring_id', 'location_id'
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
