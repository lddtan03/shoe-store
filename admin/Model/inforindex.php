<?php


$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_users where id_loaitk=1");
$statement->execute();
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_phieuxuat");
$statement->execute();
$total_order = $statement->rowCount();

$db = new Helper();
$stmt= "SELECT SUM(tongtien) as tong FROM tbl_phieuxuat";
$result=$db->fetchOne($stmt);
$total_money = $result['tong'];

?>