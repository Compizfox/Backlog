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

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/connect.php");

class game {
	private $id, $name, $status, $completed, $notes, $color, $purchase;

	function __construct($id, $name, $status, $completed, $notes, $color, $appid, $playtime, $img_icon_url, $img_logo_url, $purchase=NULL) {
		$this->setData($id, $name, $status, $completed, $notes, $color, $appid, $playtime, $img_icon_url, $img_logo_url, $purchase);
	}

	private function getColor() {
		return $this->color;
	}

	public function setData($id, $name, $status, $completed, $notes, $color, $appid, $playtime, $img_icon_url, $img_logo_url, $purchase) {
		$this->id = $id;
		$this->name = $name;
		$this->status = $status;
		$this->completed = $completed;
		$this->notes = $notes;
		$this->color = $color;
		$this->appid = $appid;
		$this->playtime = round($playtime / 60, 2);
		$this->img_icon_url = $img_icon_url;
		$this->img_logo_url = $img_logo_url;
		$this->purchase = $purchase;
	}

	public function drawRow($beginrow = 1) {
		global $currenturl;
		
		if(isset($this->purchase)) {
			$this->img_url = $this->img_icon_url;
		} else {
			$this->img_url = $this->img_logo_url;
		}
		
		$string = "";
		if($beginrow) $string .= ("<tr>");
		$string .= "<td>";
		if($this->appid != 0) $string .= "<img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_url}.jpg\" /> ";
		$string .= "{$this->name}</td>";
		$string .= "<td style=\"background-color: #{$this->getColor()}\">{$this->status}</td>";
		if(!isset($this->purchase)) $string .= "<td>{$this->playtime}</td>";
		if(!isset($this->purchase)) $string .= "<td>{$this->notes}</td>";
		$string .= "<td>";
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
		if(!isset($this->purchase)) $string .= "<td></td>";
		if(!isset($this->purchase)) $string .= "<td>{$this->notes}</td>";
		$string .= "<td>";
		if(!isset($this->purchase)) $string .= "<input type=\"checkbox\" name=\"checkeddlc[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;";
		$string .= "<a href=\"index.php?page=modifydlc&id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&delete=dlc&dlc={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
}

class listGames {
	private $condition, $query, $query2;
	
	public function setCondition($condition) {
		$this->condition = "AND " . $condition;
	}

