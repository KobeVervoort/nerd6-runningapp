<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Controllers\Controller;
use App\StravaHandler;
use App\User;
use App\UserDistance;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;

class ActivitiesController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function runActivitiesLoggedInUser()
    {

        $activities = Activity::all()->where('userId', auth()->user()->id);

        // Fetch activity with max distance (only fetch distance)
        $bestRun = Activity::with('distance')->where('userId', auth()->user()->id)->max('distance');

        // return the view with parameter activities to show on screen
        return view('activities')->with(compact('activities', 'bestRun'));
    }

    public function lastUsersActivities()
    {
        // Get all last activities
        $lastActivities = Activity::orderBy('endDate', 'desc')->get();

        return $lastActivities;
    }

    public function lastFiveUsersActivities()
    {
        // Get all last activities
        $lastActivities = Activity::orderBy('endDate', 'desc')->take(5)->get();

        return $lastActivities;
    }

    public function lastLoggedInActivities()
    {
        // Get all activities except for the logged in user
        $lastLoggedInActivities = Activity::orderBy('endDate', 'desc')->get()->where('userId', '=' , auth()->user()->id);

        return $lastLoggedInActivities;
    }

    public function lastFiveLoggedInActivities()
    {
        // Get all activities except for the logged in user
        $lastFiveLoggedInActivities = Activity::orderBy('endDate', 'desc')->take(5)->get()->where('userId', '=' , auth()->user()->id);

        return $lastFiveLoggedInActivities;
    }

    public function allUserDistances()
    {
        // Get all activities from a user
        $allUserdistances = UserDistance::all();

        return $allUserdistances;
    }

    public function totalUserDistance($id)
    {
        // Fetch total distance from a user
        $totalUserDistance = UserDistance::find($id);

        return $totalUserDistance;
    }

    public function totalUsersDistance()
    {
        // Fetch total distance from all users
        $totalUsersDistance = UserDistance::all()->sum('totalDistance');

        return $totalUsersDistance;
    }

    public function topWeeklyRunners()
    {
        // Get all weekly distances from users and sort them
        $topWeeklyRunners = UserDistance::orderBy('weeklyDistance', 'desc')->get();

        return $topWeeklyRunners;
    }

    public function topWeeklyFiveRunners()
    {
        // Get all weekly distances from users, sort them and return the best 5
        $topWeeklyFiveRunners = UserDistance::orderBy('weeklyDistance', 'desc')->take(5)->get();

        return $topWeeklyFiveRunners;
    }

    public function group() {

        $topWeeklyFiveRunners = $this->topWeeklyFiveRunners();
        $latestActivity = $this->lastUsersActivities();
        $totalUsersDistance = $this->totalUsersDistance();

        return view('activities')->with(compact('topWeeklyFiveRunners', 'latestActivity', 'totalUsersDistance'));
    }

    public function myProgress() {

        

    }

}