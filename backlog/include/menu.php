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

class menuitem {
	public $id, $parentid, $page, $scope, $options, $title, $glyphicon = "", $active = "", $submenuitems = array(), $url;
	
	function __construct($id, $parentid, $page, $scope, $options, $glyphicon, $title) {
		$this->id = $id;
		$this->parentid = $parentid;
		$this->page = $page;
		$this->scope = $scope;
		$this->options = $options;
		$this->setGlyphicon($glyphicon);
		$this->title = $title;
		$this->url = "index.php?page=$page";
		if(!empty($scope)) $this->url .= "&amp;scope=$scope";
		if(!empty($options)) $this->url .= "$options";
	}
	
	public function setGlyphicon($glyphicon) {
		$this->glyphicon = "<span class=\"glyphicon $glyphicon\"></span>";
	}
}

class menu {
	private $parentid, $page, $content = array();
	
	function __construct($parentid, $page) {
		$this->parentid = $parentid;
		$this->fill();
	}
	
	public function fill() {
		global $mysqli, $page;
		
		$result = $mysqli->query("SELECT * FROM menu WHERE parent_id = {$this->parentid} ORDER BY id ASC");
		while ($entries = $result->fetch_assoc()) {		
			$result2 = $mysqli->query("SELECT * FROM menu WHERE parent_id={$entries['id']} ORDER BY id ASC");
				
			$this->content[$entries['id']] = new menuitem($entries['id'], $entries['parent_id'], $entries['page'], $entries['scope'], $entries['options'], $entries['glyphicon'], $entries['title']);
			
			if($page == $entries['page'] AND @$_GET['scope'] == $entries['scope']) {
				$this->content[$entries['id']]->active = "active";
			}
			
			while ($subentries = $result2->fetch_assoc()) {
				$this->content[$entries['id']]->submenuitems[$subentries['id']] = new menuitem($subentries['id'], $subentries['parent_id'], $subentries['page'], $subentries['scope'], $subentries['options'], $subentries['glyphicon'], $subentries['title']);
				
				if(@$_GET['page'] == $this->content[$entries['id']]->submenuitems[$subentries['id']]->page AND @$_GET['scope'] == $this->content[$entries['id']]->submenuitems[$subentries['id']]->scope) {
					$this->content[$entries['id']]->submenuitems[$subentries['id']]->active = "active";
				}
			}
		}
	}

	/** @noinspection PhpInconsistentReturnPointsInspection */
	public function draw($style) {
		switch($style) {
			case 'h':
				return $this->drawH();
			case 'v':
				return $this->drawV();
		}
	}
	
	private function drawH() {
		$output = "";
		foreach($this->content as $menuitem) {
			$astring = "";
			$classstring = "{$menuitem->active}";
			
			if(!empty($menuitem->submenuitems)) {
				$classstring .= " dropdown";
				$astring = " class=\"dropdown-toggle\" data-toggle=\"dropdown\"";
			}
			
			$output .= "<li class=\"$classstring\"><a href=\"{$menuitem->url}\"$astring>{$menuitem->glyphicon} {$menuitem->title}</a>";
			
			if(!empty($menuitem->submenuitems)) {
				$output .= "<ul class=\"dropdown-menu\">";
				foreach($menuitem->submenuitems as $submenuitem) {
					$output .= "<li><a href=\"{$submenuitem->url}\">$submenuitem->glyphicon {$submenuitem->title}</a></li>";
				}
				$output .= "</ul>";
			}
			$output .= "</li>";
		}
		return $output;
	}
	
	private function drawV() {
		$output = "";
		foreach($this->content as $menuitem) {
			$output .= "<li class=\"{$menuitem->active}\"><a href=\"{$menuitem->url}\">{$menuitem->glyphicon} {$menuitem->title}</a>";
			if(!empty($menuitem->submenuitems)) {
				$output2 = "<ul class=\"nav\">";
				foreach($menuitem->submenuitems as $submenuitem) {
					$output2 .= "<li class=\"{$submenuitem->active}\"><a href=\"{$submenuitem->url}\">{$submenuitem->glyphicon} {$submenuitem->title}</a></li>";
				}
				$output2 .= "</ul>";
				$output .= $output2;
			}
			$output .= "</li>";
		}
		return $output;
	}
}
?>
