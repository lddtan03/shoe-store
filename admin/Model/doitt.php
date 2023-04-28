<?php
include("../Database/Helper.php");

if(isset($_REQUEST['id_user']))
{
    $db = new Helper();
    $statement ="Select * from tbl_users where id_user = ?";
    $para=[$_REQUEST["id_user"]];
    $result=$db->fetchOne($statement, $para);
    if($result['trangthai']==0){
        $statement="UPDATE tbl_users SET trangthai=1 where id_user=?";
    }else{
        $statement="UPDATE tbl_users SET trangthai=0 where id_user=?";
    }
    $para=[$_REQUEST["id_user"]];
    $db->execute($statement,$para);
}



?>