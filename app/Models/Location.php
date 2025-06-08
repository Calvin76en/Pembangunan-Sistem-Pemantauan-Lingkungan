<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'locations';
    
    // Primary key is location_id (string)
    protected $primaryKey = 'location_id';
    
    // Primary key is not auto-incrementing
    public $incrementing = false;
    
    // Primary key is string type
    protected $keyType = 'string';

    protected $fillable = [
        'location_id',
        'location_name',
        'monitoring_id',
        'status',
        // Add other fillable fields
    ];

    protected $casts = [
        'status' => 'integer',
        'monitoring_id' => 'integer',
    ];

    // Relationship with MonitoringType
    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id', 'monitoring_id');
    }

    // Scope for active locations
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // Scope for specific monitoring type
    public function scopeByMonitoringType($query, $monitoringId)
    {
        return $query->where('monitoring_id', $monitoringId);
    }
}