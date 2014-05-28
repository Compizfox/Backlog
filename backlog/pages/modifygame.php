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

$result = $mysqli->query("SELECT game_id, game.name, status_id, completed, notes as note, appid, playtime, appid_lock, hidden FROM game JOIN status USING (status_id) WHERE game_id={$_GET['id']}");
$data = $result->fetch_assoc();

if($data['appid_lock'] == 1) {
	$appidlock = "checked";
} else {
	$appidlock = "";
}
if($data['hidden'] == 1) {
	$hidden = "checked";
} else {
	$hidden = "";
}

if(isset($_POST['submit'])) {
	$query = "SELECT status_id FROM game WHERE game_id={$_GET['id']}";
	$result = $mysqli->query($query) or die($query);
	$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
	$newstatus = $_POST['status'];
	
	if($oldstatus != $newstatus) {
		$query = "INSERT INTO history (game_id, old_status, new_status, date) VALUES ({$_GET['id']}, $oldstatus, $newstatus, CURDATE())";
		$mysqli->query($query) or die($query);
	}
	
	$playtime = $_POST['playtime'] * 60;
	
	if(isset($_POST['appidlock'])) {
		$appid_lock = 1;
	} else {
		$appid_lock = 0;
	}
	if(isset($_POST['hidden'])) {
		$hidden = 1;
	} else {
		$hidden = 0;
	}
	
	$stmt = $mysqli->prepare("UPDATE game SET name=?, status_id=?, notes=?, appid=?, playtime=?, appid_lock=?, hidden=? WHERE game_id=?") or die($mysqli->error);
	$stmt->bind_param("sisiiiii", $_POST['name'], $_POST['status'], $_POST['note'], $_POST['appid'], $playtime, $appid_lock, $hidden, $_GET['id']) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	header("Location: index.php?page=games&scope=all&message=gameedited");
}
?>

<div class="well">
	<form class="form-horizontal" role="form" action="<?=htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Name:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="name" value="<?=$data['name']?>" required autofocus></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Status:</label>
				<div class="col-md-4"><select class="form-control" name="status"><?=getStatusOptions()?></select></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Steam appid:</label>
				<div class="col-md-1"><input class="form-control" type="text" name="appid" value="<?=$data['appid']?>"></div>
				<div class="col-md-3 checkbox"><label><input name="appidlock" type="checkbox" <?=$appidlock?>>Don't automatically overwrite appid</label></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Playtime (hours):</label>
				<div class="col-md-4"><input class="form-control" type="text" name="playtime" value="<?=$data['playtime'] / 60?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Note:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="note" value="<?=$data['note']?>"></div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-4">
					<div class="checkbox"><label><input name="hidden" type="checkbox" <?=$hidden?>>Hidden</label></div>
				</div>
			</div>
		</fieldset>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-4">
				<button class="btn btn-default" type="submit" name="submit">Submit</button>
			</div>
		</div>
	</form>
</div>
