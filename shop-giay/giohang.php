<?php
if (isset($_POST['clear'])) {
    $_SESSION['cart'] = array();
}
$tong_tien = 0;
if (isset($_POST['xoa'])) {
    $id_xoa = $_POST['id_xoa'];
    $size_xoa = $_POST['size_xoa'];
    $array = $_SESSION['cart'];
    foreach ($array as $spnh) {
        if ($spnh['id_pro'] == $id_xoa && $spnh['size'] == $size_xoa) {
            unset($array[$spnh['index']]);
            break;
        }
    }
    $_SESSION['cart'] = $array;
    echo "<script type='text/javascript'>alert('Đã xóa');</script>";
}
if (isset($_POST['thanhtoan'])) {
    $valid = 1;
    if (!isset($_SESSION["user1"])) {
        $valid = 0;
        echo "<script type='text/javascript'>alert('Bạn chưa đăng nhập');</script>";
    }
    if (count($_SESSION["cart"]) == 0) {
        $valid = 0;
        echo "<script type='text/javascript'>alert('Giỏ hàng trống');</script>";
    }
    if ($valid == 1) {
        date_default_timezone_set('Africa/Nairobi');
        $now = date('Y-m-d');
        $db = new Helper();
        $stmt = "insert into tbl_phieuxuat(id_kh,tongtien,tongsl,ngaydat)value(?,?,?,?)";
        $para = [$_SESSION["user1"]["id_user"], $_POST['tongtien'], $_POST['tongsl'], $now];
        $db->execute($stmt, $para);
        $stmt1 = "select id_px from tbl_phieuxuat ORDER BY id_px desc limit 1";
        $result1 = $db->fetchOne($stmt1);
        $id_px = $result1['id_px'];
        foreach ($_SESSION['cart'] as $spnh) {
            $stmt = "insert into tbl_chitiet_px (id_px,id_pro,id_size,soluong,giaban) value (?,?,?,?,?)";
            $para = [$id_px, $spnh['id_pro'], $spnh['id_size'], $spnh['soluong'], $spnh['giamoi']];
            $db->execute($stmt, $para);
        }
        $_SESSION['cart'] = array();
        echo "<script type='text/javascript'>alert('Mua hàng thành công');</script>";
    }
}
?>

<body>
    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 1850px;
                padding: 0px 50px;
            }
        }

        @media (max-width: 768px) {
            .cart {
                display: none;
            }
        }
    </style>
    <h2 class="text-center mt-3 mb-3">SẢN PHẨM TRONG GIỎ HÀNG</h2>
    <div class="container">
        <div class="row">
            <div class="cart col-xl-8 border col-md-12 mb-md-4">
                <div class="cart-title row shadow border py-1">
                    <div class="col-md-1 text-center p-1">Mã SP</div>
                    <div class="col-md-2 text-center p-1">Hình Ảnh</div>
                    <div class="col-md-3 text-center p-1">Tên SP</div>
                    <div class="col-md-1 text-center p-1">Size</div>
                    <div class="col-md-1 text-center p-1">Giá</div>
                    <div class="col-md-3 text-center p-1">Số lượng</div>
                    <div class="col-md-1 text-center p-1">Hành động</div>
                </div>
                <?php
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $row) {
                ?>
                        <div class="cart-body row mt-2 border shadow text-center d-flex align-items-center py-2">
                            <div class="col-md-1"><?php echo $row['id_pro'] ?></div>
                            <div class="col-md-2"> <img src="../uploads/<?php echo $row['hinhanh'] ?>" alt="" /></div>
                            <div class="col-md-3 text-left"><?php echo $row['ten_pro'] ?></div>
                            <div class="col-md-1"><?php echo $row['size'] ?></div>
                            <div class="col-md-1 text-left"><?php echo money($row['giamoi']) ?></div>
                            <div class="col-md-3 mx-auto">
                                <div class="row d-flex justify-content-center">
                                    <span class="quantity-btn minus" onclick="TangGiamSL(<?php echo $row['id_pro'] + $row['size'] ?>,-1)"><img src="../uploads/minus.jpg" style="width:70%;"></span>
                                    <input type="text" style="width: 20%; text-align:center" id="<?php echo $row['id_pro'] + $row['size'] ?>" name="quantity_temp" min="0" value="<?php echo $row['soluong'] ?>" readonly>
                                    <span class="quantity-btn plus" onclick="TangGiamSL(<?php echo $row['id_pro'] + $row['size'] ?>,1)"><img src="../uploads/add.jpg" style="width: 70% ;"></span>
                                </div>
                            </div>
                            <form method="POST">
                                <input type="text" name="id_xoa" hidden value="<?php echo $row['id_pro'] ?>">
                                <input type="text" name="size_xoa" hidden value="<?php echo $row['size'] ?>">
                                <button name="xoa" onclick="return confirm('Bạn có muốn xóa không')" class="btn btn-danger">Xóa</button>
                            </form>
                        </div>
                <?php
                    }
                    if (count($_SESSION["cart"]) == 0) {
                    }
                } else {
                    echo '<h4 class="text-center mt-4">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
                }
                ?>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="row">
                    <div class="col-xl-1"></div>
                    <?php
                    if (isset($_SESSION["user1"])) {
                        $ten_user = $_SESSION['user1']['ten_user'];
                        $sodth = $_SESSION['user1']['sodth'];
                        $email = $_SESSION['user1']['email'];
                        $diachi = $_SESSION['user1']['diachi'];
                    } else {
                        $ten_user = "";
                        $sodth = "";
                        $email = "";
                        $diachi = "";
                    }
                    $tong_tien = 0;
                    $tongsl = 0;
                    if (isset($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $row) {
                            $tongsl += $row['soluong'];
                            $tong_tien += $row['giamoi'] * $row['soluong'];
                        }
                    }
                    ?>
                    <div class="col-xl-11 col-md-12 border shadow py-3 px-4">
                        <h4 class="text-center mt-2"><strong>Thông tin thanh toán</strong></h4>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Họ tên:</h5>
                            <h5 class="col-md-8"><strong><?php echo $ten_user ?></strong></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Số điện thoại:</h5>
                            <h5 class="col-md-8"><strong><?php echo $sodth ?></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Email:</h5>
                            <h5 class="col-md-8"><strong><?php echo $email ?></strong></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Địa chỉ:</h5>
                            <h5 class="col-md-8"><strong><?php echo $diachi ?></strong></h5>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-7">
                                <h4>Tổng tiền: <strong><?php echo money($tong_tien) ?></strong></h4>
                            </div>
                            <div class="col-md-5">
                                <h4>Số lượng: <strong><?php echo $tongsl ?></strong></h4>
                            </div>
                        </div>

                        <div class="row mt-3 d-flex justify-content-between">
                            <form method="post">
                                <input type="text" name="tongtien" hidden value="<?php echo $tong_tien ?>">
                                <input type="text" name="tongsl" hidden value="<?php echo $tongsl ?>">
                                <input type="submit" class="btn btn-success" name="thanhtoan" value="Thanh Toán">
                                <input type="submit" name="clear" onclick="return confirm('Bạn có muốn xóa hết không')" value="Xóa danh sách" class="btn btn-danger" style="font-size: 1rem!important;"></input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    function TangGiamSL(phantu, sl) {
        var ht = document.getElementById(phantu).value;
        if (ht * 1 + sl * 1 > 0) {
            document.getElementById(phantu).value = ht * 1 + sl * 1;
        }
    }
</script>