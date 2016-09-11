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

Route::singularResourceParameters();

Route::get('/', function() {
	return view('summary');
});

// Purchase
Route::delete('purchases', 'PurchaseController@destroyMany');
Route::resource('purchases', PurchaseController::class);

// Game
Route::delete('games', 'GameController@destroyMany');
Route::patch('games', 'GameController@patchMany');
Route::resource('games', GameController::class);

// DLC
Route::delete('dlc', 'DlcController@destroyMany');
Route::patch('dlc', 'DlcController@patchMany');
Route::resource('dlc', DlcController::class);

// API
Route::group(['prefix' => 'api'], function() {
	Route::get('games', 'GameController@getCategorisedJson');
	Route::get('dlc', 'DlcController@getJson');

	Route::get('statistics/purchases', 'StatisticsController@getPurchases');
});