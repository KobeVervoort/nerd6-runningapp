<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function achievements()
    {
        return $this->belongsToMany('App/Achievement')->withTimestamps();
    }

}