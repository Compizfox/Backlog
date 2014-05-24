<?php
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
					<div class="input-group"><select style="width: 40px; padding-left: 1px; padding-right: 1px;" class="form-control" name="valuta"><option value="$">$</option><option value="€">€</option></select><span class="input-group-addon"></span><input class="form-control" type="text" name="price"></div>
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
	$query = "INSERT INTO purchase (shop, price, valuta, date, note) VALUES ('{$_POST['shop']}', {$_POST['price']}, '{$_POST['valuta']}', '{$_POST['date']}', '{$_POST['note']}')";
	$mysqli->query($query) or die($query);
	$purchase_id = $mysqli->insert_id;

	foreach($_POST['game'] as $game) {
		$query = "SELECT * FROM game WHERE name = '{$game['name']}'";
		$result = $mysqli->query($query) or die($query);
		if($entries = $result->fetch_assoc()) {
			$game_id = $entries['game_id'];
		} else {
			$query = "INSERT INTO game (name, status_id, notes) VALUES ('{$game['name']}', {$game['status']}, '{$game['notes']}')";
			$mysqli->query($query) or die($query);
			$game_id = $mysqli->insert_id;
		}

		$query = "INSERT INTO xref_purchase_game VALUES ($purchase_id, $game_id)";
		$mysqli->query($query) or die($query);
		
		for($i = 0; $i < count(array_filter(array_keys($game),'is_numeric')); $i++) {
			$dlc = $game[$i];
			$query = "INSERT INTO dlc (name, status_id, note, game_id) VALUES ('{$dlc['name']}', {$dlc['status']}, '{$dlc['notes']}', $game_id)";
			$mysqli->query($query) or die($query);
		}
	}
	
	SteamApiRequest(TRUE, TRUE, TRUE);
}
?>