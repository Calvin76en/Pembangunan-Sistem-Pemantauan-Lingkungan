<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'daily';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location_id',
        'monitoring_id',
        'NIK_user',
        'status',
        'report_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'report_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the location that owns the daily report.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the monitoring type that owns the daily report.
     */
    public function monitoringType()
    {
        return $this->belongsTo(MonitoringType::class, 'monitoring_id');
    }

    /**
     * Get the user that owns the daily report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'NIK_user', 'NIK_user');
    }

    /**
     * Get the monthly reports for the daily report.
     */
    public function monthlyReports()
    {
        return $this->hasMany(Monthly::class, 'daily_id');
    }

    /**
     * Get the approvals for the daily report.
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'daily_report_id');
    }

    /**
     * Get the signatures for the daily report.
     */
    public function signatures()
    {
        return $this->hasMany(Signature::class, 'report_id');
    }
}