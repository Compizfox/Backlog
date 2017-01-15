{{--
	Filename:   general.blade.php
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
--}}

@extends('layouts.master')

@section('content')
	<form class="panel panel-default" method="post" action="{{action('SettingsController@postGeneral')}}">
		<div class="panel-heading">
			<h1>General settings</h1>
		</div>
		<div class="panel-body form-horizontal">
			<h2>Steam</h2>
			<hr>

			<div class="form-group">
				<label class="col-sm-2 control-label">API key:</label>
				<div class="col-sm-9">
					<input name="apiKey" class="form-control" type="text" value="{{$apiKey}}">
				</div>
				<label class="control-label"><span class="glyphicon glyphicon-question-sign" title="You can get one here: http://steamcommunity.com/dev/apikey"></span></label>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Steam ID:</label>
				<div class="col-sm-9">
					<input name="steamID" class="form-control" type="text" value="{{$steamID}}">
				</div>
				<label class="control-label"><span class="glyphicon glyphicon-question-sign" title="Your Steam ID in STEAMID64 format. You can get your Steam ID here: http://steamid.co/"></span></label>
			</div>
		</div>
		<div class="panel-footer">
			{{csrf_field()}}
			<button type="submit" class="btn btn-primary">Save</button>
		</div>
	</form>

	<form class="panel panel-default" method="post" action="{{action('SettingsController@postHidden')}}">
		<div class="panel-heading">
			<h1>Hidden games</h1>
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><input type="checkbox" class="selectall"></th>
					<th>Name</th>
				</tr>
			</thead>
			<tbody>
				@foreach($games as $game)
					<tr>
						<td>
							<input type="checkbox" name="checkedGames[]" value="{{$game->id}}">
						</td>
						<td>{{$game->name}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-footer">
			{{csrf_field()}}
			<button class="btn btn-default" type="submit" name="submit">Unhide</button>
		</div>
	</form>

	<form class="panel panel-default" method="post" action="{{action('SettingsController@postStatuses')}}">
		<div class="panel-heading">
			<h1>Statuses</h1>
		</div>
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Status</th>
					<th>Color</th>
					<th>Completed</th>
					<th></th>
				</tr>
			</thead>
			<tbody id="statuses">
				@foreach($statuses as $i => $status)
					<tr>
						<td>
							<input type="hidden" name="id[{{$i}}]" value="{{$status->id}}">
							<input type="text" class="form-control" name="name[{{$i}}]" value="{{$status->name}}" required>
						</td>
						<td>
							<input type="color" class="form-control" name="color[{{$i}}]" value="{{$status->color}}" required>
						</td>
						<td>
							<input type="checkbox" name="completed[{{$i}}]"{{$status->completed ? ' checked' : ''}}>
						</td>
						<td>
							<span class="glyphicon glyphicon-remove-sign clickable deleteRow"></span>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		<div class="panel-footer">
			{{csrf_field()}}
			<button class="btn btn-default" type="button" id="addRow"><span class="glyphicon glyphicon-plus"></span> New status</button>
			<button class="btn btn-default" type="submit">Submit</button>
		</div>
	</form>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>Database operations</h2>
		</div>
		<div class="panel-body">
			{{csrf_field()}}
			<button class="btn btn-default" name="truncate" id="truncate">Truncate database</button>
			<a class="btn btn-default" href="{{action('PurchaseController@cleanup')}}">Cleanup database (remove empty purchases)</a>
		</div>
	</div>

	<table id="template" style="display:none;">
		<tr>
			<td><input type="text" class="form-control" name="name[$i]" required></td>
			<td><input type="color" class="form-control" name="color[$i]" required></td>
			<td><input type="checkbox" name="completed[$i]"></td>
			<td><span class="glyphicon glyphicon-remove-sign clickable deleteRow"></span></td>
		</tr>
	</table>

	@include('includes.truncate')
@endsection

@push('scripts')
	<script src="{{asset('js/checkall.js')}}"></script>
	<script src="{{asset('js/statuses.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#truncate').click(function() {
				$('#myModal').modal();
			});
		});
	</script>
@endpush