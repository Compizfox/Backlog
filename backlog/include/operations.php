<?php
require_once "include/classes.php";

if(isset($_POST['formsubmit'])) {
	if($_POST['submit'] == "delete") {
		foreach(@$_POST['checkedpurchases'] as $purchase) {
			deletePurchase($purchase);
		}
		foreach(@$_POST['checkedgames'] as $game) {
			deleteGame($game);
		}
		foreach(@$_POST['checkeddlc'] as $dlc) {
			deleteDLC($dlc);
		}
		
	} elseif($_POST['status'] != "") {
		foreach(@$_POST['checkedgames'] as $game) {
			$query = "SELECT status_id FROM game WHERE game_id=$game";
			$result = $mysqli->query($query) or die($query);
			$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
			$newstatus = $_POST['status'];
			
			$query = "INSERT INTO history (game_id, old_status, new_status) VALUES ($game, $oldstatus, $newstatus)";
			$mysqli->query($query) or die($query);
			
			$query = "UPDATE game SET status_id=$newstatus WHERE game_id=$game";
			$mysqli->query($query) or die($query);
		}
	
		foreach(@$_POST['checkeddlc'] as $dlc) {
			$query = "SELECT status_id FROM dlc WHERE dlc_id=$dlc";
			$result = $mysqli->query($query) or die($query);
			$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
			$newstatus = $_POST['status'];
			
			$query = "INSERT INTO history (dlc_id, old_status, new_status) VALUES ($dlc, $oldstatus, $newstatus)";
			$mysqli->query($query) or die($query);
			
			$query = "UPDATE dlc SET status_id={$_POST['status']} WHERE dlc_id=$dlc";
			$mysqli->query($query) or die($query);
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
	
	// check for empty purchases
	$query = "SELECT * FROM purchase LEFT JOIN xref_purchase_game USING(purchase_id) WHERE xref_purchase_game.purchase_id=NULL";
	$result = $mysqli->query($query) or die($query);
	if($result->num_rows > 0) {
		$query = "DELETE FROM purchase where purchase_id IN (SELECT purchase_id FROM (SELECT * FROM purchase) AS a LEFT JOIN xref_purchase_game USING(purchase_id) WHERE xref_purchase_game.purchase_id=NULL)";
		$mysqli->query($query) or die($query);
		
		echo("<div class=\"alert alert-info alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Deleted empty purchase(s).</strong></div>");
	}
	
	echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>Game(s) deleted.</strong></div>");
}

function deleteDLC($dlcid) {
	global $mysqli;
	
	$query = "DELETE FROM dlc WHERE dlc_id=$dlcid";
	$mysqli->query($query) or die($query);
	
	echo("<div class=\"alert alert-success alert-dismissable fade in\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><strong>DLC deleted.</strong></div>");
}

?>