<?php
include_once('./cart.php');
session_start();

$referer_url = "../page/index.php";

if (isset($_SERVER['HTTP_REFERER'])) {
    $referer_url = $_SERVER['HTTP_REFERER'];
}

$product_id = filter_input(INPUT_POST, 'codigo_prod', FILTER_SANITIZE_STRING);

unset($_SESSION['cart']['items'][$product_id]);

update_cart();

header("location:" . $referer_url);
?>
