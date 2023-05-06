<?php
function phantrang($pdo,$ten_table,$p)
{
    $soitem = 10;
    $statement = $pdo->prepare("SELECT * FROM $ten_table ");
    $statement->execute();
    $sopage = $statement->rowCount() / $soitem;
    if ($sopage % 1 == 0) $sopage++; 
    $min = ($p - 1) * 10;
    return $sopage;
}
?>
