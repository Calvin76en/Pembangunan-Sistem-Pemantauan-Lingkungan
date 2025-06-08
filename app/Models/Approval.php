<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'approval';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'approval_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'approval_name',
        'approval_type',
        'approval_date',
        'signature',
        'status',
        'notes',
        'NIK_user',
        'daily_report_id',
        'monthly_report_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approval_type' => 'string',
        'status' => 'string',
        'approval_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the approval.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'NIK_user', 'NIK_user');
    }

    /**
     * Get the daily report that owns the approval.
     */
    public function dailyReport()
    {
        return $this->belongsTo(Daily::class, 'daily_report_id');
    }

    /**
     * Get the monthly report that owns the approval.
     */
    public function monthlyReport()
    {
        return $this->belongsTo(Monthly::class, 'monthly_report_id');
    }
}