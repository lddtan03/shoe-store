<?php
include("../Control/inc/config.php");
$sodong = 7;
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_dm_nh");
} else {
    $search = $_GET['search'];
    if(!is_numeric($search)){
        $statement = $pdo->prepare("SELECT * FROM tbl_dm_nh join tbl_nhanhieu on tbl_dm_nh.id_nhanhieu=tbl_nhanhieu.id_nhanhieu join tbl_danhmuc on tbl_dm_nh.id_danhmuc=tbl_danhmuc.id_danhmuc 
        where tennhanhieu regexp '$search' or tendm regexp '$search' ");
    }else{
        return;
    }  
}
$statement->execute();
$sokq = $statement->rowCount();
$sotrang = round($sokq/ $sodong + 0.4);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;

$min = $sodong * ($p - 1);
?>

<?php
if (empty($_GET['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_dm_nh join tbl_nhanhieu on tbl_dm_nh.id_nhanhieu=tbl_nhanhieu.id_nhanhieu join tbl_danhmuc on tbl_dm_nh.id_danhmuc=tbl_danhmuc.id_danhmuc limit $sodong offset $min");
} else {
    $search = $_GET['search'];
    if(!is_numeric($search)){
        $statement = $pdo->prepare("SELECT * FROM tbl_dm_nh join tbl_nhanhieu on tbl_dm_nh.id_nhanhieu=tbl_nhanhieu.id_nhanhieu join tbl_danhmuc on tbl_dm_nh.id_danhmuc=tbl_danhmuc.id_danhmuc where tennhanhieu regexp '$search' or tendm regexp '$search' limit $sodong offset $min");
    }else{
        return;
    }  
}
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <tr class="dong">
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['tendm']; ?></td>
        <td><?php echo $row['tennhanhieu']; ?></td>
        <td>
            <a href="<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
            <a href="#" class="btn btn-danger btn-xs" data-href="../Model/size-delete-xl.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
        </td>
    </tr>

<?php
    
}
echo "???";
?>
<li class="page-item "><a class="page-link" onclick="show(<?php if($p>1) echo $p-1;else echo $p; ?>)">Previous</a></li>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php

}

?>
<li class="page-item "><a class="page-link" onclick="show(<?php if($p<$sotrang) echo $p+1;else echo $p; ?>)">Next</a></li>
