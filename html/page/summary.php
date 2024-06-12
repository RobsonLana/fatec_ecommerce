<?php
    session_start();
    include_once('../functions/functions.php');
    include_once('../functions/cart.php');
    include_once('../functions/clients.php');
    include_once('../functions/freights.php');

    if (!isset($_SESSION['user'])) {
        header("location:./user_select.php");
    }

    $referer_url = "./index.php";

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
    }

    $connection = connect();

    $user_address = get_client_address($connection, $_SESSION['user']);
    $user_address = $user_address[0];

    $freights = list_freights($connection);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>(<?= $_SESSION['cart']['count'] ?>) Finalizar pedido - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar('Sumário do carrinho', 'user', $referer_url)?>
        <?php
            if ($_SESSION['cart']['count'] > 0) {
        ?>
        <div class="vertical_content">
            <div class="products_container">
                <ul class="product_list">
        <?php

                foreach($_SESSION['cart']['items'] as $product_id => $item) {
                    $product_link = "./product_detail.php?product_id=" . $product_id;
                    $display_price = number_to_brl($item['value']);
        ?>
                    <li class="product_card">
                        <div class="image_box">
                            <a class="image_link" href="<?= $product_link?>">
                                <img src="../files/pictures/<?= $item['image']?>" alt="<?= $item['name']?>">
                            </a>
                        </div>
                        <div class="product_details">
                            <a class="image_link" href="<?= $product_link?>">
                                <p class="product_title"><?= $item['name']?></p>
                            </a>
                            <p class="product_price"><?= $display_price?></p>
                            <p><?= $item['category']?></p>
                        </div>
                        <div class="buttons">
                            <form method="POST" action="../functions/update_cart_item.php">
                                <input type="hidden" name="codigo_prod" value="<?=$product_id?>">
                                <?= number_selector($item['max_available'], 'quantidade', $item['quantity'], $onchange = true)?>
                            </form>
                            <form method="POST" action="../functions/delete_from_cart.php">
                                <input type="hidden" name="codigo_prod" value="<?=$product_id?>">
                                <button type="submit">Remover</button>
                            </form>
                            <form method="GET" action="<?= $product_link?>">
                                <input type="hidden" name="product_id" value="<?=$product_id?>">
                                <button class="cart">Detalhes</a>
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
                    <table>
                        <tr class="subtotal">
                            <td><strong>Subtotal:</strong></td>
                            <td class="align_right"><strong><?= number_to_brl($_SESSION['cart']['subtotal'])?></strong></td>
                        </tr>
                        <tr>
                            <td>Qtd. itens:</td>
                            <td class="align_right"><?= $_SESSION['cart']['count']?></td>
                        </tr>
                    </table>
                    <h4>Endereço de entrega</h4>
                    <p><?= $user_address['endereco_cli']?> <?= $user_address['numero_cli']?> - <?= $user_address['bairro_cli']?></p>
                    <p><?= $user_address['cidade_cli']?>, <?= $user_address['estado_cli']?> <?= $user_address['cep_cli']?></p>
                    <h4>Frete</h4>
                    <form method="POST" action="../functions/close_order.php">
                        <select name="freight">
                            <?php
                                foreach($freights as $freight) {
                            ?>
                                <option value="<?= $freight['cpf_cnpj_trans']?>"><?= $freight['nome_trans'] . ' - ' . number_to_brl($freight['valor_transporte'])?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <button class="cart" type="submit">Finalizar Pedido</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
            } else {
        ?>
        <div class="error">
            <p>O carrinho está vazio. Adicione produtos para ver o resumo da compra.</p>
        </div>
        <?php
            }
        ?>
    </body>
</html>
