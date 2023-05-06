<?php
session_start();
ob_start();
$conn = mysqli_connect('localhost', 'root', '', 'sneakershop');
$username = $_POST['username'];
$email = $_POST['email'];
$sdt = $_POST['sdt'];
$diaChi = $_POST['diaChi'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$data = array();
$error = array();
if (empty($username)) {
    $error['username'] = "Không được để trống họ tên";
} else {
    $pattern = '/^([a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]{1,10})((\s{1}[a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]{1,10}){1,5})$/';
    if (!preg_match($pattern, mb_strtolower($username))) {
        $error['username'] = "Họ tên chứa ít nhất 2 từ, không chứa ký tự đặt biệt, không chứa số";
    }
}

$sql_email = "SELECT * from `tbl_users` where email = '$email'";
$result_email = mysqli_query($conn, $sql_email);
if (empty($email)) {
    $error['email'] = "Không được để trống email";
} else {
    // $pattern = '/^[A-Za-z0-9_\.]{6,32}$/';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = "Email không đúng định dạng";
    } else if (mysqli_num_rows($result_email) > 0) {
        $error['email'] = "Email đã tồn tại trên hệ thống, vui lòng nhập email khác";
    }
}

if (empty($sdt)) {
    $error['sdt'] = "Không được để trống số điện thoại";
} else {
    $pattern = '/^[0]{1}[0-9_\.]{9}$/';
    if (!preg_match($pattern, $sdt)) {
        $error['sdt'] = "Số điện thoại chứa 10 số, bắt đầu là số 0";
    }
}

if (empty($diaChi)) {
    $error['diaChi'] = "Không được để trống địa chỉ";
} else {
    $pattern = '/^([,.0-9a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]{1,10})((\s{1}[,.0-9a-vxyỳọáầảấờễàạằệếýộậốũứĩõúữịỗìềểẩớặòùồợãụủíỹắẫựỉỏừỷởóéửỵẳẹèẽổẵẻỡơôưăêâđ]{1,10}){0,5})$/';
    if (!preg_match($pattern, mb_strtolower($diaChi))) {
        $error['diaChi'] = "Địa chỉ không chứa ký tự đặc biệt";
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

if (empty($password_confirm)) {
    $error['password_confirm'] = "Bạn cần nhập lại mật khẩu";
} else {
    if ($password != $password_confirm) {
        $error['password_confirm'] = "Mật khẩu nhập lại chưa chính xác";
    }
}

// $sql = "INSERT INTO `tbl_users`(`id_user`, `ma_user`, `matkhau`, `ten_user`, `email`, `sodth`, `diachi`, `avatar`, `trangthai`, `nhomquyen`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')";
// $result = mysqli_query($conn, $sql);


// if (mysqli_num_rows($result) > 0) {
//     $data['message'] = "Đăng nhập thành công!!!";
//     $data['is_login'] = 1;
//     // $data['user'] = mysqli_fetch_assoc($result);
//     // $_SESSION["user1"] = mysqli_fetch_assoc($result);
// } else {
//     $data['message'] = "Tên đăng nhập hoặc mật khẩu không chính xác!!!";
//     $data['is_login'] = 0;
//     // $_SESSION["user"] = $result;
//     // $data['user'] = $result;
//     // $data['user'] = mysqli_fetch_assoc($result);
// }

if (isset($_POST['btnSignUp'])) {
    if (empty($error)) {
        $data['is_login'] = 1;
        $sql = "INSERT INTO `tbl_users`(`id_user`, `ma_user`, `matkhau`, `ten_user`, `email`, `sodth`, `diachi`, `avatar`, `trangthai`) VALUES ('','','$password','$username','$email','$sdt','$diaChi','','')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $data['message'] = "Đăng ký tài khoản thành công!!!";
        } else {
            $data['message'] = "Đăng ký tài khoản thất bại!!!";
        }
    }
}

$data['error'] = $error;
echo json_encode($data);
