{{--
	Filename:   create.blade.php
	Date:       2016-07-24
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
	<div class="alert alert-info .alert-dismissable fade in">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Remember: </strong>If a game by the same name already exists, a copy will <b>not</b> be made. Instead, the existing game will be linked with the new purchase.
	</div>

	<div class="well">
		<form class="form-horizontal" role="form" action="{{action('PurchaseController@store')}}" method="post">
			{{csrf_field()}}
			<fieldset>
				<legend>Purchase</legend>
				<div class="form-group">
					<label class="col-sm-2 control-label">Shop:</label>
					<div class="col-md-4"><input class="form-control" type="text" name="shop" required autofocus></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Price:</label>
					<div class="col-md-2">
						<div class="input-group"><select style="width: 40px; padding-left: 1px; padding-right: 1px;" class="form-control" name="valuta"><option value="€">€</option><option value="$">$</option><option value="£">£</option></select><span class="input-group-addon"></span><input class="form-control" type="text" name="price"></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Date:</label>
					<div class="col-md-2"><input class="form-control" type="date" name="date" value="{{date("Y-m-d")}}"></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Note:</label>
					<div class="col-md-4"><input class="form-control" type="text" name="note"></div>
				</div>
			</fieldset>
			<fieldset id="gameContainer">
				<legend>Games</legend>
			</fieldset>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-default" type="button" id="addGame"><span class="glyphicon glyphicon-plus"></span> New game</button>
				</div>
			</div>
			<fieldset id="dlcContainer">
				<legend>DLC</legend>
			</fieldset>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-default" type="button" id="addDlc"><span class="glyphicon glyphicon-plus"></span> New DLC</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-12">
					<button class="btn btn-default" type="submit" name="submit">Submit</button>
				</div>
			</div>
		</form>
	</div>
	<div id="gameTemplate" style="display:none;">
		<label class="col-sm-1 control-label">Game:</label>
		<div class="col-md-3">
			<input class="form-control autocomplete" type="text" name="games[$i][name]" required autofocus>
		</div>
		<label class="col-sm-1 control-label">Status:</label>
		<div class="col-md-2">
			<select class="form-control" name="games[$i][status]">@include('includes.status_options')</select>
		</div>
		<label class="col-sm-1 control-label">Note:</label>
		<div class="col-md-3">
			<input class="form-control" type="text" name="games[$i][note]">
		</div>
		<label class="control-label">
			<a href="#" class="deleteRow">
				<span class="glyphicon glyphicon-remove-sign"></span>
			</a>
		</label>
	</div>
	<div id="dlcTemplate" style="display: none;">
		<label class="col-sm-1 control-label">Game:</label>
		<div class="col-md-2">
			<input class="form-control autocomplete" type="text" name="dlc[$i][game]" required autofocus>
		</div>
		<label class="col-sm-1 control-label">DLC:</label>
		<div class="col-md-2">
			<input class="form-control" type="text" name="dlc[$i][name]" required autofocus>
		</div>
		<label class="col-sm-1 control-label">Status:</label>
		<div class="col-md-1">
			<select class="form-control" name="dlc[$i][status]">@include('includes.status_options')</select>
		</div>
		<label class="col-sm-1 control-label">Note:</label>
		<div class="col-md-2">
			<input class="form-control" type="text" name="dlc[$i][note]">
		</div>
		<label class="control-label">
			<a href="#" class="deleteRow">
				<span class="glyphicon glyphicon-remove-sign"></span>
			</a>
		</label>
	</div>
@endsection

@push('links')
	<link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.css" rel="stylesheet">
@endpush

@push('scripts')
	<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
	<script src="{{asset('js/createPurchase.js')}}"></script>
	{{--TODO: jQuery UI autocorrect--}}
@endpush