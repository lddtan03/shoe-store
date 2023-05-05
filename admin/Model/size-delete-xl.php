<?php
include("../Control/inc/config.php");
// Preventing the direct access of this page.
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_size WHERE id_size=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if ($total == 0) {
		header('location: logout.php');
		exit;
	}
}
?>
<?php
$statement = $pdo->prepare("update tbl_size set daxoa=1 WHERE id_size=?");
$statement->execute(array($_REQUEST['id']));
header('location: ../Control/index.php?page=size');
?>