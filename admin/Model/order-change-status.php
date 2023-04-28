

<?php
if( !isset($_REQUEST['id']) ) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_donhang WHERE id_donhang=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>

<?php
	$statement = $pdo->prepare("UPDATE tbl_donhang SET tinhtrang=? WHERE id_donhang=?");
	$statement->execute(array("Đã xác nhận",$_REQUEST['id']));

	header('location: ../Control/Trangdieukhien.php?page=order');
?>