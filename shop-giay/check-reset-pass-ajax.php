<?php

$conn = mysqli_connect('localhost', 'root', '', 'sneakershop');
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$reset_token = $_POST['reset_token'];
$data = array();
$error = array();

if (empty($password)) {
    $error['password'] = "Không được để trống mật khẩu";
} else {
    $pattern = '/^[A-Za-z0-9_\.!@#$%^&*()]{5,32}$/';
    if (!preg_match($pattern, $password)) {
        $error['password'] = "Mật khẩu chứa ít nhất 5 ký tự, không chứa khoảng trắng và không có dấu";
    }
}

if (empty($password_confirm)) {
    $error['password_confirm'] = "Bạn cần nhập lại mật khẩu";
} else {
    if ($password != $password_confirm) {
        $error['password_confirm'] = "Mật khẩu nhập lại chưa chính xác";
    }
}


if (isset($_POST['btnResetPass'])) {
    if (empty($error)) {
        $data['is_reset_pass'] = 1;
        $sql =  "UPDATE tbl_users SET matkhau ='$password_confirm' where `reset_token`='$reset_token'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $data['message'] = "Cập nhật mật khẩu thành công!!!";
        }
    }
}

$data['error'] = $error;
echo json_encode($data);
