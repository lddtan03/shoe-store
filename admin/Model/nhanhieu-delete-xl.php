
<?php
include("../Control/inc/config.php");
	// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu WHERE id_nh=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>
<?php
	$statement = $pdo->prepare("update tbl_nhanhieu set daxoa=1 WHERE id_nh=?");
	$statement->execute(array($_REQUEST['id']));
	header('location: ../Control/index.php?page=nhanhieu');
?>