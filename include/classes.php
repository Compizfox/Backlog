<?php
require_once "config.php";
class game {
	private $id, $name, $status, $completed, $notes, $color, $purchase;

	function __construct($id, $name, $status, $completed, $notes, $color, $purchase=NULL) {
		$this->setData($id, $name, $status, $completed, $notes, $color, $purchase);
	}

	private function getColor() {
		return $this->color;
	}

	public function setData($id, $name, $status, $completed, $notes, $color, $purchase) {
		$this->id = $id;
		$this->name = $name;
		$this->status = $status;
		$this->completed = $completed;
		$this->notes = $notes;
		$this->color = $color;
		$this->purchase = $purchase;
	}

	public function drawRow($beginrow = 1) {
		global $currenturl;
		
		$string = "";
		if($beginrow) $string .= ("<tr>");
		$string .= "<td>{$this->name}</td>";
		$string .= "<td style=\"background-color: #{$this->getColor()}\">{$this->status}</td>";
		$string .= "<td>{$this->notes}</td><td>";
		if(!isset($this->purchase)) $string .= "<input type=\"checkbox\" name=\"checkedgames[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;";
		$string .= "<a href=\"index.php?page=modifygame&id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&delete=game&game={$this->id}";
		if(isset($this->purchase)) $string .= "&purchase=" . $this->purchase;
		$string .= "\"><span class=\"glyphicon glyphicon-trash\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=dlc&scope=game&game={$this->id}\"><span class=\"glyphicon glyphicon-download\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
}

class dlc {
	private $id, $name, $status, $completed, $notes, $color;

	function __construct($id, $name, $status, $completed, $notes, $color, $game=NULL, $purchase=NULL) {
		$this->setData($id, $name, $status, $completed, $notes, $color, $game, $purchase);
	}

	private function getColor() {
		return $this->color;
	}

	public function setData($id, $name, $status, $completed, $notes, $color, $game, $purchase) {
		$this->id = $id;
		$this->name = $name;
		$this->status = $status;
		$this->completed = $completed;
		$this->notes = $notes;
		$this->color = $color;
		$this->game = $game;
		$this->purchase = $purchase;
	}

