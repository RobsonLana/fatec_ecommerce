<?php
$product_joint_base_query = "select"
        . " produto.codigo_prod, nome_pro, descricao, valor_unitario, quantidade, produto.id as categoria,"
        . " peso, dimensoes,"
        . " imagem.nome_arquivo, categoria.nome, categoria.id"
        . " from produto"
        . " left join imagem on imagem.codigo_prod = produto.codigo_prod"
        . " left join categoria on produto.id = categoria.id";

function ordered_list($connection, $order = "valor_unitario", $desc = true) {
    global $product_joint_base_query;

    $desc = $desc ? 'desc' : 'asc';

    $query = $product_joint_base_query . " where quantidade > 0" . " order by $order $desc";
    $statement = $connection->prepare($query);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function category_count($connection) {
    $statement = $connection->prepare(
        "select categoria.id as id, categoria.nome as category, count(*) from produto"
        . " left join categoria on produto.id = categoria.id"
        . " group by categoria.nome, categoria.id;"
    );

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_categories($connection) {
    $statement = $connection->prepare(
        "select id, nome from categoria;"
    );

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_KEY_PAIR);
}

function full_list($connection) {
    global $product_joint_base_query;

    $statement = $connection->prepare($product_joint_base_query);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_product_by_id($connection, $product_id) {
    global $product_joint_base_query;

    $statement = $connection->prepare($product_joint_base_query . " where produto.codigo_prod = :product_id");

    $statement->bindValue(":product_id", $product_id, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function search_product($connection, $term = "", $order = "valor_unitario", $desc = true, $price_from = null, $price_to = null, $categories = []) {
    global $product_joint_base_query;

    $conditions = ["quantidade > 0"];

    if($price_from != null) {
        array_push($conditions, "valor_unitario >= :price_from");
    }

    if($price_to != null) {
        array_push($conditions, "valor_unitario <= :price_to");
    }

    if(!empty($categories)) {
        array_push($conditions, "produto.id in (" . implode(', ', $categories) . ")");
    }

    $desc = $desc ? 'desc' : 'asc';
    $term = "%" . $term . "%";

    $statement = $connection->prepare(
        $product_joint_base_query
        . ' where (produto.nome_pro like :term'
        . ' or produto.descricao like :term'
        . ' or categoria.nome like :term)'
        . ' and (' . implode(' and ', $conditions) . ')'
        . ' order by ' . $order . ' ' . $desc
    );

    $statement->bindValue(":term", $term, PDO::PARAM_STR);
    $statement->bindValue(":price_from", $price_from, PDO::PARAM_STR);
    $statement->bindValue(":price_to", $price_to, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function add_image($connection, $product_id, $image) {
    $image_uniqid = uniqid();
    $ext = pathinfo($image['name'])['extension'];
    $temp_name = $image['tmp_name'];
    $final_name = $product_id . '_' . $image_uniqid . '.' . $ext;

    $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/files/pictures/$final_name";

    move_uploaded_file($temp_name, $target_dir);

    $statement = $connection->prepare(
        'insert into imagem (codigo_prod, nome_arquivo)'
        . ' values (:product_id, :final_name);'
    );

    $statement->bindValue(":product_id", $product_id, PDO::PARAM_STR);
    $statement->bindValue(":final_name", $final_name, PDO::PARAM_STR);

    $statement->execute();

    return $final_name;
}

function add_category($connection, $category) {
    $statement = $connection->prepare(
        'insert into categoria (nome)'
        . ' values (:category)'
    );

    $statement->bindValue(":category", $category, PDO::PARAM_STR);

    $statement->execute();

    $select_stmt = $connection->prepare('select id from categoria where nome = :category');
    $select_stmt->bindValue(":category", $category, PDO::PARAM_STR);
    $select_stmt->execute();
    $category_id = $select_stmt->fetchAll(PDO::FETCH_COLUMN);

    return $category_id[0];
}

function create_product($connection, $name, $description, $price, $quantity, $weight, $dimensions, $category) {
    $product_id = uniqid();

    $statement = $connection->prepare(
        'insert into produto (codigo_prod, nome_pro, descricao, valor_unitario, quantidade, peso, dimensoes, id)'
        . ' values (:product_id, :name, :description, :price, :quantity, :weight, :dimensions, :category);'
    );

    $statement->bindValue(":product_id", $product_id, PDO::PARAM_STR);
    $statement->bindValue(":name", $name, PDO::PARAM_STR);
    $statement->bindValue(":description", $description, PDO::PARAM_STR);
    $statement->bindValue(":price", $price, PDO::PARAM_STR);
    $statement->bindValue(":quantity", $quantity, PDO::PARAM_INT);
    $statement->bindValue(":weight", $weight, PDO::PARAM_STR);
    $statement->bindValue(":dimensions", $dimensions, PDO::PARAM_STR);
    $statement->bindValue(":category", $category, PDO::PARAM_STR);

    $statement->execute();

    return $product_id;
}

function update_product($connection, $product_id, $name, $description, $price, $quantity, $weight, $dimensions, $category) {

    $statement = $connection->prepare(
        'update produto'
        . ' set nome_pro = :name,'
        . ' descricao = :description,'
        . ' valor_unitario = :price,'
        . ' quantidade = :quantity,'
        . ' peso = :weight,'
        . ' dimensoes = :dimensions,'
        . ' id = :category'
        . ' where codigo_prod = :product_id;'
    );

    $statement->bindValue(":product_id", $product_id, PDO::PARAM_STR);
    $statement->bindValue(":name", $name, PDO::PARAM_STR);
    $statement->bindValue(":description", $description, PDO::PARAM_STR);
    $statement->bindValue(":price", $price, PDO::PARAM_STR);
    $statement->bindValue(":quantity", $quantity, PDO::PARAM_INT);
    $statement->bindValue(":weight", $weight, PDO::PARAM_STR);
    $statement->bindValue(":dimensions", $dimensions, PDO::PARAM_STR);
    $statement->bindValue(":category", $category, PDO::PARAM_STR);

    $statement->execute();

    return $product_id;
}
?>
