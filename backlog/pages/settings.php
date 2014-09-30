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

require_once("include/connect.php");
require_once("include/operations.php");

if(@$_GET['process'] == "hiddengames") {
	$stmt = $mysqli->prepare("UPDATE game SET hidden=0 WHERE game_id=?") or die($mysqli->error);
	
	foreach($_POST['checkedgames'] as $game) {
		$stmt->bind_param("i", $game) or die($stmt->error);
		$stmt->execute() or die($stmt->error);
	}
}

if(@$_GET['process'] == "statuses") {
	$stmt = $mysqli->prepare("INSERT INTO status VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name=?, completed=?, color=?") or die($mysqli->error);
	$stmt2 = $mysqli->prepare("DELETE FROM status WHERE status_id=?") or die($mysqli->error);
	
	$i = 0;
	foreach($_POST['id'] as $id) {
		$stmt->bind_param("isissis", $id, $_POST['name'][$i], $_POST['completed'][$i], $_POST['color'][$i], $_POST['name'][$i], $_POST['completed'][$i], $_POST['color'][$i]) or die($stmt->error);
		$stmt->execute() or die($stmt->error);
		$i++;
	}
	
	$query = "SELECT * FROM status";
	$result = $mysqli->query($query) or die($query);
	
	while($entries = $result->fetch_assoc()) {		
		if(!in_array($entries['status_id'], $_POST['id'])) {
			$stmt2->bind_param("i", $entries['status_id']);
			$stmt2->execute() or die($stmt2->error);
		}
	}
}

if(@$_GET['process'] == "dbops") {
	if(isset($_POST['truncate'])) {
		$query = "DELETE FROM xref_purchase_game; DELETE FROM purchase; DELETE FROM history; DELETE FROM dlc; DELETE FROM game;";
		$mysqli->query($query) or die($query);
	}

	if(isset($_POST['cleanup'])) {
		cleanEmptyPurchases();
	}
}
?>

<form class="panel panel-default" method="post" action="index.php?page=settings&amp;process=hiddengames">
	<div class="panel-heading">
		<h2>Hidden games</h2>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th><input type="checkbox" id="selectall" /></th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$query = "SELECT game_id, name FROM game WHERE hidden=1";
			$result = $mysqli->query($query);
			
			while($entries = $result->fetch_assoc()) {
				echo("<tr><td><input type=\"checkbox\" name=\"checkedgames[]\" value=\"{$entries['game_id']}\" /></td>");
				echo("<td>{$entries['name']}</td></tr>");
			}
			?>
		</tbody>
	</table>
	<div class="panel-footer">
		<button class="btn btn-default" type="submit" name="submit">Unhide</button>
	</div>
</form>

<form class="panel panel-default" method="post" action="index.php?page=settings&amp;process=statuses">
	<div class="panel-heading">
		<h2>Statuses</h2>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Status</th>
				<th>Color</th>
				<th>Completed</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="dyn">
			<?php
			$query = "SELECT * FROM status";
			$result = $mysqli->query($query) or die($query);
			
			while($entries = $result->fetch_assoc()) {
				if($entries['completed'] == 1) {
					$completed = "checked";
				} else {
					$completed = "";
				}
				
				echo("<tr><td><input type=\"number\" class=\"form-control\" name=\"id[]\" value=\"{$entries['status_id']}\" min=\"0\" required /></td>\n");
				echo("<td><input type=\"text\" class=\"form-control\" name=\"name[]\" value=\"{$entries['name']}\" required /></td>\n");
				echo("<td><input type=\"color\" class=\"form-control\" name=\"color[]\" value=\"{$entries['color']}\" required /></td>\n");
				echo("<td><input type=\"hidden\" value=\"0\" name=\"completed[]\" /><input type=\"checkbox\" value=\"1\" $completed /></td>\n");
				echo("<td><a href=\"#\" onclick=\"removeRow(this); return false;\"><span class=\"glyphicon glyphicon-trash\"></span></a></td></tr>\n");
			}
			?>
		</tbody>
	</table>
	<div class="panel-footer">
		<button class="btn btn-default" type="button" onclick="addRow()"><span class="glyphicon glyphicon-plus"></span> New status</button>
		<button class="btn btn-default" type="submit" name="submit" onclick="checkboxes()">Submit</button>
	</div>
</form>

<form class="panel panel-default" method="post" action="index.php?page=settings&amp;process=dbops">
	<div class="panel-heading">
		<h2>Database operations</h2>
	</div>
	<div class="panel-body">
		<button class="btn btn-default" type="submit" name="truncate">Truncate database</button>
		<button class="btn btn-default" type="submit" name="cleanup">Cleanup database (remove empty purchases)</button>
	</div>
</form>