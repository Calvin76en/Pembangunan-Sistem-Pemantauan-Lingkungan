<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'NIK_user';
    
    // If primary key is not auto-incrementing integer
    public $incrementing = false;
    protected $keyType = 'string';

    // Specify fillable attributes
    protected $fillable = [
        'NIK_user',
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    // Specify which attributes should be hidden
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Enable or disable timestamps
    public $timestamps = true;

    // If your table has different timestamp column names, specify them
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Cast attributes to specific types
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'integer',
        'role_id' => 'integer',
    ];

    // Define relationship with roles table
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id_role');
    }
}