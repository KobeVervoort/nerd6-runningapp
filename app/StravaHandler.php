<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class StravaHandler extends Model
{
    public static function makeInitialSchedule($activity, $user, $group)
    {
        $endDate = Carbon::parse($group->end_date);
        $firstRunDate = Carbon::parse($activity->endDate);
        \Log::info('first run date = ' . $firstRunDate);

        $remainingTime = $endDate->diffInDays($firstRunDate);

        $weeksLeft = floor($remainingTime/7);

        \Log::info('weeks left = ' . $weeksLeft);

        for ($i = 0; $i<$weeksLeft; $i++)
        {
            $startDate = clone $firstRunDate;
            $startDate = $startDate->addDays(7*$i)->startOfDay();
            \Log::info('start date = ' . $startDate);
            $endDate = clone $startDate;
            $endDate = $endDate->addDays(7);
            \Log::info('end date = ' . $endDate);
            \Log::info('start date #2 = ' . $startDate);

            $schedule = new Schedule;
            $schedule->user_id = $user->id;
            $schedule->week = $i+1;
            $schedule->start_date = $startDate;
            $schedule->end_date = $endDate;

            $baseGoalDiff = $group->target_distance - $activity->distance;
            $weeklyDiff = $baseGoalDiff/$weeksLeft;

            $schedule->distance_goal = $activity->distance + $weeklyDiff*($i+1);

            $schedule->distance_reached = 0;
            $schedule->frequency_reached = 0;

            $schedule->frequency_goal = 3;
            $schedule->save();

        }

    }

    public static function handleApiRequestAllActivities()
    {

        // Get every user, stored in an array
        $users = User::all();

        foreach ($users as $user) {
            \Log::info('Activities amount #1 = ' . Activity::where('userId', $user->id)->count());

            // Get token from user
            $token = $user->token;

            // Get a user's group
            $group = Group::where('id', $user->group_id)->get()->first();


            // Request the Strava API and get the athlete activities
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', 'https://www.strava.com/api/v3/athlete/activities/', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ]
            ]);

            // Format the callback to json
            $res = json_decode($res->getBody());

            // Strava returns the activities from youngest to oldes, we need the reverse order
            $collection = collect($res);
            $activityCollection = $collection->reverse();

            foreach ($activityCollection as $result) {

                // Check if activity id already exists
                $activityId = Activity::orderBy('startDate')->where('activityId', $result->id)->first();

                // If activity id does not exists
                if ($activityId === null) {
                    $activity = new Activity;

                    // Calculate startDate and endDate of a result
                    $startDate = new \DateTime($result->start_date);
                    $endDate = $startDate->add(new \DateInterval('PT' . $result->elapsed_time . 'S'));

                    // Check if the activity is a run
                    if ($result->average_speed <= 20 && $endDate >= $group->created_at) {

                        $activity->name = $result->name;
                        $activity->activityId = $result->id;
                        $activity->userId = DB::table('users')->where('stravaId', $result->athlete->id)->first()->id;
                        $activity->distance = $result->distance;

                        $startdate = new \DateTime($result->start_date);
                        $activity->startDate = new \DateTime($result->start_date);
                        $activity->endDate = $startdate->add(new \DateInterval('PT' . $result->elapsed_time . 'S'));
                        $activity->elapsedTime = $result->elapsed_time;
                        $activity->averageSpeed = $result->average_speed;

                        \Log::info('Activities amount #2 = ' . Activity::where('userId', $user->id)->count());

                        // Check if this is a user's first activity, if so make a new schedule
                        if(Activity::where('userId', $user->id)->count() == 0)
                        {
                            // make new schedule
                            self::makeInitialSchedule($activity, $user, $group);


                        }
                        $thisWeek = Schedule::where('start_date', '<=', $activity->startDate)
                            ->where('end_date', '>', $activity->endDate)
                            ->first();

                        $thisWeek->distance_reached += $activity->distance;
                        $thisWeek->frequency_reached += 1;

                        $thisWeek->save();

                        // save these variables in the database activities
                        $activity->save();

                        // Watch if new achievement goals have been reached
                        //StravaHandler::rewardIndividualMedals();

                    }
                }
            }
            self::rewardIndividualMedals($user->id);
            self::rewardGroupMedals($user->id);
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

    public static function rewardIndividualMedals($user)
    {
        \Log::info($user);
        $activities = Activity::where('userId', '=', $user)->get();

        // amount of runs
        $amountActivities = count($activities);
        \Log::info('Amount of activities: ' . $amountActivities);

        if( $amountActivities >= 200 )
        {
            self::giveAchievement($user, 7);
        }

        if( $amountActivities >= 100 )
        {
            self::giveAchievement($user, 6);
        }

        if( $amountActivities >= 50 )
        {
            self::giveAchievement($user, 5);
        }

        if( $amountActivities >= 20 )
        {
            self::giveAchievement($user, 4);
        }

        if( $amountActivities >= 10 )
        {
            self::giveAchievement($user, 3);
        }

        if( $amountActivities >= 5 )
        {
            self::giveAchievement($user, 2);
        }

        if( $amountActivities >= 1 )
        {
            self::giveAchievement($user, 1);
        }

        //distance of runs
        $distance = Activity::orderBy('distance')->where('userId', $user)->get()->first();
        \Log::info('Distance: ' . $distance['distance']);

        if( $distance['distance'] >= 100000 )
        {
            self::giveAchievement($user, 14);
        }

        if( $distance['distance'] >= 40000 )
        {
            self::giveAchievement($user, 13);
        }

        if( $distance['distance'] >= 20000 )
        {
            self::giveAchievement($user, 12);
        }

        if( $distance['distance'] >= 16000 )
        {
            self::giveAchievement($user, 11);
        }

        if( $distance['distance'] >= 8000 )
        {
            self::giveAchievement($user, 10);
        }

        if( $distance['distance'] >= 4000 )
        {
            self::giveAchievement($user, 9);
        }

        if( $distance['distance'] >= 1000 )
        {
            self::giveAchievement($user, 8);
        }

        //distance of runs
        $duration = Activity::orderBy('elapsedTime', 'desc')->where('userId', $user)->get()->first();
        \Log::info('Duration: ' . $duration['elapsedTime']);

        if( $duration['elapsedTime'] >= 14400 )
        {
            self::giveAchievement($user, 19);
        }

        if( $duration['elapsedTime'] >= 7200 )
        {
            self::giveAchievement($user, 18);
        }

        if( $duration['elapsedTime'] >= 3600 )
        {
            self::giveAchievement($user, 17);
        }

        if( $duration['elapsedTime'] >= 1800 )
        {
            self::giveAchievement($user, 16);
        }

        if( $duration['elapsedTime'] >= 900 )
        {
            self::giveAchievement($user, 15);
        }

        //speed of runs
        $speed = Activity::orderBy('averageSpeed', 'desc')->where('userId', $user)->get()->first();
        \Log::info('Speed: ' . $speed['averageSpeed']);

        if( $speed['averageSpeed'] >= 20 )
        {
            self::giveAchievement($user, 23);
        }

        if( $speed['averageSpeed'] >= 15 )
        {
            self::giveAchievement($user, 22);
        }

        if( $speed['averageSpeed'] >= 10 )
        {
            self::giveAchievement($user, 21);
        }

        if( $speed['averageSpeed'] >= 5 )
        {
            self::giveAchievement($user, 20);
        }

        //period of training
        $firstlastactivity = Activity::orderBy('startDate', 'desc')->where('userId', $user);
        $first1= $firstlastactivity->get()->first();
        $first2 = Carbon::parse($first1['startDate']);
        $last1 = $firstlastactivity->get()->last();
        $last2 = Carbon::parse($last1['startDate']);
        $interval = $last2->diffInDays($first2);

        if( $interval >= 365 )
        {
            self::giveAchievement($user, 28);
        }

        if( $interval >= 183 )
        {
            self::giveAchievement($user, 27);
        }

        if( $interval >= 91 )
        {
            self::giveAchievement($user, 26);
        }

        if( $interval >= 30 )
        {
            self::giveAchievement($user, 25);
        }

        if( $interval >= 7 )
        {
            self::giveAchievement($user, 24);
        }

    }

    public static function rewardGroupMedals()
    {
        $activities = Activity::all();

        foreach ($activities as $activity)
        {

        }
    }

    public static function giveAchievement($userid, $achievementid)
    {
        $achievements = AchievementUser::where('user_id', '=', $userid)->where('achievement_id', $achievementid)->get();

        if (!count($achievements) > 0)
        {
            $achievementUser = new AchievementUser();

            $achievementUser->achievement_id = $achievementid;
            $achievementUser->user_id = $userid;
            $achievementUser->congratulated = 0;
            $achievementUser->created_at = Carbon::now();
            $achievementUser->updated_at = Carbon::now();

            $achievementUser->save();
        }
    }

}