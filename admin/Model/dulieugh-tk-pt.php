<?php
include("../Control/inc/config.php");
include("../Database/Helper.php");
$sodong = $_GET['sodong'];

$search = $_GET['search'];
$id_nh = $_GET['id_nh'];
$id_dm = $_GET['id_dm'];
$conn = new Helper();
$stmt = "SELECT * FROM tbl_product join tbl_danhmuc on tbl_product.id_dm = tbl_danhmuc.id_dm join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh where (id_pro regexp ? or ten_pro regexp ?) AND tbl_product.id_nh regexp ? AND tbl_product.id_dm regexp ?";
$para = [$search,$search,$id_nh,$id_dm];
$sokq = $conn->rowCount($stmt, $para);
$sotrang = round($sokq / $sodong + 0.4);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;
$min = $sodong * ($p - 1);
?>

<?php
$conn = new Helper();
$stmt = "SELECT * FROM tbl_product join tbl_danhmuc on tbl_product.id_dm = tbl_danhmuc.id_dm join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh where (id_pro regexp ? or ten_pro regexp ?) AND tbl_product.id_nh regexp ? AND tbl_product.id_dm regexp ? limit $sodong offset $min ";
$para = [$search,$search,$id_nh,$id_dm];
$result = $conn->fetchAll($stmt, $para);
foreach ($result as $row) {
?>
    <tr class="dong">
        <td class="text-center"><?php echo $row['id_pro']; ?></td>
        <td style="text-align: center;"><img src="../../uploads/<?php echo $row['hinhanh'] ?>" alt="" style="width:80px;"></td>
        <td><?php echo $row['ten_pro']; ?></td>
        <td><?php echo $row['danhmuc']; ?></td>
        <td><?php echo $row['nhanhieu']; ?></td>
        <td class="text-center"> <a href="#" class="btn btn-info btn-xs" onclick="soluongne(<?php echo $row['id_pro'] ?>)" data-toggle="modal" data-target="#soluong">
                <?php
                $db = new Helper();
                $statement = "SELECT sum(soluong) as tong FROM tbl_pro_soluong WHERE id_pro=? ";
                $para = [$row['id_pro']];
                $total = $db->fetchOne($statement, $para);
                if ($total['tong'] > 0) {
                    echo $total['tong'];
                } else {
                    echo 0;
                }
                ?></a></td>

        <td class="text-center">
            <a onclick="layTenNe(<?php echo $row['id_pro'] ?>)" data-toggle="modal" data-target="#themgiohang" class="btn btn-primary btn-xs">Chọn</a>
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

<?php
