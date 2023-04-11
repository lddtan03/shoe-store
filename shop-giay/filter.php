<?php
if (!function_exists('money')) {
    function money($number, $suffix = 'đ') {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
  }

$conn = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
$brands = isset($_POST['brands']) ? $_POST['brands'] : [];
$sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];

if (count($brands) == 0 && count($sizes) == 0) {
    $statement = $conn->prepare('select * from tbl_product');
    $statement->execute();
} else if (count($brands) == 0 && count($sizes) > 0) {
    $placeholders = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product,tbl_pro_soluong where size IN ($placeholders) and tbl_pro_soluong.id_pro =tbl_product.id_pro ");
    $statement->execute($sizes);
} else if (count($brands) > 0 && count($sizes) == 0) {
    $placeholders = implode(',', array_fill(0, count($brands), '?'));
    $statement = $conn->prepare("select * from tbl_product where id_nh IN ($placeholders)");
    $statement->execute($brands);
} else {
    $placeholders1 = implode(',', array_fill(0, count($brands), '?'));
    $placeholders2 = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product,tbl_pro_soluong where id_nh IN ($placeholders1) AND size IN ($placeholders2) and tbl_pro_soluong.id_pro =tbl_product.id_pro");
    $statement->execute(array_merge($brands, $sizes));
}

$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0  " >
        <div class="card mb-4 position-relative">
            <!-- <div class="position-absolute p-2  " style="top:0;left:0; background-color:bisque; color:tomato;">-30%</div>
                                <div class="position-absolute p-2  " style="top:0;right:0; background-color:red; color:white;"> New</div> -->

            <!-- <a href="chitietsanpham.php?id=<?php echo $row['id_i']; ?>"><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></a> -->
            <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>">
                <div style="width: 300px;height:300px;"> <img src="../uploads/<?php echo $row['hinhanh']; ?>" class="card-img-top" alt=""></div>
            </a>

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p class="small"><a href="#!" class="text-muted">Loại sản phẩm</a></p>
                    <p class=""></p>
                    <p class="small text-danger"><s><?php echo money($row['giacu']) ?></s></p>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mb-0"><?php echo $row['ten_pro'] ?></h5>
                    <h5 class="text-dark mb-0"><?php echo money($row['giamoi']) ?></h5>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <p class="text-muted mb-0">Lượt xem: <span class="fw-bold"><?php echo $row['total_view']; ?></span></p>
                    <div class="ms-auto text-warning">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
echo "???";


$p=1;
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
$dem=0;
foreach ($result as $row) {
    $dem=$dem+1;
}
$sotrang=round($dem / 9 + 0.4);
?>


<li class="page-item "><a class="page-link" onclick="show(<?php if ($p > 1) echo $p - 1;
                                                            else echo $p; ?>)">Previous</a></li>
<?php   
for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php

}

?>
<li class="page-item "><a class="page-link" onclick="show(<?php if ($p < $sotrang) echo $p + 1;
                                                            else echo $p; ?>)">Next</a></li>