	public function drawTable() {
		global $mysqli;
		$string = "";
		
		$this->query = "SELECT purchase_id, game.game_id, game.name, status.name AS status, status.completed, game.notes, status.color, game.appid, game.playtime, game.img_logo_url FROM purchase JOIN xref_purchase_game USING(purchase_id) RIGHT JOIN game USING(game_id) JOIN status USING(status_id) WHERE hidden=0 {$this->condition} GROUP BY game.name ORDER BY game.game_id";
		$this->query2 = "SELECT dlc.dlc_id, dlc.name, status.name AS status, status.completed, dlc.note, status.color FROM dlc JOIN status USING (status_id)";
		$result = $mysqli->query($this->query);

		while($entries = $result->fetch_assoc()) {
			$game = new game($entries['game_id'], $entries['name'], $entries['status'], $entries['completed'], $entries['notes'], $entries['color'], $entries['appid'], $entries['playtime'], NULL, $entries['img_logo_url']);
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
		$this->query2 = "SELECT game.game_id, game.name, game.notes, game.appid, game.img_icon_url, status.name AS status, status.completed, status.color FROM purchase JOIN xref_purchase_game USING (purchase_id) JOIN game USING (game_id) JOIN status USING (status_id)";
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
				$game = new game($entries2['game_id'], $entries2['name'], $entries2['status'], $entries2['completed'], $entries2['notes'], $entries2['color'], $entries2['appid'], NULL, $entries2['img_icon_url'], NULL, $entries['purchase_id']);
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

function SteamApiRequest($syncSteamAppids, $syncSteamIcons, $syncSteamPlaytime, $addGames) {
	global $config, $mysqli;
	
	SteamUserApiRequest();
	
	$steamdata = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key={$config['steamapikey']}&steamid={$config['steamid']}&format=json&include_appinfo=1&include_played_free_games=1"));
	
	if($syncSteamAppids == true) {
		$stmt = $mysqli->prepare("SELECT * FROM game WHERE name=?") or die($mysqli->error);
		$stmt2 = $mysqli->prepare("UPDATE game SET appid=? WHERE name=?") or die($mysqli->error);
		foreach ($steamdata->response->games as $game) {
			$stmt->bind_param("s", $game->name) or die($stmt->error);
			$stmt->execute() or die($stmt->error);
			$result = $stmt->get_result();
			
			$entries = $result->fetch_assoc();
			if($entries['appid_lock'] == 0) {
				$stmt2->bind_param("is", $game->appid, $game->name) or die($stmt2->error);
				$stmt2->execute() or die($stmt2->error);
			}
		}
	}
	
	if($syncSteamIcons == true) {
		$stmt = $mysqli->prepare("UPDATE game SET img_icon_url=?, img_logo_url=? WHERE appid=?") or die($mysqli->error);
		foreach ($steamdata->response->games as $game) {
			$stmt->bind_param("ssi", $game->img_icon_url, $game->img_logo_url, $game->appid) or die($stmt->error);
			$stmt->execute() or die($stmt->error);
		}
	}
	
	if($syncSteamPlaytime == true) {
		foreach ($steamdata->response->games as $game) {
			$appid = $game->appid;
			$playtime = $game->playtime_forever;
			
			$query = "UPDATE game SET playtime=$playtime WHERE appid=$appid";
			$mysqli->query($query) or die($query); 
		}
	}
	
	if($addGames == true) {
		$stmt = $mysqli->prepare("SELECT * FROM game WHERE name=? UNION ALL SELECT * FROM game WHERE appid=?") or die($mysqli->error);
		$stmt2 = $mysqli->prepare("INSERT INTO game (name, status_id, appid, playtime, img_icon_url, img_logo_url) VALUES (?, ?, ?, ?, ?, ?)") or die($mysqli->error);
		
		foreach ($steamdata->response->games as $game) {
			$stmt->bind_param("si", $game->name, $game->appid) or die($stmt->error);
			$stmt->execute() or die($stmt->error);
			$result = $stmt->get_result();
			
			if($result->num_rows == 0) {
				if($game->playtime_forever == 0) {
					$status_id = 1;
				} else {
					$status_id = 2;
				}
				
				$stmt2->bind_param("siiiss", $game->name, $status_id, $game->appid, $game->playtime_forever, $game->img_icon_url, $game->img_logo_url) or die($stmt2->error);
				$stmt2->execute() or die($stmt2->error);
			}
		}
	}
}

function transpose($array) {
    array_unshift($array, null);
    return call_user_func_array('array_map', $array);
}

function getGameList($type = NULL) {
	global $mysqli;
	
	if($type == "orphaned") {
		$query = "SELECT name FROM game LEFT JOIN xref_purchase_game USING(game_id) WHERE purchase_id IS NULL ";
	} else {
		$query = "SELECT name FROM game";
	}
	
	$result = $mysqli->query($query) or die($query);
	return transpose($result->fetch_all(MYSQLI_ASSOC))[0];
}

function history($limit = false) {
	global $mysqli;
	
	$historystring = "";
	
	if($limit == true) {
		$append = "LIMIT 10";
	} else {
		$append = "";
	}
	
	$query = "SELECT history_id, game.name as game, dlc.name as dlc, a.name as oldstatus, a.color as oldcolor, b.name as newstatus, b.color as newcolor FROM history JOIN status a ON history.old_status=a.status_id JOIN status b ON history.new_status=b.status_id LEFT JOIN game USING(game_id) LEFT JOIN dlc USING(dlc_id) ORDER BY history_id DESC $append";
	$result = $mysqli->query($query) or die($query);
	
	while($row = $result->fetch_assoc()) {
		$historystring .= "<tr><td>{$row['history_id']}</td><td>{$row['game']}</td><td>{$row['dlc']}</td><td style=\"background-color: #{$row['oldcolor']};\">{$row['oldstatus']}</td><td style=\"background-color: #{$row['newcolor']};\">{$row['newstatus']}</td></tr>";
	}
	
	return $historystring;
}

function SteamUserApiRequest() {
	global $config, $mysqli;
	
	$steamdata = json_decode(file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key={$config['steamapikey']}&steamids={$config['steamid']}"));
	$steamdata2 = json_decode(file_get_contents("https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v0001/?key={$config['steamapikey']}&steamid={$config['steamid']}"));
	
	$stmt = $mysqli->prepare("REPLACE INTO cache VALUES (?, ?)") or die($mysqli->error);
	
	$a = "personaname";
	$stmt->bind_param("ss", $a, $steamdata->response->players[0]->personaname) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	$a = "profileurl";
	$stmt->bind_param("ss", $a, $steamdata->response->players[0]->profileurl) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	$a = "avatarmedium";
	$stmt->bind_param("ss", $a, $steamdata->response->players[0]->avatarmedium) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
//	$data = array();
//	foreach($steamdata2->response->games as $game) {
//		$data[] = array("appid" => $game->appid, "icon" => $game->img_icon_url);
//	}
	
	$a = "games";
	$stmt->bind_param("ss", $a, json_encode($steamdata2->response->games)) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	$a = "time";
	$stmt->bind_param("ss", $a, time()) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
}
?>
