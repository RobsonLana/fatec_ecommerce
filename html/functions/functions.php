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
    return "R$ " . preg_replace("/\./", ",", $number);
}

function number_selector($number, $name) {
    $selector = "<select name=\"" . $name . "\">";

    if ($number > 0) {
        foreach(range(0, $number) as $option) {
            $selector = $selector . "<option value=\"" . $option . "\">"
                . $option . "</option>";
        }
    }

    return $selector . "</select>";
}
?>
