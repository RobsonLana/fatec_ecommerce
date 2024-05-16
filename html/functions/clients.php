<?php
session_start();

function get_client_on_session($connection) {
    if (!isset($_SESSION["client"])) {
        $statement = $connection->prepare("select cpf_cnpj_cli from cliente");

        $statement->execute();

        $clients = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
