<?php
session_start();
include("../Control/inc/config.php");
include("../Control/inc/functions.php");
$error_message = '';

if (isset($_POST['form1'])) {

	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error_message = 'Email and/or Password can not be empty<br>';
	} else {

		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);

		$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE email=?");
		$statement->execute(array($email));
		$total = $statement->rowCount();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		if ($total == 0) {
			$error_message .= 'Email Address does not match<br>';
		} else {
			foreach ($result as $row) {
				$row_password = $row['matkhau'];
			}

			if ($row_password != ($password)) {
				$error_message .= 'Password does not match<br>';
			} else {

				$_SESSION['user'] = $row;
				header("location: ../Control/index.php?page=dashboard");
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="../Control/css/bootstrap.min.css">
	<link rel="stylesheet" href="../Control/css/font-awesome.min.css">
	<link rel="stylesheet" href="../Control/css/ionicons.min.css">
	<link rel="stylesheet" href="../Control/css/datepicker3.css">
	<link rel="stylesheet" href="../Control/css/all.css">
	<link rel="stylesheet" href="../Control/css/select2.min.css">
	<link rel="stylesheet" href="../Control/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../Control/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../Control/css/_all-skins.min.css">

	<link rel="stylesheet" href="style.css">
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>

<body class="hold-transition login-page sidebar-mini">

	<div class="login-box">
		<div class="login-logo">
			<b>Admin Panel</b>
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Log in to start your session</p>

			<?php
			if ((isset($error_message)) && ($error_message != '')) :
				echo '<div class="error">' . $error_message . '</div>';
			endif;
			?>

			<form action="" method="post">
				<div class="form-group has-feedback">
					<input class="form-control" placeholder="Email address" name="email" type="email" autocomplete="off" autofocus>
				</div>
				<div class="form-group has-feedback">
					<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
				</div>
				<div class="row">
					<div class="col-xs-8"></div>
					<div class="col-xs-4">
						<input type="submit" class="btn btn-success btn-block btn-flat login-button" name="form1" value="Log In">
					</div>
				</div>
			</form>
		</div>
	</div>


	<!-- <script src="../Control/js/jquery-2.2.3.min.js"></script>
<script src="../Control/js/bootstrap.min.js"></script>
<script src="../Control/js/jquery.dataTables.min.js"></script>
<script src="../Control/js/dataTables.bootstrap.min.js"></script>
<script src="../Control/js/select2.full.min.js"></script>
<script src="../Control/js/jquery.inputmask.js"></script>
<script src="../Control/js/jquery.inputmask.date.extensions.js"></script>
<script src="../Control/js/jquery.inputmask.extensions.js"></script>
<script src="../Control/js/moment.min.js"></script>
<script src="../Control/js/bootstrap-datepicker.js"></script>
<script src="../Control/js/icheck.min.js"></script>
<script src="../Control/js/fastclick.js"></script>
<script src="../Control/js/jquery.sparkline.min.js"></script>
<script src="../Control/js/jquery.slimscroll.min.js"></script>
<script src="../Control/js/app.min.js"></script>
<script src="../Control/js/demo.js"></script> -->

</body>

</html>