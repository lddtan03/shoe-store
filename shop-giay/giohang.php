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

    // Insert the cart information into the database
    // foreach ($cart as $product) {
    //     $product_id = $product['id_pro'];
    //     $quantity = $product['quantity'];
    //     $price = $product['giamoi'];
    //     $subtotal = $price * $quantity;
    //     $query = "INSERT INTO giohang (id_pro, quantity, price, subtotal) VALUES ('$product_id', '$quantity', '$price', '$subtotal')";
    //     mysqli_query($conn, $query);
    // }

    // Close the database connection
    mysqli_close($conn);

    // Redirect the user to the checkout page
    header('Location: checkout.php');
    exit();
}
?>

<body>
    <h2 class="text-center mt-3 mb-3">SẢN PHẨM TRONG GIỎ HÀNG</h2>
    <div class="row">
        <div class="col-md-8 border shadow">
            <div class="row mb-2 shadow border text-center pt-2 pb-2 ">
                <div class="col-md-1">Mã SP</div>
                <div class="col-md-2">Hình Ảnh</div>
                <div class="col-md-3 text-left">Tên SP</div>
                <div class="col-md-1">Size</div>
                <div class="col-md-2">Số lượng</div>
                <div class="col-md-2">Hành động</div>
            </div>
            <?php
            if(isset($_SESSION['cart'])){
                foreach ($_SESSION['cart'] as $row){
                    ?>
                    <div class="row mb-2 shadow border text-center  ">
                    <div class="col-md-1">1</div>
                    <div class="col-md-2"><img src="../uploads/product-featured-8.jpg" alt=""></div>
                    <div class="col-md-3 text-left">Tên SP</div>
                    <div class="col-md-1">39</div>
                    <div class="col-md-2">
                        <div class="row ml-5">
                            <span class="quantity-btn minus  " onclick=""><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                            <input type="number" style="width: 40px;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                            <span class="quantity-btn plus" onclick=""><img src="../uploads/add.jpg" style="width:40px ;"></span>
                        </div>
                    </div>
                    <div class="col-md-2"><button class="btn btn-danger">Xóa</button></div>
                </div>
                <?php
                }
                
            }else{
                echo'<h4 class="text-center">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
            }
            ?>
            
            <!-- <div class="row mb-2 shadow border text-center  ">
                <div class="col-md-1">1</div>
                <div class="col-md-2"><img src="../uploads/product-featured-8.jpg" alt=""></div>
                <div class="col-md-3 text-left">Tên SP</div>
                <div class="col-md-1">39</div>
                <div class="col-md-2">
                    <div class="row ml-5">
                        <span class="quantity-btn minus  " onclick=""><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                        <input type="number" style="width: 40px;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                        <span class="quantity-btn plus" onclick=""><img src="../uploads/add.jpg" style="width:40px ;"></span>
                    </div>
                </div>
                <div class="col-md-2"><button class="btn btn-danger">Xóa</button></div>
            </div>
            <div class="row mb-2 shadow border text-center  ">
                <div class="col-md-1">1</div>
                <div class="col-md-2"><img src="../uploads/product-featured-8.jpg" alt=""></div>
                <div class="col-md-3 text-left">Tên SP</div>
                <div class="col-md-1">39</div>
                <div class="col-md-2">
                    <div class="row ml-5">
                        <span class="quantity-btn minus  " onclick=""><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                        <input type="number" style="width: 40px;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                        <span class="quantity-btn plus" onclick=""><img src="../uploads/add.jpg" style="width:40px ;"></span>
                    </div>
                </div>
                <div class="col-md-2"><button class="btn btn-danger">Xóa</button></div>
            </div> -->


        </div>
        <div class="col-md-4 border shadow">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10 border shadow ">
                    <h4 class="text-center mt-2"><strong>Thông tin thanh toán</strong></h4>
                    <h5> Họ tên: <strong>Nguyen Van A</strong></h5>
                    <h5>So đth: <strong>014725836</strong></h5>
                    <h5>Email: <strong>1133155444</strong></h5>
                    <h4>Tổng tiền: <strong>10,200,000đ</strong></h4> <h4>Số lượng: <strong>5</strong></h4>
                    <div class="row mb-4 mt-3">
                        <div class="col-md-4"></div>
                    <button class="btn btn-success">Thanh Toán</button>
                    </div>
                </div>
            </div>


        </div>
    </div>
</body>


<script>
    function changeQuantity(element, amount) {
        var input = element.parentNode.querySelector('input[name="quantity"]');
        var value = parseInt(input.value) + amount;
        if (value < 1) {
            value = 1;
        }
        input.value = value;
        input.form.submit();
    }
</script>