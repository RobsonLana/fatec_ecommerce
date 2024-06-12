<?php
function list_freights($connection) {
    $statement = $connection->prepare("select * from transportadora order by nome_trans asc");

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_freight($connection, $freight) {
    $statement = $connection->prepare("select * from transportadora where cpf_cnpj_trans = :freight");

    $statement->bindValue(':freight', $freight, PDO::PARAM_STR);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
