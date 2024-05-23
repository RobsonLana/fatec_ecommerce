<?php
include_once('../functions/functions.php');

function update_cart() {
    $item_count = 0;
    $subtotal = 0.0;

    foreach($_SESSION['cart']['items'] as $item) {
        $item_count += $item['quantity'];
        $subtotal += $item['value'] * $item['quantity'];
    }

    $_SESSION['cart']['count'] = $item_count;
    $_SESSION['cart']['subtotal'] = $subtotal;
}

function cart_bar() {
    $bar = '<footer>';
    $left_block = '<div class="left"><ul class="products_cart">';

    foreach($_SESSION['cart']['items'] as $product_id => $item) {
        $item_element = '<li class="product_block">'
            . '<a class="image_link" href="product_detail.php?product_id=' . $product_id . '">'
            . '<img src="../files/pictures/' . $item['image'] . '" alt="' . $item['name'] . '">'
            . '</a>'
            . '<form method="DELETE" action="delete_from_cart.php">'
            . '<button type="submit">❌</button>'
            . '</form>'
            . '<form method="PUT" action="uptade_cart_item.php">'
            . number_selector($item['max_available'], 'quantidade', $item['quantity'])
            . '</form>'
            . '</li>';

        $left_block = $left_block . $item_element;
    }

    $left_block = $left_block . '</ul></div>';

    $right_block = '<div class="right">'
        . '<p>Total: <b>' . number_to_brl($_SESSION['cart']['subtotal']) . '</b></p>'
        . '<p>Quantidade: <b>' . $_SESSION['cart']['count'] . '</b></p>'
        . '<div class="finish">'
        . '<a href="#">Finalizar pedido</a>'
        . '</div></div>';


    return $bar . $left_block . $right_block . '</footer>';
}
?>
