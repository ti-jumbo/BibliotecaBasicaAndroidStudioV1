<?php
    namespace SJD\relatorios\campanhas\consultar_campanhas;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Consultar Campanhas Estruturadas</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css//1.1/estilos.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/sjd/javascript/modulos/ModuloPrincipal.js?2.00"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
         <div class="row p-0 m-0">
             <div class="col p-0 m-0">
                <div id="barra_superior" class="barra_superior bg-dark text-white text-center text-uppercase fw-bolder position-relative">                              
                    <text class="position-absolute top-50 start-50 translate-middle">
                        Consultar Campanhas Estruturadas
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_2172322223844697 _0_9786143618140959">
                                <div></div>
                                <div name="div_consultar_campanhas_estruturadas" class="div_consultar_campanhas_estruturadas container-fluid corpo-conteudo" style="height:100%;" ajuda_elemento="Escolha uma campanha a esquerda para ver seus objetivos e seu atingimento!">
                                <div class="div_opcoes_pesquisa_l1 row" titulo="Opcoes de Pesquisa" height="25px">
                                    <div class="div_opcoes_pesquisa m-1 col">
                                        <div class="accordion">
                                            <div titulo="Opcoes de Pesquisa" target="#painel_div_opcoes_pesquisa_corpo" class="accordion-item" aberto="1">
                                            <div class="accordion-header" titulo="Opcoes de Pesquisa" target="#painel_div_opcoes_pesquisa_corpo" aberto="1">
                                                <div data-bs-toggle="collapse" data-bs-target="#painel_div_opcoes_pesquisa_corpo" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="painel_div_opcoes_pesquisa_corpo">Opcoes de Pesquisa</div>
                                            </div>
                                            <div id="painel_div_opcoes_pesquisa_corpo" class="collapse show">
                                                <div class="accordion-body" aberto="1">
                                                    <div class="div_opcoes_pesquisa_simples row">
                                                        <div class="div_opcoes_pesquisa_simples_col col">
                                                        <div class="accordion">
                                                            <div class="div_periodos accordion-item" titulo="Periodos" target="#periodos" aberto="1">
                                                                <div class="accordion-header" titulo="Periodos" target="#periodos" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#periodos" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="periodos">Periodos</div>
                                                                </div>
                                                                <div id="periodos" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <div class="row">
                                                                        <div class="col-auto mt-2 div_periodo col">
                                                                            <div dtini="2022-01-01" dtfim="2022-01-24" funcao_inclusao="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
                                                                                <div class="card-header">Periodo 01</div>
                                                                                <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="row">
                                                                                            <div class="col-auto col"><input type="date" class="componente_data" value="2022-01-01"></div>
                                                                                            <div class="col-auto col"><input type="date" class="componente_data" value="2022-01-24"></div>
                                                                                        </div>
                                                                                        <div class="align-items-center row">
                                                                                            <div class="col">
                                                                                            <div class="w-100 text-center"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/JAN.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/FEV.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/MAR.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/ABR.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/MAI.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/JUN.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/JUL.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/AGO.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/SET.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/OUT.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/NOV.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><img class="imagem_mes_calendario item_destaque100pct_hover" title="Preenche as datas com este mes inteiro" src="/sjd/images/calendario/DEZ.png" onclick="window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"><input type="number" class="inputano" value="2021" title="Ano para preenchimento do mes inteiro" step="1" min="0"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="div_opcao_controles_btns_img col-md-auto w-auto"></div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="campanhas_estruturadas" onclick="window.fnsisjd.pesquisar_campanhas_estruturadas(this,'consultar')">Pesquisar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3 m-1 resize div_arvore_opcoes_campanhas_estruturadas_consultar col">
                                        <div class="card">
                                            <div class="card-header">CAMPANHAS</div>
                                            <div class="card-body">(Clique em Pesquisar)</div>
                                        </div>
                                    </div>
                                    <div class="col-8 m-1 resize div_dados_campanha_consultar col">
                                        <div class="card">
                                            <div class="card-header">DADOS DA CAMPANHA</div>
                                            <div class="card-body">
                                            <div type_navs="pills" class="div_container_abas">
                                                <ul class="nav nav-pills mb-3" role="tablist" style="display:inline-block !important;white-space: nowrap !important">
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link active" id="pills-0-tab" data-bs-toggle="pill" href="#pills-0" role="tab" aria-controls="pills-0" aria-selected="true">Dados Campanha</a></li>
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="false">Objetivos Gerais Campanha</a></li>
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link" id="pills-2-tab" data-bs-toggle="pill" href="#pills-2" role="tab" aria-controls="pills-2" aria-selected="false">Objetivos Especificos Campanha</a></li>
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link" id="pills-3-tab" data-bs-toggle="pill" href="#pills-3" role="tab" aria-controls="pills-3" aria-selected="false">Condicionantes Campanha</a></li>
                                                </ul>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab">
                                                        <div class="div_dados_campanhas_consultar_container_corpo0_divtab">Dados Campanha (Clique numa campanha a esquerda para carregar os dados aqui!)</div>
                                                        <div class="div_dados_campanhas_consultar_container_corpo0_divgraficocamp"></div>
                                                        <div class="div_dados_campanhas_consultar_container_corpo0_divgraficossubcamp"></div>
                                                    </div>
                                                    <div class="tab-pane fade   div_dados_campanhas_consultar_container_corpo1" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">Objetivos Gerais Campanha (Clique numa campanha a esquerda para carregar os dados aqui!)</div>
                                                    <div class="tab-pane fade   div_dados_campanhas_consultar_container_corpo2" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">Objetivos Especificos Campanha (Clique numa campanha a esquerda para carregar os dados aqui!)</div>
                                                    <div class="tab-pane fade   div_dados_campanhas_consultar_container_corpo3" id="pills-3" role="tabpanel" aria-labelledby="pills-3-tab">Condicionantes Campanha (Clique numa campanha a esquerda para carregar os dados aqui!)</div>
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
                <div name="div_data_aurora" id="div_data_aurora" class="div_data_aurora" style="color: white;flot: right;position: fixed;top: 2px;right: 19px;font-size: 11px;font-wheight: bolder;z-index: 1000;background-color: gray;border-radius: 5px;">
                    <text name="data_aurora" id="data_aurora" class="texto_data_aurora data_aurora">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </text>
                </div>
            </div>
         </div>
      </div>
   </main>
</body>
<script type="module">
    import { fndt } from "/sjd/javascript/modulos/classes/data/FuncoesData.js";
    window.fnsisjd.requisitar_data_aurora();
    $("input.componente_data").eq(0).val(fndt.dataUSA(fndt.data_primeirodiames()));
    $("input.componente_data").eq(1).val(fndt.dataUSA(fndt.hoje()));
    $("input.inputano").val(fndt.dataBR_getAno(fndt.data_primeirodiames()));
</script>
</html>