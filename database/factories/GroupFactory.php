<?php

use App\Group;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Collection;

$factory->define(Group::class, function (Faker $faker) {

    $startDate = Carbon::createFromDate(2017, 11, 11);
    $endDate = Carbon::createFromDate(2018, 4, 22);

    return [
        'created_at'        => $startDate,
        'name'              => 'IMD',
        'description'       => 'Welcome to the IMD running club. Are you a student Interactive Multimedia Design and want to train for the Antwerp 10 miles?
                                Then join our club and get training!',
        'target_distance'   => 16000,
        'end_date'          => $endDate
    ];
});
