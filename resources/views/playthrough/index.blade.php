{{--
	Filename:   index.blade.php
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
	<h1>Playthroughs</h1>
	<form class="form-horizontal" action="{{action('PlaythroughController@index')}}" method="post">
		{{csrf_field()}}
		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Pending playthroughs</h2>
			</div>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><input type="checkbox" class="selectall"></th>
						<th>#</th>
						<th>Game</th>
						<th>Start date</th>
						<th>Status</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					@foreach($pending as $pt)
						<tr>
							<td>
								<input type="checkbox" name="checkedPlaythroughs[]" value="{{$pt->id}}">&nbsp;
								<a href="{{action('PlaythroughController@edit', ['id' => $pt->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
								<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('PlaythroughController@destroy', ['id' => $pt->id])}}"></span>
							</td>
							<td><a href="{{action('PlaythroughController@show', ['id' => $pt->id])}}">{{$pt->id}}</a></td>
							<td>
								@if($pt->playable_type == 'App\Game')
									<a href="{{action('GameController@show', ['id' => $pt->playable->id])}}"><img src="{{$pt->playable->getImageUrl()}}" width="32px" height="32px"> {{$pt->playable->name}}</a>
								@endif
								@if($pt->playable_type == 'App\Dlc')
									<a href="{{action('DlcController@show', ['id' => $pt->playable->id])}}"><img src="{{$pt->playable->game->getImageUrl()}}" width="32px" height="32px"><img src="{{asset('images/dlc-icon.png')}}" title="{{$pt->playable->name}}"> {{$pt->playable->name}}</a>&nbsp;
								@endif
							</td>
							<td>{{$pt->started_at}}</td>
							<td style="background-color: {{$pt->playable->status->color}}">{{$pt->playable->status->name}}</td>
							<td>{{$pt->note}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-2 control-label">Finish playthrough</label>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">With status:</label>
					<div class="col-sm-3">
						<select name="status" class="form-control"><option value="">Select a status</option>@include('includes.status_options')</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">With date:</label>
					<div class="col-sm-3">
						<input class="form-control" type="date" name="ended_at" value="{{date("Y-m-d")}}">
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

		<div class="panel panel-default">
			<div class="panel-heading">
				<h2>Finished playthroughs</h2>
			</div>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><input type="checkbox" class="selectall"></th>
						<th>#</th>
						<th>Game</th>
						<th>Start date</th>
						<th>End date</th>
						<th>Status</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					@foreach($ended as $pt)
						<tr>
							<td>
								<input type="checkbox" name="checkedPlaythroughs[]" value="{{$pt->id}}">&nbsp;
								<a href="{{action('PlaythroughController@edit', ['id' => $pt->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
								<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('PlaythroughController@destroy', ['id' => $pt->id])}}"></span>
							</td>
							<td><a href="{{action('PlaythroughController@show', ['id' => $pt->id])}}">{{$pt->id}}</a></td>
							<td>
								@if($pt->playable_type == 'App\Game')
									<a href="{{action('GameController@show', ['id' => $pt->playable->id])}}"><img src="{{$pt->playable->getImageUrl()}}" width="32px" height="32px"> {{$pt->playable->name}}</a>
								@endif
								@if($pt->playable_type == 'App\Dlc')
									<a href="{{action('DlcController@show', ['id' => $pt->playable->id])}}"><img src="{{$pt->playable->game->getImageUrl()}}" width="32px" height="32px"><img src="{{asset('images/dlc-icon.png')}}" title="{{$pt->playable->name}}"> {{$pt->playable->name}}</a>&nbsp;
								@endif
							</td>
							<td>{{$pt->started_at}}</td>
							<td>{{$pt->ended_at}}</td>
							<td style="background-color: {{$pt->playable->status->color}}">{{$pt->playable->status->name}}</td>
							<td>{{$pt->note}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="panel-body">
				<button type="submit" name="_method" value="DELETE" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</form>

	@include('includes.delete_game')
@endsection

@push('scripts')
	<script src="{{asset('js/checkall.js')}}"></script>
@endpush