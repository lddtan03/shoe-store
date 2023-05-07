<?php
$conn = mysqli_connect('localhost', 'root', '', 'sneakershop');
$active_token = $_GET['active_token'];
$sql =  "UPDATE `tbl_users` SET `is_active`='1' where `active_token`='$active_token'";
$result = mysqli_query($conn, $sql);
if($result){
    echo "Kích hoạt tài khoản thành công, vui lòng click vào link sau để đăng nhập: <a href='http://localhost/unitop.vn/front-end/DOANWED/shop-giay/index.php?page=login'>Đăng nhập</a>";
}else{
    echo "Kích hoạt tài khoản thất bại";
}
?>
