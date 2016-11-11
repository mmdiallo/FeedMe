<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['username', 'password_hash', 'password_salt'];
    protected $hidden = ['password_hash', 'password_salt'];
}
