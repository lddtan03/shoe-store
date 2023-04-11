
<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['nhomquyen'])) {
        $valid = 0;
        $error_message .= "Tên nhóm quyền không được trống<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT * FROM tbl_nhomquyen where nhomquyen=?");
		$para=[$_POST['nhomquyen']];
    	$statement->execute($para);
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Nhóm quyền đã tồn tại<br>";
    	}
    }

    if($valid == 1) {

		// Saving data into the main table tbl_nhomquyen
		$statement = $pdo->prepare("INSERT INTO tbl_nhomquyen (nhomquyen,daxoa) VALUES (?,0)");
		$statement->execute(array($_POST['nhomquyen']));
	
    	$success_message = 'Thêm nhóm quyền thành công!!.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thêm nhóm quyền</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=quyen" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Tên nhóm quyền<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="nhomquyen">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>
