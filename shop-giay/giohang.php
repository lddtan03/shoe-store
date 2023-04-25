<?php
if (isset($_POST['quantity_temp'])) {
    $_SESSION['quantity_temp'] = $_POST['quantity_temp'];
    echo "success";
} else {
}
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();


if (isset($_POST['product_id']) && isset($_POST['quantity'])) {

    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity <= 0) {
        unset($cart[$product_id]);
    } elseif (isset($cart[$product_id])) {
        $cart[$product_id]['quantity'] = $quantity;
    }
    $_SESSION['cart'] = $cart;
}

if (isset($_POST['product_id']) && isset($_POST['remove_product'])) {
    $product_id = $_POST['product_id'];
    unset($cart[$product_id]);
    $_SESSION['cart'] = $cart;
}
$tong_tien = 0;
// Check if the "Thanh toán" button was clicked
if (isset($_POST['submit'])) {

    // Retrieve the cart information from the session
    $cart = $_SESSION['cart'];

    // Connect to the MySQL database
    $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

    // Check if the connection was successful
    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }



    // Close the database connection
    mysqli_close($conn);

    // Redirect the user to the checkout page
    header('Location: checkout.php');
    exit();
}
?>

<?php
if (isset($_POST['xoa'])) {
    $product_id = $_POST['xoa'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
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
                            <div class="col-md-1">39</div>
                            <div class="col-md-1 text-left"><?php echo money($row['giamoi']) ?></div>
                            <div class="col-md-3 mx-auto">
                                <div class="row d-flex justify-content-center">
                                    <span class="quantity-btn minus" onclick="TangGiamSL(<?php echo $row['id_pro'] ?>,-1)"><img src="../uploads/minus.jpg" style="width:70%;"></span>
                                    <input type="text" style="width: 20%; text-align:center" id="<?php echo $row['id_pro'] ?>" name="quantity_temp" min="0" value="<?php echo $row['quantity'] ?>" readonly>
                                    <span class="quantity-btn plus" onclick="TangGiamSL(<?php echo $row['id_pro'] ?>,1)"><img src="../uploads/add.jpg" style="width: 70% ;"></span>
                                </div>
                            </div>
                            <form method="POST">
                                <!-- <input type="text" name="id" value="" hidden> -->
                                <div class="col-md-1"><button name="xoa" value="<?php echo $row['id_pro'] ?>" class="btn btn-danger">Xóa</button></div>
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo '<h4 class="text-center">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
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
                    }
                    $tong_tien = 0;
                    $tongsl = 0;
                    foreach($_SESSION["cart"] as $row){
                        $tongsl+=$row['quantity'];
                        $tong_tien+=$row['giamoi']*$row['quantity'];
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
                            <div class="col-md-7"><h4>Tổng tiền: <strong><?php echo money($tong_tien) ?></strong></h4></div>
                            <div class="col-md-5">  <h4>Số lượng: <strong><?php echo $tongsl ?></strong></h4></div>
                        </div>
                        
                        <div class="row mt-3 d-flex justify-content-between">
                            <!-- <div class="col-md-4"></div> -->
                            <button class="mx-auto btn btn-success">Thanh Toán</button>
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