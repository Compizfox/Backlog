<?php
/*
	Filename:   SteamWidgetComposer.php
	Date:       2017-01-16
	Author:     Lars Veldscholte
	            lars@veldscholte.eu
	            http://lars.veldscholte.eu

	Copyright 2017 Lars Veldscholte

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


namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Cache;
use App\Services\SteamService;

class SteamWidgetComposer {
	public function compose(View $view)	{
		try {
			$steamService = new SteamService(\Setting::get('apiKey'), \Setting::get('steamID'));

			list($profileURL, $avatar, $nickname) = Cache::remember('steamUserData', 1440, function() use($steamService) {
				return $steamService->retrieveUserData();
			});

			$view->with('profileURL', $profileURL);
			$view->with('avatar', $avatar);
			$view->with('nickname', $nickname);

			$games = Cache::remember('steamRecentlyPlayed', 1440, function() use($steamService) {
				return $steamService->retrieveRecentlyPlayed();
			});

			$view->with('recentlyPlayed', $games);
		} catch(\RuntimeException $e) {}
	}
}