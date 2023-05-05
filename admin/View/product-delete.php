<?php
include("../Control/inc/config.php");
if(!isset($_REQUEST['id'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE id_pro=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>

<?php
	$db = new Helper();
	$stmt ="update tbl_product set daxoa=1 where id_pro =?";
	$para=[$_REQUEST['id']];
	$db->execute($stmt,$para);

	header('location: index.php?page=product');

?>