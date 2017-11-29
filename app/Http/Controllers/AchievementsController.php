<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\AchievementUser;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoggedIn()
    {

        $achievements = AchievementUser::all()->where('userId', auth()->user()->id);

        // return the view with parameter activities to show on screen
        //return view('myProgress')->with(compact('activities', 'bestRun'));

        return $achievements;

    }
}
