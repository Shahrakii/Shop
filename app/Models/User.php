<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $guard_name = 'user';

    protected $fillable = ['name', 'email', 'phone_number', 'password', 'status'];
    protected $hidden = ['password'];
}
