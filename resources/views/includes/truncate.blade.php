{{--
	Filename:   truncate.blade.php
	Date:       2017-01-15
	Author:     Lars Veldscholte
	            lars@veldscholte.eu
	            http://lars.veldscholte.eu

	Copyright 2017 Lars Veldscholte

	This file is part of Backlog2_53.

	Backlog2_53 is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	Backlog2_53 is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with Backlog2_53. If not, see <http://www.gnu.org/licenses/>.
--}}

@extends('layouts.modal')

@section('title')
	Truncate database
@endsection

@section('body')
	Are you sure you want to truncate the whole database? All purchases, games, DLC and playthroughs will be deleted. This cannot be undone.
@endsection

@section('action')
	{{action('SettingsController@truncate')}}
@endsection