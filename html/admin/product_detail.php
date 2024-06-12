<?php
    session_start();

    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_STRING);

    include_once('../functions/functions.php');
    include_once('../functions/products.php');

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

        <link rel="stylesheet" href="../page/style.css">
    </head>
    <body>
        <?=header_bar($product_name, 'admin', $referer_url)?>
        <?php
            if($product_not_found) {
        ?>
        <div class="error">
            <p>404: O produto de ID "<?= $product_id?>" não foi encontrado...</p>
        </div>
        <?php
            } else {
                $quantity = round($product['quantidade']);
                $display_price = number_to_brl($product['valor_unitario']);

        ?>
            <div class="product_container">
                <div class="image_box">
                    <img src="../files/pictures/<?=$product['nome_arquivo']?>" alt="<?=$product['nome_pro']?>">
                </div>

                <div class="operation_card">
                    <p class="product_price"><?=$display_price?></p>
                    <p><?=$quantity?> em estoque</p>
                    <p>ID do produto: <?= $product["codigo_prod"]?></p>

                    <div class="buttons">
                        <a href="./product_edit.php?product_id=<?= $product_id?>">Editar produto</a>
                    </div>

                </div>
                <div class="product_details">
                    <h2><?=$product['nome_pro']?></h2>
                    <h3><?=$product['nome']?></h3>
                    <p class="product_price"><?=$display_price?></p>
                    <p class="product_description"><?=switch_newline($product['descricao'])?></p>
                    <p class="product_weight"><strong>Peso:</strong> <?=$product['peso'] != null ? $product['peso'] : "Não informado"?></p>
                    <p class="product_dimensions"><strong>Dimensões:</strong> <?=$product['dimensoes'] != null ? $product['dimensoes'] : "Não informadas"?></p>
                </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>
