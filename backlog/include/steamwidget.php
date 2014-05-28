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

do {
	$query = "SELECT * FROM cache";
	$result = $mysqli->query($query) or die($query);
	$rows = $result->fetch_all(MYSQLI_ASSOC);
	
	$data = array();
	foreach($rows as $row) {
		$data[$row['index']] = $row['value'];
	}
	
	$expired = false;
	if($data['time'] < time() - 86400) {
		SteamUserApiRequest();
		$expired = true;
	}
} while($expired);

$rpgamesstring = "";
foreach(json_decode($data['games']) as $game) {
	$rpgamesstring .= "<img src=\"http://media.steampowered.com/steamcommunity/public/images/apps/{$game->appid}/{$game->img_icon_url}.jpg\" title=\"{$game->name}\" alt />&nbsp;&nbsp;";
}
?>

<div class="panel panel-default nav-sidebar steamwidget">
	<div class="panel-body">
		<p>
		<a href="<?=$data['profileurl']?>" target="_blank" style="text-decoration: none;">
			<img src="<?=$data['avatarmedium']?>" alt />
			<span style="font-size: 150%; margin-left: 5px;"><?=$data['personaname']?></span>
		</a></p>
		<p><?=$rpgamesstring?></p>
	</div>
</div>