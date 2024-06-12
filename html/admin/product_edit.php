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

    $product_name = "Adicionar novo produto";

    $product_not_found = count($product) == 0;

    if (!$product_not_found) {
        $product = $product[0];
        $product_name = $product['nome_pro'];
    } else {
        $product = array(
            'codigo_prod' => '',
            'nome_pro' => '',
            'nome_arquivo' => '../assets/cube-alt-2-svgrepo-com.svg',
            'descricao' => '',
            'valor_unitario' => 0.0,
            'quantidade' => 0,
            'peso' => '',
            'dimensoes' => '',
            'id' => '',
            'nome' => ''
        );
    }

    $categories = get_categories($connection);
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
        <div class="product_container">
            <div class="image_box">
                <img src="../files/pictures/<?=$product['nome_arquivo']?>" alt="<?=$product['nome_pro']?>">
            </div>

            <div class="product_details">
                <form method="POST" action="../functions/update_product.php" enctype="multipart/form-data">
                    <input type="hidden" name="codigo_prod" value="<?= $product['codigo_prod']?>">
                    <table>
                        <tr>
                            <td>
                                <label>Adicionar imagens:</label>
                            </td>
                            <td>
                                <div class="input_file_box">
                                    <label class="input_file">
                                        <input type="file" name="images[]" accept="image/*">
                                        Escolher imagens
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="nome_pro">Nome do produto:</label>
                            </td>
                            <td>
                                <input class="product_name" type="text" name="nome_pro" placeholder="Meu produto" value="<?= $product["nome_pro"]?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="category">Categoria:</label>
                            </td>
                            <td>
                                <input type="text" name="category" list="categories" placeholder="Presente / Ferramenta" value="<?= $product['nome']?>">
                                    <datalist id="categories">
                                        <?php
                                            foreach($categories as $category_id => $category) {
                                                echo '<option value="' . $category . '">' . $category_id . '</option>';
                                            }
                                        ?>
                                    </datalist>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="valor_unitario">Valor (R$):</label>
                            </td>
                            <td>
                                <input type="number" name="valor_unitario" step="0.01" value="<?= $product["valor_unitario"]?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="descricao">Descrição:</label>
                            </td>
                            <td>
                                <textarea rows="15" name="descricao" placeholder="Descrição do Produto"><?= $product["descricao"]?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="quantidade">Estoque:</label>
                            </td>
                            <td>
                                <input type="number" name="quantidade" value="<?= round($product["quantidade"])?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="peso">Peso:</label>
                            </td>
                            <td>
                                <input type="text" name="peso" placeholder="500g / 1.5Kg" value="<?= $product["peso"]?>">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dimensoes">Dimensões:</label>
                            </td>
                            <td>
                                <input type="text" name="dimensoes" placeholder="10x15.8x100mm" value="<?= $product["dimensoes"]?>">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="operation_card">
                    <?php
                        if (isset($product["codigo_prod"])) {
                            echo '<p>ID do produto: ' . $product["codigo_prod"] . '</p>';
                        }
                    ?>
                    <div class="buttons">
                        <a href="./product_detail.php?product_id=<?= $product_id?>">Descartar</a>
                        <button class="cart" type="submit">Salvar deatlhes</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
