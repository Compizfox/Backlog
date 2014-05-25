<div class="alert alert-info .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Remember: </strong>removing games in <i>purchase view</i> unlinks the games from the purchase. To actually delete the game itself, remove it in <i>games view</i>.<br />Deleting a purchase doesn't remove the games in it.</div>
<div class="alert alert-warning .alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Warning: </strong>Empty purchases will be automatically deleted.</div>

<?php
require_once("include/classes.php");
require_once("include/operations.php");
include("include/message.php");

$script = "<script>$('#selectall').click (function () {
     var checkedStatus = this.checked;
    $('.table tbody tr').find(':checkbox').each(function () {
        $(this).prop('checked', checkedStatus);
     });
});</script>"
?>

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