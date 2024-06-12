<?php
    session_start();
    include_once('../functions/functions.php');
    include_once('../functions/products.php');
    include_once('../functions/cart.php');

    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);

    $search_term = filter_input(INPUT_GET, 'search_term', FILTER_SANITIZE_STRING);

    $order_by = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
    $order_by = $order_by == "" ? "nome_pro" : $order_by;

    $asc = filter_input(INPUT_GET, 'asc', FILTER_VALIDATE_BOOLEAN);

    $price_from = filter_input(INPUT_GET, 'price_from', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $price_to = filter_input(INPUT_GET, 'price_to', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    $filter_categories = [];

    if (isset($_GET['categories']) && is_array($_GET['categories'])) {
        $filter_categories = array_map('array_filter_input', $_GET['categories']);
    }

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

    $connection = connect();

    $products = [];

    $referer_url = null;

    if ($search_term == "" && $price_from == null && $price_to == null && empty($filter_categories)) {
        $products = ordered_list($connection, $order_by, $asc);
    } else {
        $products = search_product($connection, $search_term, $order_by, $asc, $price_from, $price_to, $filter_categories);

        $referer_url = 'index.php';
    }

    $categories = category_count($connection);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $search_term ? $search_term : "Página inicial" ?> - E-Commerce</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?=header_bar('Página inicial', 'user', $referer_url)?>
        <div class="search_bar">
            <form method="GET" action="index.php">
                <input type="text" name="search_term" placeholder="Pesquisar produto" value="<?=$search_term?>">
                <button type="submit">🔎</button>
            </form>
        </div>
        <div class="main_content">
            <div class="products_filters">
                <form method="GET" action="index.php">
                    <input type="hidden" name="search_term" value="<?= $search_term?>">
                    <h4>Ordem dos produtos</h4>
                    <select name="order_by">
                        <option <?= $order_by == "nome_pro" ? "selected" : "" ?> value="nome_pro">Nome</option>
                        <option <?= $order_by == "valor_unitario" ? "selected" : "" ?> value="valor_unitario">Preço</option>
                        <option <?= $order_by == "nome" ? "selected" : "" ?> value="nome">Categoria</option>
                    </select>
                    <select name="asc">
                        <option <?= $asc ? "" : "selected" ?> value="false">Ascendente</option>
                        <option <?= $asc ? "selected" : "" ?> value="true">Descendente</option>
                    </select>
                    <h4>Limite de preço</h4>
                    <table>
                        <tr>
                            <td class="from_label">De</td>
                            <td class="to_label">Até</td>
                        </tr>
                        <tr>
                            <td><input type="number" name="price_from" value="<?= $price_from?>" placeholder="R$ 1,00" step="0.01"></td>
                            <td><input type="number" name="price_to" value="<?= $price_to?>" placeholder="R$ 500,00" step="0.01"></td>
                        </tr>
                    </table>
                    <h4>Categorias</h4>
                    <fieldset>
                        <?php
                            foreach($categories as $category) {
                        ?>
                            <label class="checkbox_container"><?= $category['category'] . ' (' . $category['count(*)'] . ')' ?>
                            <input type="checkbox" name="categories[]" value="<?= $category["id"]?>" <?= in_array($category["id"], $filter_categories) ? "checked" : "" ?>>
                                <span class="checkbox"></span>
                            </label>
                        <?php
                            }
                        ?>
                    </fieldset>
                    <button type="submit">Filtrar</button>
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
                        <a class="image_link" href="<?= $product_link?>">
                            <img src="../files/pictures/<?= $product['nome_arquivo']?>" alt="<?= $product['nome_pro']?>">
                        </a>
                        <div class="product_details">
                            <a class="image_link" href="<?= $product_link?>">
                                <p class="product_title"><?= $product['nome_pro']?></p>
                            </a>
                            <p class="product_price"><?= $display_price?></p>
                            <p><?= $product['nome']?></p>
                            <p class="product_description"><?= switch_newline($product['descricao'])?></p>
                        </div>
                        <div class="buttons">
                            <a class="details" style="float:left;" href="<?= $product_link?>">Detalhes</a>
                            <form method="POST" action="../functions/add_to_cart.php">
                                <input type="hidden" name="codigo_prod" value="<?=$product['codigo_prod']?>">
                                <input type="hidden" name="nome_pro" value="<?=$product['nome_pro']?>">
                                <input type="hidden" name="valor_unitario" value="<?=$product['valor_unitario']?>">
                                <input type="hidden" name="image" value="<?=$product['nome_arquivo']?>">
                                <input type="hidden" name="quantidade" value="1">
                                <input type="hidden" name="category" value="<?= $product['nome']?>">
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
        </div>
        <?php
            if ($_SESSION['cart']['count'] > 0) {
                echo cart_bar();
            }
        ?>
    </body>
</html>
