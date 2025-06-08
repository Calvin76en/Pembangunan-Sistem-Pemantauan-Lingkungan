<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monthly extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'monthly';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'daily_id',
        'location_id',
        'NIK_user',
        'status',
        'month',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the daily report that owns the monthly report.
     */
    public function daily()
    {
        return $this->belongsTo(Daily::class, 'daily_id');
    }

    /**
     * Get the location that owns the monthly report.
     */
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the user that owns the monthly report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'NIK_user', 'NIK_user');
    }

    /**
     * Get the approvals for the monthly report.
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'monthly_report_id');
    }
}