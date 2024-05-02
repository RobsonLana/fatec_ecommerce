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
?>
