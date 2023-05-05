<?php
session_start();

if (isset($_POST['quantity_temp'])) {
    $quantity_temp = intval($_POST['quantity_temp']);
    $_SESSION['cart'][$_POST['product_id']]['quantity_temp'] = $quantity_temp;
    echo $quantity_temp;
}
