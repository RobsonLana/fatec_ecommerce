<!DOCTYPE html>
<?php
    include_once('../functions/functions.php');
    include_once('../functions/products.php');

    $connection = connect();

    $products = ordered_list($connection);
?>
<html>
    <head>
        <title>Página inicial</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h1>E-Commerce</h1>
            <p>Usuário</p>
        </div>
        <div class="products_container">
            <?php
                if (count($products) > 0) {
                    echo "<ul class=\"product_list\">";

                    foreach($products as $product) {

                        echo "<li class=\"product_card\">";

                        echo "<img src=\"../files/pictures/" . $product['nome_arquivo'] . "\" alt=\"" . $product['nome_pro'] . "\">";
                        echo "<p class=\"product_title\">" . $product['nome_pro'] . "</p>";
                        echo "<p>" . number_to_brl($product['valor_unitario']) . "</p>";
                        echo "<p>" . $product['nome'] . "</p>";

                        echo "</li>";
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
    </body>
</html>
