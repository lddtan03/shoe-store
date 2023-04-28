
<?php
if(!isset($_REQUEST['id'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>

<?php

	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_slider WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
	}

	// Unlink the photo
	if($photo!='') {
		unlink('../assets/uploads/'.$photo);	
	}

	// Delete from tbl_slider
	$statement = $pdo->prepare("DELETE FROM tbl_slider WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: ../Control/Trangdieukhien.php?page=slider');
?>