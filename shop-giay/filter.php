<?php
include("./Helper.php");
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }
}
if ($_REQUEST['search'] == "" && $_REQUEST['nhanhieu'] == "" && $_REQUEST['danhmuc'] == "") {
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
    $sapxep = $_REQUEST['sapxep'];
    switch ($sapxep) {
        case "giatang":
            $ghi = "order by giamoi asc";
            break;
        case "giagiam":
            $ghi = "order by giamoi desc";
            break;
        case "tentang":
            $ghi = "order by ten_pro asc";
            break;
        case "tengiam":
            $ghi = "order by ten_pro desc";
            break;
    }
    $sophantu = 6;
    $batdau = ($page - 1) * $sophantu;
    $db = new Helper();
    if (count($brands) == 0 && count($sizes) == 0) {
        $statement = "select * from tbl_product where giamoi >= $giamin and giamoi <= $giamax $ghi limit $sophantu offset $batdau ";
        $result = $db->fetchAll($statement);
    } else if (count($brands) == 0 && count($sizes) > 0) {
        $placeholders = implode(',', array_fill(0, count($sizes), '?'));
        $statement = "select * from tbl_product join tbl_pro_soluong on tbl_product.id_pro=tbl_pro_soluong.id_pro where id_size IN ($placeholders)  and giamoi >= $giamin and giamoi <= $giamax  $ghi  limit $sophantu offset $batdau ";
        $para = $sizes;
        $result = $db->fetchAll($statement, $para);
    } else if (count($brands) > 0 && count($sizes) == 0) {
        $placeholders = implode(',', array_fill(0, count($brands), '?'));
        $statement = "select * from tbl_product where id_nh IN ($placeholders) and giamoi >= $giamin and giamoi <= $giamax $ghi limit $sophantu offset $batdau ";
        $para = $brands;
        $result = $db->fetchAll($statement, $para);
    } else {
        $placeholders1 = implode(',', array_fill(0, count($brands), '?'));
        $placeholders2 = implode(',', array_fill(0, count($sizes), '?'));
        $statement = "select * from tbl_product join tbl_pro_soluong on tbl_product.id_pro=tbl_pro_soluong.id_pro where id_nh IN ($placeholders1) AND id_size IN ($placeholders2)  and giamoi >= $giamin and giamoi <= $giamax $ghi limit $sophantu offset $batdau ";
        $result = $db->fetchAll($statement, $brands ,$sizes);
    }
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
                        <?php
                        $db = new Helper();
                        $stmt = "select danhmuc from tbl_danhmuc join tbl_product where tbl_danhmuc.id_dm = tbl_product.id_dm and id_pro=?";
                        $para = [$row['id_pro']];
                        $danhmuc = $db->fetchOne($stmt, $para);
                        ?>
                        <p class="small"><a href="#!" class="text-muted"><?php echo $danhmuc['danhmuc'] ?></a></p>
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
    $db = new Helper();
    if (count($brands) == 0 && count($sizes) == 0) {
        $statement = "select * from tbl_product  where giamoi >= $giamin and giamoi <= $giamax ";
        $dem = $db->rowCount($statement);
    } else if (count($brands) == 0 && count($sizes) > 0) {
        $placeholders = implode(',', array_fill(0, count($sizes), '?'));
        $statement = "select *  from tbl_product join tbl_pro_soluong on tbl_product.id_pro=tbl_pro_soluong.id_pro where id_size IN ($placeholders)  and giamoi >= $giamin and giamoi <= $giamax ";
        $para = $sizes;
        $dem = $db->rowCount($statement, $para);
    } else if (count($brands) > 0 && count($sizes) == 0) {
        $placeholders = implode(',', array_fill(0, count($brands), '?'));
        $statement = "select * from tbl_product where id_nh IN ($placeholders) and giamoi >= $giamin and giamoi <= $giamax ";
        $para = $brands;
        $dem = $db->rowCount($statement, $para);
    } else {
        $placeholders1 = implode(',', array_fill(0, count($brands), '?'));
        $placeholders2 = implode(',', array_fill(0, count($sizes), '?'));
        $statement = "select * from tbl_product join tbl_pro_soluong on tbl_product.id_pro=tbl_pro_soluong.id_pro where id_nh IN ($placeholders1) AND id_size IN ($placeholders2)  and giamoi >= $giamin and giamoi <= $giamax ";
        $dem = $db->rowCount($statement, $brands , $sizes);
    }
    
    echo '???';
    $sotrang = round($dem / 6 + 0.4);
    ?>
    <input type="text" name="page" id="page" value="<?php echo $page ?>" hidden>
    <?php
    for ($i = 1; $i <= $sotrang; $i++) {
    ?>
        <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" onclick="hamcom(<?php echo $i; ?>)"></php><?php echo $i; ?></a></li>
    <?php
    }
} else {
    $para = [];
    if (isset($_POST['nhanhieu'])) {
        $nhloc = $_POST['nhanhieu'];
    } else {
        $nhloc = "";
    }
    if (isset($_POST['danhmuc'])) {
        $dmloc = $_POST['danhmuc'];
    } else {
        $dmloc = "";
    }
    if (isset($_REQUEST['search'])) {
        $search = $_REQUEST['search'];
    } else {
        $search = "";
    }
    if ($_REQUEST['page'] != "") {
        $page = $_REQUEST['page'];
    } else {
        $page = 1;
    }
    $sapxep = $_REQUEST['sapxep'];
    switch ($sapxep) {
        case "giatang":
            $ghi = "order by giamoi asc";
            break;
        case "giagiam":
            $ghi = "order by giamoi desc";
            break;
        case "tentang":
            $ghi = "order by ten_pro asc";
            break;
        case "tengiam":
            $ghi = "order by ten_pro desc";
            break;
    }
    $stmt = "select * from tbl_product join tbl_danhmuc on tbl_danhmuc.id_dm = tbl_product.id_dm where ten_pro regexp? and id_nh regexp ? and tbl_product.id_dm regexp ? ";
    $para = [$search, $nhloc, $dmloc];
    $db = new Helper();
    $dem = $db->rowCount($stmt, $para);
    $sophantu = 6;
    $batdau = ($page - 1) * $sophantu;
    $sotrang = round($dem / $sophantu + 0.49);
    $stmt = "select * from tbl_product join tbl_danhmuc on tbl_danhmuc.id_dm = tbl_product.id_dm  where ten_pro regexp? and  id_nh regexp ? and tbl_product.id_dm regexp ?  $ghi limit 6 offset $batdau";
    $para = [$search, $nhloc, $dmloc];
    $conn = new Helper();
    $result = $conn->fetchAll($stmt, $para);
    foreach ($result as $row) {
    ?>
        <div class="col-md-6 col-lg-4  mb-lg-0 ">
            <div class="card mb-4 position-relative" style="height: 580px;">
                <!-- <div class="position-absolute p-2  " style="top:0;left:0; background-color:bisque; color:tomato;">-30%</div>
            <div class="position-absolute p-2  " style="top:0;right:0; background-color:red; color:white;"> New</div> -->

                <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>">
                    <div style="max-width:100%; height:auto;" class="box-body"> <img src="../uploads/<?php echo $row['hinhanh']; ?>" class="card-img-top img-box-body" alt=""></div>
                </a>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p class="small"><a href="#!" class="text-muted"><?php echo $row['danhmuc'] ?></a></p>
                        <p class=""></p>
                        <p class="small text-danger"><s><?php echo money($row['giacu']) ?></s></p>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>" style="text-decoration: none;">
                            <h5 class="mb-0"><?php echo $row['ten_pro'] ?></h5>
                        </a>
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
    ?>
    <input type="text" name="page" id="page" value="1" hidden>
    <?php
    for ($i = 1; $i <= $sotrang; $i++) {
    ?>
        <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" onclick="hamcom(<?php echo $i; ?>)"></php><?php echo $i; ?></a></li>voo
<?php
    }
}
?>