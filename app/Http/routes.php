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
	return view('welcome');
});

// Purchase
Route::resource('purchases', PurchaseController::class);

// Game
Route::resource('games', GameController::class);

// DLC
Route::resource('dlc', DlcController::class);

// API
Route::group(['prefix' => 'api'], function() {
	Route::get('games', 'GameController@getCategorisedJson');
});