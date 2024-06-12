<?php
    session_start();
    include_once('../functions/functions.php');
    include_once('../functions/cart.php');
    include_once('../functions/orders.php');

    if (!isset($_SESSION['user'])) {
        header("location:./user_select.php");
    }

    $referer_url = "./index.php";

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
    }

    $order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_STRING);

    $connection = connect();

    $order = get_order_by_id($connection, $order_id);
    $order = $order[0];
    $date = date_parse_from_format("Y-m-d", $order['data']);

    $items = list_order_items($connection, $order_id);

    $order_not_found = count($order) == 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Detalhes do pedido - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar('Detalhes do pedido', 'user', $referer_url)?>
        <?php
            if (!$order_not_found) {
        ?>
        <div class="vertical_content">
            <div class="products_container">
                <ul class="product_list">
        <?php

                foreach($items as $item) {
                    $item_link = "./product_detail.php?product_id=" . $item['codigo_prod'];
                    $display_price = number_to_brl($item['valor_unitario']);
                    $total_price = number_to_brl($item['valor']);
        ?>
                    <li class="product_card">
                        <div class="image_box">
                            <a class="image_link" href="<?= $item_link?>">
                                <img src="../files/pictures/<?= $item['nome_arquivo']?>" alt="<?= $item['nome_pro']?>">
                            </a>
                        </div>
                        <div class="product_details">
                            <a class="image_link" href="<?= $item_link?>">
                                <p class="product_title"><?= $item['nome_pro']?></p>
                            </a>
                            <p class="product_price"><?= $total_price?></p>
                            <p class="product_price">Unitário: <?= $display_price?></p>
                            <p>Quantidade: <?= round($item['quantidade'])?></p>
                            <p><?= $item['nome']?></p>
                        </div>
                        <div class="buttons">
                            <form method="GET" action="<?= $item_link?>">
                                <input type="hidden" name="product_id" value="<?=$item['codigo_prod']?>">
                                <button>Detalhes</a>
                            </form>
                        </div>
                    </li>

        <?php
                }

        ?>
                </ul>
            </div>
            <div class="options_container">

                <div class="options">
                    <h3>Resumo do pedido</h3>
                    <h4>Número: <?= $order_id?></h4>
                    <p>Data: <?= $date['day'] . '/' . $date['month'] . '/' . $date['year']?></p>
                    <table>
                        <tr class="subtotal">
                            <td><strong>Total:</strong></td>
                            <td class="align_right"><strong><?= number_to_brl($order['valor_total'])?></strong></td>
                        </tr>
                        <tr>
                            <td>Subtotal:</td>
                            <td class="align_right"><?= number_to_brl($order['sub_total'])?></td>
                        </tr>
                        <tr>
                            <td>Frete:</td>
                            <td class="align_right"><?= number_to_brl($order['valor_transporte'])?></td>
                        </tr>
                        <tr>
                            <td>Qtd. itens:</td>
                            <td class="align_right"><?= round($order['total_itens'])?></td>
                        </tr>
                    </table>
                    <form method="GET" action="./invoice.php">
                        <input type="hidden" name="order_id" value="<?= $order_id?>">
                        <button class="cart" type="submit">Visualizar nota fiscal</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            } else {
        ?>
        <div class="error">
            <p>404: Pedido especificado não foi encontrado</p>
        </div>
        <?php
            }
            if ($_SESSION['cart']['count'] > 0) {
                echo cart_bar();
            }
        ?>
    </body>
</html>
