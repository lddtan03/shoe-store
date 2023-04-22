

<?php
 ob_start();
require_once("header.php");
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case "home":
            require_once("home.php");
            break;
        case "login":
            require_once("login.php");
            break;
        case "sign-up":
            require_once("sign-up.php");
            break;
        case "product":
            require_once("product.php");
            break;
        case "chitietsp":
            require_once("giohang.php");
            break;
        case "giohang":
            require_once("giohang.php");
            break;
        case "forgot-pass":
            require_once("forgot-pass.php");
            break;
        default:
            require_once("home.php");
            break;
    }
} else {
    require_once("home.php");
}
require_once("footer.php");
ob_end_flush();
?>