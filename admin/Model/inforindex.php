<?php


$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_users");
$statement->execute();
$total_customers = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_phieuxuat");
$statement->execute();
$total_order = $statement->rowCount();

$statement = $pdo->prepare("SELECT SUM(tongia) FROM tbl_phieuxuat");
$statement->execute();
$total_money = $statement->rowCount();

?>