<?php
    session_start();

    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_STRING);

    if (!isset($_SESSION['user'])) {
        header("location:./user_select.php");
    }

    include_once('../functions/functions.php');
    include_once('../functions/products.php');
    include_once('../functions/cart.php');

    $referer_url = "./index.php";

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
    }

    $connection = connect();

    $product = get_product_by_id($connection, $product_id);

    $product_name = "Produto não encontrado";

    $product_not_found = count($product) == 0;

    if (!$product_not_found) {
        $product = $product[0];
        $product_name = $product['nome_pro'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <title><?=$product_name?> - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar($product_name, $referer_url)?>
        <div class="product_container">
            <?php
                if($product_not_found) {
            ?>
            <div class="error">
                <p>404: O produto em questão não foi encontrado...</p>
            </div>
            <?php
                } else {
                    $quantity = round($product['quantidade']);
                    $display_price = number_to_brl($product['valor_unitario']);

            ?>
                <img src="../files/pictures/<?=$product['nome_arquivo']?>" alt="<?=$product['nome_pro']?>">

                <div class="operation_card">
                    <p class="product_price"><?=$display_price?></p>
                    <p><?=$quantity?> em estoque</p>

                    <form method="POST" action="../functions/add_to_cart.php">
                        <input type="hidden" name="codigo_prod" value="<?=$product['codigo_prod']?>">
                        <input type="hidden" name="valor_unitario" value="<?=$product['valor_unitario']?>">
                        <input type="hidden" name="image" value="<?=$product['nome_arquivo']?>">
                        <input type="hidden" name="max_quantity" value="<?=$quantity?>">
                        <?=number_selector($quantity, 'quantidade')?>
                        <button class="cart" type="submit">Adicionar ao carrinho</button>
                    </form>

                </div>
                <div class="product_details">
                    <h2><?=$product['nome_pro']?></h2>
                    <h3><?=$product['nome']?></h3>
                    <p class="product_price"><?=$display_price?></p>
                    <p class="product_description"><?=switch_newline($product['descricao'])?></p>
                </div>
            <?php
                }
            ?>
        </div>
        <?php
            if ($_SESSION['cart']['count'] > 0) {
                echo cart_bar();
            }
        ?>
    </body>
</html>
