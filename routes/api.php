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
Route::group(['namespace' => 'Api','prefix'=> 'v1'],function (){
    Route::post('/cadastrar/anime', 'AnimeController@store')->name('cadastrar.anime');
    Route::post('/cadastrar/episode/anime', 'EpisodeController@store')->name('cadastrar.episode.anime');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
