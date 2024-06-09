<?php
include_once('./cart.php');
session_start();

$referer_url = "../page/index.php";

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer_url = $_SERVER['HTTP_REFERER'];
}

$product_id = filter_input(INPUT_POST, 'codigo_prod', FILTER_SANITIZE_STRING);
$quantity = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);

if (isset($_SESSION['cart']['items'][$product_id])) {
    $_SESSION['cart']['items'][$product_id]['quantity'] = $quantity;
}

update_cart();

header("location:" . $referer_url);
?>
