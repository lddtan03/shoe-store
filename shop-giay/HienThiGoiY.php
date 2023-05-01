<style>
    .row.hienThiGoiY {
        width: 100%;
        margin-left: 0;
        border-bottom: 1px solid black;
        padding: 10px 0;
    }

    .row.hienThiGoiY:last-child {
        margin-bottom: 0px;
    }

    .row.hienThiGoiY:hover {
        background: rgb(200, 300, 300);
        border-bottom: 1px solid black;
    }


    img {
        max-width: 100%;
    }
</style>
<?php
include("Helper.php");
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
      if (!empty($number)) {
        return number_format($number, 0, ',', ',') . "{$suffix}";
      }
    }
  }
if (isset($_REQUEST['search'])) {
    $conn = new Helper();
    $stmt = "SELECT * FROM tbl_product join tbl_nhanhieu on tbl_nhanhieu.id_nh =tbl_product.id_nh join tbl_danhmuc on tbl_danhmuc.id_dm = tbl_product.id_dm WHERE ten_pro regexp ? limit 5";
    $para = [$_REQUEST['search']];
    $result = $conn->fetchAll($stmt, $para);
}
foreach ($result as $row) {
    if ($_REQUEST['search'] == "") {
        echo "";
        break;
    }
?>
    <div class="row hienThiGoiY">
        <div class="col-md-3"><img src="../uploads/<?php echo $row['hinhanh'] ?>" alt=""></div>
        <div class="col-md-9 d-block">
            <div>
                <a href="chitietsp.php?id=<?php echo $row['id_pro']; ?>">
                    <h5 style="color: #0288d9;"><?php echo $row["ten_pro"] ?></h5>
                </a>
            </div>
            <div class="row d-flex my-2">
                <div style="margin: 0 18px;"><?php echo $row['danhmuc']; ?></div>
                <div><?php echo $row['nhanhieu']; ?></div>
            </div>
            <div class="row d-flex " style="margin-left:10px; align-items:center;">
                <div style="margin-right:20px; color: #0288d9; font-weight: bold; font-size:larger;"><?php echo money($row["giamoi"]) ?></div>
                <div><del><?php echo money($row["giacu"]) ?></del></div>
            </div>
        </div>
    </div>
<?php
}
?>