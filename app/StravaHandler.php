<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

                // If activity id does not exists
                if ($activityId === null) {
                    $activity = new Activity;

                    // Check if the activity is a run
                    if ($activity->averageSpeed <= 20) {

                        $activity->name = $result->name;
                        $activity->activityId = $result->id;
                        $activity->userId = DB::table('users')->where('stravaId', $result->athlete->id)->first()->id;
                        $activity->distance = $result->distance;

                        $startdate = new \DateTime($result->start_date);
                        $activity->startDate = new \DateTime($result->start_date);
                        $activity->endDate = $startdate->add(new \DateInterval('PT' . $result->elapsed_time . 'S'));
                        $activity->elapsedTime = $result->elapsed_time;
                        $activity->averageSpeed = $result->average_speed;

                        // save these variables in the database activities
                        $activity->save();
                    }
                }
            }
        }
    }

    public static function userDistances()
    {
        self::weeklyUserDistances();
        self::totalUserDistances();
    }

    public static function weeklyUserDistances()
    {

        // Get every user, stored in an array
        $users = User::all();
        $activity = Activity::all();

        foreach ($users as $user) {

            // check if row exists
            $rowDB = UserDistance::where('userId', $user->id)->first();
            $sumWeeklyDistances = $activity->where('userId', '=', $user->id)->where('endDate', '>', Carbon::now()->subDays(7))->sum('distance');

            if( $rowDB == null  ) {
                $userDistance = new UserDistance();
                $userDistance->userId = $user->id;
                $userDistance->totalDistance = 0;

                \Log::info('weeklyUserDistance didnt exist yet for user ' . $user->id);

            } else {

                $userDistance = UserDistance::where('userId', $user->id)->first();
                $userDistance->updated_at = Carbon::now();
                //\Log::info('weeklyUserDistance updated for user ' . $user->id);
            }

            // set totalDistance
            $userDistance->weeklyDistance = $sumWeeklyDistances;

            // save/update record in database
            $userDistance->save();


        }
    }

    public static function totalUserDistances()
    {

        // Get every user, stored in an array
        $users = User::all();
        $activity = Activity::all();

        foreach ($users as $user) {

            // check if row exists
            $sumDistances = $activity->where('userId', '=', $user->id)->sum('distance');

            $userDistance = UserDistance::where('userId', $user->id)->first();
            $userDistance->updated_at = Carbon::now();
            //\Log::info('totalUserDistance updated for user ' . $user->id);

            // set totalDistance
            $userDistance->totalDistance = $sumDistances;

            // save/update record in database
            $userDistance->save();


        }
    }
}