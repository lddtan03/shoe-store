<?php
include("../Database/Helper.php");
// include("../Control/inc/config.php");
$sodong = 7;
if (empty($_GET['search'])) {
    $statement = "SELECT * FROM tbl_size where daxoa<>1";
} else {
    $search = $_GET['search'];
    $statement = "SELECT * FROM tbl_size where daxoa<>1 and id_size regexp $search or size regexp $search ";
}
$db = new Helper();
$sokq = $db->rowCount($statement);
$sotrang = round($sokq / $sodong + 0.4);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;

$min = $sodong * ($p - 1);
?>

<?php
if (empty($_GET['search'])) {
    $statement = "SELECT * FROM tbl_size where daxoa<>1 limit $sodong offset $min ";
} else {
    $search = $_GET['search'];
    $statement = "SELECT * FROM tbl_size where daxoa<>1 and id_size regexp $search or size regexp $search limit $sodong offset $min ";
}
$result = $db->fetchAll($statement);
foreach ($result as $row) {
?>
    <tr class="dong">
    <td><?php echo $row['id_size']; ?></td>
        <td><?php echo $row['size']; ?></td>
        <td>
            <a href="index.php?page=size-edit&id=<?php echo $row['id_size']; ?>" class="btn btn-primary btn-xs">Edit</a>
            <a href="#" class="btn btn-danger btn-xs" data-href="../Model/size-delete-xl.php?id=<?php echo $row['id_size']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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