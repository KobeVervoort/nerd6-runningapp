<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $dates = ['start_date', 'end_date'];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }
}
