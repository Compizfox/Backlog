{{--
	Filename:   index.blade.php
	Date:       2016-09-12
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
	<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Deleting a game will delete all of its DLC. <br />Empty purchases will be automatically deleted.</div>

	<form class="form-horizontal" action="{{action('GameController@index')}}" method="post">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>Games</h1></div>

			@include('includes.game_table', ['games' => $games])

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

	@include('includes.delete_game')
@endsection

@push('scripts')
	<script src="{{asset('js/checkall.js')}}"></script>
	<script src="{{asset('js/batchOperations.js')}}"></script>
@endpush