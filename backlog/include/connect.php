<?php
require_once("config.php");

$mysqli = new mysqli($config['host'], $config['user'], $config['pass'], $config['db']);
$mysqli->query("SET NAMES utf8");
ini_set("display_errors", 1);
error_reporting(E_ALL);
?>