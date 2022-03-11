<?php
    namespace SJD\clientes;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/header.php';
    echo '
    <body>
        <main style="display: block;">
            <div class="container-fluid p-0 m-0">';
                include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/topbar.php';
                echo '
                <div class="row">
                    <div class="col">
                        <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                            <div name="div_grid_linha_corpo_pagina" class="row">
                                <div name="div_grid_col_corpo_pagina" class="col">
                                    <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid">
                ';   
?>                                    