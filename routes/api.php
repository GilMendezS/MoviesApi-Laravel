<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//auth routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');
    Route::post('logout', 'Api\AuthController@logout')->middleware(['cors','auth:api']);
});
Route::group(['middleware' => ['cors','auth:api']], function() {
    Route::get('user', 'Api\AuthController@user');
    Route::get('/mymovies','Api\MovieController@myMovies');
});
Route::resource('/movies', 'Api\MovieController');

