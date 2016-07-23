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
	<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Remember: </strong>removing games in <i>purchase view</i> unlinks the games from the purchase. To actually delete the game itself, remove it in <i>games view</i>.<br />Deleting a purchase doesn't remove the games in it.</div>
	<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Empty purchases will be automatically deleted.</div>

	<form class="form-horizontal" action="" method="post">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th><input type="checkbox" id="selectall"></th>
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
							<input type="checkbox" name="checkedpurchases[]" value="1">&nbsp;
							<a href="purchase/{{$purchase->id}}"><span class="glyphicon glyphicon-search"></span></a>&nbsp;
							<a href="purchase/{{$purchase->id}}/edit"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;
							<a href="#"><span class="glyphicon glyphicon-trash"></span></a>
						</td>
						<td>{{$purchase->shop}}</td>
						<td>{{$purchase->getFormattedPrice()}}</td>
						<td>{{$purchase->purchased_at}}</td>
						<td>{{$purchase->note}}</td>
						<td>
							@foreach($purchase->games as $game)
								<img src="{{$game->getIconUrl()}}" title="{{$game->name}}">&nbsp;
							@endforeach
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<div class="panel panel-default">
			<div class="panel-body">
				<button type="submit" name="submit" value="delete" class="btn btn-danger">Delete</button>
			</div>
		</div>
	</form>
@endsection