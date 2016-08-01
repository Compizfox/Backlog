{{--
	Filename:   master.blade.php
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="application-name" content="Backlog">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.6/slate/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel="stylesheet">
	<link href="{{asset('stylesheet.css')}}" rel="stylesheet">
	@stack('links')

	<title>Backlog</title>
</head>

<body>
	<header>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="h1">Backlog <small>The ultimate game database</small></div>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						@include('includes.top_menu')
					</ul>
					<form class="navbar-form navbar-right" action="index.php" method="get">
						<input type="text" name="query" class="form-control" placeholder="Search...">
						<input type="hidden" name="page" value="search">
					</form>
				</div>
			</div>
		</nav>
	</header>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					@include('includes.side_menu')
				</ul>
				<!-- Steam widget -->
			</nav>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				@include('includes.errors')
				@include('includes.status')
				@yield('content')
			</div>
		</div>
	</div>

	<footer class="navbar navbar-fixed-bottom">
		<p class="text-center"><a href="https://github.com/Compizfox/Backlog">Made by Lars Veldscholte</a></p>
	</footer>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
	@stack('scripts')
</body>
</html>
