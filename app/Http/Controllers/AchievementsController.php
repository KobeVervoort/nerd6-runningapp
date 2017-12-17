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

        $achievementsLoggedIn = AchievementUser::orderBy('achievement_id', 'desc')->where('user_id', '=' , auth()->user()->id)->get();
        /*$bestAchievementsLoggedIn = [];

        $amountOfRuns = $achievementsLoggedIn->where('achievement_id', '<=', 7 )->get()->first();
        if( count($amountOfRuns) == 1 ) {
            $bestAchievementsLoggedIn = $amountOfRuns;
            return $bestAchievementsLoggedIn;
        }

        $distanceRuns = $achievementsLoggedIn->where('achievement_id', '>', 7 )->where('achievement_id', '<=', 14 )->get()->first();
        if( count($distanceRuns) == 1 ) {
            $bestAchievementsLoggedIn = $distanceRuns;
            return $bestAchievementsLoggedIn;
        }

        $timeRuns = $achievementsLoggedIn->where('achievement_id', '>', 14 )->where('achievement_id', '<=', 19 )->get()->first();
        if( count($timeRuns) == 1 ) {
            $bestAchievementsLoggedIn = $timeRuns;
            return $bestAchievementsLoggedIn;
        }

        $speedRuns = $achievementsLoggedIn->where('achievement_id', '>', 19 )->where('achievement_id', '<=', 24 )->get()->first();
        if( count($speedRuns) == 1 ) {
            $bestAchievementsLoggedIn = $speedRuns;
            return $bestAchievementsLoggedIn;
        }

        $periodRuns = $achievementsLoggedIn->where('achievement_id', '>', 24 )->get()->first();
        if( count($periodRuns) == 1 ) {
            $bestAchievementsLoggedIn = $periodRuns;
            return $bestAchievementsLoggedIn;
        }

        return $bestAchievementsLoggedIn;*/
        return $achievementsLoggedIn;
    }

    public function weeklyAchievements() {

        $weeklyAchievements = AchievementUser::orderBy('created_at', 'desc')->where('created_at', '<=' , Carbon::now(-7))->get();

        return $weeklyAchievements;
    }
}
