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
include("include/message.php");

if(isset($_GET['syncappids'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(TRUE, FALSE, FALSE, FALSE);
		header("Location: index.php?page=steam&message=appidssynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will link all games in the database to their Steam appids (if known). <a href="index.php?page=steam&syncappids&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['syncicons'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(FALSE, TRUE, FALSE, FALSE);
		header("Location: index.php?page=steam&message=iconssynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will retrieve icons and logos from Steam for all games in the database with linked Steam appids. <a href="index.php?page=steam&syncicons&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['syncplaytime'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(FALSE, FALSE, TRUE, FALSE);
		header("Location: index.php?page=steam&message=playtimesynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will retrieve your played hours from Steam for all games in the database with linked Steam appids. This will potentially overwrite manually-set playtime. Are you sure? <a href="index.php?page=steam&syncplaytime&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['addgames'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(FALSE, FALSE, FALSE, TRUE);
		header("Location: index.php?page=steam&message=gamesadded");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will import all your games that aren't in the database yet from Steam as orphaned games (no purchase). Do you want to continue? <a href="index.php?page=steam&addgames&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['refreshuserstats'])) {
	SteamUserApiRequest();
	header("Location: index.php");
}
?>
