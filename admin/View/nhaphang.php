<?php
if (isset($_POST['clear'])) {
    $_SESSION['phieunhap'] = array();
}
if (isset($_POST['thempn'])) {
    $size = $_REQUEST["size"];
    $gianhap = 0;
    if (!empty($_REQUEST['gianhap'])) {
        $gianhap = $_REQUEST['gianhap'];
    }
    $index = 0;
    if (isset($_SESSION['phieunhap'])) {
        $array = $_SESSION['phieunhap'];
        foreach ($array as $spnh) {
            $index = $spnh['index'];
        }
    } else {
        $array = array();
    }
    foreach ($_REQUEST['size'] as $size => $values) {
        if ($gianhap == 0) {
            echo "<script type='text/javascript'>alert('Bạn chưa nhập giá');</script>";
            break;
        }
        foreach ($values as $value) {
            $db = new Helper();
            $stmt = "select id_size from tbl_size where size =? ";
            $para = [$size];
            $result = $db->fetchOne($stmt, $para);
            $id_size = $result['id_size'];
            if ($value > 0) {
                $co = 0;
                foreach ($array as $spnh) {
                    if ($spnh['id_pro'] == $_REQUEST["id_pro"]) {
                        $array[$spnh['index']]['gianhap'] = $gianhap;
                        unset($_SESSION['phieunhap']);
                        $_SESSION['phieunhap'] = $array;
                    }
                    if ($spnh['id_pro'] == $_REQUEST["id_pro"] && $spnh['size'] == $size) {
                        $array[$spnh['index']]['soluong'] += $value;
                        $co = 1;
                        unset($_SESSION['phieunhap']);
                        $_SESSION['phieunhap'] = $array;
                    }
                }
                if ($co == 0) {
                    $product = array(
                        'index' => $index++,
                        'id_pro' => $_REQUEST["id_pro"],
                        'ten_pro' => $_REQUEST["ten_pro"],
                        'size' => $size,
                        'id_size' => $id_size,
                        'gianhap' => $gianhap,
                        'soluong' => $value
                    );
                    $_SESSION['phieunhap'][] = $product;
                }
            }
        }
    }
}
if (isset($_POST['xoa'])) {
    $id_xoa = $_POST['id_xoa'];
    $size_xoa = $_POST['size_xoa'];
    $dem = 0;
    $array = $_SESSION['phieunhap'];
    foreach ($array as $spnh) {
        if ($spnh['id_pro'] == $id_xoa && $spnh['size'] == $size_xoa) {
            unset($array[$spnh['index']]);
            break;
        }
        $dem++;
    }
    $_SESSION['phieunhap'] = $array;
    echo "<script type='text/javascript'>alert('Đã xóa');</script>";
}
$tongtien = 0;
$tongsl = 0;

if (isset($_SESSION['phieunhap'])) {
    foreach ($_SESSION['phieunhap'] as $spnh) {
        $tongsl += $spnh['soluong'] * 1;
        $tongtien += $spnh['soluong'] * $spnh['gianhap'];
    }
}
date_default_timezone_set('Africa/Nairobi');
$now = date('d-m-Y');

if (isset($_POST['nhaphang'])) {
    $valid = 1;
    if (count($_SESSION["phieunhap"]) == 0) {
        $valid = 0;
        echo "<script type='text/javascript'>alert('Danh sách sản phẩm trống');</script>";
    }
    if ($valid == 1) {
        date_default_timezone_set('Africa/Nairobi');
        $now = date('Y-m-d');
        $db = new Helper();
        $stmt = "insert into tbl_phieunhap(id_nv,id_ncc,tongtien,tongsl,ngaynhap)value(?,?,?,?,?)";
        $para = [$_SESSION["user"]["id_user"], $_POST['nhacungcap'], $_POST['tongtien'], $_POST['tongsl'], $now];
        $db->execute($stmt, $para);
        $stmt1 = "select id_pn from tbl_phieunhap ORDER BY id_pn desc limit 1";
        $result1 = $db->fetchOne($stmt1);
        $id_px = $result1['id_pn'];
        foreach ($_SESSION['phieunhap'] as $spnh) {
            $stmt = "insert into tbl_chitiet_pn (id_pn,id_pro,id_size,soluong,dongia) value (?,?,?,?,?)";
            $para = [$id_px, $spnh['id_pro'], $spnh['id_size'], $spnh['soluong'], $spnh['gianhap']];
            $db->execute($stmt, $para);
            $stmt0 = "select id_pro from tbl_pro_soluong where id_pro = ? and id_size = ?";
            $para0 = [$spnh['id_pro'], $spnh['id_size']];
            if ($db->rowCount($stmt0, $para0) > 0) {
                $stmt0 = "select soluong from tbl_pro_soluong where id_pro = ? and id_size = ?";
                $para0 = [$spnh['id_pro'], $spnh['id_size']];
                $soluongtemp = $db->fetchOne($stmt0, $para0);
                $stmt1 = "update tbl_pro_soluong set soluong = ? where id_pro = ? and id_size = ?";
                $para1 = [$soluongtemp['soluong'] * 1 + $spnh['soluong'] * 1, $spnh['id_pro'], $spnh['id_size']];
                $db->execute($stmt1, $para1);
            } else {
                $stmt1 = "insert into tbl_pro_soluong(soluong,id_pro,id_size) values (?, ?, ?)";
                $para1 = [$spnh['soluong'], $spnh['id_pro'], $spnh['id_size']];
                $db->execute($stmt1, $para1);
            }
        }
        $_SESSION['phieunhap'] = array();
        echo "<script type='text/javascript'>alert('Nhập hàng thành công');</script>";
    }
}
?>
<script>
    window.history.replaceState(null, null, window.location.href);
