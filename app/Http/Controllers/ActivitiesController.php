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

    public function allUsersActivities()
    {
        // Get all activities except for the logged in user
        $allUsersActivities = Activity::all()->where('userId', '!=' , auth()->user()->id);

        return $allUsersActivities;
    }

    public function lastLoggedInActivities()
    {
        // Get all activities except for the logged in user
        $lastLoggedInActivities = Activity::all()->where('userId', '=' , auth()->user()->id)->first();

        return $lastLoggedInActivities;
    }

    public function allLoggedInActivities()
    {
        // Get all activities except for the logged in user
        $allLoggedInActivities = Activity::orderBy('endDate', 'desc')->get()->where('userId', '=' , auth()->user()->id);

        return $allLoggedInActivities;
    }

    public function allUserDistances()
    {
        // Get all activities from a user
        $distances = UserDistance::all();

        return $distances;
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

    public function TopWeeklyRunners()
    {
        // Get all weekly distances from users, sort them and return the best 5
        $users = UserDistance::orderBy('weeklyDistance', 'desc')->take(5)->get();

        return $users;
    }
}