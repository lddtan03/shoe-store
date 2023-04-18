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
    <style>
        @media (min-width: 1200px){
            .container{
                max-width: 1850px;
                padding: 0px 50px;
            }
        }

        @media (max-width: 768px){
            .cart{
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
                <div class="col-md-4 text-center p-1">Tên SP</div>
                <div class="col-md-1 text-center p-1">Size</div>
                <div class="col-md-3 text-center p-1">Số lượng</div>
                <div class="col-md-1 text-center p-1">Hành động</div>
            </div>
            <?php
            if(isset($_SESSION['cart'])){
                foreach ($_SESSION['cart'] as $row){
                    ?>
                    <div class="cart-body row mt-2 border shadow text-center d-flex align-items-center py-2">
                        <div class="col-md-1">1</div>
                        <div class="col-md-2"><img src="../uploads/product-featured-8.jpg" alt=""></div>
                        <div class="col-md-4 text-left">Lorem ipsum d molestiae unde nobis sequi provident odit ducimus error distinctio, nihil illo soluta sit repellat! Distinctio laborum suscipit debitis nobis maxime quae voluptatum ipsam iure! Error nisi pariatur ea quidem accusantium perspiciatis placeat tempora veniam. Ipsa, dolore possimus.</div>
                        <div class="col-md-1">39</div>
                        <div class="col-md-3 mx-auto">
                        <div class="row d-flex justify-content-center">
                            <span class="quantity-btn minus  " onclick=""><img src="../uploads/minus.jpg" style="width:70%;"></span>
                            <input type="number" style="width: 20%;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                            <span class="quantity-btn plus" onclick=""><img src="../uploads/add.jpg" style="width: 70% ;"></span>
                        </div>
                        </div>
                        <div class="col-md-1"><button class="btn btn-danger">Xóa</button></div>
                </div>
                <?php
                }
                
            }else{
                echo'<h4 class="text-center">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
            }
            ?>

            <?php
            if(isset($_SESSION['cart'])){
                foreach ($_SESSION['cart'] as $row){
                    ?>
                    <div class="cart-body row mt-2 border shadow text-center d-flex align-items-center py-2">
                        <div class="col-md-1">1</div>
                        <div class="col-md-2"><img src="../uploads/product-featured-8.jpg" alt=""></div>
                        <div class="col-md-4 text-left">Lorem ipsum d molestiae unde nobis sequi provident odit ducimus error distinctio, nihil illo soluta sit repellat! Distinctio laborum suscipit debitis nobis maxime quae voluptatum ipsam iure! Error nisi pariatur ea quidem accusantium perspiciatis placeat tempora veniam. Ipsa, dolore possimus.</div>
                        <div class="col-md-1">39</div>
                        <div class="col-md-3 mx-auto">
                        <div class="row d-flex justify-content-center">
                            <span class="quantity-btn minus  " onclick=""><img src="../uploads/minus.jpg" style="width:70%;"></span>
                            <input type="number" style="width: 20%;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                            <span class="quantity-btn plus" onclick=""><img src="../uploads/add.jpg" style="width: 70% ;"></span>
                        </div>
                        </div>
                        <div class="col-md-1"><button class="btn btn-danger">Xóa</button></div>
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
        <div class="col-xl-4 col-md-12">
            <div class="row">
                <div class="col-xl-1"></div>
                <div class="col-xl-11 col-md-12 border shadow py-3 px-4">
                    <h4 class="text-center mt-2"><strong>Thông tin thanh toán</strong></h4>
                    <h5> Họ tên: <strong>Nguyen Van A</strong></h5>
                    <h5>So đth: <strong>014725836</strong></h5>
                    <h5>Email: <strong>1133155444</strong></h5>
                    <h4>Tổng tiền: <strong>10,200,000đ</strong></h4> <h4>Số lượng: <strong>5</strong></h4>
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