<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\AchievementUser;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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

    public function show() {

        $longestRunLoggedIn = $this->longestRunLoggedIn();
        $averageSpeedLoggedIn = $this->averageSpeedLoggedIn();
        $totalAchievementsLoggedIn = $this->totalAchievementsLoggedIn();
        $achievementsLoggedIn = $this->achievementsLoggedIn(); // longest run ATM

        return view('achievements')->with(compact('longestRunLoggedIn', 'averageSpeedLoggedIn', 'totalAchievementsLoggedIn', 'achievementsLoggedIn'));
    }

    public function longestRunLoggedIn() {

        $longestRunLoggedIn = Activity::orderBy('distance', 'desc')->get()->where('userId', '=' , auth()->user()->id)->first();

        return $longestRunLoggedIn->distance / 1000;
    }

    public function averageSpeedLoggedIn() {

        $averageSpeedLoggedIn = Activity::all()->where('userId', '=' , auth()->user()->id)->avg('averageSpeed');

        return $averageSpeedLoggedIn;
    }

    public function totalAchievementsLoggedIn() {

        $totalAchievementsLoggedIn = AchievementUser::where('user_id', '=' , auth()->user()->id)->count();

        return $totalAchievementsLoggedIn;
    }

    public function achievementsLoggedIn() {

        $achievementsLoggedIn = AchievementUser::orderBy('updated_at', 'desc')->get()->where('user_id', '=' , auth()->user()->id);

        return $achievementsLoggedIn;
    }
}
