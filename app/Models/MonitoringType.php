<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringType extends Model
{
    use HasFactory;

    protected $table = 'monitoring_types';
    
    // Primary key is monitoring_id
    protected $primaryKey = 'monitoring_id';
    
    // If monitoring_id is not auto-incrementing
    public $incrementing = false;
    
    // If monitoring_id is string/custom format
    protected $keyType = 'string';

    protected $fillable = [
        'monitoring_id',
        'monitoring_types', // This seems to be the name field
        'status',
        // Add other fillable fields
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    // Relationship with Location
    public function locations()
    {
        return $this->hasMany(Location::class, 'monitoring_id', 'monitoring_id');
    }

    // Scope for active monitoring types
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}