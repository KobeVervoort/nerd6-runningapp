<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\AchievementUser;
use App\Activity;
use Carbon\Carbon;
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
        $achievementsLoggedIn = $this->achievementsLoggedIn();
        $weeklyAchievements = $this->weeklyAchievements();

        return view('achievements')->with(compact('longestRunLoggedIn', 'averageSpeedLoggedIn', 'totalAchievementsLoggedIn', 'achievementsLoggedIn', 'weeklyAchievements'));
    }

    public function longestRunLoggedIn() {

        $longestRunLoggedIn = Activity::orderBy('distance', 'desc')->get()->where('userId', '=' , auth()->user()->id)->first();

        if( $longestRunLoggedIn == null )
        {
            return $longestRunLoggedIn = 0;
        }

        return $longestRunLoggedIn->distance / 1000;
    }

    public function averageSpeedLoggedIn() {

        $averageSpeedLoggedIn = Activity::all()->where('userId', '=' , auth()->user()->id)->avg('averageSpeed');

        if( $averageSpeedLoggedIn == null )
        {
            return $averageSpeedLoggedIn = 0;
        }

        return $averageSpeedLoggedIn;
    }

    public function totalAchievementsLoggedIn() {

        $totalAchievementsLoggedIn = AchievementUser::where('user_id', '=' , auth()->user()->id)->count();

        return $totalAchievementsLoggedIn;
    }

    public function achievementsLoggedIn() {

        $achievementsLoggedIn = AchievementUser::orderBy('created_at', 'desc')->get()->where('user_id', '=' , auth()->user()->id);

        return $achievementsLoggedIn;
    }

    public function weeklyAchievements() {

        $weeklyAchievements = AchievementUser::orderBy('created_at', 'desc')->get()->where('created_at', '<=' , Carbon::now(-7));

        return $weeklyAchievements;
    }
}
