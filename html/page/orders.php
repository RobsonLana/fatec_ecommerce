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

    $connection = connect();

    $orders = list_client_orders($connection, $_SESSION['user']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meus pedidos - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar('Meus pedidos', 'user', $referer_url)?>
        <?php
            if (count($orders) > 0) {
        ?>
        <div class="vertical_content">
            <div class="products_container">
                <ul class="product_list">
        <?php

                foreach($orders as $order) {
                    $order_link = "./order_details.php?order_id=" . $order['numero_compra'];
                    $date = date_parse_from_format("Y-m-d", $order['data']);

                    $subtotal = number_to_brl($order['sub_total']);
                    $freight = number_to_brl($order['valor_transporte']);
                    $total_value = number_to_brl($order['valor_total']);
        ?>
                    <li class="product_card">
                        <div class="image_box">
                            <a class="image_link" href="<?= $order_link?>">
                                <img src="../files/assets/paper-svgrepo-com.svg" alt="Paper icon">
                            </a>
                        </div>
                        <div class="product_details">
                            <a class="image_link" href="<?= $order_link?>">
                                <p class="product_title"><?= $order['numero_compra']?></p>
                            </a>
                            <p><strong><?= $date['day'] . '/' . $date['month'] . '/' . $date['year']?></strong></p>
                            <table>
                                <tr>
                                    <td>Subtotal:</td>
                                    <td class="align_right"><?= $subtotal?></td>
                                </tr>
                                <tr>
                                    <td>Frete:</td>
                                    <td class="align_right"><?= $freight?></td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td class="align_right"><?= $total_value?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="buttons">
                            <form method="GET" action="./order_details.php">
                                <input type="hidden" name="order_id" value="<?=$order['numero_compra']?>">
                                <button>Detalhes</a>
                            </form>
                            <form method="GET" action="./invoice.php">
                                <input type="hidden" name="order_id" value="<?= $order['numero_compra']?>">
                                <button class="cart" type="submit">Nota fiscal</button>
                            </form>
                        </div>
                    </li>

        <?php
                }

        ?>
                </ul>
            </div>
        </div>
        <?php
            } else {
        ?>
        <div class="error">
            <p>Não há pedidos registrados.</p>
        </div>
        <?php
            }
            if ($_SESSION['cart']['count'] > 0) {
                echo cart_bar();
            }
        ?>
    </body>
</html>
