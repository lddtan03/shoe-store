<?php
include("../Control/inc/config.php");
$sodong = 3;
if (!isset($_POST['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_size");
} else {
    $search = $_POST['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_size where id_size regexp $search or size regexp $search");
}
$statement->execute();
$sotrang  = $statement->rowCount();
if (isset($_POST['p'])) {
    $p = $_POST['p'];
} else $p = 1;
$sotrang = round($sotrang / $sodong + 0.4);

$min = $sodong * ($p - 1);
?>
<?php
if (!isset($_POST['search'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_size limit $sodong offset $min");
} else {
    $search = $_POST['search'];
    $statement = $pdo->prepare("SELECT * FROM tbl_size where id_size regexp $search or size regexp $search limit $sodong offset $min");
}
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
?>
    <tr class="dong">
        <td><?php echo $row['id_size']; ?></td>
        <td><?php echo $row['size']; ?></td>
        <td>
            <a href="Trangdieukhien.php?page=size-edit&id=<?php echo $row['id_size']; ?>" class="btn btn-primary btn-xs">Edit</a>
            <a href="#" class="btn btn-danger btn-xs" data-href="../Model/size-delete.php?id=<?php echo $row['id_size']; ?>" data-toggle="modal" data-tarPOST="#confirm-delete">Delete</a>
        </td>
    </tr>

<?php
    // break;
}
echo "???";

for ($i = 1; $i <= $sotrang; $i++) {
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" href="
    <?php echo "Trangdieukhien.php?page=size&p=$i"; ?>"><?php echo $i; ?></php></a></li>
<?php

}

?>