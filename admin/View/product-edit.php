<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['id_dm'])) {
		$valid = 0;
		$error_message .= "You must have to select a top level category<br>";
	}

	if (empty($_POST['mcat_id'])) {
		$valid = 0;
		$error_message .= "You must have to select a mid level category<br>";
	}

	if (empty($_POST['ten_pro'])) {
		$valid = 0;
		$error_message .= "Product name can not be empty<br>";
	}

	if (empty($_POST['giamoi'])) {
		$valid = 0;
		$error_message .= "Current Price can not be empty<br>";
	}

	$path = $_FILES['hinhanh']['name'];
	$path_tmp = $_FILES['hinhanh']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}


	if ($valid == 1) {

		// if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmten_pro"])) {

		// 	$photo = array();
		// 	$photo = $_FILES['photo']["name"];
		// 	$photo = array_values(array_filter($photo));

		// 	$photo_temp = array();
		// 	$photo_temp = $_FILES['photo']["tmten_pro"];
		// 	$photo_temp = array_values(array_filter($photo_temp));

		// 	$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
		// 	$statement->execute();
		// 	$result = $statement->fetchAll();
		// 	foreach ($result as $row) {
		// 		$next_id1 = $row[10];
		// 	}
		// 	$z = $next_id1;

		// 	$m = 0;
		// 	for ($i = 0; $i < count($photo); $i++) {
		// 		$my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
		// 		if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
		// 			$final_name1[$m] = $z . '.' . $my_ext1;
		// 			move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $final_name1[$m]);
		// 			$m++;
		// 			$z++;
		// 		}
		// 	}

		// 	if (isset($final_name1)) {
		// 		for ($i = 0; $i < count($final_name1); $i++) {
		// 			$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,id_pro) VALUES (?,?)");
		// 			$statement->execute(array($final_name1[$i], $_REQUEST['id']));
		// 		}
		// 	}
		// }

		if ($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							ten_pro=?, 
        							giacu=?, 
        							giamoi=?,
        							mota=?
        							-- p_is_featured=?,
        							-- p_is_active=?,
        							WHERE id_pro=?");
			$statement->execute(array(
				$_POST['ten_pro'],
				$_POST['giacu'],
				$_POST['giamoi'],
				$_POST['mota'],
				// $_POST['p_is_featured'],
				// $_POST['p_is_active'],
				$_REQUEST['id']
			));
		} else {

			// unlink('../assets/uploads/' . $_POST['current_photo']);

			$final_name = 'product-featured-' . $_REQUEST['id'] . '.' . $ext;
			move_uploaded_file($path_tmp, '../../uploads/' . $final_name);


			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							ten_pro=?, 
        							giacu=?, 
        							giamoi=?, 
        							hinhanh=?,
        							mota=?     							
        							-- p_is_featured=?,
        							-- p_is_active=?,

        							WHERE id_pro=?");
			$statement->execute(array(
				$_POST['ten_pro'],
				$_POST['giacu'],
				$_POST['giamoi'],
				$final_name,
				$_POST['mota'],
				// $_POST['p_is_featured'],
				// $_POST['p_is_active'],
				$_REQUEST['id']
			));
		}

		// $statement = $pdo->prepare("SELECT FROM tbl_size ");
		// $statement->execute();
		// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
		// foreach ($result as $row) {
		// 	$size = $row['size'];
		// 	$id_size=$row['id_size'];
		// 	if (isset($_POST[$size])) {
		// 		$statement = $pdo->prepare("UPDATE tbl_pro_soluong set soluong=? where id_pro=? and id_size=?");
		// 		$statement->execute(array($_POST['size'],$_REQUEST['id']),$id_size);
		// 	} 
		// }
		$success_message = 'Product is updated successfully.';
	}
}
?>

