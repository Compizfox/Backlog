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

require_once("include/classes.php");
require_once("include/operations.php");
include("include/message.php");
?>

<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Deleting a game will delete all of its DLC. <br />Empty purchases will be automatically deleted.</div>

<form class="form-horizontal" action="<?=htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Status</th>
				<th>Playtime (hours)</th>
				<th>Notes</th>
				<th><input type="checkbox" id="selectall" /></th>
			</tr>
		</thead>
		<tbody>
			<?php
			switch($_GET['scope']) {
				case "all":
					echo(listGames(""));
					break;

				case "uncompleted":
					echo(listGames("AND completed=0"));
					break;

				case "completed":
					echo(listGames("AND completed=1"));
					break;
					
				case "purchase":
					echo(listGames("AND purchase_id='{$_GET['purchase']}'", false));
					break;
					
				case "orphaned":
					echo(listGames("AND purchase_id IS NULL"));
					break;

				case "search":
					echo(listGames("AND game.name LIKE '%{$_GET['query']}%'"));
					break;
			}
			?>
		</tbody>
	</table>
	
	<div class="panel panel-default">
		<div class="panel-body">
			<fieldset>
				<input type="hidden" name="formsubmit" value="formsubmit" />
				<div class="form-group">
					<button type="submit" name="submitbtn" value="delete" class="btn btn-danger">Delete</button>
					<button type="submit" name="submitbtn" value="hide" class="btn btn-default">Hide</button>
					<label class="col-sm-3 control-label">Set status:</label>
					<div class="col-sm-3"><select name="status" class="form-control" onchange="this.form.submit()"><option value="">Select a status</option><?php echo(getStatusOptions()) ?></select></div>
				</div>
			</fieldset>
		</div>
	</div>
</form>
