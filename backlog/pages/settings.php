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

if(@$_GET['process'] == "hiddengames") {
	$stmt = $mysqli->prepare("UPDATE game SET hidden=0 WHERE game_id=?") or die($mysqli->error);
	
	foreach($_POST['checkedgames'] as $game) {
		$stmt->bind_param("i", $game) or die($stmt->error);
		$stmt->execute() or die($stmt->error);
	}
}
?>

<form class="panel panel-default" method="post" action="index.php?page=settings&process=hiddengames">
	<div class="panel-heading">
		<h2>Hidden games</h2>
	</div>
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th><input type="checkbox" id="selectall" /> unhide</th>
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
		<button class="btn btn-default" type="submit" name="submit">Submit</button>
	</div>
</form>