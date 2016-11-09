{{--
	Filename:   index.blade.php
	Date:       2016-07-22
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
--}}

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Name</th>
			<th>Status</th>
			<th>Playtime (hours)</th>
			<th>Notes</th>
			<th><input type="checkbox" class="selectall"></th>
		</tr>
	</thead>
	<tbody>
		@foreach($games as $game)
			<tr>
				<td><a href="{{action('GameController@show', ['id' => $game->id])}}"><img src="{{$game->getImageUrl('logo')}}" width="184px" height="69px"> {{$game->name}}</a></td>
				<td style="background-color: {{$game->status->color}}">{{$game->status->name}}</td>
				<td>{{$game->getFormattedPlaytime()}}</td>
				<td>{{$game->notes}}</td>
				<td>
					<input type="checkbox" name="checkedGames[]" value="{{$game->id}}">&nbsp;
					<a href="{{action('GameController@edit', ['id' => $game->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
					<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('GameController@destroy', ['id' => $game->id])}}"></span>
					<a href="/dlc"><span class="glyphicon glyphicon-download"></span></a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>