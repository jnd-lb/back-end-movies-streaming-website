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
Route::get('visual/search', 'MovieController@searchBy');

Route::get('visual/years', 'MovieController@getAllYears');
Route::get('visual/{id}', 'MovieController@show');
Route::get('visual', 'MovieController@retrieve');
Route::post('visual', 'MovieController@uploadVisual');
Route::put('visual/{id}', 'MovieController@update');
Route::delete('visual/{id}', 'MovieController@destroy');

/*--------------------------- Get Streaming Links --------------------------*/
Route::get('mslinks/{id}', 'MovieController@getStreamingLinks');

/*--------------------------- Get Download Links --------------------------*/
Route::get('mdlinks/{id}', 'MovieController@getDownloadLinks');

/*--------------------------- Get Genres --------------------------*/
Route::get('mgenres/{id}', 'MovieController@getGenres');


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


/*
|--------------------------------------------------------------------------
| Download_links Routes
|--------------------------------------------------------------------------
*/
Route::post('dlink', 'DownloadLinkController@create');
Route::get('dlink', 'DownloadLinkController@retrieve');
Route::put('dlink/{id}', 'DownloadLinkController@update');
Route::delete('dlink/{id}', 'DownloadLinkController@destroy');

