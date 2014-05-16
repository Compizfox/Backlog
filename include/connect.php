<?php
$host = "localhost";
$user = "informatica";
$pass = "proskater";
$db   = "backlog";

$mysqli = new mysqli($host, $user, $pass, $db);
$mysqli->query("SET NAMES utf8");
ini_set("display_errors", 1);
error_reporting(E_ALL);
?>