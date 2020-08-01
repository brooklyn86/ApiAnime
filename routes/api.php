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
    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');
    Route::get('/animes/lancamento', 'AnimeController@getLancamento')->name('cadastrar.anime');
    Route::get('/animes/melhoresAnimes', 'AnimeController@getMelhoresAnimes')->name('cadastrar.anime');
    Route::get('/animes/recentes', 'AnimeController@getRecentesAnime')->name('cadastrar.anime');
    Route::get('/animes/todosAnimes', 'AnimeController@returnAnimes')->name('anime.totalAnime');
    Route::get('/animes/todosAnimes/autoComplete', 'AnimeController@returnAutoCompleteAnimes')->name('anime.totalAnime.autocomplete');
    Route::get('/episode/anime/{id}', 'AnimeController@getEpisodebyAnime')->name('anime.episode');
    Route::get('/next/episode/{anime}/{id}', 'AnimeController@getNextEpisodebyAnime')->name('anime.next.episode');
    Route::get('/animes/{id}', 'AnimeController@getAnime')->name('anime.episode');
    Route::get('/anime/episode/{id}', 'AnimeController@getEpisodeAnime')->name('anime.episode');
    Route::post('/cadastrar/episode/anime', 'EpisodeController@store')->name('cadastrar.episode.anime');
    Route::post('/cadastrar/player/anime', 'EpisodeController@storePlayer')->name('cadastrar.episode.anime');

});

Route::group(['middleware' => 'auth:api','namespace' => 'Api', 'prefix'=> 'v1'], function(){
    Route::post('details', 'UserController@details');
    Route::post('/cadastrar/minha-lista', 'MinhaListaController@store')->name('cadastrar.episode.anime');
    Route::post('/remover/minha-lista', 'MinhaListaController@remover')->name('remover.episode.anime');
    Route::get('/minha-lista', 'MinhaListaController@getMinhaLista')->name('cadastrar.episode.anime');

});
