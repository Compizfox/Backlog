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
	}
?>
<div class="alert alert-success .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?=$message?></div>
<?php }?>