<?php
if (isset($_GET['doitt'])){
    echo"vo";
}
include("../Control/inc/config.php");
$sodong = 7;
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_users");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_users where id_user regexp $search or ten_user regexp $search");
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
    $statement = $pdo->prepare("SELECT * FROM tbl_users limit $sodong offset $min");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_users where id_user regexp $search or ten_user regexp $search limit $sodong offset $min");
}
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <tr  class="dong " style="background-color:<?php if ($row['trangthai'] == 1)
                    echo"#c44b69";
                    else
                    echo"#71f593";
                    ?>; color:black;" >
        <td><?php echo $row['id_user']; ?></td>
        <td>
            <div class="row" style="text-align: left;">
                <div class="col-md-3"><img src="../assets/uploads/product-featured-84.jpg" width="100px" alt=""></div>
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
        <td> <?php echo $row['nhomquyen']; ?></td>
        <td>
        <button onclick="doitt(<?php echo $row['id_user']; ?>)"><?php if ($row['trangthai'] == 0)
                        echo "Hoạt động";
                    else echo "Bị khóa";
                    ?></button>
        </td>

        <td>
            <a href="#" class="btn btn-danger btn-xs" data-href="../Model/ten_user-delete-xl.php?id=<?php echo $row['id_user']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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