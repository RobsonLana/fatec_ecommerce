<?php
    session_start();

    include_once('../functions/functions.php');
    include_once('../functions/orders.php');
    include_once('../functions/clients.php');
    include_once('../functions/freights.php');

    if (!isset($_SESSION['user'])) {
        header("location:./user_select.php");
    }

    $order_id = filter_input(INPUT_GET, 'order_id', FILTER_SANITIZE_STRING);

    $referer_url = "./index.php";

    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer_url = $_SERVER['HTTP_REFERER'];
    }

    $connection = connect();

    $order = get_order_by_id($connection, $order_id);

    $client = null;
    $items = null;
    $freight = null;

    $order_not_found = count($order) == 0;

    if (!$order_not_found) {
        $order = $order[0];
        $date = date_parse_from_format("Y-m-d", $order['data']);

        $client = get_client_address($connection, $_SESSION['user']);
        $client= $client[0];

        $items = list_order_items($connection, $order_id);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Nota fiscal do pedido - <?= $order_id?></title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="invoice.css">
    </head>
    <body>
    <?php
        if ($order_not_found) {
    ?>
        <p>Pedido não encontrado... Voltar para a <a href="<?= $referer_url?>">Página anterior</a></p>
    <?php
        } else {
    ?>
      <h1>E-Commerce - Nota fiscal eletrônica</h1>
      <h3>Emissor: 60993088000111</h3>
      <!--CNPJ fictício fíxo para finalidade de demonstração-->
      <h2>remetente</h2>
      <table>
          <tr>
              <td>
                  <p>Nome</p>
                  <p><?= $order['nome_trans']?></p>
              </td>
              <td>
                  <p>CPF/CNPJ</p>
                  <p><?= $order['cpf_cnpj_trans']?></p>
              </td>
              <td>
                  <p></p>
                  <p></p>
              </td>
          </tr>
          <tr>
              <td>
                  <p>Endereço</p>
                  <p><?= $order['endereco_trans'] . ' ' . $order['numero_trans']?></p>
              </td>
              <td>
                  <p>CEP</p>
                  <p><?= $order['cep_trans']?></p>
              </td>
              <td>
                  <p>Cidade</p>
                  <p><?= $order['cidade_trans'] . ' - ' . $order['estado_trans']?></p>
              </td>
          </tr>
      </table>
      <h2>Destinatário</h2>
      <table>
          <tr>
              <td>
                  <p>Nome</p>
                  <p><?= $client['nome_cli']?></p>
              </td>
              <td>
                  <p>CPF/CNPJ</p>
                  <p><?= $client['cpf_cnpj_cli']?></p>
              </td>
              <td>
                  <p>Data de emissão</p>
                  <p><?= $date['day'] . '/' . $date['month'] . '/' . $date['year']?></p>
              </td>
          </tr>
          <tr>
              <td>
                  <p>Endereço</p>
                  <p><?= $client['endereco_cli'] . ' ' . $client['numero_cli']?></p>
              </td>
              <td>
                  <p>CEP</p>
                  <p><?= $client['cep_cli']?></p>
              </td>
              <td>
                  <p>Cidade</p>
                  <p><?= $client['cidade_cli'] . ' - ' . $client['estado_cli']?></p>
              </td>
          </tr>
      </table>
      <h3>Produtos</h3>
      <table class="products">
          <tr>
              <th>Código</th>
              <th>Nome</th>
              <th>Qtd.</th>
              <th>Peso</th>
              <th>Dimensões</th>
              <th>Preço Un. (R$)</th>
              <th>Valor total (R$)</th>
          </tr>
          <?php
              foreach($items as $item) {
          ?>
          <tr>
              <td><?= $item['codigo_prod']?></td>
              <td><?= $item['nome_pro']?></td>
              <td><?= round($item['quantidade'])?></td>
              <td><?= $item['peso']?></td>
              <td><?= $item['dimensoes']?></td>
              <td><?= number_to_brl($item['valor_unitario'])?></td>
              <td><?= number_to_brl($item['valor'])?></td>
          </tr>
          <?php
              }
          ?>
      </table>
      <h3>Valores</h3>
      <table>
          <tr>
              <td>
                  <p>Subtotal</p>
                  <p><?= number_to_brl($order['sub_total'])?></p>
              </td>
              <td>
                  <p>Frete</p>
                  <p><?= number_to_brl($order['valor_transporte'])?></p>
              </td>
              <td>
                  <p>Total</p>
                  <p><?= number_to_brl($order['valor_total'])?></p>
              </td>
          </tr>
      </table>
      <footer>
        <p>Documento ilustrativo sem valor fiscal</p>
      </footer>
    <?php
        }
    ?>
    </body>
</html>

