<?php
/*
	Filename:   SteamService.php
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


namespace App\Services;

class SteamService {
	private $apiKey;
	private $steamID;

	public function __construct($apiKey, $steamID) {
		$this->apiKey = $apiKey;
		$this->steamID = $steamID;
	}

	public function retrieveGames() {
		$url = 'https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?';

		$arguments = [
			'key'               => $this->apiKey,
			'steamid'           => $this->steamID,
			'format'            => 'json',
			'include_appinfo'   => 1,
		];

		$result = json_decode(file_get_contents($url . http_build_query($arguments)));

		return $result->response->games;
	}
}

?>