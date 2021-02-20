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

/*
|--------------------------------------------------------------------------
| Movie Routes
|--------------------------------------------------------------------------
*/

Route::get('visual', 'MovieController@searchByName');
Route::get('visual/years', 'MovieController@getAllYears');
Route::get('visual/{id}', 'MovieController@show');
Route::post('visual', 'MovieController@uploadVisual');
Route::put('visual/{id}', 'MovieController@update');
Route::delete('visual/{id}', 'MovieController@destroy');

// get streaming link for a single movie
Route::get('mslinks/{id}', 'MovieController@getStreamingLinks');

/*
|--------------------------------------------------------------------------
| Episode Routes
|--------------------------------------------------------------------------
*/
Route::post('episode', 'EpisodeController@uploadEpisode');
Route::get('episode/{id}', 'EpisodeController@getAllEpisodes');
Route::get('episode', 'EpisodeController@retrieve');

//Route::get('serieEpisodes', 'SeriesController@getEpisodes');

/*
|--------------------------------------------------------------------------
| Streaming_links Routes
|--------------------------------------------------------------------------
*/
Route::post('slink', 'StreamingLinkController@create');
