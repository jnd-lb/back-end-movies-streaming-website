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

Route::get('visual', 'VisualController@searchByName');
Route::get('visual/years', 'VisualController@getAllYears');
Route::get('visual/{id}', 'VisualController@show');
Route::post('visual', 'VisualController@uploadVisual');
Route::put('visual/{id}', 'VisualController@update');
Route::delete('visual/{id}', 'VisualController@destroy');

Route::post('episode', 'EpisodeController@uploadEpisode');
Route::get('episode/{id}', 'EpisodeController@getAllEpisodes');
Route::get('episode', 'EpisodeController@retrieve');
Route::get('streaming-links/{id}', 'EpisodeController@getAllStreamingLinks');

Route::get('serieEpisodes', 'SeriesController@getEpisodes');
