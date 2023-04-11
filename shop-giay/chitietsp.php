<?php
session_start();
require_once("header.php");
if (!function_exists('money')) {
  function money($number, $suffix = 'đ')
  {
    if (!empty($number)) {
      return number_format($number, 0, ',', ',') . "{$suffix}";
    }
  }
}
// Kết nối đến CSDL
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'sneakershop';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
  $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// truy vấn
$product_id = $_GET['id'];
// $query = "SELECT tbl_product.id_pro, ten_pro, giamoi, mota, hinhanh, id_size,id_nh,id_danhmuc,giacu,total_view FROM tbl_product, tbl_pro_soluong WHERE tbl_product.id_pro = tbl_pro_soluong.id_pro";
$stmt = $pdo->prepare("SELECT * FROM tbl_product join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh join tbl_danhmuc on tbl_product.id_dm = tbl_danhmuc.id_dm WHERE id_pro = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();
$product_temp = $product;
$temp = $product;
$viewmoi = $temp['total_view'] + 1;
// Tăng view
$stmt = $pdo->prepare("UPDATE tbl_product set total_view = $viewmoi WHERE id_pro = ?");
$stmt->execute([$product_id]);

if (!$product) {
  header('HTTP/1.0 404 Not Found');
  echo '<h1>404 Not Found</h1>';
  exit();
}

// trúy vấn cái size

$mysqli = mysqli_connect('localhost', 'root', '', 'sneakershop');
$result_size = $mysqli->query("
SELECT size,soluong
 FROM tbl_pro_soluong as ps join tbl_size on ps.id_size =tbl_size.id_size
 WHERE id_pro = $product_id
  ");
$products_size = array();
if ($result_size->num_rows > 0) {
  while ($row = $result_size->fetch_assoc()) {
    $products_size[] = $row;
  }
}
// xử lý cái vụ số lượng

$quantity_temp  = 1;


// dùng để sử lí session

if (isset($_POST['product_id'])) {

  $product_id = $_POST['product_id'];
  $product = $temp;

  // echo ('dang ');
  // echo ($quantity_temp);
  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity']++;
  } else {
    $product['quantity'] = 1;
    $_SESSION['cart'][$product_id] = $product;
  }


  $message = "<h1>Thêm vào giỏ hàng: </h1><br>" .
    "<div class = 'box-mes'>" .
    "<img src='" . $product['hinhanh'] . "' alt='" . $product['ten_pro'] . "'> " .
    "<span>" . $product['ten_pro'] . "<br>" .
    "Mã SP : " . $_SESSION['cart'][$product_id]['id_pro'] . "<br>" .
    "Nhóm : " . $_SESSION['cart'][$product_id]['id_nh'] . "<br>" .
    "Giá  : " . number_format($product['giamoi']) . " đ<br>" .
    "Số lượng : " . $quantity_temp . "</span> <br>" .
    "</div>" .
    " <a href='index.php?page=chitietsp'><p class='click_giohang'> Xem giỏ hàng </p></a>";
}


?>
<!-- //////////////////////////////////////////////////-->
<!-- <body> -->
<div id="wrapper">
  <!-- <?php
        echo ($product_id);
        ?> -->
  <div id="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="../uploads/<?php echo $temp['hinhanh'] ?>" alt="" />
        </div>

        <div class="col-md-6 mt-xl-5">
          <div class="product-info d-flex">
            <h2><?php echo $temp['ten_pro']; ?></h2>
            <div class="product-info-more my-2">
              <span class="type">Loại: <strong><?php echo $temp['danhmuc']; ?></strong></span>
              <span>Nhãn hiệu: <strong><?php echo $temp['nhanhieu']; ?></strong></span>
            </div>
            <div class="price">
              <span class="price-new mr-3"><?php echo money($temp['giamoi']); ?></span>
              <span class="price-old"><?php echo money($temp['giacu']); ?></span>
            </div>

            <div class="size my-2">
              <span>Size</span>

            </div>
            <div>
              <ul class="">
                <?php if (isset($_GET['sizechon'])) {
                  $sizechon = $_GET['sizechon'];
                }
                ?>
                <?php foreach ($products_size as $rows) : ?>
                  <form method="post" action="">
                    <a style="float: left" class="mr-2 <?php if ($sizechon == $rows['size']) echo "btn btn-info";
                                                        else echo "btn btn-secondary" ?>" href="chitietsp.php?id=<?php echo $_REQUEST['id']; ?>&sizechon=<?php echo $rows['size']; ?>"><?php echo $rows['size']; ?></a>
                  </form>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="amount mt-3">
              <!-- <span class="amount-title">Số lượng</span> -->
              <div class="d-flex justify-content-between">
                <div class="product-button">
                  <div class="exchange">
                    <span class="exchange-size">Bảng quy đổi size</span>
                    <span>Hướng dẫn đổi size giày</span>
                  </div>
                  <form method="post" action="">
                    <input type="hidden" name="product_id" value="<?php echo $product['id_pro']; ?>">
                    <div class="mb-3 mt-3 ml-4">
                      <span class="quantity-btn minus ml-5 " onclick="changeQuantity(this, -1)"><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                      <input type="number" style="width: 40px;" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                      <span class="quantity-btn plus" onclick="changeQuantity(this, 1)"><img src="../uploads/add.jpg" style="width:40px ;"></span>
                    </div>


                    <button type="submit" class="btn btn-info ml-2" name="add_to_cart">Thêm vào giỏ</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- <button class="btn btn-success">Mua ngay</button> -->
          </div>

        </div>


      </div>
    </div>
  </div>
  <!-- end content -->
  <div id="product-detail" class="mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Mô tả sản phẩm</h2>
          <p>
            <?php echo $product['mota']; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="related-products">
      <div class="container text-center">
        <h3 class="my-4">Sản phẩm liên quan</h3>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <a href="" class="img-box-body">
              <img src="assets/images/a-banh-nike-zoom-mercurial-vapor-15-academy-tf-dj5635-146-trang-xanh-1_16d876477ba945ff8659338ea6012fed_large.webp" alt="" />
            </a>
            <a href="" class="name-type name-box-body text-dark text-justify">NIKE ZOOM MERCURIAL VAPOR 15 ACADEMY TF - DJ5635-146 -
              TRẮNG/XANH</a>
            <span class="price-box-body d-block text-center text-danger">2.000.000đ</span>
          </div>
          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <a href="" class="img-box-body">
              <img src="assets/images/a-banh-nike-zoom-mercurial-vapor-15-academy-tf-dj5635-146-trang-xanh-1_16d876477ba945ff8659338ea6012fed_large.webp" alt="" />
            </a>
            <a href="" class="name-type name-box-body text-dark text-justify">NIKE ZOOM MERCURIAL VAPOR 15 ACADEMY TF - DJ5635-146 -
              TRẮNG/XANH</a>
            <span class="price-box-body d-block text-center text-danger">2.000.000đ</span>
          </div>
          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <a href="" class="img-box-body">
              <img src="assets/images/a-banh-nike-zoom-mercurial-vapor-15-academy-tf-dj5635-146-trang-xanh-1_16d876477ba945ff8659338ea6012fed_large.webp" alt="" />
            </a>
            <a href="" class="name-type name-box-body text-dark text-justify">NIKE ZOOM MERCURIAL VAPOR 15 ACADEMY TF - DJ5635-146 -
              TRẮNG/XANH</a>
            <span class="price-box-body d-block text-center text-danger">2.000.000đ</span>
          </div>
          <div class="col-md-3 col-sm-6 col-6 mb-4">
            <a href="" class="img-box-body">
              <img src="assets/images/a-banh-nike-zoom-mercurial-vapor-15-academy-tf-dj5635-146-trang-xanh-1_16d876477ba945ff8659338ea6012fed_large.webp" alt="" />
            </a>
            <a href="" class="name-type name-box-body text-dark text-justify">NIKE ZOOM MERCURIAL VAPOR 15 ACADEMY TF - DJ5635-146 -
              TRẮNG/XANH</a>
            <span class="price-box-body d-block text-center text-danger">2.000.000đ</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end product-detail -->
</div>
<div class="message-box" id="message-box">
  <?php if (isset($message)) : ?>
    <script>
      var notification = document.getElementById("message-box");
      var wrapper = document.getElementById("wrapper");
      wrapper.style.backgroundColor = "rgba(0, 0, 0, 0.2)";
    </script>
    <div id="notification">

      <?php echo $message; ?>
    </div>
  <?php endif; ?>
</div>

<script>
  // const decrementBtn = document.querySelector('.decrement');
  // const incrementBtn = document.querySelector('.increment');
  // const quantityInput = document.querySelector('input[name="quantity_temp"]');

  // decrementBtn.addEventListener('click', () => {
  //   const currentValue = parseInt(quantityInput.value);
  //   if (currentValue > 1) {
  //     quantityInput.value = currentValue - 1;
  //     document.querySelector('input[name="quantity_temp"]').setAttribute('value', 'quantityInput');

  //   }
  // });

  // incrementBtn.addEventListener('click', () => {
  //   const currentValue = parseInt(quantityInput.value);
  //   if (currentValue < 100) {
  //     quantityInput.value = currentValue + 1;
  //     document.querySelector('input[name="quantity_temp"]').setAttribute('value', 'quantityInput');

  //   }
  // });


  // Lấy đối tượng thông báo
  var notification = document.getElementById("notification");
  var message_box = document.getElementById("message-box");

  var wrapper = document.getElementById("wrapper");

  // Bắt sự kiện click ra ngoài cửa sổ thông báo
  window.addEventListener('click', function(event) {
    if (event.target != notification && !notification.contains(event.target)) {
      notification.style.display = "none";
      message_box.style.display = "none";
      wrapper.style.backgroundColor = "rgba(0, 0, 0, 0)";

    }
  });

  setTimeout(function() {
    notification.style.display = "none";
    message_box.style.display = "none";
    wrapper.style.backgroundColor = "rgba(0, 0, 0, 0)";


  }, 7000);


  // phần này nè hokk bik làm 
  function changeQuantity(element, amount) {
    var input = element.parentNode.querySelector('input[name="quantity_temp"]');
    var value = parseInt(input.value) + amount;
    if (value < 1) {
      value = 1;
    }
    input.value = value;

    // Tạo đối tượng XMLHttpRequest để gửi yêu cầu AJAX
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Xử lý kết quả trả về từ máy chủ
        if (this.responseText == "success") {
          console.log("Đã cập nhật giá trị quantity_temp thành công");
        } else {
          console.log("Lỗi khi cập nhật giá trị quantity_temp");
        }
      }
    };
    xhttp.open("POST", "update_quantity_temp.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("quantity_temp=" + value);
  }
</script>

<!-- </body>
</html> -->