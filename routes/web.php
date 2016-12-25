<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StatisticsController@summary');

// Purchase
Route::delete('purchases', 'PurchaseController@destroyMany');
Route::resource('purchases', 'PurchaseController');

// Game
Route::delete('games', 'GameController@destroyMany');
Route::patch('games', 'GameController@patchMany');
Route::resource('games', 'GameController');

// DLC
Route::delete('dlc', 'DlcController@destroyMany');
Route::patch('dlc', 'DlcController@patchMany');
Route::resource('dlc', 'DlcController');

// Playthrough
Route::delete('playthroughs', 'PlaythroughController@destroyMany');
Route::patch('playthroughs', 'PlaythroughController@patchMany');
Route::resource('playthroughs', 'PlaythroughController');

// Steam integration
Route::get('steam/sync', 'SteamController@syncGames');
Route::get('steam/import', 'SteamController@importGames');
Route::get('steam/update', 'SteamController@updateAppinfo');