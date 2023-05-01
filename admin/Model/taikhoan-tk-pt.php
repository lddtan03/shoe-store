<?php
if (isset($_GET['doitt'])) {
    echo "vo";
}
include("../Control/inc/config.php");
include("../Database/Helper.php");
$sodong = 7;
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_users where daxoa=0");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_users where id_user regexp $search or ten_user regexp $search and daxoa=0");
}
$statement->execute();
$sokq = $statement->rowCount();
$sotrang = round($sokq / $sodong + 0.4);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;

$min = $sodong * ($p - 1);
?>

<?php
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_users where daxoa=0 limit $sodong offset $min ");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_users where daxoa = 0 andid_user regexp $search or ten_user regexp $search limit $sodong offset $min");
}
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <tr class="dong " style="background-color:<?php if ($row['trangthai'] == 1)
                                                    echo "#c44b69";
                                                else
                                                    echo "#71f593";
                                                ?>; color:black;">
        <td><?php echo $row['id_user']; ?></td>
        <td>
            <div class="row" style="text-align: left;">
                <div class="col-md-3"><img src="../../uploads/<?php echo $row['avatar']; ?>" width="100px" height="100px" style="border-radius: 100%;" alt=""></div>
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <b>Tên: </b><?php echo $row['ten_user']; ?> <br>
                    <b>Email: </b><?php echo $row['email']; ?> <br>
                    <b>Số điện thoại: </b><?php echo $row['sodth']; ?>
                </div>

            </div>

        </td>
        <td style="text-align: left; padding-left:30px;">
            <b>Tài khoản: </b> <?php echo $row['email']; ?> <br>
            <b>Mật khẩu: </b> <?php echo $row['matkhau']; ?>
        </td>
        <td>
           
            <?php
                ?>
                 <select id="nhomquyen<?php echo $row['id_user']; ?>" style="height: 25px;" onchange="doicv(<?php echo $row['id_user']; ?>)">
                <?php

                $db = new Helper();
                $stmt = "select * from tbl_nhomquyen where daxoa=0";
                $result1 = $db->fetchAll($stmt);
                foreach ($result1 as $row1) {
                ?>
                    <option <?php if($row1['nhomquyen'] == $row['nhomquyen']) echo "selected" ?>  value="<?php echo $row1['nhomquyen']; ?>"><?php echo $row1['nhomquyen']; ?></option>
                <?php
                }
                if($row["id_loaitk"] == 1){
                ?>
                <option selected> Khách Hàng</option>
                <?php
                }
                ?>
            </select>
        </td>
        <td>
            <button onclick="doitt(<?php echo $row['id_user']; ?>)"><?php if ($row['trangthai'] == 0)
                                                                        echo "Hoạt động";
                                                                    else echo "Bị khóa";
                                                                    ?></button>
        </td>
        <td>
            <a href="../View/taikhoan-delete.php?id=<?php echo $row['id_user']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có muốn xóa không')" >Delete</a>
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