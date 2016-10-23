{{--
	Filename:   create.blade.php
	Date:       2016-10-09
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

@extends('layouts.master')

@section('content')
	<h1>Add playthrough</h1>

	<form class="form-horizontal well" role="form" action="{{action('PlaythroughController@store')}}" method="post" style="max-width: 800px;">
		{{csrf_field()}}

		<div class="form-group">
			<div class="col-md-2 col-md-offset-3">
				<div class="radio">
					<label>
						<input type="radio" name="playable_type" value="Game" checked>
						Game
					</label>
				</div>
			</div>

			<div class="col-md-7">
				<select class="form-control playable" name="Game" id="game"></select>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-2 col-md-offset-3">
				<div class="radio">
					<label>
						<input type="radio" name="playable_type" value="Dlc">
						DLC
					</label>
				</div>
			</div>

			<div class="col-md-7">
				<select class="form-control playable" name="Dlc" id="dlc" disabled></select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label">Started at:</label>
			<div class="col-md-9">
				<input class="form-control" type="date" name="started_at" value="{{date("Y-m-d")}}" required>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3 control-label">
				<label><input type="checkbox" name="isEnded" id="isEnded"> Finished at:</label>
			</div>
			<div class="col-md-9">
				<input class="form-control" type="date" name="ended_at" id="ended_at" value="{{date("Y-m-d")}}" disabled>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3 control-label">
				<label><input type="checkbox" name="updateStatus" id="updateStatus"> Update status with:</label>
			</div>
			<div class="col-md-9">
				<select class="form-control" name="status" id="status" disabled>@include('includes.status_options')</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Note:</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="note">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-3 col-md-5">
				<button class="btn btn-default" type="submit" name="submit">Submit</button>
			</div>
		</div>
	</form>
@endsection

@push('scripts')
<script src="{{asset('js/createPlaythrough.js')}}"></script>
<script>
	$.getJSON('{{action('GameController@getCategorisedJson')}}', function(data) {
		fill(data, $('#game'));
	});

	$.getJSON('{{action('DlcController@getJson')}}', function(data) {
		fill(data, $('#dlc'));
	});
</script>
@endpush