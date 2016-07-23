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

<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Deleting a game will delete all of its DLC. <br />Empty purchases will be automatically deleted.</div>

<form class="form-horizontal" action="" method="post">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Status</th>
				<th>Playtime (hours)</th>
				<th>Notes</th>
				<th><input type="checkbox" id="selectall"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($games as $game)
				<tr>
					<td><img src="{{$game->getLogoUrl()}}"> {{$game->name}}</td>
					<td style="background-color: {{$game->status->color}}">{{$game->status->name}}</td>
					<td>{{$game->getFormattedPlaytime()}}</td>
					<td>{{$game->notes}}</td>
					<td>
						<input type="checkbox" name="checkedgames[]" value="{{$game->id}}">&nbsp;
						<a href="/game/{{$game->id}}/edit"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
						<a href="#"><span class="glyphicon glyphicon-trash"></span></a>&nbsp;
						<a href="/dlc"><span class="glyphicon glyphicon-download"></span></a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>

	<div class="panel panel-default">
		<div class="panel-body">
			<fieldset>
				<input type="hidden" name="formsubmit" value="formsubmit" />
				<div class="form-group">
					<button type="submit" name="submitbtn" value="delete" class="btn btn-danger">Delete</button>
					<button type="submit" name="submitbtn" value="hide" class="btn btn-default">Hide</button>
					<label class="col-sm-3 control-label">Set status:</label>
					<div class="col-sm-3"><select name="status" class="form-control" onchange="this.form.submit()"><option value="">Select a status</option></select></div>
				</div>
			</fieldset>
		</div>
	</div>
</form>