<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles'; // Pastikan tabel roles ada
    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name', // Nama role, seperti 'admin', 'user'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id_role');
    }
}
