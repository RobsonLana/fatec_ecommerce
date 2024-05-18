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
    }

    include_once('../functions/functions.php');
    include_once('../functions/products.php');

    $connection = connect();

    $products = ordered_list($connection, 'nome_pro', true);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Página inicial</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <div class="left">
                <h1>E-Commerce</h1>
                <p>Página inicial</p>
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
        <div class="products_container">
            <?php
                if (count($products) > 0) {
                    echo "<ul class=\"product_list\">";

                    foreach($products as $product) {

                        echo "<li class=\"product_card\">";

                        echo "<img src=\"../files/pictures/" . $product['nome_arquivo'] . "\" alt=\"" . $product['nome_pro'] . "\">";
                        echo "<p class=\"product_title\">" . $product['nome_pro'] . "</p>";
                        echo "<p class=\"product_price\">" . number_to_brl($product['valor_unitario']) . "</p>";
                        echo "<p>" . $product['nome'] . "</p>";
                        echo "<p class=\"product_description\">" . $product['descricao'] . "</p>";

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
