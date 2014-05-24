<?php
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