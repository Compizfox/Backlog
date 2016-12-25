{{--
	Filename:   top_menu.blade.php
	Date:       2016-08-01
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

<li class="{{Request::is('purchases/create') ? 'active' : ''}}">
	<a href="{{url('purchases/create')}}"><span class="glyphicon glyphicon-plus"></span> Add purchase</a>
</li>
<li class="{{Request::is('playthroughs/create') ? 'active' : ''}}">
	<a href="{{url('playthroughs/create')}}"><span class="glyphicon glyphicon-plus"></span> Add playthrough</a>
</li>
<li class="dropdown{{Request::is('steam/*') ? 'active' : ''}}">
	<a class="dropdown-toggle clickable" data-toggle="dropdown"><span class="glyphicon fa fa-steam"></span> Steam</a>
	<ul class="dropdown-menu">
		<li><a href="{{url('steam/sync')}}"><span class="glyphicon glyphicon-link"></span> Link games with Steam</a></li>
		<li><a href="{{url('steam/import')}}"><span class="glyphicon glyphicon-import"></span> Import games from Steam</a></li>
		<li><a href="{{url('steam/update')}}"><span class="glyphicon glyphicon-time"></span> Update playtime, icons and logos</a></li>
		<li><a href="{{url('steam/refreshuserstats')}}"><span class="glyphicon glyphicon-refresh"></span> Refresh user stats</a></li>
	</ul>
</li>
<li class="{{Request::is('settings') ? 'active' : ''}}">
	<a href="{{url('settings')}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
</li>