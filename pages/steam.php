<?php
require_once("include/classes.php");
include("include/message.php");

if(isset($_GET['syncappids'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(TRUE, FALSE, FALSE);
		header("Location: index.php?page=steam&message=appidssynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will link all games in the database to their Steam appids (if known). <a href="index.php?page=steam&syncappids&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['syncicons'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(FALSE, TRUE, FALSE);
		header("Location: index.php?page=steam&message=iconssynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will retrieve icons and logos from Steam for all games in the database with linked Steam appids. <a href="index.php?page=steam&syncicons&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}

if(isset($_GET['syncplaytime'])) {
	if(@$_GET['sure'] == 1) {
		SteamApiRequest(FALSE, FALSE, TRUE);
		header("Location: index.php?page=steam&message=playtimesynced");
	} else { ?>
		<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> This will retrieve your played hours from Steam for all games in the database with linked Steam appids. This will potentially overwrite manually-set playtime. Are you sure? <a href="index.php?page=steam&syncplaytime&sure=1" class="btn btn-primary">Alrighty!</a></div>
	<?php }
}
?>