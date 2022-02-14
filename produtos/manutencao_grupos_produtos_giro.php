<?php
    namespace SJD\produtos;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Editar Grupos Giro</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/1.0/estilos.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/sjd/javascript/modulos/ModuloPrincipal.js?2.00"></script>
</head>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
         <div class="row p-0 m-0">
             <div class="col p-0 m-0">
                <div id="barra_superior" class="barra_superior bg-dark text-white text-center text-uppercase fw-bolder position-relative">                              
                    <text class="position-absolute top-50 start-50 translate-middle">
                        Editar Grupos Giro
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_4117746109313718 _0_6076885641276292">
                                <div></div>
                                <div name="div_manutencao_grupos_produtos_giro" class="div_manutencao_grupos_produtos_giro container-fluid corpo-conteudo">
                                <div class="mt-2 card">
                                    <div class="card-header">Grupos de Produtos - Giro</div>
                                    <div class="card-body _0_7670471883940508 _0_6864049315451303">
                                        <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
         </div>
      </div>
   </main>
</body>
<script type="module">
    import { fnsisjd } from "/sjd/javascript/modulos/classes/sisjd/1.0.2/FuncoesSisJD.js";
    fnsisjd.carregar_dados_processo({codprocesso:10200,seletor_local_retorno:"div.card-body"});
</script>
</html>