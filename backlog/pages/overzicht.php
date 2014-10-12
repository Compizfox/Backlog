<?php
/*
	Date:	2014-05-25
    Author:	Lars Veldscholte
			lars@veldscholte.eu
			http://lars.veldscholte.eu

    Copyright 2014 Lars Veldscholte

    This file is part of Backlog.

    Backlog is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Backlog is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Backlog. If not, see <http://www.gnu.org/licenses/>.
*/

require_once("include/classes.php");
require_once("include/connect.php");

$query = "SELECT COUNT(*) FROM purchase";
$result = $mysqli->query($query) or die($query);
$numpurchases = $result->fetch_array(MYSQLI_NUM)[0];

$query = "SELECT COUNT(*) FROM purchase WHERE price=0";
$result = $mysqli->query($query) or die($query);
$numfreepurchases = $result->fetch_array(MYSQLI_NUM)[0];

$query = "SELECT COUNT(*) FROM game";
$result = $mysqli->query($query) or die($query);
$numgames = $result->fetch_array(MYSQLI_NUM)[0];

$query = "SELECT COUNT(*) FROM dlc";
$result = $mysqli->query($query) or die($query);
$numdlc = $result->fetch_array(MYSQLI_NUM)[0];

$query = "SELECT COUNT(*) FROM game JOIN status USING(status_id) WHERE completed=1";
$result = $mysqli->query($query) or die($query);
$numcompletedgames = $result->fetch_array(MYSQLI_NUM)[0];

$query = "SELECT COUNT(*) FROM game JOIN status USING(status_id) WHERE completed=0";
$result = $mysqli->query($query) or die($query);
$numuncompletedgames = $result->fetch_array(MYSQLI_NUM)[0];

// Piechart games
$canvasstring = "";
$script = "<script>var ctx = document.getElementById(\"chart\").getContext(\"2d\"); var data = [";

$query = "SELECT COUNT(*) FROM game";
$result = $mysqli->query($query) or die($query);
$total = $result->fetch_row()[0];

$query = "SELECT status.name, COUNT(*) as count, color FROM game JOIN status USING(status_id) GROUP BY status_id";
$result = $mysqli->query($query) or die($query);

$i = 1;
while($row = $result->fetch_assoc()) {
	$share = round($row['count'] / $total * 100);
	$canvasstring .= "<tr><td style=\"background-color: {$row['color']};\">{$row['name']}</td><td style=\"background-color: {$row['color']};\">$share%</td>";
	$script .= "{value: $share, color: \"{$row['color']}\" }";
	if($i != $result->num_rows) $script .= ",";
	$i++;
}

$script .= "]; var myNewChart = new Chart(ctx).Pie(data);</script>";

// Piechart DLC
$canvasstring2 = "";
$script .= "<script>var ctx = document.getElementById(\"chart2\").getContext(\"2d\"); var data = [";

$query = "SELECT COUNT(*) FROM dlc";
$result = $mysqli->query($query) or die($query);
$total = $result->fetch_row()[0];

$query = "SELECT status.name, COUNT(*) as count, color FROM dlc JOIN status USING(status_id) GROUP BY status_id";
$result = $mysqli->query($query) or die($query);

$i = 1;
while($row = $result->fetch_assoc()) {
	$share = round($row['count'] / $total * 100);
	$canvasstring2 .= "<tr><td style=\"background-color: {$row['color']};\">{$row['name']}</td><td style=\"background-color: {$row['color']};\">$share%</td>";
	$script .= "{value: $share, color: \"{$row['color']}\" }";
	if($i != $result->num_rows) $script .= ",";
	$i++;
}

$script .= "]; var myNewChart = new Chart(ctx).Pie(data);</script>";


// Shops
$canvasstring3 = "";

$query = "SELECT shop, COUNT(*) as count FROM game JOIN xref_purchase_game USING(game_id) JOIN purchase USING(purchase_id) GROUP BY shop ORDER BY count DESC LIMIT 20";
$result = $mysqli->query($query) or die($query);

$i = 1;
while($row = $result->fetch_assoc()) {
	$share = round($row['count'] / $numgames * 100);
	$canvasstring3 .= "<tr><td>{$row['shop']}</td><td>$share%</td>";
}
?>

<div class="row">
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numpurchases?></h1>
			<p>Number of purchases made</p>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numgames?></h1>
			<p>Number of games in library</p>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numdlc?></h1>
			<p>Number of DLC in library</p>
		</div>
	</div><div class="clearfix visible-lg"></div>
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numcompletedgames?></h1>
			<p>Number of completed games</p>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numfreepurchases?></h1>
			<p>Number of free purchases</p>
		</div>
	</div>
	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox">
			<h1 style="font-size: 1000%;"><?=$numuncompletedgames?></h1>
			<p>Number of uncompleted games</p>
		</div><div class="clearfix visible-lg"></div>
	</div>

	<div class="col-lg-4 col-md-6">
		<div class="jumbotron statbox" style="height: 900px">
			<p>Status breakdown for games</p>
			<div style="height: 350px">
				<table class="table"><tr><th>Status</th><th>Share</th></tr>
					<?=$canvasstring?>
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
					<?=$canvasstring2?>
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
					<?=$canvasstring3?>
				</table>
			</div>
			<canvas id="chart3" width="400" height="400"></canvas>
		</div><div class="clearfix visible-lg"></div>
	</div>
</div>
