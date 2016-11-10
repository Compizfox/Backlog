{{--
	Filename:   index.blade.php
	Date:       2016-07-19
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
	<form class="form-horizontal" action="{{action('PurchaseController@destroyMany')}}" method="post">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>Purchases</h1></div>

			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th><input type="checkbox" class="selectall"></th>
						<th>Shop</th>
						<th>Price</th>
						<th>Date</th>
						<th>Note</th>
						<th>Games/DLC</th>
					</tr>
				</thead>
				<tbody>
					@foreach($purchases as $purchase)
						<tr>
							<td>
								<input type="checkbox" name="checkedPurchases[]" value="{{$purchase->id}}">&nbsp;
								<a href="{{action('PurchaseController@show', ['id' => $purchase->id])}}"><span class="glyphicon glyphicon-search"></span></a>&nbsp;
								<a href="{{action('PurchaseController@edit', ['id' => $purchase->id])}}"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
								<span class="glyphicon glyphicon-trash clickable delete" data-url="{{action('PurchaseController@destroy', ['id' => $purchase->id])}}"></span>
							</td>
							<td>{{$purchase->shop}}</td>
							<td>{{$purchase->getFormattedPrice()}}</td>
							<td>{{$purchase->purchased_at}}</td>
							<td>{{$purchase->note}}</td>
							<td>
								@foreach($purchase->games as $game)
									<a href="{{action('GameController@show', ['id' => $game->id])}}"><img src="{{$game->getImageUrl()}}" title="{{$game->name}}" width="32px" height="32px"></a>&nbsp;
								@endforeach
								@foreach($purchase->dlc as $dlc)
									<a href="{{action('DlcController@show', ['id' => $dlc->id])}}"><img src="{{$dlc->game->getImageUrl()}}" title="{{$dlc->name}}" width="32px" height="32px"><img src="{{asset('images/dlc-icon.png')}}" title="{{$dlc->name}}"></a>&nbsp;
								@endforeach
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<div class="panel-body">
				{{method_field('DELETE')}}
				{{csrf_field()}}
				<button type="submit" name="submit" value="delete" class="btn btn-danger">Delete</button>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="deleteChildren"> Delete games and DLC in purchase
					</label>
				</div>
			</div>
		</div>
	</form>
	@include('includes.delete_purchase')
@endsection

@push('scripts')
	<script src="{{asset('js/checkall.js')}}"></script>
@endpush