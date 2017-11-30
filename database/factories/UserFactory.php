<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {

    $genders = ['M', 'F'];

    return [
        'stravaId' => $faker->numberBetween(0, 10),
        'token' => $faker->randomNumber(8),
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'city' => $faker->city,
        'avatar' => 'http://lorempixel.com/600/600/people',
        'gender' => 'M'/*$faker->randomElements($genders)*/,
        'remember_token' => '',
        'group_id' => 1
    ];
});

$factory->define(App\Activity::class, function (Faker $faker) {

    // Fetch all user ids
    $userIDs = App\User::all()->pluck('id')->toArray();
    // Get random user id
    $userID = $faker->randomElement($userIDs);

    return [
        'activityId' => $faker->randomNumber(8),
        'userId' => $userID,
        'name' => $faker->realText(50),
        'distance' => $faker->numberBetween(1000, 20000),
        'startDate' => $faker->date(Carbon::now()),
        'endDate' => $faker->date(Carbon::now()),
        'elapsedTime' => 1,
        'averageSpeed' => $faker->numberBetween(0, 20),
    ];
});
