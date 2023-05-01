<?php 
include("../Database/Helper.php");
$db=new Helper();
$stmt="update tbl_users set nhomquyen =?,id_loaitk=2 where id_user =?";
$para =[$_REQUEST["nhomquyen"],$_REQUEST["id_tk"]];
$db->execute($stmt,$para);
header("location: ../Control/index.php?page=taikhoan"); 
?> 