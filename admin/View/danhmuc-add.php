
<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['danhmuc'])) {
        $valid = 0;
        $error_message .= "Tên Danh mục không để trống<br>";
    } else {
    	// Duplicate Category checking
    	$statement = "SELECT * FROM tbl_danhmuc WHERE danhmuc=?";
		$para=[$_POST['danhmuc']];
		$db = new Helper();
    	$total = $db->rowCount($statement,$para);
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Tên Danh mục đã tồn tại<br>";
    	}
    }

    if($valid == 1) {
		$statement = "INSERT INTO tbl_danhmuc (danhmuc,daxoa) VALUES (?,0)";
		$para=[$_POST['danhmuc']];
		$db = new Helper();
		$db->execute($statement,$para);
    	$success_message = 'Thêm Danh mục thành công.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thêm Danh mục</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=danhmuc" class="btn btn-primary btn-sm">View All</a>
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
							<label for="" class="col-sm-2 control-label">Danh mục<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="danhmuc">
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
