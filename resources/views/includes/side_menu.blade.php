{{--
	Filename:   side_menu.blade.php
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

<li class="{{Request::is('/') ? 'active' : ''}}">
	<a href="{{url('/')}}"><span class="glyphicon glyphicon-stats"></span> Summary</a>
</li>
<li class="{{Request::is('playthroughs') ? 'active' : ''}}">
	<a href="{{url('playthroughs')}}"><span class="glyphicon fa fa-history"></span> Playthroughs</a>
</li>
<li class="{{Request::is('purchases') ? 'active' : ''}}">
	<a href="{{url('purchases')}}"><span class="glyphicon glyphicon-shopping-cart"></span> Purchases</a>
</li>
<li class="{{Request::is('games') ? 'active' : ''}}">
	<a href="{{url('games')}}"><span class="glyphicon glyphicon-play"></span> Games</a>
	<ul class="nav">
		<li class="{{Request::is('games?completion=0') ? 'active' : ''}}">
			<a href="{{url('games?completion=0')}}"><span class="glyphicon glyphicon-exclamation-sign"></span> Uncompleted games</a>
		</li>
		<li class="{{Request::is('games?completion=1') ? 'active' : ''}}">
			<a href="{{url('games?completion=1')}}"><span class="glyphicon glyphicon-ok-sign"></span> Completed games</a>
		</li>
		<li class="{{Request::is('games?purchases=0') ? 'active' : ''}}">
			<a href="{{url('games?purchases=0')}}"><span class="glyphicon fa fa-chain-broken"></span> Orphaned games</a>
		</li>
	</ul>
</li>
<li class="{{Request::is('dlc') ? 'active' : ''}}">
	<a href="{{url('dlc')}}"><span class="glyphicon glyphicon-download"></span> DLC</a>
	<ul class="nav">
		<li class="{{Request::is('dlc?completion=0') ? 'active' : ''}}">
			<a href="{{url('dlc?completion=0')}}"><span class="glyphicon glyphicon-exclamation-sign"></span> Uncompleted DLC</a>
		</li>
		<li class="{{Request::is('dlc?completion=1') ? 'active' : ''}}">
			<a href="{{url('dlc?completion=1')}}"><span class="glyphicon glyphicon-ok-sign"></span> Completed DLC</a>
		</li>
	</ul>
</li>