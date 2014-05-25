<?php
require_once("connect.php");

if(isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = "overzicht";
}

$result = $mysqli->query(@"SELECT * FROM menu LEFT JOIN library USING(library_id) WHERE page='$page' AND scope='{$_GET['scope']}'");
$entries = $result->fetch_assoc();

if (!empty($entries)) {
	$pagename = $entries['title'];
	$include = $entries['page'] . ".php";
} else {
    header("HTTP/1.0 404 Not Found");
    $pagename = "Pagina niet gevonden";
	$include = "404.php";
}

$currenturl = @"index.php?page=$page&scope={$_GET['scope']}";

if(!empty($entries['css_url'])) $css = "<link href=\"{$entries['css_url']}\" rel=\"stylesheet\" media=\"screen\">";
if(!empty($entries['js_url'])) $js = "<script src=\"{$entries['js_url']}\"></script>";
?>