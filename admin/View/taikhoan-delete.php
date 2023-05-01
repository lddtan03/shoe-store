<?php
include("../Database/Helper.php");
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
    $db = new Helper();
	$statement = "SELECT * FROM tbl_users WHERE id_user=?";
    $para=[$_REQUEST['id']];
	$total = $db->rowCount($statement,$para);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>
<?php
$db = new Helper();
	$statement = "Update tbl_users set daxoa=1 ,trangthai=1 WHERE id_user=?";
    $para=[$_REQUEST['id']];
    $db->execute($statement,$para);
	header('location: ../Control/index.php?page=taikhoan');
?>