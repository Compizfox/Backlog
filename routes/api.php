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

Route::group(['prefix' => 'statistics'], function () {
	Route::get('purchases', 'StatisticsController@getPurchases');
	Route::get('playthroughs', 'StatisticsController@getPlaythroughs');
	Route::get('statusshare', 'StatisticsController@getStatusShare');
	Route::get('shopshare', 'StatisticsController@getShopShare');
});