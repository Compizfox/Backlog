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

<form class="form-horizontal" action="{{action('DlcController@index')}}" method="post">
	<div class="panel panel-default">
		<div class="panel-heading"><h2>DLC</h2></div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Name</th>
					<th>Game</th>
					<th>Status</th>
					<th>Notes</th>
					<th><input type="checkbox" class="selectall" /></th>
				</tr>
			</thead>
			<tbody>
				@foreach($dlcs as $dlc)
					<tr>
						<td>{{$dlc->name}}</td>
						<td><img src="{{$dlc->game->getImageUrl('logo')}}" width="184px" height="69px"><img src="{{asset('images/dlc-logo.png')}}"> {{$dlc->game->name}}</td>
						<td style="background-color: {{$dlc->status->color}}">{{$dlc->status->name}}</td>
						<td>{{$dlc->notes}}</td>
						<td>
							<input type="checkbox" name="checkedDlc[]" value="{{$dlc->id}}">&nbsp;
							<a href="{{action('DlcController@edit', ['id' => $dlc->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
							<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('DlcController@destroy', ['id' => $dlc->id])}}"></span>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-body">
			{{csrf_field()}}
			<div class="form-group">
				<div class="col-sm-2">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="updateStatus"> Set status:
						</label>
					</div>
				</div>
				<div class="col-sm-3"><select name="status" class="form-control status"><option value="">Select a status</option>@include('includes.status_options')</select></div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="setHidden"> Set hidden
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3">
					<button type="submit" name="_method" value="PATCH" class="btn btn-primary">Submit</button>
					<button type="submit" name="_method" value="DELETE" class="btn btn-danger">Delete</button>
				</div>
			</div>
		</div>
	</div>
</form>