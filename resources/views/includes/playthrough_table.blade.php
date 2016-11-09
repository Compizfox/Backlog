{{--
	Filename:   playthrough_table.blade.php
	Date:       2016-11-09
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
			<th>#</th>
			<th>Start date</th>
			<th>End date</th>
		</tr>
	</thead>
	<tbody>
		@foreach($playthroughs as $pt)
			<tr>
				<td><a href="{{action('PlaythroughController@edit', ['id' => $pt->id])}}">{{$pt->id}}</a></td>
				<td>{{$pt->started_at}}</td>
				<td>{{$pt->ended_at or ''}}</td>
			</tr>
		@endforeach
	</tbody>
</table>