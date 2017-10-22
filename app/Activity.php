<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $dates = array('endDate'); // tells laravel to make a Carbon object to whatever attribute we add to $dates

    public function user()
    {

        return $this->belongsTo(User::class, 'userId');

    }

}
