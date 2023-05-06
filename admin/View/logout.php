<?php 
ob_start();
include '../Control/inc/config.php'; 
unset($_SESSION['user']);
ob_flush();
header("location: ../../shop-giay/index.php"); 
?>