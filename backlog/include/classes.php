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
	private $id, $name, $status, $completed, $notes, $color, $appid, $playtime, $img_icon_url, $img_logo_url, $purchase, $img_url;

	function __construct($id) {
		global $mysqli;

		$result = $mysqli->query("SELECT game.name, game.notes, game.appid, game.img_icon_url, game.img_logo_url, playtime, status.name AS status, status.completed, status.color FROM game JOIN status USING (status_id) WHERE game_id=$id") or die($mysqli->error);
		$row = $result->fetch_assoc();

		$this->id = $id;
		$this->name = $row['name'];
		$this->status = $row['status'];
		$this->completed = $row['completed'];
		$this->notes = $row['notes'];
		$this->color = $row['color'];
		$this->appid = $row['appid'];
		$this->playtime = round($row['playtime'] / 60, 2);
		$this->img_icon_url = $row['img_icon_url'];
		$this->img_logo_url = $row['img_logo_url'];
	}

	public function setPurchase($purchase) {
		$this->purchase = $purchase;
	}

	public function drawPurchaseRow($beginrow = 1) {
		global $currenturl;
		$this->img_url = $this->img_icon_url;

		$string = "";
		if($beginrow) $string .= ("<tr>");
		$string .= "<td colspan=\"2\">";
		if($this->appid != 0) $string .= "<img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_url}.jpg\" alt /> ";
		$string .= "{$this->name}</td>";
		$string .= "<td style=\"background-color: {$this->color}\">{$this->status}</td>";
		$string .= "<td><a href=\"index.php?page=modifygame&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=game&amp;game={$this->id}&amp;purchase={$this->purchase}\"><span class=\"glyphicon glyphicon-trash\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=dlc&amp;scope=game&amp;game={$this->id}\"><span class=\"glyphicon glyphicon-download\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}

	public function drawGameRow() {
		global $currenturl;
		$this->img_url = $this->img_logo_url;

		$string = "<tr><td>";
		if($this->appid != 0) $string .= "<img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_url}.jpg\" alt /> ";
		$string .= "{$this->name}</td>";
		$string .= "<td style=\"background-color: {$this->color}\">{$this->status}</td>";
		$string .= "<td>{$this->playtime}</td>";
		$string .= "<td>{$this->notes}</td>";
		$string .= "<td><input type=\"checkbox\" name=\"checkedgames[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifygame&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=game&amp;game={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=dlc&amp;scope=game&amp;game={$this->id}\"><span class=\"glyphicon glyphicon-download\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
}

class dlc {
	private $id, $name, $status, $completed, $notes, $color, $game, $purchase, $appid, $img_url;

	function __construct($id) {
		global $mysqli;
		$result = $mysqli->query("SELECT dlc.name, status.name AS status, status.completed, dlc.note, status.color, game.name AS gamename, img_icon_url, appid FROM game JOIN dlc USING(game_id) JOIN status ON dlc.status_id=status.status_id WHERE dlc_id=$id") or die($mysqli->error);
		$row = $result->fetch_assoc();

		$this->id = $id;
		$this->name = $row['name'];
		$this->status = $row['status'];
		$this->completed = $row['completed'];
		$this->notes = $row['note'];
		$this->color = $row['color'];
		$this->game = $row['gamename'];
		$this->img_url = $row['img_icon_url'];
		$this->appid = $row['appid'];
	}

	public function setPurchase($purchase) {
		$this->purchase = $purchase;
	}

	public function drawDLCRow() {
		global $currenturl;
		$string = "";
		$string .= "<tr>";
		$string .= "<td>{$this->name}</td>";
		$string .= "<td><img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_url}.jpg\" alt /> {$this->game}</td>";
		$string .= "<td style=\"background-color: {$this->color}\">{$this->status}</td>";
		$string .= "<td>{$this->notes}</td>";
		$string .= "<td><input type=\"checkbox\" name=\"checkeddlc[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifydlc&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=dlc&amp;dlc={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}

	public function drawPurchaseRow($beginrow = 1) {
		global $currenturl;

		$string = "";
		if($beginrow) $string .= ("<tr>");
		$string .= "<td><img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_url}.jpg\" alt /> {$this->game}</td>";
		$string .= "<td>{$this->name}</td>";
		$string .= "<td style=\"background-color: {$this->color}\">{$this->status}</td>";
		$string .= "<td><a href=\"index.php?page=modifydlc&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=dlc&amp;dlc={$this->id}&amp;purchase={$this->purchase}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}

	public function drawGameRow() {
		global $currenturl;

		$string = "";
		$string .= "<tr class=\"dlc\">";
		$string .= "<td style=\"padding-left: 200px;\">{$this->name}</td>";
		$string .= "<td style=\"background-color: {$this->color}\">{$this->status}</td>";
		$string .= "<td></td>";
		$string .= "<td>{$this->notes}</td>";
		$string .= "<td><input type=\"checkbox\" name=\"checkeddlc[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifydlc&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=dlc&amp;dlc={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
		$string .= "</tr>";
		return $string;
	}
}

function listGames($condition, $listDLC=true) {
	global $mysqli;
	$string = "";

	$result = $mysqli->query("SELECT game_id FROM purchase JOIN xref_purchase_game USING(purchase_id) RIGHT JOIN game USING(game_id) JOIN status USING(status_id) WHERE hidden=0 $condition GROUP BY game.name ORDER BY game.name");
	while($entries = $result->fetch_assoc()) {
		$game = new game($entries['game_id']);
		$string .= $game->drawGameRow();

		if($listDLC) {
			$result2 = $mysqli->query("SELECT dlc_id FROM dlc WHERE game_id='{$entries['game_id']}'");
			while($entries2 = $result2->fetch_assoc()) {
				$dlc = new dlc($entries2['dlc_id']);
				$string .= $dlc->drawGameRow();
			}
		}
	}
	return $string;
}

function listDLC($condition) {
	global $mysqli;
	$string = "";

	$result = $mysqli->query("SELECT dlc_id FROM purchase JOIN xref_purchase_dlc USING(purchase_id) RIGHT JOIN (SELECT dlc_id, game_id, dlc.name AS dlcname, dlc.status_id, completed, game.name AS gamename FROM game JOIN dlc USING(game_id) JOIN status ON dlc.status_id=status.status_id) AS dlc USING(dlc_id) $condition GROUP BY dlcname ORDER BY gamename");
	while($entries = $result->fetch_assoc()) {
		$dlc = new dlc($entries['dlc_id']);
		$string .= $dlc->drawDLCRow();
	}

	return $string;
}

function listPurchases() {
	global $mysqli;
	$string = "";

	$result = $mysqli->query("SELECT purchase_id FROM purchase");
	while($entries = $result->fetch_assoc()) {
		$purchase = new purchase($entries['purchase_id']);
		$string .= $purchase->drawRow();

		$result2 = $mysqli->query("SELECT game_id FROM xref_purchase_game WHERE purchase_id={$entries['purchase_id']}");
		$j = 0; // draw first game without <tr>
		while($entries2 = $result2->fetch_assoc()) {
			$game = new game($entries2['game_id']);
			$game->setPurchase($entries['purchase_id']);
			$string .= $game->drawPurchaseRow($j);
			$j = 1;
		}

		$result3 = $mysqli->query("SELECT dlc_id FROM xref_purchase_dlc WHERE purchase_id={$entries['purchase_id']}");
		while($entries3 = $result3->fetch_assoc()) {
			$dlc = new dlc($entries3['dlc_id']);
			$dlc->setPurchase($entries['purchase_id']);
			$string .= $dlc->drawPurchaseRow($j);
			$j = 1;
		}
	}
	return $string;
}

class purchase {
	private $id, $shop, $price, $valuta, $date, $note, $numGames;

	function __construct($id) {
		global $mysqli;

		$result = $mysqli->query("SELECT * FROM purchase WHERE purchase_id=$id") or die($mysqli->error);
		$row = $result->fetch_assoc();

		$this->id = $id;
		$this->shop = $row['shop'];
		$this->price = $row['valuta'] . $row['price'];
		$this->date = $row['date'];
		$this->note = $row['note'];

		$this->numGames = $mysqli->query("SELECT l1.count + l2.count FROM (SELECT COUNT(*) AS count FROM purchase JOIN xref_purchase_game USING (purchase_id) JOIN game USING (game_id) WHERE purchase.purchase_id=$id) AS l1, (SELECT COUNT(*) AS count FROM purchase JOIN xref_purchase_dlc USING (purchase_id) JOIN dlc USING (dlc_id) WHERE purchase.purchase_id=$id) AS l2")->fetch_row()[0];
	}

	public function drawRow() {
		global $currenturl;
		
		$string = "";
		$string .= "<tr>";
		$string .= "<td rowspan=\"{$this->numGames}\"><input type=\"checkbox\" name=\"checkedpurchases[]\" value=\"{$this->id}\" />&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=purchasedetail&amp;purchase={$this->id}\"><span class=\"glyphicon glyphicon-search\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=modifypurchase&amp;id={$this->id}\"><span class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"$currenturl&amp;delete=purchase&amp;purchase={$this->id}\"><span class=\"glyphicon glyphicon-trash\"></span></a></td>";
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
	
	$query = "SELECT history_id, game.name as game, dlc.name as dlc, a.name as oldstatus, a.color as oldcolor, b.name as newstatus, b.color as newcolor, date FROM history JOIN status a ON history.old_status=a.status_id JOIN status b ON history.new_status=b.status_id LEFT JOIN game USING(game_id) LEFT JOIN dlc USING(dlc_id) ORDER BY history_id DESC $append";
	$result = $mysqli->query($query) or die($query);
	
	while($row = $result->fetch_assoc()) {
		$historystring .= "<tr><td>{$row['history_id']}</td><td>{$row['game']}</td><td>{$row['dlc']}</td><td style=\"background-color: {$row['oldcolor']};\">{$row['oldstatus']}</td><td style=\"background-color: {$row['newcolor']};\">{$row['newstatus']}</td><td>{$row['date']}</td></tr>";
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
	
	$a = "games";
	$b = json_encode($steamdata2->response->games);
	$stmt->bind_param("ss", $a, $b) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
	
	$a = "time";
	$b = time();
	$stmt->bind_param("ss", $a, $b) or die($stmt->error);
	$stmt->execute() or die($stmt->error);
}
?>
