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

    public function runActivitiesLoggedIn()
    {

        $activities = Activity::all()->where('userId', auth()->user()->id);

        // Fetch activity with max distance (only fetch distance)
        $bestRun = Activity::with('distance')->where('userId', auth()->user()->id)->max('distance');

        // return the view with parameter activities to show on screen
        return view('myProgress')->with(compact('activities', 'bestRun'));
    }

    public function lastActivitiesUsers()
    {
        // Get all last activities
        $lastActivities = Activity::orderBy('endDate', 'desc')->get();

        return $lastActivities;
    }

    public function lastActivityUsers()
    {
        // Get all last activities
        $lastActivityUsers = Activity::orderBy('endDate', 'desc')->get()->first();

        return $lastActivityUsers;
    }

    public function lastFiveUsersActivities()
    {
        // Get all last activities
        $lastActivities = Activity::orderBy('endDate', 'desc')->take(5)->get();

        return $lastActivities;
    }

    public function lastActivitiesLoggedIn()
    {
        // Get all activities except for the logged in user
        $lastLoggedInActivities = Activity::orderBy('endDate', 'desc')->get()->where('userId', '=' , auth()->user()->id);

        return $lastLoggedInActivities;
    }

    public function lastFiveActivitiesLoggedIn()
    {
        // Get all activities except for the logged in user
        $lastFiveLoggedInActivities = Activity::orderBy('endDate', 'desc')->take(5)->get()->where('userId', '=' , auth()->user()->id);

        return $lastFiveLoggedInActivities;
    }

    public function allDistancesUser()
    {
        // Get all activities from a user
        $allUserdistances = UserDistance::all();

        return $allUserdistances;
    }

    public function totalDistanceUser($id)
    {
        // Fetch total distance from a user
        $totalUserDistance = UserDistance::find($id);

        return $totalUserDistance;
    }

    public function totalDistanceUsers()
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

    public function longestRunLoggedIn() {

        $longestRunLoggedIn = Activity::orderBy('distance', 'desc')->get()->where('userId', '=' , auth()->user()->id)->first();

        return $longestRunLoggedIn;
    }

    public function averageSpeedLoggedIn() {

        $averageSpeedLoggedIn = Activity::all()->where('userId', '=' , auth()->user()->id)->avg('averageSpeed');

        return $averageSpeedLoggedIn;
    }

    public function totalAchievementsLoggedIn() {

        $totalAchievementsLoggedIn = Achievement::where('user_id', '=' , auth()->user()->id)->count();

        return $totalAchievementsLoggedIn;
    }

    public function achievementsLoggedIn() {

        $achievementsLoggedIn = Achievement::orderBy('updated_at', 'desc')->get()->where('user_id', '=' , auth()->user()->id);

        return $achievementsLoggedIn;
    }

    public function bestRunLoggedIn() {

        $bestRunLoggedIn = Activity::orderBy('elapsedTime', 'desc')->get()->where('userId', '=' , auth()->user()->id)->first();

        return $bestRunLoggedIn;
    }

    public function group() {

        $topWeeklyFiveRunners = $this->topWeeklyFiveRunners();
        $lastActivityUsers = $this->lastActivityUsers();
        $totalDistanceUsers = $this->totalDistanceUsers();

        return view('group')->with(compact('topWeeklyFiveRunners', 'lastActivityUsers', 'totalDistanceUsers'));

    }

    public function myProgress() {

        if(empty(auth()->user()->group_id))
        {
            return redirect('/signup');
        } else
        {
            $lastActivitiesLoggedIn = $this->lastActivitiesLoggedIn();

            return view('myProgress')->with(compact('lastActivitiesLoggedIn'));
        }
    }

    public function achievements() {

        $longestRunLoggedIn = $this->longestLoggedInRun();
        $averageSpeedLoggedIn = $this->averageSpeedLoggedIn();
        $totalAchievementsLoggedIn = $this->totalAchievementsLoggedIn();
        $achievementsLoggedIn = $this->achievementsLoggedIn(); // longest run ATM

        return view('achievements')->with(compact('longestRunLoggedIn', 'averageSpeedLoggedIn', 'totalAchievementsLoggedIn', 'achievementsLoggedIn'));
    }

}