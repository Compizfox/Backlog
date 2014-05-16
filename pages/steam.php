<?php
require_once("include/classes.php");
include("include/message.php");

if(isset($_GET['syncappids'])) {
	syncSteamAppids();
	header("Location: index.php?page=steam&message=appidssynced");
}

if(isset($_GET['syncplaytime'])) {
	syncSteamPlaytime();
	header("Location: index.php?page=steam&message=playtimesynced");
}
?>