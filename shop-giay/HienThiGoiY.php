<?php
include("Helper.php");
if (isset($_REQUEST['search'])) {
    $conn = new Helper();
    $stmt = "SELECT * FROM tbl_product  WHERE ten_pro regexp ? limit 5";
    $para = [$_REQUEST['search']];
    $result = $conn->fetchAll($stmt, $para);
}
foreach ($result as $row) {
    if ($_REQUEST['search'] =="") {
        echo"";
        break;
    }
?>
    <div class="row">
        <div class="col-md-3"><img src="../uploads/product-featured-7.jpg" alt=""></div>
        <div class="col-md-9 d-block">
            <div>
                <h4><?php echo $row["ten_pro"] ?></h4>
            </div>
            <div class="row d-flex">
                <div>Loai san pham</div>
                <div>Nhan Hieu</div>
            </div>
            <div class="row d-flex">
                <div><?php echo $row["giacu"] ?></div>
                <div><?php echo $row["giamoi"] ?></div>
            </div>
        </div>
    </div>
<?php
}
?>