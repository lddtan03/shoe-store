
<style>
	* {
		font-size: 15px;
	}

	table {
		margin-top: 30px;
	}

	th {
		background-color: aqua;
	}

	thead :first-child {
		border-top-left-radius: 20px;
	}

	thead :last-child {
		border-top-right-radius: 20px;
	}
	.dong {
		border-bottom: 2px groove;
	}
    a:hover{
        cursor: pointer;
    }
</style>
<?php
require_once("../View/header.php");
ob_start();
if (isset($_GET["page"])) {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
    }
    $page = $_GET["page"];
    require_once('../View/' . $page . '.php');
    // switch ($page){
    //     case 'profile-edit':
    //         require_once('profile-edit.php');
    //         break;
    //     case 'profile-edit':
    //         require_once('logout.php');
    //         break;
    //     case "caidatwedsite":
    //         require_once("caidatwedsite.php");
    //         break;
    //     case "settings":
    //         require_once("settings.php");
    //         break;
    //     case "product-add":
    //         require_once("product-add.php");
    //         break;
    //     case "product-edit":
    //         require_once("product-edit.php");
    //         break;
    //     case 'size':
    //         require_once('size.php');
    //         break;
    //     case 'size-add':
    //         require_once('size-add.php');
    //         break;
    //     case 'size-edit':
    //         require_once('size-edit.php');
    //         break;
    //     case "color":
    //         require_once('color.php');
    //         break;
    //     case 'color-add':
    //         require_once('color-add.php');
    //         break;
    //     case 'color-edit':
    //         require_once('color-edit.php');
    //         break;
    //     case 'top-category':
    //         require_once('top-category.php');
    //         break;
    //     case "top-category-add":
    //         require_once('top-category-add.php');
    //         break;
    //     case "top-category-edit":
    //         require_once('top-category-edit.php');
    //         break;
    //     case 'mid-category':
    //         require_once('mid-category.php');
    //         break;
    //     case 'mid-category-add':
    //         require_once('mid-category-add.php');
    //         break;
    //     case 'mid-category-edit':
    //         require_once('mid-category-edit.php');
    //         break;
    //     case 'product':
    //         require_once('product.php');
    //         break;
    //     case 'order':
    //         require_once('order.php');
    //         break;
    //     case 'slider':
    //         require_once('slider.php');
    //         break;
    //     case 'slider-add':
    //         require_once('slider-add.php');
    //         break;
    //     case 'slider-edit':
    //         require_once('slider-edit.php');
    //         break;
    //     case 'customer':
    //         require_once('customer.php');
    //         break;
    //     case 'social-media':
    //         require_once('social-media.php');
    //         break;
    //     default:
    //         require_once("index.php");
    //         break;
    // }
} else {
    require_once("../View/dashboard.php");
}
ob_end_flush();
// require_once("../View/mau.php");
require_once("../View/footer.php");
?>