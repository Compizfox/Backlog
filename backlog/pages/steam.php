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

if(isset($_POST['submit'])) {
	if(isset($_POST['syncappids']) || isset($_POST['syncicons']) || isset($_POST['syncplaytime']) || isset($_POST['addgames'])) {
		SteamApiRequest(isset($_POST['syncappids']), isset($_POST['syncicons']), isset($_POST['syncplaytime']), isset($_POST['addgames']));
	}
	
	if(isset($_POST['refreshuserstats'])) {
		SteamUserApiRequest();
	}
}

if(isset($_GET['all'])) {
?>

<form class="form-horizontal" role="form" method="post" action="index.php?page=steam">
	<div class="well">
		<div class="checkbox">
			<label>
				<input name="syncappids" type="checkbox"> Link games with Steam
			</label>
			<span class="help-block">This will link all games in the database to their Steam appids (if known).</span>
		</div>
		<div class="checkbox" name="syncplaytime">
			<label>
				<input type="checkbox"> Sync playtime with Steam
			</label>
			<span class="help-block">This will retrieve your played hours from Steam for all games in the database with linked Steam appids. This will potentially overwrite manually-set playtime.</span>
		</div>
		<div class="checkbox" name="syncicons">
			<label>
				<input type="checkbox"> Retrieve icons/logos
			</label>
			<span class="help-block">This will retrieve icons and logos from Steam for all games in the database with linked Steam appids.</span>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="addgames"> Import games from Steam
			</label>
			<span class="help-block">This will import all your games that aren't in the database yet from Steam as orphaned games (no purchases).</span>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="refreshuserstats"> Refresh user stats
			</label>
			<span class="help-block">This will manually update your Steam nickname, avatar and most played games (shown in bottom-left corner). It is automatically updated every 24 hours.</span>
		</div>
		<div class="form-group">
			<button type="submit" name="submit" class="btn btn-default">Submit</button>
		</div>
	</div>
</form>

<?php } ?>