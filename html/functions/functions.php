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

function header_bar($page_name, $back_page = null) {
    $referer = $back_page != null ? '<a href="' . $back_page . '">Voltar</a>' : '';

    $header = '<header>'
        . '<div class="left">'
        . $referer
        . '<h1><a class="page_title" href="index.php">E-Commerce</a></h1>'
        . '<p class="page_name">' . $page_name . '</p>'
        . '</div>'
        . '<div class="right"><div>'
        . '<p class="user_name"><b>' . $_SESSION['user_name'] . '</b></p>'
        . '<p class="user_cpf_cnpj"><b>' . $_SESSION['user'] . '</b></p>'
        . '</div>'
        . '<form method="GET" action="user_select.php">'
        . '<button>Deslogar</button>'
        . '</form></div>'
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