	public function drawRow() {
		global $currenturl;
		$string = "";
		$string .= "<tr>";
		$string .= "<td>{$this->name}</td>";
		$string .= "<td>{$this->game}</td>";
		$string .= "<td style=\"background-color: #{$this->getColor()}\">{$this->status}</td>";
		$string .= "<td>{$this->notes}</td>";
		$string .= "<td><input type=\"checkbox\" name=\"checkeddlc[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifydlc&id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&delete=dlc&dlc={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
	
	public function drawSubRow() {
		global $currenturl;
		$string = "";
		$string .= "<tr class=\"dlc\">";
		$string .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;{$this->name}</td>";
		$string .= "<td style=\"background-color: #{$this->getColor()}\">{$this->status}</td>";
		$string .= "<td>{$this->notes}</td><td>";
		if(!isset($this->purchase)) $string .= "<input type=\"checkbox\" name=\"checkeddlc[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;";
		$string .= "<a href=\"index.php?page=modifydlc&id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&delete=dlc&dlc={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
}

class listGames {
	private $condition, $query, $query2;
	
	public function setCondition($condition) {
		$this->condition = "WHERE " . $condition;
	}

	public function drawTable() {
		global $mysqli;
		$string = "";
		
		$this->query = "SELECT purchase_id, game.game_id, game.name, status.name AS status, status.completed, game.notes, status.color FROM purchase JOIN xref_purchase_game USING(purchase_id) RIGHT JOIN game USING(game_id) JOIN status USING(status_id) {$this->condition} GROUP BY game.name ORDER BY game.game_id";
		$this->query2 = "SELECT dlc.dlc_id, dlc.name, status.name AS status, status.completed, dlc.note, status.color FROM dlc JOIN status USING (status_id)";
		$result = $mysqli->query($this->query);

		while($entries = $result->fetch_assoc()) {
			$game = new game($entries['game_id'], $entries['name'], $entries['status'], $entries['completed'], $entries['notes'], $entries['color']);
			$string .= $game->drawRow();

			$game_id = $entries['game_id'];
			$result2 = $mysqli->query($this->query2 . " WHERE dlc.game_id='$game_id'");
			while($entries2 = $result2->fetch_assoc()) {
				$dlc = new dlc($entries2['dlc_id'], $entries2['name'], $entries2['status'], $entries2['completed'], $entries2['note'], $entries2['color']);
				$string .= $dlc->drawSubRow();
			}
		}
		return $string;
	}
}

class listDLC {
	private $query;
	
	function __construct() {
		$this->query = "SELECT dlc.dlc_id, dlc.name, status.name AS status, status.completed, dlc.note, status.color, game.name AS game FROM game JOIN dlc USING(game_id) JOIN status ON dlc.status_id=status.status_id";
	}
	
	public function setCondition($condition) {
		$this->query .= " WHERE " . $condition;
	}
	
	public function drawTable() {
		global $mysqli;
		$string = "";
		
		$result = $mysqli->query($this->query);
		while($entries = $result->fetch_assoc()) {
			$dlc = new dlc($entries['dlc_id'], $entries['name'], $entries['status'], $entries['completed'], $entries['note'], $entries['color'], $entries['game']);
			$string .= $dlc->drawRow();
		}
		
		return $string;
	}
}

class listPurchases {
	private $query, $query2, $query3;

	function __construct() {
		$this->query = "SELECT * FROM purchase";
		$this->query2 = "SELECT game.game_id, game.name, game.notes, status.name AS status, status.completed, status.color FROM purchase JOIN xref_purchase_game USING (purchase_id) JOIN game USING (game_id) JOIN status USING (status_id)";
		$this->query3 = "SELECT dlc.dlc_id, dlc.name, status.name AS status, status.completed, dlc.note, status.color FROM game JOIN dlc USING (game_id) JOIN status on dlc.status_id=status.status_id";
	}
	
	private function getNumGamesDLC($purchaseid) {
		global $mysqli;
		$gamesresult = $mysqli->query("SELECT * FROM purchase JOIN xref_purchase_game USING (purchase_id) JOIN game USING (game_id) WHERE purchase.purchase_id=$purchaseid");
		$dlcresult = $mysqli->query("SELECT * FROM purchase JOIN xref_purchase_game USING (purchase_id) JOIN game USING (game_id) JOIN dlc USING (game_id) WHERE purchase.purchase_id=$purchaseid");
		return $gamesresult->num_rows + $dlcresult->num_rows;
	}

	public function drawTable() {
		global $mysqli;
		$string = "";
		
		$result = $mysqli->query($this->query);
		while($entries = $result->fetch_assoc()) {
			$numrows = $this->getNumGamesDLC($entries['purchase_id']);
			$purchase = new purchase($entries['purchase_id'], $entries['shop'], $entries['price'], $entries['valuta'], $entries['date'], $entries['note'], $numrows);
			$string .= $purchase->drawRow();

			$result2 = $mysqli->query($this->query2 . " WHERE purchase.purchase_id={$entries['purchase_id']}");
			$j = 0; // draw first game without <tr>
			while($entries2 = $result2->fetch_assoc()) {
				$game = new game($entries2['game_id'], $entries2['name'], $entries2['status'], $entries2['completed'], $entries2['notes'], $entries2['color'], $entries['purchase_id']);
				$string .= $game->drawRow($j);

				$result3 = $mysqli->query($this->query3 . " WHERE game_id={$entries2['game_id']}");
				while($entries3 = $result3->fetch_assoc()) {
					$dlc = new dlc($entries3['dlc_id'], $entries3['name'], $entries3['status'], $entries3['completed'], $entries3['note'], $entries3['color'], NULL, $entries['purchase_id']);
					$string .= $dlc->drawSubRow();
				}
				$j = 1;
			}
		}
		return $string;
	}
}

class purchase {
	private $id, $shop, $price, $date, $note, $numGames;

	function __construct($id, $shop, $price, $valuta, $date, $note, $numGames) {
		$this->setData($id, $shop, $price, $valuta, $date, $note, $numGames);
	}

	public function setData($id, $shop, $price, $valuta, $date, $note, $numGames) {
		$this->id = $id;
		$this->shop = $shop;
		$this->price = $valuta . $price;
		$this->date = $date;
		$this->note = $note;
		$this->numGames = $numGames;
	}

	public function drawRow() {
		global $currenturl;
		
		$string = "";
		$string .= "<tr>";
		$string .= "<td rowspan=\"{$this->numGames}\"><input type=\"checkbox\" name=\"checkedpurchases[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=games&scope=purchase&purchase={$this->id}\"><span class=\"glyphicon glyphicon-search\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifypurchase&id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&delete=purchase&purchase={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "<td rowspan=\"{$this->numGames}\">{$this->shop}</td>";
		$string .= "<td rowspan=\"{$this->numGames}\">{$this->price}</td>";
		$string .= "<td rowspan=\"{$this->numGames}\">{$this->date}</td>";
		$string .= "<td rowspan=\"{$this->numGames}\">{$this->note}</td>";
		return $string;
	}
}

function getStatusOptions() {
	$string = "";
	global $mysqli;
	$result = $mysqli->query("SELECT * FROM status");
	while($entries = $result->fetch_assoc()) {
		$string .= "<option value =\"{$entries['status_id']}\">{$entries['name']}</option>";
	}
	return $string;
}

function syncSteam () {
	global $mysqli, $config;
	
	$json = file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key={$config['steamapikey']}&steamid={$config['steamid']}&format=json&include_appinfo=1");
	$steamdata = json_decode($json);
	
	foreach ($steamdata->response->games as $game) {
		$name = addslashes($game->name);
		$appid = $game->appid;
		$playtime = $game->playtime_forever;
		
		$query = "UPDATE game SET appid=$appid, playtime=$playtime WHERE name='$name'";
		$mysqli->query($query) or die($query); 
	}
}
?>