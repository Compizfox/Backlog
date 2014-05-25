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

require_once("include/connect.php");

$result = $mysqli->query("SELECT * FROM purchase WHERE purchase_id={$_GET['id']}");
$data = $result->fetch_assoc();

$dollarselected = ""; $euroselected = "";
switch($data['valuta']) {
	case '$':
		$dollarselected = " selected";
		break;
	case '€':
		$euroselected = " selected";
}

if(isset($_POST['submit'])) {
	$query = "UPDATE purchase SET shop='{$_POST['shop']}', price={$_POST['price']}, valuta='{$_POST['valuta']}', date='{$_POST['date']}', note='{$_POST['note']}' WHERE purchase_id={$_GET['id']}";
	$mysqli->query($query) or die($query);
	header("Location: index.php?page=purchases&message=purchaseedited");
}
?>

<div class="well">
	<form class="form-horizontal" role="form" action="<?=htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Shop:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="shop" value="<?=$data['shop']?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Price:</label>
				<div class="col-md-2">
					<div class="input-group"><select style="width: 40px; padding-left: 1px; padding-right: 1px;" class="form-control" name="valuta"><option value="$"<?=$dollarselected?>>$</option><option value="€"<?=$euroselected?>>€</option></select><span class="input-group-addon"></span><input class="form-control" type="text" name="price" value="<?=$data['price']?>"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Date:</label>
				<div class="col-md-2"><input class="form-control" type="date" name="date" value="<?=$data['date']?>"></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Note:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="note" value="<?=$data['note']?>"></div>
			</div>	
		</fieldset>
		<button class="btn btn-default" type="submit" name="submit">Submit</button>
	</form>
</div>
