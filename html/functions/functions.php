<?php
function connect() {
    $host = 'localhost';

    if (isset($_ENV["MYSQL_HOST"])) {
      $host = $_ENV["MYSQL_HOST"];
    }

    $user = "root";
    $pass = "labdb";
    $dsn = "mysql:host=$host:3306;dbname=loja";

    $connection = new PDO($dsn, $user, $pass);

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    return $connection;
}

function number_to_brl($number) {
    return "R$ " . preg_replace("/\./", ",", sprintf("%.2f", $number));
}

function header_user_block($user_name, $user) {

        return '<div>'
        . '<p class="user_name"><b>' . $user_name . '</b></p>'
        . '<p class="user_cpf_cnpj"><b>' . $user . '</b></p>'
        . '</div>'
        . '<form method="GET" action="orders.php">'
        . '<button>Pedidos</button>'
        . '</form>'
        . '<form method="GET" action="user_select.php">'
        . '<button>Deslogar</button>'
        . '</form>';
}

function header_admin_block() {
    return '<form method="GET" action="../page/index.php">'
        . '<button>Sair para página do usuário</button>'
        . '</form>';
}


function header_bar($page_name, $mode, $back_page = null) {
    $referer = $back_page != null ? '<a href="' . $back_page . '">Voltar</a>' : '';

    $right_block = $mode == 'admin' ? header_admin_block() : header_user_block($_SESSION['user_name'], $_SESSION['user']);

    $header = '<header>'
        . '<div class="left">'
        . $referer
        . '<h1><a class="page_title" href="index.php">E-Commerce</a></h1>'
        . '<p class="page_name">' . $page_name . '</p>'
        . '</div>'
        . '<div class="right">'
        . $right_block
        . '</div></header>';

    return $header;
}

function number_selector($number, $name, $preselect = null, $onchange = false) {
    $onchange = $onchange ? 'onchange="this.form.submit()"' : '';
    $selector = '<select ' . $onchange . ' name="' . $name . '">';

    if ($number > 0) {
        foreach(range(1, $number) as $option) {
            $selected = $option == $preselect ? 'selected' : '';
            $selector = $selector . '<option ' . $selected  . ' value="' . $option . '">'
                . $option . '</option>';
        }
    } else {
        $selector = $selector . '<option selected value="0">0</option>';
    }

    return $selector . '</select>';
}

function switch_newline($text) {
    return preg_replace("/\\n/", "<br>", $text);
}

function array_filter_input($input) {
    return filter_var(trim($input), FILTER_SANITIZE_STRING);
}
?>