</script>

<section class="content-header">
    <div class="content-header-left">
        <h1>Nhập hàng</h1>
    </div>

</section>

<section class="content">
    <div class="row">
        <div class="col-md-12" style="overflow: scroll;">
            <div class="box box-info" style="width: 1500px;">
                <div style="width: 1500px; display: flex; height: 500px;" >
                    <div style="width: 500px; margin-right: 50px;">
                        <h3 style="text-align: center;">PHIẾU NHẬP</h3>
                        <div style="height:400px; border: 1px solid black; border-radius: 15px; padding: 20px 2px;">
                            <form method="post">
                                <div class="row" style="margin: 5px 0; text-align:center;">
                                    <div class="col-md-5 text-right"><span style="font-size: 2rem;">Tên nhân viên: </span></div>
                                    <div class="col-md-7"><strong style="font-size: 2rem;"><?php echo $_SESSION['user']['ten_user'] ?></strong></div>
                                </div>
                                <div class="row" style="margin: 5px 0; text-align:center;">
                                    <div class="col-md-5 text-right" style="font-size: 2rem;">Nhà cung cấp:</div>
                                    <div class="col-md-7"><select name="nhacungcap" id="" style="width: 130px;height: 30px; border: 2px groove black; border-radius: 5px;">
                                            <?php
                                            $db = new Helper();
                                            $stmt = "select * from tbl_nhacungcap where daxoa <>1";
                                            $result = $db->fetchAll($stmt);
                                            foreach ($result as $row) {
                                            ?>
                                                <option value="<?php echo $row['id_ncc'] ?>"><?php echo $row['ten_ncc'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" style="margin: 5px 0; text-align:center;">
                                    <div class="col-md-5 text-right" style="font-size: 2rem;">Ngày nhập:</div>
                                    <div class="col-md-7"><strong style="font-size: 2rem;"><?php echo $now ?></strong></div>
                                </div>
                                <div class="row" style="margin: 5px auto; text-align: center;">
                                    <div class="col-md-5" style="font-size: 2rem; padding:0;">Tổng số lượng: <strong style="font-size: 2rem;"><?php echo $tongsl ?></strong></div>
                                    <dic class="col-md-7" style="font-size: 2rem; padding:0;">Tổng tiền nhập: <strong style="font-size: 2rem;"><?php echo money($tongtien) ?></strong></dic>
                                </div>
                                <div style="text-align: center; margin-top: 20px; display:flex; justify-content: center;">
                                    <input type="text" name="tongtien" hidden value="<?php echo $tongtien ?>">
                                    <input type="text" name="tongsl" hidden value="<?php echo $tongsl ?>">
                                    <button name="nhaphang" class="btn btn-success" onclick="return confirm('Bạn có muốn nhập hàng không')" style="font-size: 2rem; margin-right: 20px;">Nhập hàng</button>
                                    <input type="submit" name="clear" onclick="return confirm('Bạn có muốn xóa không')" value="Xóa danh sách" class="btn btn-danger" style="font-size: 2rem!important;"></input>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div style="width: 900px;">
                        <h3 style="text-align: center;">DANH SÁCH HÀNG NHẬP</h3>
                        <div style="height:400px; overflow-y: scroll;">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="col-md-1 text-center">ID Sản Phẩm</th>
                                        <th class="col-md-3">Tên sản phẩm</th>
                                        <th class="col-md-1 text-center">Size</th>
                                        <th class="col-md-1 text-center">Giá nhập</th>
                                        <th class="col-md-1 text-center">Số lượng</th>
                                        <th class="col-md-1 text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['phieunhap'])) {
                                        foreach ($_SESSION['phieunhap'] as $spnh) {
                                    ?>
                                            <tr class="dong">
                                                <td class="text-center"><?php echo $spnh['id_pro'] ?></td>
                                                <td><?php echo $spnh['ten_pro'] ?></td>
                                                <td class="text-center"><?php echo $spnh['size'] ?></td>
                                                <td class="col-md-1 text-right"><?php echo money($spnh['gianhap']) ?></td>
                                                <td class="text-center"><?php echo $spnh['soluong'] ?></td>
                                                <td class="text-center">
                                                    <form method="POST">
                                                        <input type="text" name="id_xoa" hidden value="<?php echo $spnh['id_pro'] ?>">
                                                        <input type="text" name="size_xoa" hidden value="<?php echo $spnh['size'] ?>">
                                                        <button name="xoa" onclick="return confirm('Bạn có muốn xóa không')" class="btn btn-danger">Xóa</button>
                                                    </form>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <div class="wrap col-md-12">
                        <div class="m-5">
                            <form style="display:flex; margin: 30px 0 10px 0;">
                                <div style="padding: 0 20px;">
                                    Search <input type="text" id="search" placeholder="ID or Name">
                                </div>
                                <div style="padding: 0 20px;">
                                    Nhãn hiệu <select name="" onchange="show(1)" id="nhanhieu">
                                        <option value="">Tất cả</option>
                                        <?php
                                        $db = new Helper();
                                        $stmt = "select * from tbl_nhanhieu";
                                        $result = $db->fetchAll($stmt);
                                        foreach ($result as $row) {
                                        ?>
                                            <option value="<?php echo $row['id_nh'] ?>"><?php echo $row['nhanhieu'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div style="padding: 0 20px;">
                                    Danh mục <select name="" onchange="show(1)" id="danhmuc">
                                        <option value="">Tất cả</option>
                                        <?php
                                        $db = new Helper();
                                        $stmt = "select * from tbl_danhmuc";
                                        $result = $db->fetchAll($stmt);
                                        foreach ($result as $row) {
                                        ?>
                                            <option value="<?php echo $row['id_dm'] ?>"><?php echo $row['danhmuc'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div style="padding: 0 20px;">
                                    Số Dòng / Trang <select name="" onchange="show(1)" id="sodong">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="20">20</option>
                                    </select>

                                </div>
                                <div style="padding: 0 20px;"><input type="button" id="tim" value="Tim" onclick="show(1)"></div>

                            </form>
                        </div>
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="col-md-1 text-center">id</th>
                                    <th class="col-md-2">Hình ảnh</th>
                                    <th class="col-md-4">Tên sản phẩm</th>
                                    <th class="col-md-2">Danh mục</th>
                                    <th class="col-md-1">Nhãn hiệu</th>
                                    <th class="col-md-1 text-center">Số lượng</th>
                                    <th class="col-md-1 text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="dulieu">

                            </tbody>
                        </table>
                    </div>
                    <style>
                    </style>
                    <nav aria-label="Page navigation " style="width: 100%; display: flex; justify-content: center; padding-bottom: 20px;">

<ul class="pagination mt-3 row " id="trang" style="width: 400px; display: flex; justify-content: center; overflow-x: scroll;">
</ul>

</nav>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal model-lg fade" id="themgiohang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">THÊM VÀO DANH SÁCH</h4>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="mb-3" style="margin-bottom: 20px;"> Nhập số lượng:</div>
                    <div class="d-flex row">
                        <input type="text" hidden name="id_pro" value="" id="id_pro">
                        <input type="text" hidden name="ten_pro" value="" id="ten_pro">
                        <div style="margin-left: 30px;">
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size ASC");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($result as $row) {
                            ?>
                                <div style="float:left; margin-right:10px;">
                                    <label for="" class="control-label"><?php echo $row['size']; ?><input type="number" min="0" style="width:50px; margin-left:5px;" name="size[<?php echo $row['size']; ?>][]"></label>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div style="margin-top: 10px; margin-bottom: 10px; display: flex; justify-content: center;">Giá Nhập <input style="margin-left: 10px;" min="0" name="gianhap" type="number"></div>
                    <div class="row text-center"><button type="submit" class="btn btn-success" value="Xác nhận" name="thempn">Xác nhận</button></div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="soluong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Số lượng từng kích thước</h4>
            </div>
            <div class="modal-body">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th>Kích thước</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody id="soluongsize">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script defer>
    function show(p) {
        var search = document.getElementById("search").value;
        var id_nh = document.getElementById("nhanhieu").value;
        var id_dm = document.getElementById("danhmuc").value;
        var sodong = document.getElementById("sodong").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Model/dulieugh-tk-pt.php?p=" + p + "&search=" + search + "&id_nh=" + id_nh + "&id_dm=" + id_dm + "&sodong=" + sodong, true);
        xmlhttp.send();
    }
    window.onload = show(1);

    function soluongne(p) {
        var search = document.getElementById("search").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("soluongsize").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "../Model/product-soluong.php?id_pro=" + p, true);
        xmlhttp.send();
    }

    function layTenNe(p) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("id_pro").value = inra[0];
                document.getElementById("ten_pro").value = inra[1];
            }
        }
        xmlhttp.open("GET", "../Model/LayTen.php?id_pro=" + p, true);
        xmlhttp.send();
    }
</script>