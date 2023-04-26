<?php
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}
$conn = new PDO('mysql:host=localhost;dbname=sneakershop', 'root', '');
$brands = isset($_POST['brands']) ? $_POST['brands'] : [];
$sizes = isset($_POST['sizes']) ? $_POST['sizes'] : [];
$giamin = $_REQUEST['min'];
$giamax = $_REQUEST['max'];
//Phân trang
if ($_REQUEST['page'] != "") {
    $page = $_REQUEST['page'];
} else {
    $page = 1;
}
$sophantu = 6;
$batdau = ($page - 1) * $sophantu;
if (count($brands) == 0 && count($sizes) == 0) {
    $statement = $conn->prepare("select * from tbl_product  where giamoi >= $giamin and giamoi <= $giamax limit $sophantu offset $batdau");
    $statement->execute();
} else if (count($brands) == 0 && count($sizes) > 0) {
    $placeholders = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product,tbl_pro_soluong where id_size IN ($placeholders)  and giamoi >= $giamin and giamoi <= $giamax limit $sophantu offset $batdau");
    $statement->execute($sizes);
} else if (count($brands) > 0 && count($sizes) == 0) {
    $placeholders = implode(',', array_fill(0, count($brands), '?'));
    $statement = $conn->prepare("select * from tbl_product where id_nh IN ($placeholders) and giamoi >= $giamin and giamoi <= $giamax limit $sophantu offset $batdau");
    $statement->execute($brands);
} else {
    $placeholders1 = implode(',', array_fill(0, count($brands), '?'));
    $placeholders2 = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product where id_nh IN ($placeholders1) AND id_size IN ($placeholders2)  and giamoi >= $giamin and giamoi <= $giamax limit $sophantu offset $batdau");
    $statement->execute(array_merge($brands, $sizes));
}
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <div class="col-md-6 col-lg-4 mb-4 mb-lg-0  ">
        <div class="card mb-4 position-relative">
            <!-- <div class="position-absolute p-2  " style="top:0;left:0; background-color:bisque; color:tomato;">-30%</div>
                                <div class="position-absolute p-2  " style="top:0;right:0; background-color:red; color:white;"> New</div> -->

            <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>">
                <div style="width:100%;auto;"> <img src="../uploads/<?php echo $row['hinhanh']; ?>" class="card-img-top" alt=""></div>
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
// echo "<script type='text/javascript'>alert('$sizes[0]');</script>";

if (count($brands) == 0 && count($sizes) == 0) {
    $statement = $conn->prepare("select * from tbl_product  where giamoi >= $giamin and giamoi <= $giamax ");
    $statement->execute();
} else if (count($brands) == 0 && count($sizes) > 0) {
    $placeholders = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product,tbl_pro_soluong where id_size IN ($placeholders)  and giamoi >= $giamin and giamoi <= $giamax ");
    $statement->execute($sizes);
} else if (count($brands) > 0 && count($sizes) == 0) {
    $placeholders = implode(',', array_fill(0, count($brands), '?'));
    $statement = $conn->prepare("select * from tbl_product where id_nh IN ($placeholders) and giamoi >= $giamin and giamoi <= $giamax ");
    $statement->execute($brands);
} else {
    $placeholders1 = implode(',', array_fill(0, count($brands), '?'));
    $placeholders2 = implode(',', array_fill(0, count($sizes), '?'));
    $statement = $conn->prepare("select * from tbl_product where id_nh IN ($placeholders1) AND id_size IN ($placeholders2)  and giamoi >= $giamin and giamoi <= $giamax ");
    $statement->execute(array_merge($brands, $sizes));
}
$result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
$dem = 0;
foreach ($result1 as $row) {
    $dem = $dem + 1;
}
echo '???';
$sotrang = round($dem / 6 + 0.4);
?>
<li class="page-item "><a class="page-link" onclick="">Previous</a></li>
<input type="text" name="page" id="page" value="<?php echo $page ?>" hidden>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" onclick="DoiTrang(<?php echo $i; ?>)"></php><?php echo $i; ?></a></li>
<?php
}
?>
<li class="page-item "><a class="page-link" onclick="show()">Next</a></li>