<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;


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
