<?
    include_once('../functions/functions.php');
    include_once('../functions/products.php');

    $connection = connect();

    $product_id = filter_input(INPUT_POST, 'codigo_prod', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'nome_pro', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'valor_unitario', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $description = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
    $quantity = filter_input(INPUT_POST, 'quantidade', FILTER_SANITIZE_NUMBER_INT);
    $weight = filter_input(INPUT_POST, 'peso', FILTER_SANITIZE_STRING);
    $dimensions = filter_input(INPUT_POST, 'dimensoes', FILTER_SANITIZE_STRING);

    $categories = get_categories($connection);
    $category_id = array_search($category, $categories);

    if ($category_id === false) {
        $category_id = add_category($connection, $category);
    }

    if ($product_id == null || $product_id == "") {
        $product_id = create_product($connection, $name, $description, $price, $quantity, $weight, $dimensions, $category_id);
    } else {
        update_product($connection, $product_id, $name, $description, $price, $quantity, $weight, $dimensions, $category_id);
    };

    if ($_FILES['images']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        $images = $_FILES['images'];
        $image_count = count($images['name']);

        for ($i = 0; $i < $image_count; $i++) {
            $image = array(
                'name' => $images['name'][$i],
                'tmp_name' => $images['tmp_name'][$i],
            );

            add_image($connection, $product_id, $image);
        }
    }

    header("location:../admin/product_detail.php?product_id=" . $product_id);
?>
