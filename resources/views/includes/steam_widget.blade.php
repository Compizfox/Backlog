{{--
	Filename:   steam_widget.blade.php
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
--}}

@if(isset($nickname))
	<div class="nav-sidebar steamwidget">
		<div class="panel-body">
			<p>
				<a href="{{$profileURL}}" target="_blank" style="text-decoration: none;">
					<img src="{{$avatar}}" alt>
					<span style="font-size: 150%; margin-left: 5px;">{{$nickname}}</span>
				</a>
			</p>
			<p>
				@foreach($recentlyPlayed as $game)
					<img style="margin: 4px" src="http://media.steampowered.com/steamcommunity/public/images/apps/{{$game->appid}}/{{$game->img_icon_url}}.jpg" title="{{$game->name}}" alt >
				@endforeach
			</p>
		</div>
	</div>
@endif