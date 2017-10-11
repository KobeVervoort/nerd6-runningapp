<?php

namespace App\Http\Controllers;

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

        $client = new \GuzzleHttp\Client();
        $res = $client->request( 'GET', 'https://www.strava.com/api/v3/athlete/activities/', [
            'headers' => [
                'Authorization' => 'Bearer f1bf048f75872dbe22fdeb146f821f4d54d93a54 ',
            ]
        ]);

        $result = json_decode($res->getBody());

        //var_dump($result);

        //return view('activities');
    }
}