<?php
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE id_pro=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if ($total == 0) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Product</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=product" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE id_pro=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ten_pro = $row['ten_pro'];
	$giacu = $row['giacu'];
	$giamoi = $row['giamoi'];
	$mota = $row['mota'];
	$hinhanh = $row['hinhanh'];
	// 	$p_is_featured = $row['p_is_featured'];
	// 	$p_is_active = $row['p_is_active'];
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

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Danh mục<span>*</span></label>
							<div class="col-sm-4">
								<select name="id_dm" class="form-control select2 top-cat">
									<?php
									$idne = $_REQUEST['id'];
									$statement = $pdo->prepare("SELECT * FROM tbl_danhmuc WHERE id_dm= $idne");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_dm']; ?>"><?php echo $row['danhmuc']; ?></option>
									<?php
									}
									?>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_danhmuc WHERE id_dm <> $idne");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_dm']; ?>"><?php echo $row['danhmuc']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Nhãn hiệu<span>*</span></label>
							<div class="col-sm-4">
								<select name="mcat_id" class="form-control select2 mid-cat">
									<?php
									$idne = $_REQUEST['id'];
									$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu WHERE id_nh= $idne");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_nh']; ?>"><?php echo $row['nhanhieu']; ?></option>
									<?php
									}
									?>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu WHERE id_nh <> $idne");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_nh']; ?>"><?php echo $row['nhanhieu']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Tên sản phẩm<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="ten_pro" class="form-control" value="<?php echo $ten_pro; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá cũ<br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giacu" class="form-control" value="<?php echo $giacu; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá hiện tại<span>*</span><br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giamoi" class="form-control" value="<?php echo $giamoi; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Số lượng<span>*</span></label>
							<div class="d-flex">
								<?php
								$statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size ASC");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
								?>
									<div style="float:left; margin-right:10px;">
										<label for="" class="control-label"><?php echo $row['size']; ?><input type="text" style="width:30px; margin-left:5px;" name="<?php echo $row['size']; ?>"></label>
									</div>
								<?php
								}
								?>
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="" class="col-sm-3 control-label">Select Size</label>
							<div class="col-sm-4">
								<select name="size[]" class="form-control select2" multiple="multiple">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY id_size ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_size']; ?>"><?php echo $row['size']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div> -->

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Ảnh hiển thị<span></span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<img src="../../uploads/<?php echo $hinhanh ?>" alt="" width="80px">

								<input type="text" name="current_photo" value="<?php echo $hinhanh ?>" hidden>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Chọn ảnh khác<span>*</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="hinhanh" accept=".jpg, .png">
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="" class="col-sm-3 control-label">Ảnh khác<br><span style="font-size:10px;font-weight:normal;">(Có thể không chọn hoặc chọn nhiều ảnh)</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<table id="ProductTable" style="width:100%;">
									<input type="file" name="photo[]" style="margin-bottom:5px;" accept=".jpg, .png" multiple>
								</table>
							</div>
						</div> -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Mô tả</label>
							<div class="col-sm-8">
								<textarea name="mota" class="form-control" cols="30" rows="10" id="editor1"><?php echo $mota?></textarea>
							</div>
						</div>
						<!-- <div class="form-group">
							<label for="" class="col-sm-3 control-label">Features</label>
							<div class="col-sm-8">
								<textarea name="p_feature" class="form-control" cols="30" rows="10" id="editor3"></textarea>
							</div>
						</div> -->
						<!-- <div class="form-group">
							<label for="" class="col-sm-3 control-label">Conditions</label>
							<div class="col-sm-8">
								<textarea name="p_condition" class="form-control" cols="30" rows="10" id="editor4"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Return Policy</label>
							<div class="col-sm-8">
								<textarea name="p_return_policy" class="form-control" cols="30" rows="10" id="editor5"></textarea>
							</div>
						</div> -->
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Featured?</label>
							<div class="col-sm-8">
								<select name="p_is_featured" class="form-control" style="width:auto;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Is Active?</label>
							<div class="col-sm-8">
								<select name="p_is_active" class="form-control" style="width:auto;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Cập nhật</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>