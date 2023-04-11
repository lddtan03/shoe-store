<?php
if (isset($_POST['form1'])) {
	$valid = 1;

	// if (empty($_POST['danhmuc'])) {
	// 	$valid = 0;
	// 	$error_message .= "You must have to select a top level category<br>";
	// }

	// if (empty($_POST['nhanhieu'])) {
	// 	$valid = 0;
	// 	$error_message .= "You must have to select a mid level category<br>";
	// }

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
	} else {
		$valid = 0;
		$error_message .= 'You must have to select a featured photo<br>';
	}


	if ($valid == 1) {

		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			$ai_id = $row[10];
		}

		if (isset($_FILES['photo']["name"]) && isset($_FILES['photo']["tmten_pro"])) {
			$photo = array();
			$photo = $_FILES['photo']["name"];
			$photo = array_values(array_filter($photo));

			$photo_temp = array();
			$photo_temp = $_FILES['photo']["tmten_pro"];
			$photo_temp = array_values(array_filter($photo_temp));

			$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_product_photo'");
			$statement->execute();
			$result = $statement->fetchAll();
			foreach ($result as $row) {
				$next_id1 = $row[10];
			}
			$z = $next_id1;

			$m = 0;
			for ($i = 0; $i < count($photo); $i++) {
				$my_ext1 = pathinfo($photo[$i], PATHINFO_EXTENSION);
				if ($my_ext1 == 'jpg' || $my_ext1 == 'png' || $my_ext1 == 'jpeg' || $my_ext1 == 'gif') {
					$final_name1[$m] = $z . '.' . $my_ext1;
					move_uploaded_file($photo_temp[$i], "../assets/uploads/product_photos/" . $final_name1[$m]);
					$m++;
					$z++;
				}
			}

			if (isset($final_name1)) {
				for ($i = 0; $i < count($final_name1); $i++) {
					$statement = $pdo->prepare("INSERT INTO tbl_product_photo (photo,p_id) VALUES (?,?)");
					$statement->execute(array($final_name1[$i], $ai_id));
				}
			}
		}

		$final_name = 'product-featured-' . $ai_id . '.' . $ext;
		move_uploaded_file($path_tmp, '../assets/uploads/' . $final_name);

		//Saving data into the main table tbl_product
		$statement = $pdo->prepare("INSERT INTO tbl_product(
										ten_pro,
										id_danhmuc,
										id_nhanhieu,
										giacu,
										giamoi,
										hinhanh,
										mota,
										total_view
										-- p_is_featured,
										-- p_is_active,
									) VALUES (?,?,?,?,?,?,?,?)");
		$statement->execute(array(
			$_POST['ten_pro'],
			$_POST['danhmuc'],
			$_POST['nhanhieu'],
			$_POST['giacu'],
			$_POST['giamoi'],
			$final_name,
			$_POST['mota'],
			0
			// $_POST['p_is_featured'],
			// $_POST['p_is_active'],
		));
		$statement = $pdo->prepare("SELECT FROM tbl_size ");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			$size = $row['size'];
			$id_size = $row['id_size'];
			if(isset($_POST[$size])){
				$statement = $pdo->prepare("INSERT INTO tbl_pro_soluong(id_pro,id_size,soluong, values(?,?,?");
				$statement->execute(array($_REQUEST['id']), $id_size,$_POST['size']);
			}else{
				$statement = $pdo->prepare("INSERT INTO tbl_pro_soluong(id_pro,id_size,soluong, values(?,?,?");
				$statement->execute(array($_REQUEST['id']), $id_size,0);
			}
		}
		$success_message = 'Product is added successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thêm sản phẩm</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=product" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>
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
								<select name="danhmuc" class="form-control select2 top-cat">
									<option value="">Chọn danh mục</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_danhmuc ORDER BY danhmuc ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_danhmuc']; ?>"><?php echo $row['danhmuc']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Nhãn hiệu <span>*</span></label>
							<div class="col-sm-4">
								<select name="nhanhieu" class="form-control select2 mid-cat">
									<option value="">Chọn nhãn hiệu</option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu ORDER BY nhanhieu ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_nhanhieu']; ?>"><?php echo $row['nhanhieu']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Tên sản phẩm<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="ten_pro" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá trước đây<br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giacu" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá hiện tại<span>*</span><br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giamoi" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Số lượng<span>*</span></label>
							<!-- <div class="col-sm-4">
								<input type="text" name="p_qty" class="form-control">
							</div> -->
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
							<label for="" class="col-sm-3 control-label">Ảnh hiển thị<span>*</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="hinhanh" accept=".jpg, .png">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Ảnh khác<br><span style="font-size:10px;font-weight:normal;">(Có thể không chọn hoặc chọn nhiều ảnh)</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<table id="ProductTable" style="width:100%;">
									<input type="file" name="photo[]" style="margin-bottom:5px;" accept=".jpg, .png" multiple>
								</table>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Mô tả</label>
							<div class="col-sm-8">
								<textarea name="mota" class="form-control" cols="30" rows="10" id="editor1"></textarea>
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
								<button type="submit" class="btn btn-success pull-left" name="form1">Thêm vào kho</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>