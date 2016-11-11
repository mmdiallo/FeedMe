<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['username', 'password_hash'];
    protected $hidden = ['password_hash', 'password_salt'];
}
