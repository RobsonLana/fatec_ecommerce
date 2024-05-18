<?php
function list_clients($connection) {
    $statement = $connection->prepare("select cpf_cnpj_cli, nome_cli from cliente order by nome_cli asc");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
