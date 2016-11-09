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
	<div class="panel panel-default">
		<div class="panel-heading">
			<h1>Purchase #{{$purchase->id}}</h1>
		</div>

		<div class="panel-body">
			<p><b>Shop:</b> {{$purchase->shop}}</p>
			<p><b>Price:</b> {{$purchase->getFormattedPrice()}}</p>
			<p><b>Purchase date:</b> {{$purchase->purchased_at}}</p>
			<p><b>Note:</b> {{$purchase->note}}</p>
			<hr>
		</div>

		@if(!$purchase->games->isEmpty())
			<div class="panel-body">
				<h2>Games</h2>
			</div>
			@include('includes.game_table', ['games' => $purchase->games])
		@endif

		@if(!$purchase->dlc->isEmpty())
			<div class="panel-body">
				<h2>DLC</h2>
			</div>
			@include('includes.dlc_table', ['dlcs' => $purchase->dlc])
		@endif

		<div class="panel-footer">
			<a href="{{action('PurchaseController@edit', ['id' => $purchase->id])}}" class="btn btn-default">Edit</a>
		</div>
	</div>

	@include('includes.delete_game')
@endsection