<?php
if (!isset($_REQUEST['nhomquyen'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_nhomquyen WHERE nhomquyen=?");
	$statement->execute(array($_REQUEST['nhomquyen']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if ($total == 0) {
		header('location: ../View/logout.php');
		exit;
	}
}
if (isset($_POST['capquyen'])) {
	$db = new Helper();
	$quyen = $_POST['quyen'];
	$stateclear = "DELETE FROM tbl_phanquyen where nhomquyen=?";
	$para = [$_REQUEST['nhomquyen']];
	$db->execute($stateclear, $para);
	$statement = "INSERT INTO tbl_phanquyen(nhomquyen,quyen) VALUES (?,?)";
	foreach ($quyen as $q) {
		$para = [$_REQUEST['nhomquyen'], $q];
		$db->execute($statement, $para);
	}
	$success_message = 'Cập nhật quyền thành công!!';
}
function kttontai($quyen)
{
	$db = new Helper();
	$statement = "SELECT quyen FROM tbl_phanquyen where nhomquyen=?";
	$para = [$_REQUEST['nhomquyen']];
	$result = $db->fetchAll($statement, $para);
	foreach ($result as $q) {
		if ($quyen == $q['quyen']) {
			return true;
		}
	}
	return false;
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý quyền</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=quyen" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>
			<div class="box box-info" >
				<div class="box-body">
					<form method="post">
						<div class="row" style="margin-left: 40px;">

							<div class="col-md-2">
								<label for="">Sản phẩm</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("sp-xem")) echo "checked" ?> value="sp-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("sp-them")) echo "checked" ?> value="sp-them"> Thêm</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("sp-sua")) echo "checked" ?> value="sp-sua"> Sửa</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("sp-xoa")) echo "checked" ?> value="sp-xoa"> Xóa</div>
							</div>
							<div class="col-md-2">
								<label for="">Đơn hàng</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("dh-xem")) echo "checked" ?> value="dh-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("dh-xacnhan")) echo "checked" ?> value="dh-xacnhan"> Xác nhận</div>
								<!-- <div><input type="checkbox" name="quyen[]" id=""> Xóa</div> -->
							</div>
							<div class="col-md-2">
								<label for="">Slider</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("slider-xem")) echo "checked" ?> value="slider-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("slider-them")) echo "checked" ?> value="slider-them"> Thêm</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("slider-sua")) echo "checked" ?> value="slider-sua"> Sửa</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("slider-xoa")) echo "checked" ?> value="slider-xoa"> Xóa</div>
							</div>
							<div class="col-md-2">
								<label for="">Cài đặt shop</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("cds-xem")) echo "checked" ?> value="cds-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("cds-sua")) echo "checked" ?> value="cds-sua"> Sửa</div>
							</div>
							<div class="col-md-2">
								<label for="">Tài khoản</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("tk-xem")) echo "checked" ?> value="tk-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("tk-dtt")) echo "checked" ?> value="tk-dtt"> Đổi trạng thái</div>
							</div>
							<div class="col-md-2">
								<label for="">Mạng xã hội</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("mxh-xem")) echo "checked" ?> value="mxh-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("mxh-sua")) echo "checked" ?> value="mxh-sua"> Sửa</div>
							</div>
						</div>
						<div class="row" style="margin-left: 40px;margin-top:30px;">

							<div class="col-md-2">
								<label for="">Cài đặt Wedsite</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("cdw-xem")) echo "checked" ?> value="cdw-xem"> Xem</div>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("cdw-sua")) echo "checked" ?> value="cdw-sua"> Sửa</div>
							</div>
							<div class="col-md-2">
								<label for="">Thống kê</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("tke-xem")) echo "checked" ?> value="tke-xem"> Xem</div>
								<!-- <div><input type="checkbox" name="quyen[]" <?php if (kttontai("dh-xacnhan")) echo "checked" ?> value="dh-xacnhan"> Xác nhận</div> -->
								<!-- <div><input type="checkbox" name="quyen[]" id=""> Xóa</div> -->
							</div>
							<div class="col-md-2">
								<label for="">Dashboard</label>
								<div><input type="checkbox" name="quyen[]" <?php if (kttontai("dabo-xem")) echo "checked" ?> value="dabo-xem"> Xem</div>
							</div>
							
						</div>
						<div class="form-group mt-3 mb-2">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<input type="submit" name="capquyen" class="btn btn-success pull-left" value="Cập nhật" name="form1"></input>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
</section>