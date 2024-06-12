<?
    session_start();

    include_once('../functions/functions.php');
    include_once('../functions/freights.php');
    include_once('../functions/orders.php');

    $connection = connect();

    $freight = filter_input(INPUT_POST, 'freight', FILTER_SANITIZE_STRING);

    $freight = get_freight($connection, $freight);
    $freight = $freight[0];

    $items = $_SESSION['cart']['items'];
    $quantity = $_SESSION['cart']['count'];
    $subtotal = $_SESSION['cart']['subtotal'];
    $total_value = $subtotal + $freight['valor_transporte'];

    $order_id = register_order($connection, $freight['valor_transporte'], $freight['cpf_cnpj_trans'], $_SESSION['user'], $subtotal, $total_value, $quantity);

    foreach($items as $product_id => $item) {
        register_item_order($connection, $order_id, $product_id, $item);
    }

    $_SESSION['cart'] = [
        "items" => [],
        "count" => 0,
        "subtotal" => 0.0
    ];

    header("location:../page/index.php");
?>
