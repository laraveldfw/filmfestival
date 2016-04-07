<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {
    //Auth
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    });
    Route::post('/isEmailUnique', 'FilmAuthController@isEmailUnique');
    Route::post('/register', 'FilmAuthController@register');
    Route::post('/checkConfirmation', 'FilmAuthController@checkConfirmation');
    Route::get('/checkAuth', 'FilmAuthController@checkAuth');
    
    // Film Register
    Route::get('/register', 'RegisterFilmController@show');
    
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/getCategoryTickets', 'RegisterFilmController@getCategoryTickets'); 
    });
    
});
