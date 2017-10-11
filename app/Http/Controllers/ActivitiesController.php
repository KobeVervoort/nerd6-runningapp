<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Controllers\Controller;
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
        // Get token from logged in user
        //$token = Auth::user()->token;

        //var_dump($token);

        // Request the Strava API and get the athlete activities

        // 1 keer in database steken en dan vanuit de database ophalen
        $client = new \GuzzleHttp\Client();
        $res = $client->request( 'GET', 'https://www.strava.com/api/v3/athlete/activities/', [
            'headers' => [
                'Authorization' => 'Bearer f1bf048f75872dbe22fdeb146f821f4d54d93a54 ',
            ]
        ]);

        $res = json_decode($res->getBody());

        foreach ($res as $result) {

            // Check if activity id already exists
            $activityId = Activity::all()->where('activityId', $result->id)->first();

            // Als activity id reeds bestaat in tabel --> niets
            if ( $activityId === null)
            {
                $activity = new Activity;
                $activity->name = $result->name;
                $activity->activityId = $result->id;
                $activity->stravaId = $result->athlete->id; // = strava_id in table Users
                $activity->distance = $result->distance;
                $activity->startDate = $result->start_date;
                $activity->averageSpeed = $result->average_speed;
                $activity->save();
            }
        }

        var_dump($res);

        //return view('activities')->with('activities', $activities);
    }
}