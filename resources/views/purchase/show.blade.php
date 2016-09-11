{{--
	Filename:   show.blade.php
	Date:       2016-07-22
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
	<h1>Purchase #{{$purchase->id}}</h1>
	@if(!$purchase->games->isEmpty())
		@include('includes.game_table', ['games' => $purchase->games])
	@endif

	@if(!$purchase->dlc->isEmpty())
		@include('includes.dlc_table', ['dlcs' => $purchase->dlc])
	@endif

	@include('includes.delete_game')
@endsection

@push('scripts')
	<script src="{{asset('js/checkall.js')}}"></script>
	<script src="{{asset('js/batchOperations.js')}}"></script>
@endpush