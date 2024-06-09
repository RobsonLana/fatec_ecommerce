<?php
$product_joint_base_query = "select"
        . " produto.codigo_prod, nome_pro, descricao, valor_unitario, quantidade, produto.id as categoria,"
        . " imagem.nome_arquivo, categoria.nome"
        . " from produto"
        . " left join imagem on imagem.codigo_prod = produto.codigo_prod"
        . " left join categoria on produto.id = categoria.id";

function ordered_list($connection, $order = "valor_unitario", $asc = true) {
    global $product_joint_base_query;

    $query = $product_joint_base_query . " where quantidade > 0" . " order by $order $asc";

    $asc = $asc ? 'asc' : 'desc';
    $statement = $connection->prepare($product_joint_base_query . " where quantidade > 0" . " order by $order $asc");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function category_count($connection) {
    $statement = $connection-> prepare(
        "select categoria.id as id, categoria.nome as category, count(*) from produto"
        . " left join categoria on produto.id = categoria.id"
        . " group by categoria.nome, categoria.id;"
    );

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
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

function search_product($connection, $term = "", $order = "valor_unitario", $asc = true, $price_from = null, $price_to = null, $categories = []) {
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

    $asc = $asc ? 'asc' : 'desc';
    $term = "%" . $term . "%";

    $statement = $connection->prepare(
        $product_joint_base_query
        . ' where (produto.nome_pro like :term'
        . ' or produto.descricao like :term'
        . ' or categoria.nome like :term)'
        . ' and (' . implode(' and ', $conditions) . ')'
        . ' order by ' . $order . ' ' . $asc
    );

    $statement->bindValue(":term", $term, PDO::PARAM_STR);
    $statement->bindValue(":price_from", $price_from, PDO::PARAM_STR);
    $statement->bindValue(":price_to", $price_to, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
