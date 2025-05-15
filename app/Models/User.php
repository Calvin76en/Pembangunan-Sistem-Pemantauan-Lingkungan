<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
use App\Models\Post;

=======
>>>>>>> b533741de0b6b313976441ac7d8e8944ed274e0e

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'NIK_user'; // NIK_user sebagai primary key
    protected $keyType = 'string'; // Karena NIK_user biasanya string

    protected $fillable = [
        'user_id',
        'NIK_user',
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: Seorang User memiliki banyak Post
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'NIK_user')->onDelete('cascade');
    }
}
