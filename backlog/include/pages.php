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

require_once("connect.php");

if(isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = "overzicht";
}

if(isset($_GET['scope'])) {
	$scope = $_GET['scope'];
} else {
	$scope = "";
}

$css = ""; $js = "";

$stmt = $mysqli->prepare("SELECT * FROM menu LEFT JOIN xref_menu_library ON id=menu_id LEFT JOIN library USING(library_id) WHERE page=? AND scope=?") or die($mysqli->error);
$stmt->bind_param("ss", $page, $scope) or die($stmt->error);
$stmt->execute() or die($stmt->error);
$result = $stmt->get_result();

$entries = $result->fetch_assoc();
if (!empty($entries)) {
	$pagename = $entries['title'];
	$include = $entries['page'] . ".php";
} else {
    header("HTTP/1.0 404 Not Found");
    $pagename = "Pagina niet gevonden";
	$include = "404.html";
}


if(!empty($entries['css_url'])) $css .= "<link href=\"{$entries['css_url']}\" rel=\"stylesheet\" media=\"screen\">";
if(!empty($entries['js_url'])) $js .= "<script src=\"{$entries['js_url']}\"></script>";
while($entries = $result->fetch_assoc()) {
	if(!empty($entries['css_url'])) $css .= "<link href=\"{$entries['css_url']}\" rel=\"stylesheet\" media=\"screen\">";
	if(!empty($entries['js_url'])) $js .= "<script src=\"{$entries['js_url']}\"></script>";
}

$currenturl = @"index.php?page=$page&scope={$_GET['scope']}";
?>
