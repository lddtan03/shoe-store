<?php
include("../Database/Helper.php");
$id_pro = $_REQUEST['id_pro'];
$db = new Helper();
$statement = "SELECT size,soluong FROM tbl_pro_soluong as pl join tbl_size on pl.id_size=tbl_size.id_size where id_pro = ?";
$para = [$id_pro];
$result = $db->execute($statement, $para);
foreach ($result as $row) {

?>
    <tr>
        <td><?php echo $row["size"] ?></td>
        <td><?php echo $row["soluong"] ?></td>
    </tr>
<?php
}

?>
