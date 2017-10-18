<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\View\View;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function information()
    {
        // return the view with parameter activities to show on screen
        return view('profile');
    }



}