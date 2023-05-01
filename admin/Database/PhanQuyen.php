<?php
include("./Helper.php");
function ktrPhanQuyen($nhomquyen,$quyen){
    $db = new Helper();
    $statement="SELECT * FROM tbl_phanquyen where nhomquyen=? and quyen =?";
    $para=[$nhomquyen,$quyen];
    $count = $db->rowCount($statement,$para);
if($count>0){
    return true;

}return false;
}
?>
