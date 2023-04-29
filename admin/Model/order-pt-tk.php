<?php
include("../Control/inc/config.php");
include("../Database/Helper.php");
$sodong = $_GET['sodong'];
$id_dh = $_GET['id_dh'];
$khachhang = $_GET['khachhang'];
$nhanvien = $_GET['nhanvien'];
$trangthai = $_GET['tinhtrang'];
$db = new Helper();
$stmt = "select id_px from tbl_phieuxuat where id_px regexp ? and id_kh regexp ? and id_nv regexp ? and trangthai regexp ?";
$para=[$id_dh,$khachhang,$nhanvien,$trangthai];
$dem=$db->rowCount($stmt,$para);
$sotrang = round($dem/ $sodong + 0.49);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;
$min = $sodong * ($p - 1);

$db = new Helper();
$stmt = "select * from tbl_phieuxuat where id_px regexp ? and id_kh regexp ? and id_nv regexp ? and trangthai regexp ? limit $sodong offset $min";
$para=[$id_dh,$khachhang,$nhanvien,$trangthai];
$result = $db->fetchAll($stmt,$para);
foreach ($result as $row) {
    $db = new Helper();
    $stmt1 = "select id_user,ten_user,email,sodth from tbl_users where id_user =?";
    $para1 = [$row['id_kh']];
    $khachhang = $db->fetchOne($stmt1, $para1);
    $nhanvien = null;
    if ($row['trangthai'] != 0) {
        $stmt1 = "select id_user,ten_user,email,sodth from tbl_users where id_user =?";
        $para1 = [$row['id_nv']];
        $nhanvien = $db->fetchOne($stmt1, $para1);
    }
?>
    <tr class="<?php if ($row['trangthai'] == '1') {
                    echo 'bg-g';
                } else if ($row['trangthai'] == '2') {
                    echo 'bg-r';
                } ?>">
        <td><?php echo $row['id_px']; ?></td>
        <td>
            <b>Id:</b> <?php echo $khachhang['id_user'] ?><br>
            <b>Name:</b> <?php echo $khachhang['ten_user'] ?><br>
            <b>Email:</b> <?php echo $khachhang['email'] ?><br>
            <b>Số điện thoại:</b> <?php echo $khachhang['sodth'] ?><br>
        </td>
        <td>
            <?php
            if ($nhanvien != null) {
            ?>
                <b>Id:</b> <?php echo $nhanvien['id_user'] ?><br>
                <b>Name:</b> <?php echo $nhanvien['ten_user'] ?><br>
                <b>Email:</b> <?php echo $nhanvien['email'] ?><br>
                <b>Số điện thoại:</b> <?php echo $nhanvien['sodth'] ?><br>
            <?php
            }
            ?>
        </td>
        <td>5</td>
        <td>
            <?php echo money($row['tongtien']); ?>
        </td>
        <td>
            <?php
            if ($row['trangthai'] == 0) {
            ?>
                <form method="post">
                    <input type="text" name="id_xuly" hidden value="<?php echo $row['id_px']; ?>">
                    <button type="submit" onclick="return confirm('Bạn có muốn xác nhận đơn hàng không')" name="xacnhan" class="btn btn-warning btn-xs ">Xác nhận </button>
                    <button type="submit" onclick="return confirm('Bạn có muốn hủy đơn hàng không')" name="huydon" class="btn btn-danger btn-xs">Hủy Đơn </button>
                </form>
            <?php
            } else if ($row['trangthai'] == 1) {
            ?>
                <button class="btn btn-success btn-xs"> Đã Xác Nhận</button>
            <?php
            } else {
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
echo "???";
?>
<li class="page-item "><a class="page-link" onclick="show(<?php if ($p > 1) echo $p - 1;
                                                            else echo $p; ?>)">Previous</a></li>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php
}
?>
<li class="page-item "><a class="page-link" onclick="show(<?php if ($p < $sotrang) echo $p + 1;
                                                            else echo $p; ?>)">Next</a></li>