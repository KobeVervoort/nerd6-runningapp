<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Controllers\Controller;
use App\StravaHandler;
use App\User;
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

        // haal de records van de ingelogde gebruiker uit de DB en geef deze terug
        $activities = Activity::all()->where('userId', auth()->user()->id);

        // haal activiteit op met de hoogste afgelegde afstand
        $bestRun = Activity::with('distance')->where('userId', auth()->user()->id)->max('distance');

        // return the view with parameter activities to show on screen
        return view('activities')->with(compact('activities', 'bestRun'));
    }

    public function friends()
    {
        // Get all activities except for the logged in user
        $activities = Activity::all()->where('userId', '!=' , auth()->user()->id);
        return view('dashboard')->with(compact('activities'));
    }

    public function allUserDistance()
    {
        // Get all activities from a user
        $distance= Activity::all()->sum('distance');
        return $distance;
    }

    public function totalUserDistance($id)
    {
        // Get all activities from a user
        $distanceActivity = Activity::all()->where('userId', '=', $id)->sum('distance');
        return /*view('dashboard')->with(compact('activities'))*/;
    }

    public function FiveBestUsersDistance($id)
    {
        // Get all users
        $users = Activity::all()->groupBy('userId')->sum('distance')->orderBy('distance')->take(5);
        

        //$distanceActivity = Activity::all()->where('userId', '=', $id)->sum('distance');
        return /*view('dashboard')->with(compact('activities'))*/;
    }
}