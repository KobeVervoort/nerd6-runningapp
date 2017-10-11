<?php

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

Route::get('/', function () {
    return view('home');
});

// login redirects
Route::get('/login', 'Auth\LoginController@login');
Route::get('/loginstrava', 'Auth\LoginController@redirectToProvider');
Route::get('oauth/code_callback', 'Auth\LoginController@handleProviderCallback');

// User activities
Route::get('/myactivities', 'ActivitiesController@showAll');
