{{--
	Filename:   index.blade.php
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
	<form class="form-horizontal" action="{{action('DlcController@index')}}" method="post">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>DLC</h1></div>

			@include('includes.dlc_table', ['dlcs' => $dlc])

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