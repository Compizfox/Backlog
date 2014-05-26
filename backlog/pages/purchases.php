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

<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Remember: </strong>removing games in <i>purchase view</i> unlinks the games from the purchase. To actually delete the game itself, remove it in <i>games view</i>.<br />Deleting a purchase doesn't remove the games in it.</div>
<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Empty purchases will be automatically deleted.</div>

<form class="form-horizontal" action="<?=htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th><input type="checkbox" id="selectall" /></th>
				<th>Shop</th>
				<th>Price</th>
				<th>Date</th>
				<th>Note</th>
				<th>Game(s)</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$list = new listPurchases;
			echo($list->drawTable());
			?>
		</tbody>
	</table>

	<div class="panel panel-default">
		<div class="panel-body">
			<fieldset>
				<input type="hidden" name="formsubmit" value="formsubmit" />
				<div class="form-group">
					<button type="button" type="submit" value="delete" class="btn btn-danger">Delete</button>
					<label class="col-sm-3 control-label">Set status:</label>
					<div class="col-sm-3"><select name="status" class="form-control" onchange="this.form.submit()"><option value="">Select a status</option><?php echo(getStatusOptions()) ?></select></div>
				</div>
			</fieldset>
		</div>
	</div>
</form>
