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

if(isset($_POST['formsubmit'])) {
	if(@$_POST['submitbtn'] == "delete") {
		foreach(@$_POST['checkedpurchases'] as $purchase) {
			deletePurchase($purchase);
		}
		
		foreach(@$_POST['checkedgames'] as $game) {
			deleteGame($game);
		}
		
		foreach(@$_POST['checkeddlc'] as $dlc) {
			deleteDLC($dlc);
		}
	} elseif(@$_POST['submitbtn'] == "hide") {
		$stmt = $mysqli->prepare("UPDATE game SET hidden=1 WHERE game_id=?") or die($mysqli->error);
		
		foreach($_POST['checkedgames'] as $game) {
			$stmt->bind_param("i", $game) or die($stmt->error);
			$stmt->execute() or die($stmt->error);
		}
	} elseif($_POST['status'] != "") {
		if(isset($_POST['checkedgames'])) {
			foreach($_POST['checkedgames'] as $game) {
				$query = "SELECT status_id FROM game WHERE game_id=$game";
				$result = $mysqli->query($query) or die($query);
				$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
				$newstatus = $_POST['status'];

				$query = "INSERT INTO history (game_id, old_status, new_status, date) VALUES ($game, $oldstatus, $newstatus, CURDATE())";
				$mysqli->query($query) or die($query);

				$query = "UPDATE game SET status_id=$newstatus WHERE game_id=$game";
				$mysqli->query($query) or die($query);
			}
		}

		if(isset($_POST['checkeddlc'])) {
			foreach($_POST['checkeddlc'] as $dlc) {
				$query = "SELECT status_id FROM dlc WHERE dlc_id=$dlc";
				$result = $mysqli->query($query) or die($query);
				$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
				$newstatus = $_POST['status'];

				$query = "INSERT INTO history (dlc_id, old_status, new_status, date) VALUES ($dlc, $oldstatus, $newstatus, CURDATE())";
				$mysqli->query($query) or die($query);

				$query = "UPDATE dlc SET status_id={$_POST['status']} WHERE dlc_id=$dlc";
				$mysqli->query($query) or die($query);
			}
		}
		echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Status(es) updated.</strong></div>");
	}
}

switch(@$_GET['delete']) {
	case "purchase":
		deletePurchase($_GET['purchase']);
		break;
		
	case "game":
		deleteGame($_GET['game'], $_GET['purchase']);
		break;
		
	case "dlc":
		deleteDLC($_GET['dlc']);
		break;
		
	default:
		break;
}

function deletePurchase($purchaseid) {
	global $mysqli;
	
	$query = "DELETE FROM xref_purchase_game WHERE purchase_id=$purchaseid";
	$mysqli->query($query) or die($query);
	
	$query = "DELETE FROM purchase WHERE purchase_id=$purchaseid";
	$mysqli->query($query) or die($query);
	
	echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Purchase deleted. To add the reamaining games to a new purchase, add one and add the games with exactly the same names.</strong></div>");
}

function deleteGame($gameid, $purchaseid=NULL) {
	global $mysqli;
	
	if(isset($purchaseid)) {
		$query = "DELETE FROM xref_purchase_game WHERE game_id=$gameid AND purchase_id=$purchaseid";
		$mysqli->query($query) or die($query);
	} else {
		$query = "DELETE FROM xref_purchase_game WHERE game_id=$gameid";
		$mysqli->query($query) or die($query);
		
		$query = "DELETE FROM dlc WHERE game_id=$gameid";
		$mysqli->query($query) or die($query);
		
		$query = "DELETE FROM game WHERE game_id=$gameid";
		$mysqli->query($query) or die($query);
	}
	
	cleanEmptyPurchases();
	
	echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Game(s) deleted.</strong></div>");
}

function deleteDLC($dlcid, $purchaseid=NULL) {
	global $mysqli;

	if(isset($purchaseid)) {
		$query = "DELETE FROM xref_purchase_dlc WHERE dlc_id=$dlcid AND purchase_id=$purchaseid";
		$mysqli->query($query) or die($query);
	} else {
		$query = "DELETE FROM xref_purchase_dlc WHERE dlc_id=$dlcid";
		$mysqli->query($query) or die($query);

		$query = "DELETE FROM dlc WHERE dlc_id=$dlcid";
		$mysqli->query($query) or die($query);
	}

	cleanEmptyPurchases();
	
	echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>DLC deleted.</strong></div>");
}

function cleanEmptyPurchases() {
	global $mysqli;

	$query = "SELECT * FROM xref_purchase_dlc RIGHT JOIN purchase USING(purchase_id) LEFT JOIN xref_purchase_game USING(purchase_id) WHERE game_id IS NULL AND dlc_id IS NULL";
	$result = $mysqli->query($query) or die($query);
	if($result->num_rows > 0) {
		$query = "DELETE FROM purchase WHERE purchase_id IN (SELECT purchase_id FROM xref_purchase_dlc RIGHT JOIN (SELECT * FROM purchase) AS a USING(purchase_id) LEFT JOIN xref_purchase_game USING(purchase_id) WHERE game_id IS NULL AND dlc_id IS NULL)";
		$mysqli->query($query) or die($query);

		echo("<div class=\"alert alert-info alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Deleted empty purchase(s).</strong></div>");
	}
}

?>
