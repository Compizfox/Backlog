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

$gamelist = getGameList("orphaned");
$gamearray = array(array());
foreach ($gamelist as $label) {
	$row['label'] = $label;
	$row['category'] = "Orphaned";
	$gamearray[] = $row;
}

$gamelist = getGameList();
foreach ($gamelist as $label) {
	$row['label'] = $label;
	$row['category'] = "Already in database";
	if(!in_array(array('label' => $label, 'category' => 'Orphaned'), $gamearray)) $gamearray[] = $row;
}

$autocompletelist = json_encode($gamearray);

$script = "
<script>
	$.widget( 'custom.catcomplete', $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var that = this,
			currentCategory = '';
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( '<li class=\'ui-autocomplete-category\'>' + item.category + '</li>' );
					currentCategory = item.category;
				}
				that._renderItemData( ul, item );
			});
		}
	});

	$(function() {
		var availableTags = $autocompletelist;
		
		$('body').delegate('.autocomplete', 'focusin', function() {
			$( '.autocomplete' ).catcomplete({
				source: availableTags
			});
		});
	});
</script>";
?>

<script>
	window.onload = addInput;
	
	var i = 0;
	var j = new Array();
	
	function addInput() {
		var newdiv = document.createElement('div');
		newdiv.setAttribute('class', 'form-group');
		newdiv.setAttribute('id', i);
		newdiv.innerHTML = "<label class=\"col-sm-1 control-label\">Game:</label> <div class=\"col-md-3\"><input class=\"form-control autocomplete\" type=\"text\" name=\"game[" + i + "][name]\" required autofocus></div> <label class=\"col-sm-1 control-label\">Status:</label> <div class=\"col-md-2\"><select class=\"form-control\" name=\"game[" + i + "][status]\"><?=addslashes(getStatusOptions())?></select></div> <label class=\"col-sm-1 control-label\">Note:</label><div class=\"col-md-3\"> <input class=\"form-control\" type=\"text\" name=\"game[" + i + "][notes]\"></div><label class=\"col-sm-1 control-label\"><a onclick=\"addDLC(this)\"><span class=\"glyphicon glyphicon-plus-sign\"></span> DLC</a></label>";
		document.getElementById('dyn').appendChild(newdiv);
		j[i] = 0;
		i++;
	}
	
	function addDLC(caller) {
		var game = caller.parentNode.parentNode;
		var gameid = game.id;
		var newdiv = document.createElement('div');
		newdiv.setAttribute('class', 'form-group');
		newdiv.innerHTML = "<div class=\"col-md-1\"></div><label class=\"col-sm-1 control-label\">DLC:</label> <div class=\"col-md-2\"><input class=\"form-control\" type=\"text\" name=\"game[" + gameid + "][" + j[gameid] +"][name]\" required autofocus></div> <label class=\"col-sm-1 control-label\">Status:</label> <div class=\"col-md-2\"><select class=\"form-control\" name=\"game[" + gameid + "][" + j[gameid] +"][status]\"><?=addslashes(getStatusOptions())?></select></div> <label class=\"col-sm-1 control-label\">Note:</label><div class=\"col-md-3\"> <input class=\"form-control\" type=\"text\" name=\"game[" + gameid + "][" + j[gameid] +"][notes]\"></div>";
		game.parentNode.insertBefore(newdiv, game.nextSibling);
		j[gameid]++;
	}
</script>

<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Remember: </strong>If a game by the same name already exists, a copy will <b>not</b> be made. Instead, the existing game will be linked with the new purchase.</div>

<div class="well">
	<form class="form-horizontal" role="form" action="index.php?page=add" method="post">
		<fieldset>
			<legend>Purchase</legend>
			<div class="form-group">
				<label class="col-sm-2 control-label">Shop:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="shop" required autofocus></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Price:</label>
				<div class="col-md-2">
					<div class="input-group"><select style="width: 40px; padding-left: 1px; padding-right: 1px;" class="form-control" name="valuta"><option value="€">€</option><option value="$">$</option><option value="£">£</option></select><span class="input-group-addon"></span><input class="form-control" type="text" name="price"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Date:</label>
				<div class="col-md-2"><input class="form-control" type="date" name="date"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Note:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="note"></div>
			</div>	
		</fieldset>
		<fieldset id="dyn">
			<legend>Games</legend>
		</fieldset>
			<button class="btn btn-default" onclick="addInput()"><span class="glyphicon glyphicon-plus"></span> New game</button> <button class="btn btn-default" type="submit" name="submit">Submit</button>
	</form>
</div>
<?php
if(isset($_POST['submit'])) {
	$price = str_replace(",", ".", $_POST['price']);
	if($_POST['price'] == "") $price = NULL;
	
	$stmt = $mysqli->prepare("INSERT INTO purchase (shop, price, valuta, date, note) VALUES (?, ?, ?, ?, ?)") or die($mysqli->error);
	$stmt->bind_param("sdsss", $_POST['shop'], $price, $_POST['valuta'], $_POST['date'], $_POST['note']) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	$purchase_id = $mysqli->insert_id;
	
	$stmt = $mysqli->prepare("SELECT * FROM game WHERE name = ?") or die($mysqli->error);
	$stmt2 = $mysqli->prepare("INSERT INTO game (name, status_id, notes) VALUES (?, ?, ?)") or die($mysqli->error);
	$stmt3 = $mysqli->prepare("INSERT INTO xref_purchase_game VALUES (?, ?)") or die($mysqli->error);
	$stmt4 = $mysqli->prepare("INSERT INTO dlc (name, status_id, note, game_id) VALUES (?, ?, ?, ?)") or die($mysqli->error);
	foreach($_POST['game'] as $game) {
		$stmt->bind_param("s", $game['name']) or die($stmt->error);
		$stmt->execute() or die($stmt->error);
		$result = $stmt->get_result();

		if($entries = $result->fetch_assoc()) {
			$game_id = $entries['game_id'];
		} else {
			$stmt2->bind_param("sis", $game['name'], $game['status'], $game['notes']) or die($stmt2->error);
			$stmt2->execute() or die($stmt2->error);

			$game_id = $mysqli->insert_id;
		}
		
		$stmt3->bind_param("ii", $purchase_id, $game_id) or die($stmt3->error);
		$stmt3->execute() or die($stmt3->error);
		
		for($i = 0; $i < count(array_filter(array_keys($game),'is_numeric')); $i++) {
			$dlc = $game[$i];
			
			$stmt4->bind_param("sisi", $dlc['name'], $dlc['status'], $dlc['notes'], $game_id) or die($stmt4->error);
			$stmt4->execute() or die($stmt4->error);
		}
	}
}
?>
