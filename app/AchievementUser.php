<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AchievementUser extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
