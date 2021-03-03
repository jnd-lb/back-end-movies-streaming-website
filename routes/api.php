<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/episodes','EpisodeController@index');
Route::get('/episode/{name}','EpisodeController@show');
Route::get('/visuals/search','VisualController@show');
Route::get('/visuals/','VisualController@getAll');
Route::get('/home/genre','VisualController@showHome');
Route::get('/visuals/{id}','VisualController@showById');
Route::get('/visuals/genre','VisualController@getVisualsByGenre');

//Movies
Route::get('/movie/{id}','VisualController@showById');
