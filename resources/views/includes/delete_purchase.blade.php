{{--
	Filename:   delete_purchase.blade.php
	Date:       2016-07-26
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


@extends('layouts.modal')

@section('title')
	Delete confirmation
@endsection

@section('body')
	Are you sure you want to delete this purchase? This cannot be undone.
@endsection

@section('inputs')
	<div class="checkbox">
		<label>
			<input type="hidden" name="_method" value="DELETE">
			<input type="checkbox" name="deleteChildren"> Delete games and DLC in this purchase
		</label>
	</div>
@endsection

@push('scripts')
	<script src="{{asset('js/deleteRow.js')}}"></script>
@endpush