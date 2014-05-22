<?php
include "include/operations.php";
include "include/message.php";

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
				<th>Name</th>
				<th>Game</th>
				<th>Status</th>
				<th>Notes</th>
				<th><input type="checkbox" id="selectall" /></th>
			</tr>
		</thead>
		<tbody>
			<?php
			switch($_GET['scope']) {
				case "all":
					$list = new listDLC;
					echo($list->drawTable());
					break;

				case "uncompleted":
					$list = new listDLC;
					$list->setCondition("completed=0");
					echo($list->drawTable());
					break;

				case "completed":
					$list = new listDLC;
					$list->setCondition("completed=1");
					echo($list->drawTable());
					break;
					
				case "purchase":
					$list = new listDLC;
					$list->setCondition("purchase_id='{$_GET['purchase']}'");
					echo($list->drawTable());
					break;
					
				case "game":
					echo("<h3>#{$_GET['game']}");
					$list = new listDLC;
					$list->setCondition("game_id='{$_GET['game']}'");
					echo($list->drawTable());
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
					<button type="button" type="submit" value="delete" class="btn btn-danger">Delete</button>
					<label class="col-sm-3 control-label">Set status:</label>
					<div class="col-sm-3"><select name="status" class="form-control" onchange="this.form.submit()"><option value="">Select a status</option><?php echo(getStatusOptions()) ?></select></div>
				</div>
			</fieldset>
		</div>
	</div>
</form>