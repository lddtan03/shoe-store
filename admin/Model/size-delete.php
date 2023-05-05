
<?php
include("../Control/inc/config.php");

// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_size WHERE id_size=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>

<?php

	$statement = $pdo->prepare("DELETE FROM tbl_size WHERE id_size=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: ../Control/Trangdieukhien.php?page=size');
?>