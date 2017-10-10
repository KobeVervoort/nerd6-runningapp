<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = array('first_name', 'last_name', 'email', 'avatar');
}
