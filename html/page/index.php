<?php
    session_start();

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);

    if ($user == "") {
        if (!isset($_SESSION['user'])) {
            header("location:./user_select.php");
        }
    } else {
        list($user_cpf_cnpj, $user_name) = explode(":", $user);

        $_SESSION['user'] = $user_cpf_cnpj;
        $_SESSION['user_name'] = $user_name;

        $_SESSION['cart'] = [
            "items" => [],
            "count" => 0,
            "subtotal" => 0.0
        ];
    }

    include_once('../functions/functions.php');
    include_once('../functions/products.php');
    include_once('../functions/cart.php');

    $connection = connect();

    $products = ordered_list($connection, 'nome_pro', true);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Página inicial - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar('Página inicial')?>
        <div class="search_bar">
            <form method="GET" action="../functions/search_products">
                <input type="text" placeholder="Pesquisar produto">
                <button type="submit">🔎</button>
            </form>
        </div>
        <div class="products_container">
            <?php
                if (count($products) > 0) {
                    echo "<ul class=\"product_list\">";

                    foreach($products as $product) {
                        $product_link = "./product_detail.php?product_id=" . $product['codigo_prod'];
                        $display_price = number_to_brl($product['valor_unitario']);
            ?>

            <li class="product_card">
                <img src="../files/pictures/<?= $product['nome_arquivo']?>" alt="<?= $product['nome_pro']?>">
                <div class="product_details">
                    <p class="product_title"><?= $product['nome_pro']?></p>
                    <p class="product_price"><?= $display_price?></p>
                    <p><?= $product['nome']?></p>
                    <p class="product_description"><?= switch_newline($product['descricao'])?></p>
                </div>
                <div class="buttons">
                    <a class="details" style="float:left;" href="<?= $product_link?>">Detalhes</a>
                    <form method="POST" action="../functions/add_to_cart.php">
                        <input type="hidden" name="codigo_prod" value="<?=$product['codigo_prod']?>">
                        <input type="hidden" name="valor_unitario" value="<?=$product['valor_unitario']?>">
                        <input type="hidden" name="image" value="<?=$product['nome_arquivo']?>">
                        <input type="hidden" name="quantidade" value="1">
                        <input type="hidden" name="max_quantity" value="<?=round($product['quantidade'])?>">
                        <button class="cart" style="float:right;" type="submit">🛒</button>
                    </form>

                </div>
            </li>

            <?php
                    }

                    echo "</ul>";
                } else {
            ?>
            <div class="error">
                <p>Estamos sem produtos que atendam a essa pesquisa...</p>
            </div>
            <?php
                }
            ?>
            </ul>
        </div>
        <?php
            if ($_SESSION['cart']['count'] > 0) {
                echo cart_bar();
            }
        ?>
    </body>
</html>
