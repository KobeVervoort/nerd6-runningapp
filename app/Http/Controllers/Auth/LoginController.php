<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {

        return redirect("https://www.strava.com/oauth/authorize?client_id=20719&response_type=code&redirect_uri=http://homestead.app/oauth/code_callback&scope=write&state=mystate&approval_prompt=force");

    }

    public function handleProviderCallback()
    {
        $code = request()->code;
        // var_dump($code);

        $client = new \GuzzleHttp\Client();
        $res = $client->request( 'POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '20719',
                'client_secret' => '4c169a3a25c1af00cf2d12f3ff931c4c7c143591',
                'code'=> $code,
            ]

        ]);


        $result = json_decode($res->getBody());
        $athlete = $result->athlete;

        $user = User::all()->where('stravaId', $athlete->id)->first();
        if ( $user === null)
        {
            $user = new User;
            $user->stravaId = $athlete->id;
            $user->firstname = $athlete->firstname;
            $user->lastname = $athlete->lastname;
            $user->city = "Mechelen";
            $user->email = $athlete->email;
            $user->password = TRUE ;
            $user->save();
        }

        return redirect('/');
    }
}
