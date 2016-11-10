{{--
	Filename:   summary.blade.php
	Date:       2016-08-07
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
	<div class="jumbotron statbox">
		<p>Completion history</p>
		<canvas id="completionChart" style="width: 100%;" width="1400" height="400"></canvas>
		<br>
		<span>Number of finished playthroughs per month</span>
	</div>

	<div class="jumbotron statbox">
		<p>Purchase history</p>
		<canvas id="purchaseChart" style="width: 100%;" width="1400" height="400"></canvas>
		<br>
		<span>Number of games/DLC purchased per month</span>
	</div>

	<div class="row">
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;">{{$purchaseCount}}</h1>
				<p>Number of purchases made</p>
			</div>
		</div>

		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;">{{$gameCount}}</h1>
				<p>Number of games in library</p>
			</div>
		</div>

		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;">{{$dlcCount}}</h1>
				<p>Number of DLC in library</p>
			</div>
		</div><div class="clearfix visible-lg"></div>

		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<p>Statuses</p>
				<div style="height: 400px;">
					<canvas id="statusChart"></canvas>
				</div>
				<br>
				<span>Status share for games/DLC</span>
			</div>
		</div>

		<div class="col-lg-8 col-md-12">
			<div class="jumbotron statbox">
				<p>Shops</p>
				<div style="height: 400px;">
					<canvas id="shopChart"></canvas>
				</div>
				<br>
				<span>Shop share for games/DLC</span>
			</div><div class="clearfix visible-lg"></div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
	<script>
		chartOptions = {
			responsive: true,
			legend: {
				display: false
			},
			scales: {
				xAxes: [{
					type: "time",
					categoryPercentage: 0.3
				}],
				yAxes: [{
					type: "linear",
					ticks: {
						min: 0
					},
					scaleLabel: {
						display: true,
						labelString: "# per month"
					},
					gridLines: {
						display: false
					}
				}]
			}
		};

		var ctx = document.getElementById("completionChart").getContext("2d");
		$.getJSON('{{action('StatisticsController@getPlaythroughs')}}', function(chartdata) {
			chartdata.datasets[0].backgroundColor = '#5bc0de';
			chartdata.datasets[0].hoverBackgroundColor = '#BAEAF8';

			var myBarChart = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				options: chartOptions
			});
		});

		var ctx2 = document.getElementById("purchaseChart").getContext("2d");
		$.getJSON('{{action('StatisticsController@getPurchases')}}', function(chartdata) {
			chartdata.datasets[0].backgroundColor = '#5bc0de';
			chartdata.datasets[0].hoverBackgroundColor = '#BAEAF8';

			var myBarChart = new Chart(ctx2, {
				type: 'bar',
				data: chartdata,
				options: chartOptions
			});
		});

		var ctx3 = document.getElementById("statusChart").getContext("2d");
		$.getJSON('{{action('StatisticsController@getStatusShare')}}', function(chartdata) {
			chartdata.datasets[0].borderWidth = 0;
			var myDoughnutChart = new Chart(ctx3, {
				type: 'doughnut',
				data: chartdata,
				options: {
					maintainAspectRatio: false
				}
			});
		});

		var ctx4 = document.getElementById("shopChart").getContext("2d");
		$.getJSON('{{action('StatisticsController@getShopShare')}}', function(chartdata) {
			chartdata.datasets[0].borderWidth = 0;

			// Automatic colours
			chartdata.datasets[0].backgroundColor = chartdata.datasets[0].data.map(function(v, i, a) {
				return 'hsl(' + Math.floor(360 * i / a.length) + ', 100%, 50%)';
			});

			var myDoughnutChart = new Chart(ctx4, {
				type: 'doughnut',
				data: chartdata,
				options: {
					maintainAspectRatio: false,
					legend: {
						position: 'left'
					}
				}
			});
		});
	</script>
@endpush