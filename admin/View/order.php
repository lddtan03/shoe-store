<?php
$error_message = '';
if (isset($_POST['form1'])) {
    $valid = 1;
    if (empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if (empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if ($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        

        $i = 0;
        $statement = $pdo->prepare("SELECT * FROM tbl_phieunhap WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item ' . $i . '</u></b><br>
Product Name: ' . $row['product_name'] . '<br>
Size: ' . $row['size'] . '<br>
Color: ' . $row['color'] . '<br>
Quantity: ' . $row['quantity'] . '<br>
Unit Price: ' . $row['unit_price'] . '<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text, $message_text, $order_detail, $_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
' . $message_text . '
<h3>Order Details: </h3>
' . $order_detail . '
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
            'Reply-To: ' . $admin_email . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to admin                  
        mail($to_customer, $subject_text, $message, $headers);

        $success_message = 'Your email to customer is sent successfully.';
    }
}
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
                            $statement = $pdo->prepare("SELECT * FROM tbl_phieunhap");
                            $statement->execute();

                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                            ?>
                                <tr class="<?php if ($row['tinhtrang'] == '0') {
                                                echo 'bg-r';
                                            } else {
                                                echo 'bg-g';
                                            } ?>">
                                    <td><?php echo $row['id_donhang']; ?></td>
                                    <td>
                                        <b>Id:</b> <?php  ?><br>
                                        <b>Name:</b><br> <?php  ?><br>
                                        <b>Email:</b><br> <?php  ?><br>
                                    </td>
                                    <td>
                                        <b>Id:</b> <?php  ?><br>
                                        <b>Name:</b><br> <?php  ?><br>
                                        <b>Email:</b><br> <?php  ?><br>
                                    </td>
                                    <td>5</td>
                                    <td>
                                        <?php echo $row['tongia']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row['tinhtrang'] == 'Chờ xác nhận') {
                                        ?>
                                            <a href="#" data-href="../View/order-change-status.php?id=<?php echo $row['id_donhang']; ?>" class="btn btn-success btn-xs" style="width:30%%;margin-bottom:4px;" data-toggle="modal" data-target="#xacnhan">Chờ xác nhận</a>
                                        <?php
                                        } else {
                                            echo $row['tinhtrang'];
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-info btn-xs" data-toggle="modal" data-target="#chitiet">Chi tiết</a>
                                        <a href="#" class="btn btn-danger btn-xs" data-href="../Model/color-delete.php?id=<?php echo $row['id_donhang']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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