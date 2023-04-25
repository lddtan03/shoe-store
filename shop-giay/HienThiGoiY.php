<?php
include("Helper.php");
if (isset($_REQUEST['search'])) {
    $conn = new Helper();
    $stmt = "SELECT * FROM tbl_product  WHERE ten_pro regexp ? limit 5";
    $para = [$_REQUEST['search']];
    $result = $conn->fetchAll($stmt, $para);
}
foreach ($result as $row) {
    if ($_REQUEST['search'] == "") {
        echo "";
        break;
    }
?>

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


    <div class="row hienThiGoiY">
        <div class="col-md-3"><img src="../uploads/product-featured-7.jpg" alt=""></div>
        <div class="col-md-9 d-block">
            <div>
                <h5 style="color: #0288d9;"><?php echo $row["ten_pro"] ?></h5>
            </div>
            <div class="row d-flex my-2">
                <div style="margin: 0 18px;">Loai san pham</div>
                <div>Nhan Hieu</div>
            </div>
            <div class="row d-flex " style="margin-left:10px; align-items:center;" >
                <div style="margin-right:20px; color: #0288d9; font-weight: bold; font-size:larger;"><?php echo $row["giamoi"] ?></div>
                <div><del><?php echo $row["giacu"] ?></del></div>
            </div>
        </div>
    </div>
<?php
}
?>