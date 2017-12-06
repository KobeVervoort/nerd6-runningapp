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
    Route::get('/myProgress', 'SchedulesController@myProgress');
    Route::get('/group', 'ActivitiesController@group');
    Route::get('/achievements', 'ActivitiesController@achievements');
    Route::get('/logout', 'Auth\LoginController@destroy');
    Route::get('/profile', 'UsersController@information');
    Route::get('/signup', 'Auth\LoginController@signup');
    Route::get('/achievements', 'AchievementsController@show');
    Route::post('/signup/groups', 'Auth\LoginController@groups');
    Route::post('/signup/existingGroup', 'Auth\LoginController@addToExistingGroup');
    Route::post('/signup/newGroup', 'Auth\LoginController@addToNewGroup');
});
