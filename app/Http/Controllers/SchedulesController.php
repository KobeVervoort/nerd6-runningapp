<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    private function lastActivitiesLoggedIn()
    {
        // Get all activities except for the logged in user
        $lastLoggedInActivities = Activity::orderBy('endDate', 'desc')->get()->where('userId', '=' , auth()->user()->id);

        return $lastLoggedInActivities;
    }

    private function getCurrentWeek()
    {
        return Schedule::where('start_date', '<=', Carbon::now())
            ->where('end_date', '>', Carbon::now())
            ->first();
    }

    /*private function distanceGoalReached()
    {
        $week = $this->getCurrentWeek();

        return $week->distance_reached >= $week->distance_goal ?  true :  false;
    }

    private function frequencyGoalReached()
    {
        $week = $this->getCurrentWeek();

        return $week->frequency_reached >= $week->frequency_goal ?  true :  false;
    }*/

    public function myProgress()
    {

        if(empty(auth()->user()->group_id))
        {
            return redirect('/signup');
        }

        else
        {
            $lastActivitiesLoggedIn = $this->lastActivitiesLoggedIn();

            $thisWeek = $this->getCurrentWeek();


            return view('myProgress')->with(compact('lastActivitiesLoggedIn', 'thisWeek'));
        }
    }

}
