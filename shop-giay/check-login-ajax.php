<?php
session_start();
ob_start();
$conn = mysqli_connect('localhost', 'root', '', 'sneakershop');
$email = $_POST['email'];
$password = $_POST['password'];

$data = array();
$error = array();
if (isset($_POST['btnLogin'])) {
    if (empty($email)) {
        $error['email'] = "Không được để trống email";
    } else {
        // $pattern = '/^[A-Za-z0-9_\.]{6,32}$/';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Email không đúng định dạng";
        }
    }

    if (empty($password)) {
        $error['password'] = "Không được để trống mật khẩu";
    } else {
        $pattern = '/^[A-Za-z0-9_\.!@#$%^&*()]{5,32}$/';
        if (!preg_match($pattern, $password)) {
            $error['password'] = "Mật khẩu chứa ít nhất 5 ký tự, không chứa khoảng trắng và không có dấu";
        }
    }

    $sql = "SELECT * from `tbl_users` where email = '$email' and matkhau = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data['message'] = "Đăng nhập thành công!!!";
        $data['is_login'] = 1;
        // $data['user'] = mysqli_fetch_assoc($result);
        $_SESSION["user1"] = mysqli_fetch_assoc($result);
    } else {
        $data['message'] = "Tài khoản của bạn không tồn tại trên hệ thống!!!";
        $data['is_login'] = 0;
        // $_SESSION["user"] = $result;
        // $data['user'] = $result;
        // $data['user'] = mysqli_fetch_assoc($result);
    }

    $data['error'] = $error;

    echo json_encode($data);
}
