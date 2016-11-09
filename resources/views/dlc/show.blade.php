{{--
	Filename:   show.blade.php
	Date:       2016-10-08
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
	<div class="panel panel-default" style="max-width: 800px;">
		<div class="panel-heading">
			<h1>{{$dlc->name}}</h1>
		</div>
		<div class="panel-body">
			<p><a href="{{action('GameController@show', ['id' => $dlc->game->id])}}"><img src="{{$dlc->game->getImageUrl('logo')}}" width="184px" height="69px"> {{$dlc->game->name}}</a></p>
			<p style="background-color: {{$dlc->status->color}}"><b>Status:</b> {{$dlc->status->name}}</p>
			<p><b>Note:</b> {{$dlc->note}}</p>

			<hr>
			<h2>Purchases</h2>
			@include('includes.purchase_table', ['purchases' => $dlc->purchases])

			@if(!$dlc->playthroughs->isEmpty())
				<hr>
				<h2>Playthroughs</h2>
				@include('includes.playthrough_table', ['playthroughs' => $dlc->playthroughs])
			@endif
		</div>
		<div class="panel-footer">
			<a href="{{action('DlcController@edit', ['id' => $dlc->id])}}" class="btn btn-default">Edit</a>
		</div>
	</div>
@endsection