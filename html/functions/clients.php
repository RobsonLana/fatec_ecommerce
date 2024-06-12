<?php
function list_clients($connection) {
    $statement = $connection->prepare("select cpf_cnpj_cli, nome_cli from cliente order by nome_cli asc");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_client_address($connection, $client) {
    $statement = $connection->prepare(
        "select * from cliente"
        . " where cpf_cnpj_cli = :client"
    );

    $statement->bindValue(':client', $client, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
