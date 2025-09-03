<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $guard_name = 'customer';

    protected $fillable = ['name', 'email', 'phone_number', 'password', 'status'];
    protected $hidden = ['password'];
}
