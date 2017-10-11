<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class StravaHandler extends Model
{
    public static function handleApiRequestAllActivities()
    {

        // Get every user, stored in an array
        $users = User::all();

        foreach ($users as $user) {

            // Get token from user
            $token = $user->token;

            // Request the Strava API and get the athlete activities
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://www.strava.com/api/v3/athlete/activities/', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            // Format the callback to json
            $res = json_decode($res->getBody());

            foreach ($res as $result) {

                // Check if activity id already exists
                $activityId = Activity::all()->where('activityId', $result->id)->first();

                // Als activity id reeds bestaat in tabel --> niets
                if ($activityId === null) {
                    $activity = new Activity;
                    $activity->name = $result->name;
                    $activity->activityId = $result->id;
                    $activity->stravaId = $result->athlete->id; // = strava_id in table Users
                    $activity->distance = $result->distance;
                    $activity->startDate = $result->start_date;
                    $activity->averageSpeed = $result->average_speed;
                    $activity->save();
                }
            }
        }
    }
}