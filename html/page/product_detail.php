<?php
    session_start();

    $product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_STRING);

    if (!isset($_SESSION['user'])) {
        header("location:./user_select.php");
    }

    include_once('../functions/functions.php');
    include_once('../functions/products.php');

    $referer_url = "./index.php";

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
    }

    $connection = connect();

    $product = get_product_by_id($connection, $product_id);

    $product_not_found = count($product) == 0;

    if (!$product_not_found) {
        $product = $product[0];
    }
?>
<!DOCTYPE html>
<html>
    <head>
    <title><?= $product_not_found ? "Produto não encontrado" : $product['nome_pro']?> - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <div class="left">
                <a href="<?= $referer_url ?>">Voltar</a>
                <h1>E-Commerce</h1>
                <p>Detalhes do produto</p>
            </div>
            <div class="right">
                <div>
                    <p class="user_name"><b><?=$_SESSION['user_name']?></b></p>
                    <p class="user_cpf_cnpj"><?=$_SESSION['user']?></p>
                </div>
                <form method="GET" action="./user_select.php">
                    <button>Deslogar</button>
                </form>
            </div>
        </header>
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

                    <?=number_selector($quantity, 'quantidade')?>

                    <div class="buttons">
                        <a>Adicionar ao carrinho</a>
                    </div>

                </div>
                <div class="product_details">
                    <h2><?=$product['nome_pro']?></h2>
                    <h3><?=$product['nome']?></h3>
                    <p class="product_price"><?=$display_price?></p>
                    <p class="product_description"><?=$product['descricao']?></p>
                </div>
            <?php
                }
            ?>
        </div>
    </body>
</html>
