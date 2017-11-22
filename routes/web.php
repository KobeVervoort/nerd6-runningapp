<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes accessible to everyone

Route::get('/loginstrava', 'Auth\LoginController@redirectToProvider');
Route::get('oauth/code_callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/', 'Auth\LoginController@login')->name('login');

// routes only accessible after a user is logged in

Route::group(['middleware' => 'auth'], function () {
    Route::get('/group', 'ActivitiesController@group');
    Route::get('/logout', 'Auth\LoginController@destroy');
    Route::get('/myactivities', 'ActivitiesController@runActivitiesLoggedInUser');
    Route::get('/profile', 'UsersController@information');
    Route::get('/signup', 'LoginController@signup');
});




