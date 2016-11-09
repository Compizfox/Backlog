{{--
	Filename:   show.blade.php
	Date:       2016-10-01
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
			<h1><img src="{{$game->getImageUrl('logo')}}" width="184px" height="69px"> {{$game->name}}</h1>
		</div>
		<div class="panel-body">
			<p style="background-color: {{$game->status->color}}"><b>Status:</b> {{$game->status->name}}</p>
			<p><b>Playtime (minutes):</b> {{$game->getFormattedPlaytime()}}</p>
			<p><b>Note:</b> {{$game->note}}</p>

			<hr>
			<h2>Purchases</h2>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach($game->purchases as $purchase)
						<tr>
							<td>
								<a href="{{action('PurchaseController@show', ['id' => $purchase->id])}}">#{{$purchase->id}} ({{$purchase->shop}})</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@if(!$game->dlc->isEmpty())
				<hr>
				<h2>DLC</h2>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Status</th>
							<th>Notes</th>
						</tr>
					</thead>
					<tbody>
						@foreach($game->dlc as $dlc)
							<tr>
								<td><a href="{{action('DlcController@show', ['id' => $dlc->id])}}">{{$dlc->name}}</a></td>
								<td style="background-color: {{$dlc->status->color}}">{{$dlc->status->name}}</td>
								<td>{{$dlc->notes}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif

			@if(!$game->playthroughs->isEmpty())
				<hr>
				<h2>Playthroughs</h2>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Start date</th>
							<th>End date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($game->playthroughs as $pt)
							<tr>
								<td>{{$pt->id}}</td>
								<td>{{$pt->started_at}}</td>
								<td>{{$pt->ended_at or ''}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
		<div class="panel-footer">
			<a href="{{action('GameController@edit', ['id' => $game->id])}}" class="btn btn-default">Edit</a>
		</div>
	</div>
@endsection