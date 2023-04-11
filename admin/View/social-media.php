
<?php
if(isset($_POST['form1'])) {

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['facebook'],'Facebook'));

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['twitter'],'Twitter'));

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['linkedin'],'LinkedIn'));

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['youtube'],'YouTube'));

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['instagram'],'Instagram'));

	$statement = $pdo->prepare("UPDATE tbl_mangxh SET url=? WHERE tenmxh=?");
	$statement->execute(array($_POST['whatsapp'],'WhatsApp'));

	$success_message = 'Social Media URLs are updated successfully.';

}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Mạng xã hội</h1>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_mangxh");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	if($row['tenmxh'] == 'Facebook') {
		$facebook = $row['url'];
	}
	if($row['tenmxh'] == 'Twitter') {
		$twitter = $row['url'];
	}
	if($row['tenmxh'] == 'LinkedIn') {
		$linkedin = $row['url'];
	}
	if($row['tenmxh'] == 'YouTube') {
		$youtube = $row['url'];
	}
	if($row['tenmxh'] == 'Instagram') {
		$instagram = $row['url'];
	}
	if($row['tenmxh'] == 'WhatsApp') {
		$whatsapp = $row['url'];
	}

}
?>

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
						<p style="padding-bottom: 20px;">Nếu bạn muốn hiển thị mạng xã hội nào ở trang chủ, hãy điền vào ô trống đó.</p>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Facebook </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="facebook" value="<?php echo $facebook; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Twitter </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="twitter" value="<?php echo $twitter; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">LinkedIn </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="linkedin" value="<?php echo $linkedin; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">YouTube </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="youtube" value="<?php echo $youtube; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Instagram </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="instagram" value="<?php echo $instagram; ?>">
							</div>
						</div>
						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">WhatsApp </label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="whatsapp" value="<?php echo $whatsapp; ?>">
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

