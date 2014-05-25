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

if(isset($_GET['message'])){
	switch($_GET['message']) {
		case "gameedited":
			$message = "The game has been succesfully edited.";
			break;
		case "dlcedited":
			$message = "The dlc has been succesfully edited.";
			break;
		case "purchaseedited":
			$message = "The purchase has been succesfully edited.";
			break;
		case "appidssynced":
			$message = "All games should now have Steam appids assigned. If not, add them manually.";
			break;
		case "iconssynced":
			$message = "All games with Steam appids should now have icons and logos.";
			break;
		case "playtimesynced":
			$message = "All games with Steam appids should now show your Steam playtime.";
			break;
		case "gamesadded":
			$message = "The games from Steam have been succesfully imported.";
			break;
	}
?>
<div class="alert alert-success .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?=$message?></div>
<?php }?>
