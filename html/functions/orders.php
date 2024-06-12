<?php
function register_order($connection, $freight_value, $freight, $client, $subtotal, $total_value, $quantity) {
    $statement = $connection->prepare(
        "insert into compra (numero_compra, data, valor_transporte, cpf_cnpj_trans, cpf_cnpj_cli, sub_total, valor_total, total_itens)"
        . " values (:order_id, :date, :freight_value, :freight, :client, :subtotal, :total_value, :quantity);"
    );

    $order_id = uniqid();
    $date = date("Y-m-d");

    $statement->bindValue(':order_id', $order_id, PDO::PARAM_STR);
    $statement->bindValue(':date', $date, PDO::PARAM_STR);
    $statement->bindValue(':freight_value', $freight_value, PDO::PARAM_STR);
    $statement->bindValue(':freight', $freight, PDO::PARAM_STR);
    $statement->bindValue(':client', $client, PDO::PARAM_STR);
    $statement->bindValue(':subtotal', $subtotal, PDO::PARAM_STR);
    $statement->bindValue(':total_value', $total_value, PDO::PARAM_STR);
    $statement->bindValue(':quantity', $quantity, PDO::PARAM_INT);

    $statement->execute();

    return $order_id;
}

function register_item_order($connection, $order_id, $product_id, $item) {
    $statement = $connection->prepare(
        "insert into itemcompra (numero_compra, codigo_prod, valor, quantidade)"
        . " values (:order_id, :product_id, :value, :quantity);"
    );

    $statement->bindValue(':order_id', $order_id, PDO::PARAM_STR);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_STR);
    $statement->bindValue(':value', $item['value'], PDO::PARAM_STR);
    $statement->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);

    $statement->execute();

    return $order_id;
}

function list_client_orders($connection, $client) {
    $statement = $connection->prepare("select * from compra where cpf_cnpj_cli = :client");

    $statement->bindValue(':client', $client, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function list_order_items($connection, $order_id) {
    $statement = $connection->prepare(
        "select codigo_prod, valor, quantidade"
        . " from itemcompra where numero_compra = :order_id");

    $statement->bindValue(':order_id', $order_id, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
