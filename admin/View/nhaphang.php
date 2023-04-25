<?php
if (isset($_POST['clear'])) {
    $_SESSION['phieunhap'] = array();
}
if (isset($_POST['thempn'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size ASC");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC); 
    $size = $_REQUEST["size"];
    if (isset($_SESSION['phieunnhap'])) {
        $array = $_SESSION['phieunnhap'];
    } else {
        $array = array();
    }
    $dem = 0;
    foreach ($size as $row1) {
        $dem1 = 0;
        foreach ($result as $row) {
            if ($row1 > 0 && $dem == $dem1) {
                $array += array(
                    'id_pro' => $_REQUEST["id_pro"],
                    'ten_pro' => $_REQUEST["ten_pro"],
                    'size' => $row['size'],
                    'soluong' => $row1,
                );
            }
            $dem1++;
        }
        $dem++;
    }
    array_push($_SESSION['phieunhap'], $array);
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
        <div class="col-md-12">
            <div class="box box-info">
                <div class="row">
                    <div class="col-md-4">
                        <h3 style="text-align: center;">PHIẾU NHẬP</h3>

                        <div style="height:400px;" class="shadow border">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-5 text-right">Tên nhân viên: </div>
                                    <div class="col-md-7"><strong><?php echo $_SESSION['user']['ten_user'] ?></strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 text-right">Nhà cung cấp:</div>
                                    <div class="col-md-7"><strong><?php echo $_SESSION['user']['ten_user'] ?></strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5 text-right">Ngày nhập:</div>
                                    <div class="col-md-7"><strong><?php echo $_SESSION['user']['ten_user'] ?></strong></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">Tổng số lượng: <strong>100</strong></div>
                                    <dic class="col-md-7">Tổng tiền nhập: <strong>100000tr</strong></dic>

                                </div>
                                <button class="btn btn-success">Nhập hàng</button>
                                <input type="submit" name="clear" value="Xóa danh sách" class="btn btn-danger"></input>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h3 style="text-align: center;">DANH SÁCH HÀNG NHẬP</h3>
                        <div style="height:400px; overflow: scroll;">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="col-md-1 text-center">ID Sản Phẩm</th>
                                        <th class="col-md-3">Tên sản phẩm</th>
                                        <th class="col-md-1 text-center">Size</th>
                                        <th class="col-md-1 text-center">Số lượng</th>
                                        <th class="col-md-1 text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody s>
                                    <?php
                                    foreach ($_SESSION['phieunhap'] as $spnh) {
                                    ?>
                                        <tr class="dong">
                                            <td class="text-center"><?php echo $spnh['id_pro'] ?></td>
                                            <td><?php echo $spnh['ten_pro'] ?></td>
                                            <td class="text-center"><?php echo $spnh['size'] ?></td>
                                            <td class="text-center"><?php echo $spnh['soluong'] ?></td>
                                            <td class="text-center btn btn-danger">Xóa</a></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <div class="wrap col-md-12">
                            <div class="m-5 ">
                                <form>
                                    <div class="" style="float:left;">
                                        Search <input type="text" id="search" placeholder="ID or Name">

                                    </div>
                                    <div class="" style="float:left;">
                                        Nhãn hiệu <select name="" id="">
                                            <option value="">Nike</option>
                                        </select>

                                    </div>
                                    <div class="" style="float:left;">
                                        Danh mục <select name="" id="">
                                            <option value="">Giày sân cỏ</option>
                                        </select>
                                    </div>
                                    <div class="" style="float:left;"><input type="button" id="tim" value="Tim" onclick="show(1)"></div>

                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th class="col-md-1 text-center">id</th>
                                        <th class="col-md-2">Hình ảnh</th>
                                        <th class="col-md-3">Tên sản phẩm</th>
                                        <th class="col-md-1">Danh mục</th>
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
                        <nav aria-label="Page navigation ">

                            <ul class="pagination mt-3 row " id="trang">
                            </ul>

                        </nav>
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
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_size ORDER BY size ASC");
                        $statement->execute();
                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($result as $row) {
                        ?>
                            <div style="float:left; margin-right:10px;">
                                <label for="" class="control-label"><?php echo $row['size']; ?><input type="text" style="width:30px; margin-left:5px;" name="size[]"></label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
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
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Model/dulieugh-tk-pt.php?p=" + p + "&search=" + search, true);
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