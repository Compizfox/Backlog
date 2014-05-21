<?php
include "include/operations.php";
include "include/message.php";

$script = "$('#selectall').click (function () {
     var checkedStatus = this.checked;
    $('.table tbody tr').find(':checkbox').each(function () {
        $(this).prop('checked', checkedStatus);
     });
});"
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
					$list = new listGames;
					echo($list->drawTable());
					break;

				case "uncompleted":
					$list = new listGames;
					$list->setCondition("completed=0");
					echo($list->drawTable());
					break;

				case "completed":
					$list = new listGames;
					$list->setCondition("completed=1");
					echo($list->drawTable());
					break;
					
				case "purchase":
					echo("<h3>#{$_GET['purchase']}");
					$list = new listGames;
					$list->setCondition("purchase_id='{$_GET['purchase']}'");
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