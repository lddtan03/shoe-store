<?php
require_once("header.php");
if (!function_exists('money')) {
  function money($number, $suffix = 'đ')
  {
    if (!empty($number)) {
      return number_format($number, 0, ',', ',') . "{$suffix}";
    }
  }
}
// truy vấn
$conn = new Helper();
$product_id = $_GET['id'];
$stmt = "SELECT * FROM tbl_product join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh join tbl_danhmuc on tbl_product.id_dm = tbl_danhmuc.id_dm WHERE id_pro = ?";
$para = [$product_id];
$product = $conn->fetchOne($stmt, $para);
$product_temp = $product;
$temp = $product;
$viewmoi = $temp['total_view'] + 1;
// Tăng view

$stmt = "UPDATE tbl_product set total_view = $viewmoi WHERE id_pro = ?";
$para = [$product_id];
$conn->execute($stmt, $para);

if (!$product) {
  header('Location: index.php?page=home');
}

$conn = new Helper();
$stmt = "SELECT size,soluong FROM tbl_pro_soluong as ps join tbl_size on ps.id_size =tbl_size.id_size WHERE id_pro = $product_id";
$result_size = $conn->fetchAll($stmt);
$products_size = array();
foreach ($result_size as $row) {
  $products_size[] = $row;
}

if (isset($_POST['product_id'])) {
  $size = $_REQUEST["size_chon"];
  $db=new Helper();
  $stmt ="select id_size from tbl_size where size =? ";
  $para =[$size];
  $result =$db->fetchOne($stmt,$para);
  $id_size=$result['id_size'];
  $quantity_temp = $_REQUEST["quantity_temp"];
  $index = -1;
  if (isset($_SESSION['cart'])) {
    $array = $_SESSION['cart'];
    foreach ($array as $spgh) {
      $index = $spgh['index'];
    }
  } else {
    $array = array();
  }
  $co = 0;
  foreach ($array as $spgh) {
    if ($spgh['id_pro'] == $_POST['product_id'] && $spgh['size'] == $size) {
      $array[$spgh['index']]['soluong'] += $quantity_temp;
      $co = 1;
      unset($_SESSION['cart']);
      $_SESSION['cart'] = $array;
    }
  }
  if ($co == 0) {
    $product = array(
      'index' => $index + 1,
      'id_pro' => $product_id,
      'ten_pro' => $product['ten_pro'],
      'size' => $size,
      'id_size' => $id_size,
      'soluong' => $quantity_temp,
      'hinhanh' => $product['hinhanh'],
      'giamoi' => $product['giamoi'],
    );
    $_SESSION['cart'][] = $product;
  }
  echo "<script type='text/javascript'>alert('Đã thêm vào giỏ hàng');</script>";
}
?>
<script>
  function batNut() {
    document.getElementById("nutBam").disabled = false;
  }
</script>

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
              <div class="d-flex justify-content-between">
                <div class="product-button">
                  <div class="exchange">
                    <span class="exchange-size">Bảng quy đổi size</span>
                    <span>Hướng dẫn đổi size giày</span>
                  </div>
                  <form method="post" action="">
                    <input type="hidden" name="product_id" value="<?php echo $product['id_pro']; ?>">
                    <input type="hidden" name="size_chon" value="<?php echo $sizechon; ?>">
                    <div class="mb-3 mt-3 ml-4">
                      <span class="quantity-btn minus ml-5 " onclick="TangGiamSL(-1)"><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                      <input type="text" style="width: 40px; text-align:center;" id="soluong" name="quantity_temp" min="0" value="1" readonly>
                      <span class="quantity-btn plus" onclick="TangGiamSL(1)"><img src="../uploads/add.jpg" style="width:40px ;"></span>
                    </div>
                    <button type="submit" class="btn btn-info ml-2" <?php if (!isset($_REQUEST['sizechon'])) {
                                                                      echo "disabled";
                                                                    }  ?> name="add_to_cart">Thêm vào giỏ</button>
                  </form>
                </div>
              </div>
            </div>
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
            <?php echo $temp['mota']; ?>
          </p>
        </div>
      </div>
    </div>
    <div class="related-products">
      <div class="container text-center">
        <h3 class="my-4">Sản phẩm liên quan</h3>
        <div class="row">
          <?php
          $db = new Helper();
          $product_id = $_GET['id'];
          $stmt = "SELECT * FROM tbl_product where id_dm = (select id_dm from tbl_product WHERE id_pro = ?) and id_pro <> ? limit 4";
          $para = [$product_id, $product_id];
          $product = $db->fetchAll($stmt, $para);
          foreach ($product as $sp) {
          ?>
            <div class="col-md-3 col-sm-6 col-6 mb-4">
              <a href="chitietsp.php?id=<?php echo $sp['id_pro']; ?>" class="img-box-body">
                <img src="../uploads/<?php echo $sp['hinhanh'] ?>" alt="" />
              </a>
              <a href="chitietsp.php?id=<?php echo $sp['id_pro']; ?>" class="name-type name-box-body text-justify" style="color:blue; font-weight: bold;"><?php echo $sp['ten_pro']; ?></a>
              <span class="price-box-body d-block text-center text-danger"><?php echo money($sp['giamoi']); ?></span>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function TangGiamSL(sl) {
    <?php
    $db = new Helper();
    $stmt = "select soluong from tbl_pro_soluong as ps join tbl_size on ps.id_size = tbl_size.id_size where id_pro=? and size=?";
    $para = [$product_id, $_REQUEST['sizechon']];
    $result = $db->fetchOne($stmt,$para);
    $max = $result['soluong'];
    ?>
    var ht = document.getElementById("soluong").value;
    var max = <?php echo json_encode($max); ?>;
    if (ht * 1 + sl * 1 > max) {
      alert("Đã tới giới hạn trong kho");
      return;
    }
    if (ht * 1 + sl * 1 > 0) {
      document.getElementById("soluong").value = ht * 1 + sl * 1;
    }
  }
</script>