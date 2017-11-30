<?php

namespace App\Http\Controllers\Auth;

use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function login()
    {
        // If you are already logged in, redirect!
        if(Auth::user()){
            return redirect('/myProgress');
        } else {
            // You are not logged in, so log in!
            return view('login/login');
        }

    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/');
    }

    public function redirectToProvider()
    {

        return redirect("https://www.strava.com/oauth/authorize?client_id=20719&response_type=code&redirect_uri=" . env('STRAVA_CALLBACK_DOMAIN') . "/oauth/code_callback&scope=write&state=mystate");

    }

    public function handleProviderCallback()
    {

        $code = request()->code;
        var_dump($code);

        $client = new \GuzzleHttp\Client();
        $res = $client->request( 'POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => env('STRAVA_CLIENT_ID'),
                'client_secret' => env('STRAVA_CLIENT_SECRET'),
                'code'=> $code,
            ]

        ]);


        $result = json_decode($res->getBody());
        var_dump($result); // shows results of the logged in user
        $athlete = $result->athlete;

        $user = User::all()->where('stravaId', $athlete->id)->first();

        // If such a user already exists, don't create a new one
        if($user == null){
            $user = new User;
            $user->stravaId = $athlete->id;
            $user->token = $result->access_token; // gets the token out of $user 's parent element
            $user->firstname = $athlete->firstname;
            $user->lastname = $athlete->lastname;
            $user->email = $athlete->email;
            if($user->city == null)
            {
                $user->city = "";
            } else {
                $user->city = $athlete->city;
            }
            $user->avatar =  $athlete->profile; //"http://lorempixel.com/600/600/people";
            $user->gender = $athlete->sex;
            $user->save();

            auth()->login($user);

            return redirect('/signup');
        } else {
            auth()->login($user);

            return redirect('/myProgress');
        }
    }

    public function signup()
    {
        if(auth()->user()->group_id == '')
        {
            return view('login/signup');
        }
        else
        {
            return redirect('/myProgress');
        }

    }

    public function groups(\Illuminate\Http\Request $request)
    {
        $term = $request->searchTerm;

        if(!empty($term))
        {
            $groups = Group::where('name', 'like', '%'.$term.'%')->get();

            foreach ($groups as $group)
            {
                $endDate = new Carbon($group->end_date);
                $group->end_date = $endDate->toFormattedDateString();
            }

            return $groups;
        }
        else
        {
            return '';
        }

    }

    public function groupDetails(\Illuminate\Http\Request $request)
    {
        return Group::where('id', $request->groupID)->first();
    }

    public function addToExistingGroup(\Illuminate\Http\Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->group_id = $request->groupID;
        $user->save();

        return 'Ok';
    }

    public function addToNewGroup(\Illuminate\Http\Request $request)
    {
        $group = new Group;

        $group->name = $request->name;
        $group->description = $request->description;
        $group->target_distance = $request->target * 1000;
        $group->end_date = $request->deadline;

        $group->save();

        $user = User::find(auth()->user()->id);
        $user->group_id = $group->id;
        $user->save();

        return 'Ok';
    }
}



























