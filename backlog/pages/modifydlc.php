<?php
require_once("include/classes.php");
$result = $mysqli->query("SELECT dlc_id, dlc.name, status_id, note FROM dlc JOIN status USING (status_id) WHERE dlc_id={$_GET['id']}");
$data = $result->fetch_assoc();

if(isset($_POST['submit'])) {
	$query = "SELECT status_id FROM dlc WHERE dlc_id={$_GET['id']}";
	$result = $mysqli->query($query) or die($query);
	$oldstatus = $result->fetch_array(MYSQLI_NUM)[0];
	$newstatus = $_POST['status'];
	
	if($oldstatus != $newstatus) {
		$query = "INSERT INTO history (dlc_id, old_status, new_status) VALUES ({$_GET['id']}, $oldstatus, $newstatus)";
		$mysqli->query($query) or die($query);
	}
	
	$query = "UPDATE dlc SET name='{$_POST['name']}', status_id={$_POST['status']}, note='{$_POST['note']}' WHERE dlc_id={$_GET['id']}";
	$mysqli->query($query) or die($query);
	header("Location: index.php?page=dlc&scope=all&message=dlcedited");
}
?>

<div class="well">
	<form class="form-horizontal" role="form" action="<?=htmlentities($_SERVER['REQUEST_URI'])?>" method="post">
		<fieldset>
			<div class="form-group">
				<label class="col-sm-2 control-label">Name:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="name" value="<?=$data['name']?>" required autofocus></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">Status:</label>
				<div class="col-md-4"><select class="form-control" name="status"><?=getStatusOptions()?></select></div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Note:</label>
				<div class="col-md-4"><input class="form-control" type="text" name="note" value="<?=$data['note']?>"></div>
			</div>
		</fieldset>
		<button class="btn btn-default" type="submit" name="submit">Submit</button>
	</form>
</div>