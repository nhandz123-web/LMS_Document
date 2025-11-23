<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'fullname',   // thêm
        'email',
        'password',
        'role',       // thêm
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
