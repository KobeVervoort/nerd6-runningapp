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

    public function showAll()
    {

        // API request voor alle activities
        StravaHandler::handleApiRequestAllActivities();

        // haal de records van de ingelogde gebruiker uit de DB en geef deze terug
        $activities = Activity::all()->where('stravaId', auth()->user()->stravaId);

        // return the view with parameter activities to show on screen
        return view('activities')->with('activities', $activities);
    }
}