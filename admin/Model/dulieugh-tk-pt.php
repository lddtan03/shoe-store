<?php
include("../Control/inc/config.php");
include("../Database/Helper.php");
$sodong = 7;
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_product");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_product where id_pro regexp $search or ten_pro regexp $search ");
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
    $statement = $pdo->prepare("SELECT * FROM tbl_product limit $sodong offset $min");
} else {
    $search = $_GET['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_product where id_pro regexp $search or ten_pro regexp '$search' limit $sodong offset $min");
}
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <tr class="dong">
        <td class="text-center"><?php echo $row['id_pro']; ?></td>
        <td style="text-align: center;"><img src="../../uploads/<?php echo $row['hinhanh'] ?>" alt="" style="width:80px;"></td>
        <!-- <td style="text-align: center;"><img src="../assets/uploads/product-featured-86.jpg" style="width:80px;" alt=""></td> -->
        <td><?php echo $row['ten_pro']; ?></td>
        <td></td>
        <td></td>
        <td class="text-center"> <a href="#" class="btn btn-info btn-xs" onclick="soluongne(<?php echo $row['id_pro'] ?>)" data-toggle="modal" data-target="#soluong">
                <?php
                $db = new Helper();
                $statement ="SELECT sum(soluong) as tong FROM tbl_pro_soluong WHERE id_pro=? ";
                $para=[$row['id_pro']];
                $total = $db->fetchOne($statement,$para);
                if($total['tong']>0)
                {
                    echo $total['tong'];
                }else{
                    echo 0;
                }
                ?></a></td>

        <td class="text-center">
            <a onclick="truyenid(<?php echo $row['id_pro']; ?>,<?php echo $row['ten_pro']; ?>)"  data-toggle="modal" data-target="#themgiohang" class="btn btn-primary btn-xs">Chọn</a>
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
<li class="page-item "><a class="page-link"  onclick="show(<?php if ($p < $sotrang) echo $p + 1;
                                                            else echo $p; ?>)">Next</a></li>

<?php
