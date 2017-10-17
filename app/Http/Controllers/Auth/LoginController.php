<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
            return redirect('/dashboard');
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

        return redirect("https://www.strava.com/oauth/authorize?client_id=20719&response_type=code&redirect_uri=http://homestead.app/oauth/code_callback&scope=write&state=mystate");

    }

    public function handleProviderCallback()
    {

        $code = request()->code;
        var_dump($code);

        $client = new \GuzzleHttp\Client();
        $res = $client->request( 'POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '20719',
                'client_secret' => '4c169a3a25c1af00cf2d12f3ff931c4c7c143591',
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
        }

        auth()->login($user);

        return redirect('/dashboard');
    }
}
