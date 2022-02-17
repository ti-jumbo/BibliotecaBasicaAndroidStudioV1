<?php
    namespace SJD\relatorios;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />
    <title>SisJD - Relatorio Cispe</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css//1.1/estilos.css" rel="stylesheet">
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
                        Relatorio Cispe
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_6489441253192613 _0_546660850661575">
                                <div></div>
                                <div name="div_cispe" class="div_cispe container-fluid corpo-conteudo" ajuda_elemento="Veja clientes da base Cispe, podem ser potenciais novos clientes para negocios!" data-tit_aba="cispe" data-nome="cispe">
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
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="clientescispenaojumbo" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div_resultado_l2 row">
                                    <div class="div_resultado col"></div>
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