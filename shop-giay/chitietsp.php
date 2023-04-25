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
$conn=new Helper();
$product_id = $_GET['id'];
$stmt = "SELECT * FROM tbl_product join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh join tbl_danhmuc on tbl_product.id_dm = tbl_danhmuc.id_dm WHERE id_pro = ?";
$para=[$product_id];
$product = $conn->fetchOne($stmt,$para);
$product_temp = $product;
$temp = $product;
$viewmoi = $temp['total_view'] + 1;
// Tăng view

$stmt ="UPDATE tbl_product set total_view = $viewmoi WHERE id_pro = ?";
$para=[$product_id];
$conn->execute($stmt,$para);

if (!$product) {
  header('Location: index.php?page=home');

}

$conn=new Helper();
$stmt= "SELECT size,soluong FROM tbl_pro_soluong as ps join tbl_size on ps.id_size =tbl_size.id_size WHERE id_pro = $product_id"; 
$result_size =$conn->fetchAll($stmt);
$products_size = array();
foreach($result_size as $row){
  $products_size[] = $row;
}

$quantity_temp  = 1;
if (isset($_POST['product_id'])) {
  $quantity_temp=$_REQUEST["quantity_temp"];
  $product_id = $_POST['product_id'];
  $product = $temp;

  if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity']+=$quantity_temp;
  } else {
    $product['quantity'] = $quantity_temp;
    $_SESSION['cart'][$product_id] = $product;
  }
}
?>
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
                    <div class="mb-3 mt-3 ml-4">
                      <span class="quantity-btn minus ml-5 " onclick="TangGiamSL(-1)"><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                      <input type="text" style="width: 40px; text-align:center;" id="soluong" name="quantity_temp" min="0" value="<?php echo $quantity_temp; ?>" readonly>
                      <span class="quantity-btn plus" onclick="TangGiamSL(1)"><img src="../uploads/add.jpg" style="width:40px ;"></span>
                    </div>
                    <button type="submit" class="btn btn-info ml-2" name="add_to_cart">Thêm vào giỏ</button>
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
<script>
  function TangGiamSL(sl){
    var ht=document.getElementById("soluong").value;
    if(ht*1+sl*1>0){
      document.getElementById("soluong").value=ht*1+sl*1;
    }
  }
</script>
