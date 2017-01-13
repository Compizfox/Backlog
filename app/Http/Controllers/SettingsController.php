<?php
/*
	Filename:   SettingsController.php
	Date:       2016-12-29
	Author:     Lars Veldscholte
	            lars@veldscholte.eu
	            http://lars.veldscholte.eu

	Copyright 2016 Lars Veldscholte

	This file is part of Backlog2_53.

	Backlog2_53 is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	Backlog2_53 is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Backlog2_53. If not, see <http://www.gnu.org/licenses/>.
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Status;

class SettingsController extends Controller {
	public function get() {
		// General settings
		$apiKey = \Setting::get('apiKey');
		$steamID = \Setting::get('steamID');

		// Hidden games
		$games = Game::where('hidden', 1)->get();

		// Statuses
		$statuses = Status::all();

		return view('settings', [
				'apiKey'    => $apiKey,
				'steamID'   => $steamID,
				'games'     => $games,
				'statuses'  => $statuses
		]);
	}

	public function postGeneral(Request $request) {
		$this->validate($request, [
				'apiKey'    => 'string',
				'steamID'   => 'string'
		]);

		\Setting::set('apiKey', $request->apiKey);
		\Setting::set('steamID', $request->steamID);
		\Setting::save();

		return redirect()->action('SettingsController@get')->with('status', 'Settings applied!');
	}

	public function postHidden(Request $request) {
		$this->validate($request, ['checkedGames.*' => 'required|exists:games,id']);

		Game::whereIn('id', $request->checkedGames)->update(['hidden' => 0]);

		return redirect()->action('SettingsController@get')->with('status', 'Games unhidden!');
	}

	public function postStatuses(Request $request) {
		$this->validate($request, [
				'id.*'          => 'integer',
				'name.*'        => 'required|string',
				'color.*'       => 'required|string',
		]);

		// Get all rows that were removed in the form and remove them
		$removed = array_diff(Status::pluck('id')->toArray(), $request->id);
		Status::destroy($removed);

		// Update or insert all POSTed rows
		foreach($request->name as $i => $name) {
			$id = $request->id[$i] ?? NULL;
			Status::updateOrCreate(['id' => $id], [
					'name'      => $request->name[$i],
					'color'     => $request->color[$i],
					'completed' => isset($request->completed[$i])
			]);
		}

		return redirect()->action('SettingsController@get')->with('status', 'Statuses updated!');
	}
}
