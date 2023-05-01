<?php
include("../Database/Helper.php");
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}
if (isset($_REQUEST['id_lay'])) {
    $id_lay = $_REQUEST['id_lay'];
} else {
    $id_lay = 0;
}
$stt = 1;
$db = new Helper();
$stmt = "select * from tbl_chitiet_px as px join tbl_size on px.id_size =tbl_size.id_size join tbl_product on tbl_product.id_pro=px.id_pro where  id_px =? ";
$para = [$id_lay];
$result = $db->fetchAll($stmt, $para);
foreach ($result as $row) {
?>
    <tr>
        <td><?php echo $stt++; ?></td>
        <td><?php echo $row['ten_pro'] ?></td>
        <td><?php echo $row['size'] ?></td>
        <td><?php echo $row['soluong'] ?></td>
        <td><?php echo money($row['giaban']) ?></td>
    </tr>
<?php
}
?>