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
$stmt = "select * from tbl_product join tbl_danhmuc on tbl_danhmuc.id_dm = tbl_product.id_dm  where ten_pro regexp? and  id_nh regexp ? and tbl_product.id_dm regexp ? limit 6 ";
$para = [$search, $nhloc, $dmloc];
$conn = new Helper();
$result = $conn->fetchAll($stmt, $para);
$products = $result;
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
<?php
$stmt = "select * from tbl_product join tbl_danhmuc on tbl_danhmuc.id_dm = tbl_product.id_dm where ten_pro regexp? and id_nh regexp ? and tbl_product.id_dm regexp ?";
$para = [$search, $nhloc, $dmloc];
$db = new Helper();
$dem = $db->rowCount($stmt, $para);
$sotrang = round($dem / 6 + 0.4);
?>
<input type="text" name="page" id="page" value="1" hidden>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($i == 1) echo "active"; ?>"><a class="page-link" onclick="loc2(<?php echo $i; ?>)"></php><?php echo $i; ?></a></li>
<?php
}
?>