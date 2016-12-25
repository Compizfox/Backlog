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

Route::get('games', 'GameController@getCategorisedJson');
Route::get('dlc', 'DlcController@getJson');

Route::get('statistics/purchases', 'StatisticsController@getPurchases');
Route::get('statistics/playthroughs', 'StatisticsController@getPlaythroughs');
Route::get('statistics/statusshare', 'StatisticsController@getStatusShare');
Route::get('statistics/shopshare', 'StatisticsController@getShopShare');