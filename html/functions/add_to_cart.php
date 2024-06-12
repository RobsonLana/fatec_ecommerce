<?php
include_once('./cart.php');
session_start();

$referer_url = "../page/index.php";

$product_id = filter_input(INPUT_POST, 'codigo_prod', FILTER_SANITIZE_STRING);
$name = filter_input(INPUT_POST, 'nome_pro', FILTER_SANITIZE_STRING);
$value = filter_input(INPUT_POST, 'valor_unitario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$quantity = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
$category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
$max_quantity = filter_input(INPUT_POST, 'max_quantity', FILTER_SANITIZE_NUMBER_INT);
$image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING);

if (!isset($_SESSION['cart']['items'][$product_id])) {
    $_SESSION['cart']['items'][$product_id] = [
        "name" => $name,
        "value" => $value,
        "quantity" => $quantity,
        "category" => $category,
        "max_available" => $max_quantity,
        "image" => $image
    ];
} else {
    $_SESSION['cart']['items'][$product_id]["quantity"] += $quantity;
}

update_cart();

header("location:" . $referer_url);
?>
