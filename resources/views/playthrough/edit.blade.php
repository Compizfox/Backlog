{{--
	Filename:   edit.blade.php
	Date:       2016-10-23
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
	<h1>Edit playthrough</h1>

	<form class="form-horizontal well" role="form" action="{{action('PlaythroughController@update', ['id' => $pt->id])}}" method="post" style="max-width: 800px;">
		{{csrf_field()}}
		{{method_field('PUT')}}

		<div class="form-group">
			<label class="col-sm-3 control-label">
				@if($pt->playable_type == 'App\Game')Game:
				@elseif($pt->playable_type == 'App\Dlc')DLC:
				@endif
			</label>
			<div class="col-md-9">
				<p class="form-control-static">{{$pt->playable->name}}</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label">Started at:</label>
			<div class="col-md-9">
				<input class="form-control" type="date" name="started_at" value="{{$pt->started_at}}">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-3 control-label">
				<label><input type="checkbox" name="isEnded" id="isEnded"{{$pt->ended ? ' checked' : ''}}> Finished at:</label>
			</div>
			<div class="col-md-9">
				<input class="form-control" type="date" name="ended_at" id="ended_at" value="{{$pt->ended_at}}"{{$pt->ended ? '' : ' disabled'}}>
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
				<input class="form-control" type="text" name="note" value="{{$pt->note}}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Playtime (hours):</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="playtime" value="{{$pt->getPlaytime()}}">
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
@endpush