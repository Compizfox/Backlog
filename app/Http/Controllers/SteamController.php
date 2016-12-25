<?php
/*
	Filename:   SteamController.php
	Date:       2016-12-24
	Author:     Lars Veldscholte
	            lars@veldscholte.eu
	            http://lars.veldscholte.eu

	Copyright 2016 Lars Veldscholte

	This file is part of Backlog2.

	Backlog2 is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	Backlog2 is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Backlog2. If not, see <http://www.gnu.org/licenses/>.
*/


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Game;
use App\Services\SteamService;

class SteamController extends Controller {
	private $steamGames = [];

	public function __construct() {
		// Retrieve list of games from Steam
		$steamService = new SteamService(\Setting::get('apiKey'), \Setting::get('steamID'));
		$this->steamGames = $steamService->retrieveGames();
	}

	public function syncGames() {
		$count = 0;

		foreach($this->steamGames as $steamGame) {
			// Get game matching the name from db
			$dbGame = Game::where('name', $steamGame->name)->first();

			// Update game with appid if it is not set
			if($dbGame != NULL and $dbGame->appid == NULL) {
				$dbGame->appid = $steamGame->appid;
				$dbGame->save();

				$count++;
			}
		}

		return redirect()->back()->with('status', "$count games in database linked to a Steam appid!");
	}

	public function importGames() {
		// Get list of game names in db
		$dbNames = Game::pluck('name');

		// Get list of game appids in db
		$dbAppids = Game::pluck('appid');

		// Only retain games which name and appid does not exist in database
		$steamGames = array_filter($this->steamGames, function($e) use($dbNames, $dbAppids) {
			return !$dbNames->contains($e->name) and !$dbAppids->contains($e->appid);
		});

		$count = 0;

		// Insert those remaining games into database
		foreach($steamGames as $steamGame) {
			$game = new Game();
			$game->name = $steamGame->name;
			$game->status_id = 1;
			$game->appid = $steamGame->appid;
			$game->save();

			$count++;
		}

		return redirect()->back()->with('status', "$count games imported from Steam!");
	}

	public function updateAppinfo() {
		foreach($this->steamGames as $steamGame) {
			// Get game matching the appid from db
			$dbGame = Game::where('appid', $steamGame->appid)->first();

			if($dbGame != NULL) {
				$dbGame->playtime = $steamGame->playtime_forever;
				$dbGame->img_icon_url = $steamGame->img_icon_url;
				$dbGame->img_logo_url = $steamGame->img_logo_url;
				$dbGame->save();
			}
		}

		return redirect()->back()->with('status', "Playtime, icons and logos updated!");
	}
}

?>