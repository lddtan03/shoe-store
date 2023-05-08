<?php
$conn = mysqli_connect('localhost', 'root', '', 'sneakershop');
$active_token = $_GET['active_token'];
$sql =  "UPDATE `tbl_users` SET `is_active`='1', active_token = NULL where `active_token`='$active_token'";
$result = mysqli_query($conn, $sql);
?>

<style>
    a:hover {
        color: tomato;
        text-decoration: none;
    }

    #active_account {
        margin: 0px auto;
        min-height: 500px;
    }

    h1 {
        display: inline-block;
        padding: 15px;
        border-radius: 10px;
    }

    p {
        font-size: larger;
    }

    #message-success {
        color: darkgreen;
        border: 2px solid green;
    }

    #message-error {
        color: crimson;
        border: 2px solid red;
    }
</style>
<div id="active_account" class="col-lg-12 text-center mt-5">
    <?php if ($result) { ?>
        <h1 id="message-success">Kích hoạt tài khoản thành công</h1>
        <p>Vui lòng click vào link sau để đăng nhập <a href="index.php?page=login">Đăng nhập</a></p>
    <?php } else { ?>
        <h1 id="message-error">Kích hoạt tài khoản thất bại</h1>
        <p>Quay lại trang <a href="index.php?page=sign-up">Đăng ký</a></p>
    <?php } ?>
</div>