<?php
include("../Control/inc/config.php");
include("../Database/Helper.php");
$sodong = $_GET['sodong'];
$id_nh = $_GET['id_nh'];
$id_dm = $_GET['id_dm'];
$ngaymin = $_GET['ngaymin'];
$ngaymax = $_GET['ngaymax'];
$topsp = $_GET['topsp'];

$db = new Helper();
$stmt = "select px.id_pro from tbl_phieuxuat join tbl_chitiet_px as px on tbl_phieuxuat.id_px = px.id_px join tbl_product on px.id_pro = tbl_product.id_pro join tbl_nhanhieu on tbl_product.id_nh = tbl_nhanhieu.id_nh 
    where tbl_product.id_nh regexp ? and tbl_product.id_dm regexp ? and ngaydat >= ? and ngaydat <=? group by tbl_product.id_pro";
$para = [$id_nh, $id_dm,$ngaymin,$ngaymax];
$dem = $db->rowCount($stmt, $para);
$sotrang = round($dem / $sodong + 0.49);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;
$min = $sodong * ($p - 1);

$db = new Helper();
$stmt = "SELECT tbl_product.id_pro,ten_pro FROM tbl_phieuxuat join tbl_chitiet_px as px on tbl_phieuxuat.id_px = px.id_px join tbl_product on px.id_pro =tbl_product.id_pro 
 where tbl_product.id_nh regexp ? and tbl_product.id_dm regexp ? and ngaydat >= ? and ngaydat <=?  group by tbl_product.id_pro order by sum(soluong) asc limit $sodong offset $min";
$para = [$id_nh, $id_dm,$ngaymin,$ngaymax];
$result = $db->fetchAll($stmt, $para);
foreach ($result as $row) {
    $stmt1 = "select sum(soluong) as tongsl from tbl_chitiet_px where id_pro =?";
    $para1 = [$row['id_pro']];
    $tong = $db->fetchOne($stmt1, $para1);
    $tongsl = $tong['tongsl'];
    $stmt2 = "select soluong,giaban from tbl_chitiet_px where id_pro =?";
    $para2 = [$row['id_pro']];
    $result2 = $db->fetchAll($stmt2, $para2);
    $tongtien = 0;
    foreach ($result2 as $row2) {
        $tongtien += $row2['soluong'] * $row2['giaban'];
    }
?>
    <tr>
        <td class="text-center"><?php echo $row['id_pro'] ?></td>
        <td>
            <?php echo $row['ten_pro'] ?>
        </td>
        <td class="text-center">
            <?php echo $tongsl ?>
        </td>
        <td class="text-right">
            <?php echo money($tongtien) ?>
        </td>
        <td class="text-center">
           <?php
            $db = new Helper();
            $stmt = "select sum(soluong) as sl from tbl_pro_soluong where id_pro =?";
            $para=[$row['id_pro']];
            $result =$db->fetchOne($stmt,$para);
            echo $result['sl'];
           ?>
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