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
    <title>SisJD - Editar Grupos Produtos Equivalentes</title>
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
                        Editar Grupos Produtos Equivalentes
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_3929327658544043 _0_12453479092884734">
                                <div></div>
                                <div name="div_manutencao_grupos_produtos_equivalentes" class="div_manutencao_grupos_produtos_equivalentes container-fluid corpo-conteudo" style="height:100%;" ajuda_elemento="Altere os grupos de produtos equivalentes e seus dados!">
                                <div class="row">
                                    <div class="col-4 m-1 resize div_manutencao_grupos_prodequiv_arvore_opcoes col _0_7942653445300174 _0_9237892320567965">
                                        <div class="card">
                                            <div class="card-header">Grupos de Produtos</div>
                                            <div class="card-body">
                                            <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 m-1 resize div_dados_gruposprodequiv_consultar col">
                                        <div class="card">
                                            <div class="card-header">DADOS DO GRUPO</div>
                                            <div class="card-body">
                                            <div type_navs="pills" class="div_container_abas">
                                                <ul class="nav nav-pills mb-3" role="tablist" style="display:inline-block !important;white-space: nowrap !important">
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link active" id="pills-0-tab" data-bs-toggle="pill" href="#pills-0" role="tab" aria-controls="pills-0" aria-selected="true">Dados Grupo</a></li>
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="false">Integrantes do Grupo</a></li>
                                                </ul>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active div_dados_grupos_alterar_container_orelha0" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab"></div>
                                                    <div class="tab-pane fade   div_dados_grupos_alterar_container_orelha1" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab"></div>
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
                </div>          
            </div>
         </div>
      </div>
   </main>
</body>
<script type="module">
    import { fnsisjd } from "/sjd/javascript/modulos/classes/sisjd/1.0.2/FuncoesSisJD.js";
    fnsisjd.carregar_dados_grupos_equivalentes();
</script>
</html>