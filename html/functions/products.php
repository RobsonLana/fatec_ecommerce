<?php
$product_joint_base_query = "select"
        . " produto.codigo_prod, nome_pro, descricao, valor_unitario, quantidade, peso, dimensoes unidade_Venda, produto.id,"
        . " imagem.nome_arquivo, categoria.nome"
        . " from produto"
        . " left join imagem on imagem.codigo_prod = produto.codigo_prod"
        . " left join categoria on produto.id = categoria.id";

function ordered_list($connection, $order = "valor_unitario", $asc = true) {
    global $product_joint_base_query;

    $asc = $asc ? 'asc' : 'desc';
    $statement = $connection->prepare($product_joint_base_query . " where quantidade > 0" . " order by $order $asc");

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

function search_product($connection, $term, $order = "valor_unitario", $asc = true) {
    global $product_joint_base_query;

    $asc = $asc ? 'asc' : 'desc';

    $statement = $connection->prepare(
        $product_joint_base_query
        . ' where produto.nome_pro like "%' . $term . '%"'
        . ' or produto.descricao like "%' . $term . '%"'
        . ' or categoria.nome like "%' . $term . '%"'
    );

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
