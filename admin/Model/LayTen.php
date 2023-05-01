<?php 
include("../Database/Helper.php");
$id=$_REQUEST['id_pro'];
$conn = new Helper();
$stmt="select ten_pro from tbl_product where id_pro =$id";
$result=$conn->fetchOne($stmt);
echo $id;
echo "???";
echo $result['ten_pro'];
?>
