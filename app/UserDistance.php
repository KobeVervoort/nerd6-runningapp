<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDistance extends Model
{
    public function user()
    {

        return $this->belongsTo(User::class, 'userId');

    }
}
