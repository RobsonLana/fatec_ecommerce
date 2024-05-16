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
        <h1>E-Commerce</h1>
        <div class="products_container">
            <ul class="product_list">
            <?php
                foreach($products as $product) {

                    echo "<li class=\"product_card\">";

                    echo "<img src=\"../files/pictures/" . $product['nome_arquivo'] . "\" alt=\"" . $product['nome_pro'] . "\">";
                    echo "<p>" . $product['nome_pro'] . "<br>";
                    echo $product['valor_unitario'] . "<br>";
                    echo $product['nome'] . "</p>";

                    echo "</li>";
                }
            ?>
            </ul>
        </div>
    </body>
</html>
