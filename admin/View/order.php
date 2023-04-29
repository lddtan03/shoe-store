<?php
if (isset($_POST['xacnhan'])) {
    $id_xuly = $_POST['id_xuly'];
    $db = new Helper();
    $stmt = "update tbl_phieuxuat set trangthai = 1, id_nv=? where id_px =?";
    $para = [$_SESSION['user']['id_user'], $id_xuly];
    $db->execute($stmt, $para);
    echo "<script type='text/javascript'>alert('Xác nhận thành công');</script>";
}
if (isset($_POST['huydon'])) {
    $id_xuly = $_POST['id_xuly'];
    $db = new Helper();
    $stmt = "update tbl_phieuxuat set trangthai = 2, id_nv=? where id_px =?";
    $para = [$_SESSION['user']['id_user'], $id_xuly];
    $db->execute($stmt, $para);
    echo "<script type='text/javascript'>alert('Đã hủy đơn');</script>";
}
?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Các đơn hàng</h1>
    </div>
</section>
<section class="content">

    <div class="row">
        <div class="box box-info">
            <div class="box-body table-responsive">
                <div class="wrap col-md-12">
                    <div class="m-5 ">
                        <form>
                            <input type="hidden" name="p" value="1">
                            <div class="">
                                ID Đơn hàng<input type="text" id="id_dh" placeholder="ID">
                                Khách Hàng<input type="text" id="khachhang" placeholder="Name">
                                Nhân Viên<input type="text" id="nhanvien" placeholder="Name">
                                Tình Trạng<select name="" id="tinhtrang" onchange="show(1)">
                                    <option value="">Tất cả</option>
                                    <option value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đã hủy</option>
                                </select>
                                Số dòng<select name="" id="sodong" onchange="show(1)">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                </select>
                                <input type="button" id="tim" value="Tim" onclick="show(1)">
                            </div>
                        </form>
                    </div>
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="col-md-1">#</th>
                                <th class="col-md-3">Khách hàng</th>
                                <th class="col-md-3">Nhân viên</th>
                                <th class="col-md-1">Số lượng</th>
                                <th class="col-md-1">Tổng tiền</th>
                                <th class="col-md-1">Trạng thái</th>
                                <th class="col-md-2">Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="dulieu">

                        </tbody>
                    </table>
                    <nav aria-label="Page navigation ">
                        <ul class="pagination mt-3 " id="trang">

                        </ul>
                    </nav>
                </div>
            </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="chitiet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Chi tiết đơn hàng</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-md-2">STT</th>
                            <th class="col-md-3">Tên sản phẩm</th>
                            <th class="col-md-2">Size</th>
                            <th class="col-md-2">Số lượng</th>
                            <th class="col-md-2">Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>dep cao su</td>
                            <td>XL</td>
                            <td>3</td>
                            <td>23000 đ</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Tổng cộng:</td>
                            <td colspan="1"><strong>15000 đ</strong> </td>
                        </tr>
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
        var id_dh = document.getElementById("id_dh").value;
        var khachhang = document.getElementById("khachhang").value;
        var nhanvien = document.getElementById("nhanvien").value;
        var tinhtrang = document.getElementById("tinhtrang").value;
        var sodong = document.getElementById("sodong").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Model/order-pt-tk.php?p=" + p + "&id_dh=" + id_dh + "&khachhang=" + khachhang + "&nhanvien=" + nhanvien + "&tinhtrang=" + tinhtrang + "&sodong=" + sodong, true);
        xmlhttp.send();
    }
    window.onload = show(1);
</script>