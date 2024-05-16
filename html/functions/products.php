<?php
function ordered_list($connection, $order = "valor_unitario", $asc = true) {
    $asc = $asc ? 'asc' : 'desc';
    $statement = $connection->prepare("select"
        . " produto.codigo_prod, nome_pro, descricao, valor_unitario, quantidade, peso, dimensoes unidade_Venda, produto.id,"
        . " imagem.nome_arquivo, categoria.nome"
        . " from produto"
        . " left join imagem on imagem.codigo_prod = produto.codigo_prod"
        . " left join categoria on produto.id = categoria.id"
        . " order by :order :asc");

    $statement->bindParam(':order', $order);
    $statement->bindParam(':asc', $asc);

    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>
