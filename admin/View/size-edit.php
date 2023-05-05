<?php
include("../Database/Helper.php");
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['size'])) {
		$valid = 0;
		$error_message .= "Size can not be empty<br>";
	} else {
		$db = new Helper();
		$statement = "SELECT * FROM tbl_size WHERE id_size=?";
		$para = [$_REQUEST['id']];
		$result = $db->fetchAll($statement, $para);
		foreach ($result as $row) {
			$current_size = $row['size'];
		}
		$db = new Helper();
		$statement = "SELECT * FROM tbl_size WHERE size=? ";
		$para = [$_POST['size']];
		$total = $db->rowCount($statement, $para);
		if ($total) {
			$valid = 0;
			$error_message .= 'Size name already exists<br>';
		}
	}

	if ($valid == 1) {
		// updating into the database
		$statement = $pdo->prepare("UPDATE tbl_size SET size=? WHERE id_size=?");
		$statement->execute(array($_POST['size'], $_REQUEST['id']));

		$success_message = 'Size is updated successfully.';
	}
}
?>

<?php
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = "SELECT * FROM tbl_size WHERE id_size=?";
	$db = new Helper();
	$para = [$_REQUEST['id']];
	$total = $db->rowCount($statement, $para);
	$result = $db->fetchAll($statement, $para);
	if ($total == 0) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Chỉnh sửa Size</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=size" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php
foreach ($result as $row) {
	$size = $row['size'];
}
?>

<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if ($error_message) : ?>
				<div class="callout callout-danger">

					<p>
						<?php echo $error_message; ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">

					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Size<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="size" value="<?php echo $size; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>

					</div>

				</div>

			</form>



		</div>
	</div>

</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				Are you sure want to delete this item?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>