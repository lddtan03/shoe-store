<?php
$error_message = '';
?>
<?php
if ($error_message != '') {
    echo "<script>alert('" . $error_message . "')</script>";
}
if ($success_message != '') {
    echo "<script>alert('" . $success_message . "')</script>";
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
                        <form action="index.php" method="get">
                            <input type="hidden" name="page" value="size">
                            <input type="hidden" name="p" value="1">
                            <div class="">Search <input type="text" name="search" placeholder="ID or Name"><input type="submit" value="Tìm" name="tim"></div>
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
                        <tbody>
                            <?php
                            $statement = $pdo->prepare("SELECT * FROM tbl_phieuxuat");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $db=new Helper();
                                $stmt1= "select id_user,ten_user,email,sodth from tbl_users where id_user =?";
                                $para1=[$row['id_kh']];
                                $khachhang =$db ->fetchOne($stmt1,$para1);
                            ?>
                                <tr class="<?php if ($row['trangthai'] == '1') {
                                                echo 'bg-g';
                                            } else if ($row['trangthai'] == '2'){
                                                echo 'bg-r';
                                            } ?>">
                                    <td><?php echo $row['id_px']; ?></td>
                                    <td>
                                        <b>Id:</b> <?php echo $khachhang['id_user'] ?><br>
                                        <b>Name:</b> <?php echo $khachhang['ten_user']?><br>
                                        <b>Email:</b> <?php echo $khachhang['email'] ?><br>
                                        <b>Số điện thoại:</b> <?php echo $khachhang['sodth'] ?><br>
                                    </td>
                                    <td>
                                        <b>Id:</b> <?php  ?><br>
                                        <b>Name:</b><br> <?php  ?><br>
                                        <b>Email:</b><br> <?php  ?><br>
                                    </td>
                                    <td>5</td>
                                    <td>
                                        <?php echo money($row['tongtien']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['trangthai'] == 0) {
                                        ?>
                                            <a href="#" data-href="../View/order-change-status.php?id=<?php echo $row['id_px']; ?>" class="btn btn-warning btn-xs" style="width:30%%;margin-bottom:4px;" data-toggle="modal" data-target="#xacnhan">Xác nhận</a>
                                            <a href="#" data-href="../View/order-change-status.php?id=<?php echo $row['id_px']; ?>" class="btn btn-danger btn-xs" style="width:30%%;margin-bottom:4px;" data-toggle="modal" data-target="#huydon">Hủy Đơn</a>
                                        <?php
                                        } else if($row['trangthai'] == 1){
                                        ?>
                                           <button class="btn btn-success btn-xs"> Đã Xác Nhận</button>
                                        <?php
                                        }else{
                                            ?>
                                            <button class="btn btn-danger btn-xs"> Đã hủy</button>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#chitiet">Chi tiết</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-href="../Model/color-delete.php?id=<?php echo $row['id_px']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation ">
                        <ul class="pagination mt-3 ">
                            <li class="page-item "><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
</section>

<div class="modal fade" id="xacnhan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận đơn hàng</h4>
            </div>
            <div class="modal-body">
                Bạn có đồng ý xác nhận đơn hàng không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Dồng ý</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="huydon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận đơn hàng</h4>
            </div>
            <div class="modal-body text-danger">
                Bạn có đồng ý hủy đơn hàng không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Dồng ý</a>
            </div>
        </div>
    </div>
</div>
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