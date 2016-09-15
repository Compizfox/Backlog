{{--
	Filename:   edit.blade.php
	Date:       2016-09-15
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
	<h1>Edit DLC # {{$dlc->id}}</h1>

	<form class="form-horizontal well" role="form" action="{{action('DlcController@update', ['id' => $dlc->id])}}" method="post" style="max-width: 800px;">
		<fieldset>
			{{method_field('PUT')}}
			{{csrf_field()}}

			<div class="form-group">
				<label class="col-sm-2 control-label">Name:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="name" value="{{$dlc->name}}" required autofocus></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Status:</label>
				<div class="col-md-4"><select class="form-control" name="status">@include('includes.status_options', ['selected' => $dlc->status_id])</select></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Note:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="note" value="{{$dlc->note}}"></div>
			</div>
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-6">
				<button class="btn btn-default" type="submit" name="submit">Submit</button>
			</div>
		</div>
	</form>
@endsection