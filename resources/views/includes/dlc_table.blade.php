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
			<th><input type="checkbox" class="selectall"></th>
			<th>Name</th>
			<th>Game</th>
			<th>Status</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
		@foreach($dlcs as $dlc)
			<tr>
				<td>
					<input type="checkbox" name="checkedDlc[]" value="{{$dlc->id}}">&nbsp;
					<a href="{{action('DlcController@edit', ['id' => $dlc->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
					<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('DlcController@destroy', ['id' => $dlc->id])}}"></span>
				</td>
				<td><a href="{{action('DlcController@show', ['id' => $dlc->id])}}">{{$dlc->name}}</a></td>
				<td><a href="{{action('GameController@show', ['id' => $dlc->game->id])}}"><img src="{{$dlc->game->getImageUrl('logo')}}" width="184px" height="69px"><img src="{{asset('images/dlc-logo.png')}}"> {{$dlc->game->name}}</a></td>
				<td style="background-color: {{$dlc->status->color}}">{{$dlc->status->name}}</td>
				<td>{{$dlc->notes}}</td>
			</tr>
		@endforeach
	</tbody>
</table>