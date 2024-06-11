<?php
    include_once('../functions/functions.php');
    include_once('../functions/clients.php');

    session_start();

    $connection = connect();

    $clients = list_clients($connection);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Selecionar usuário</title>
        <meta charset="UTF-8">
        <meta name="viewpoort" content="width=device-width, inital-scale=1.0">

        <meta name="keywords" content="ecommerce, e-commerce, project, fatec, php">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <div class="left">
                <h1>E-Commerce</h1>
                <p>Selecionar usuário</p>
            </div>
        </header>
        <div class="user_prompt">
            <h2>Escolher usuário</h3>
            <form method="POST" action="./index.php">
                <select name="user">
                    <?php
                        foreach($clients as $client) {
                            echo "<option value=\"" . $client['cpf_cnpj_cli'] . ":" . $client['nome_cli'] . "\">" . $client['nome_cli'] . "</option>";
                        }
                    ?>
                </select>
                <button>Entrar</button>
            </form>
        </div>
        <footer>
            <p style="text-align: center;">Imagens dos produtos coletadas de Amazon e Aliexpress. Projeto de finalidade acadêmica.</p>
        </footer>
    </body>
</html>
