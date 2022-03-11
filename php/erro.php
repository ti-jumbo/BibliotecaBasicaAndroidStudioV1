<?php

    /*Pagina para mostrar erro conforme post recebido ou mensagem.
    Utilizado para quando cliente tenta acessar pastas e/ou arquivos que não devem ser acessados diretamente
    */

    $erro = $_POST || $_GET;
    switch($erro) {
        case '1':case 1:
            $erro = 'Local inacessivel!';
            break;
        default:
            
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Erro</title>
</head>
<body>
    <h3>Erro<h3>
    <p>
        <?php echo $erro; ?>
    <p>
    <h5>Jumbo Alimentos Ltda - 2022<h5>
</body>
</html>