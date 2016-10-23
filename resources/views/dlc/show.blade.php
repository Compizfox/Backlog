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
			<p><a href="{{action('GameController@show', ['id' => $dlc->game->id])}}">{{$dlc->game->name}}</a></p>
			<p style="background-color: {{$dlc->status->color}}">Status: {{$dlc->status->name}}</p>
			<p>Note: {{$dlc->note}}</p>

			<hr>
			<h2>Purchases</h2>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach($dlc->purchases as $purchase)
						<tr>
							<td>
								<a href="{{action('PurchaseController@show', ['id' => $purchase->id])}}">#{{$purchase->id}} ({{$purchase->shop}})</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			@if(!$dlc->playthroughs->isEmpty())
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
						@foreach($dlc->playthroughs as $pt)
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
			<a href="{{action('DlcController@edit', ['id' => $dlc->id])}}" class="btn btn-default">Edit</a>
		</div>
	</div>
@endsection