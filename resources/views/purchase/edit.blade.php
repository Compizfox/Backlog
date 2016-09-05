{{--
	Filename:   edit.blade.php
	Date:       2016-08-27
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
	<h1>Edit purchase #{{$purchase->id}}</h1>
	<form class="form-horizontal" role="form" action="{{action('PurchaseController@update', ['id' => $purchase->id])}}" method="post" style="max-width: 800px;">
		{{method_field('PUT')}}
		{{csrf_field()}}

		<h2>Purchase properties</h2>
		<div class="well">
			<div class="form-group">
				<label class="col-md-2 control-label">Shop:</label>
				<div class="col-md-6"><input class="form-control" type="text" name="shop" value="{{$purchase->shop}}"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Price:</label>
				<div class="col-md-6">
					<div class="input-group">
						<select style="width: 40px; padding-left: 1px; padding-right: 1px;" class="form-control" name="valuta">
							<option value="€">€</option>
							<option value="$">$</option>
							<option value="£">£</option>
						</select>
						<span class="input-group-addon"></span>
						<input class="form-control" type="text" name="price" value="{{$purchase->price}}">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Date:</label>
				<div class="col-md-6"><input class="form-control" type="date" name="date" value="{{$purchase->purchased_at}}"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label">Note:</label>
				<div class="col-md-6"><input class="form-control" type="text" name="note" value="{{$purchase->note}}"></div>
			</div>
		</div>

		<h2>Linked members</h2>
		<div class="well">
			<div class="form-group">
				<div class="col-md-8">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
							</tr>
						</thead>
						<tbody>
							@foreach($purchase->games as $game)
								<tr>
									<td>
										<input type="hidden" name="games[]" value="{{$game->id}}">
										<span class="fa fa-chain-broken clickable"></span>
									</td>
									<td><img src="{{$game->getImageUrl('icon')}}" width="32px" height="32px"> {{$game->name}}</td>
								</tr>
							@endforeach
							@foreach($purchase->dlc as $dlc)
								<tr>
									<td>
										<input type="hidden" name="dlc[]" value="{{$dlc->id}}">
										<span class="fa fa-chain-broken clickable"></span>
									</td>
									<td><img src="{{$dlc->game->getImageUrl('icon')}}" title="{{$dlc->game->name}}" width="32px" height="32px"><img src="{{asset('images/dlc-icon.png')}}" title="{{$dlc->game->name}}"> {{$dlc->name}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-md-4">
					<label class="control-label">Add game</label>
					<select class="form-control" id="game"><option></option></select>
					<label class="control-label">Add dlc</label>
					<select class="form-control" id="dlc"><option></option></select>
				</div>
			</div>
		</div>
		<button class="btn btn-default" type="submit" name="submit">Submit</button>
	</form>

	<table id="template" style="display: none;">
		<tr>
			<td>
				<input type="hidden">
				<span class="fa fa-chain-broken clickable"></span>
			</td>
			<td id="name"></td>
		</tr>
	</table>
@endsection

@push('scripts')
	<script src="{{asset('js/editPurchase.js')}}"></script>
	<script>
		$.getJSON('{{action('GameController@getCategorisedJson')}}', fillGames);
		$.getJSON('{{action('DlcController@getJson')}}', fillDlc);
	</script>
@endpush