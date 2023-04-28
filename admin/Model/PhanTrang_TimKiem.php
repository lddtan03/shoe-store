<?php
include("../Database/Helper.php");
function laySoTrang($search,$table){
    $sodong = 7;
    if (empty($search)) {
        $statement = "SELECT * FROM ?";
    } else {
        $statement = "SELECT * FROM ? where id_size regexp $search or size regexp $search";
    }
    $db = new Helper();
    $sokq = $db->rowCount($statement);
    $sotrang = round($sokq/ $sodong + 0.4);
    return $sotrang;
}
// include("../Control/inc/config.php");

if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else $p = 1;

$min = $sodong * ($p - 1);
?>

<?php
if (empty($_GET['search'])) {
    $statement = "SELECT * FROM tbl_size limit $sodong offset $min";
} else {
    $search = $_GET['search'];
    $statement = "SELECT * FROM tbl_size where id_size regexp $search or size regexp $search limit $sodong offset $min";
}
$result = $db->fetchAll($statement);
?>