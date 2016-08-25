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
		<canvas id="CompletionChart" style="width: 100%;" width="1400" height="400"></canvas>
	</div>

	<div class="jumbotron statbox">
		<p>Purchase history</p>
		<canvas id="purchaseChart" style="width: 100%;" width="1400" height="400"></canvas>
		<br>
		<span>Number of games purchased per month</span>
	</div>

	<div class="row">
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of purchases made</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of games in library</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of DLC in library</p>
			</div>
		</div><div class="clearfix visible-lg"></div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of completed games</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of free purchases</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox">
				<h1 style="font-size: 1000%;"></h1>
				<p>Number of uncompleted games</p>
			</div><div class="clearfix visible-lg"></div>
		</div>

		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox" style="height: 900px">
				<p>Status breakdown for games</p>
				<div style="height: 350px">
					<table class="table"><tr><th>Status</th><th>Share</th></tr>

					</table>
				</div>
				<canvas id="chart" style="width: 100%;" width="400" height="400"></canvas>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox" style="height: 900px">
				<p>Status breakdown for DLC</p>
				<div style="height: 350px">
					<table class="table"><tr><th>Status</th><th>Share</th></tr>

					</table>
				</div>
				<canvas id="chart2" width="400" height="400"></canvas>
			</div>
		</div>
		<div class="col-lg-4 col-md-6">
			<div class="jumbotron statbox" style="height: 900px">
				<p>Shop breakdown</p>
				<div style="height: 350px">
					<table class="table"><tr><th>Shop</th><th>Share</th></tr>

					</table>
				</div>
				<canvas id="chart3" width="400" height="400"></canvas>
			</div><div class="clearfix visible-lg"></div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.1/Chart.bundle.min.js"></script>
	<script>
		var ctx = document.getElementById("purchaseChart").getContext("2d");

		$.getJSON('{{action('StatisticsController@getPurchases')}}', function(chartdata) {
			chartdata.datasets[0].backgroundColor = 'rgba(151,187,205,0.2)';
			chartdata.datasets[0].borderColor = 'rgba(151,187,205,1)';
			chartdata.datasets[0].hoverBackgroundColor = 'rgba(220,220,220,1)';
			chartdata.datasets[0].hoverBorderColor = 'rgba(220,220,220,1)';

			console.log(chartdata);

			var myBarChart = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				options: {
					responsive: true,
					scales: {
						xAxes: [{
							type: "time",
							time: {
								format: 'YYYY-MM'
							}
						}],
						yAxes: [{
							type: "linear",
							ticks: {
								min: 0
							},
							scaleLabel: {
								display: true,
								labelString: "Games per month"
							},
							gridLines: {
								display: false
							}
						}]
					}
				}
			});
		});
	</script>
@endpush