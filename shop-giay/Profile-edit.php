<?php
if (isset($_POST['form1'])) {

	if ($_SESSION['user']['role'] == 'Super Admin') {

		$valid = 1;

		if (empty($_POST['full_name'])) {
			$valid = 0;
			$error_message .= "Name can not be empty<br>";
		}

		if (empty($_POST['email'])) {
			$valid = 0;
			$error_message .= 'Email address can not be empty<br>';
		} else {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
				$valid = 0;
				$error_message .= 'Email address must be valid<br>';
			} else {
				// current email address that is in the database
				$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE id_user=?");
				$statement->execute(array($_SESSION['user']['id_user']));
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result as $row) {
					$current_email = $row['email'];
				}

				$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE email=? and email!=?");
				$statement->execute(array($_POST['email'], $current_email));
				$total = $statement->rowCount();
				if ($total) {
					$valid = 0;
					$error_message .= 'Email address already exists<br>';
				}
			}
		}

		if ($valid == 1) {

			$_SESSION['user']['full_name'] = $_POST['full_name'];
			$_SESSION['user']['email'] = $_POST['email'];

			// updating the database
			$statement = $pdo->prepare("UPDATE tbl_users SET full_name=?, email=?, sodth=? WHERE id_user=?");
			$statement->execute(array($_POST['full_name'], $_POST['email'], $_POST['sodth'], $_SESSION['user']['id_user']));

			$success_message = 'User Information is updated successfully.';
		}
	} else {
		$_SESSION['user']['sodth'] = $_POST['sodth'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET sodth=? WHERE id_user=?");
		$statement->execute(array($_POST['sodth'], $_SESSION['user']['id_user']));

		$success_message = 'User Information is updated successfully.';
	}
}

if (isset($_POST['form2'])) {

	$valid = 1;

	$path = $_FILES['avatar']['name'];
	$path_tmp = $_FILES['avatar']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}

	if ($valid == 1) {

		// removing the existing avatar
		if ($_SESSION['user']['avatar'] != '') {
			unlink('../../uploads/' . $_SESSION['user']['avatar']);
		}

		// updating the data
		$final_name = 'user-' . $_SESSION['user']['id_user'] . '.' . $ext;
		move_uploaded_file($path_tmp, '../../uploads/' . $final_name);
		$_SESSION['user']['avatar'] = $final_name;

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET avatar=? WHERE id_user=?");
		$statement->execute(array($final_name, $_SESSION['user']['id_user']));

		$success_message = 'User avatar is updated successfully.';
	}
}

if (isset($_POST['form3'])) {
	$valid = 1;

	if (empty($_POST['password']) || empty($_POST['re_password'])) {
		$valid = 0;
		$error_message .= "Password can not be empty<br>";
	}

	if (!empty($_POST['password']) && !empty($_POST['re_password'])) {
		if ($_POST['password'] != $_POST['re_password']) {
			$valid = 0;
			$error_message .= "Passwords do not match<br>";
		}
	}

	if ($valid == 1) {

		$_SESSION['user']['matkhau'] = $_POST['password'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET matkhau=? WHERE id_user=?");
		$statement->execute(array($_POST['password'], $_SESSION['user']['id_user']));

		$success_message = 'User Password is updated successfully.';
	}
}
?>

<section class="content-header container mt-2">
	<div class="content-header">
		<h1>Edit Profile</h1>
	</div>
</section>

<?php
$full_name = $_SESSION['user1']['ten_user'];
$email     = $_SESSION['user1']['email'];
$sodth     = $_SESSION['user1']['sodth'];
$avatar     = $_SESSION['user1']['avatar'];
?>
<style>
	.tabne{
		margin-right: 20px;
		margin-bottom: 10px;
	}
</style>

<section class="content container">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs mt-2 mb-2">
					<li class="tabne" class="active"><a href="#tab_1" data-toggle="tab">Update Information</a></li>
					<li class="tabne"><a href="#tab_2" data-toggle="tab">Update avatar</a></li>
					<li class="tabne"><a href="#tab_3" data-toggle="tab">Update Password</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<div class="form-group">
											<label for="" class="col-sm-2 control-label">Ảnh đại diện</label>
											<div class="col-sm-6" style="padding-top:6px;">
												<img src="../uploads/<?php echo $avatar ?>" class="existing-avatar" style="width:200px;height:200px">
											</div>
										</div>
										<label for="" class="col-sm-2 control-label">Họ Tên<span>*</span></label>

										<div class="col-sm-4" style="padding-top:7px;">
											<input type="text" name="hoten" id="" value="<?php echo $full_name ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email<span>*</span></label>

										<div class="col-sm-4">
											<input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Số điện thoại</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="sodth" value="<?php echo $sodth; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update Information</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_2">
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">New avatar</label>
										<div class="col-sm-6" style="padding-top:6px;">
											<input type="file" name="avatar">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update avatar</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane" id="tab_3">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Retype Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="re_password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update Password</button>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>

		</div>
	</div>
</section>