<?php
    namespace SJD\pedidos;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Consultar Pedidos</title>
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
                        Consultar Pedidos
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_7445634216291522 _0_4850479436937939">
                                <div></div>
                                <div name="div_consultar_pedido" class="div_consultar_pedido container-fluid corpo-conteudo" ajuda_elemento="Consulte os pedidos em funcao das opcoes disponiveis." data-tit_aba="div_consultar_pedido" data-nome="div_consultar_pedido">
                                <div name="div_pedido" class="div_pedido" data-tit_aba="Pedidos" data-nome="aba_pedido">
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
                                                                <div class="avancado div_avancado accordion-item" titulo="Avancado" target="#avancada">
                                                                    <div class="accordion-header" titulo="Avancado" target="#avancada">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#avancada" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="avancada">Avancado</div>
                                                                    </div>
                                                                    <div id="avancada" class="collapse">
                                                                    <div class="accordion-body">
                                                                        <div class="div_opcoes_pesquisa_avancada row">
                                                                            <div class="div_opcoes_pesquisa_avancada_col col">
                                                                                <div class="accordion">
                                                                                <div class="painel_ver_vals_de accordion-item" titulo="Ver Valores de" target="#painel_ver_vals_de">
                                                                                    <div class="accordion-header" titulo="Ver Valores de" target="#painel_ver_vals_de">
                                                                                        <div data-bs-toggle="collapse" data-bs-target="#painel_ver_vals_de" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="painel_ver_vals_de">Ver Valores de</div>
                                                                                    </div>
                                                                                    <div id="painel_ver_vals_de" class="collapse">
                                                                                        <div class="accordion-body">
                                                                                            <div class="row">
                                                                                            <div class="col"><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="0" checked="true">R - Recebido</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="1">C - Cancelados</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="2" checked="true">B - Bloqueados</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="3" checked="true">P - Pendentes</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="4" checked="true">L - Liberados</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="5" checked="true">M - Montados</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="6">F - Faturados</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)">Todas as opcoes</label></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="div_condicionantes accordion-item" titulo="Condicionantes" target="#painel_condicionantes">
                                                                                    <div class="accordion-header" titulo="Condicionantes" target="#painel_condicionantes">
                                                                                        <div data-bs-toggle="collapse" data-bs-target="#painel_condicionantes" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="painel_condicionantes">Condicionantes</div>
                                                                                    </div>
                                                                                    <div id="painel_condicionantes" class="collapse">
                                                                                        <div class="accordion-body">
                                                                                            <img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})" title="Acrescentar um item">
                                                                                            <div class="row"></div>
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
                                                            <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="consulta_pedido" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="div_dados_pedido_consultar_container div_abas" class="div_dados_pedido_consultar_container div_abas" style="width:100%;height:100%;overflow:hidden;">
                                        <div name="div_dados_pedido_consultar_container_orelhas div_abas_orelhas" class="div_dados_pedido_consultar_container_orelhas div_abas_orelhas">
                                            <div name="div_dados_pedido_consultar_container_orelha0 div_aba_orelha" class="div_dados_pedido_consultar_container_orelha0 div_aba_orelha aberta" idaba="div_dados_pedido_consultar_container_aba0">Pesquisa Pedido</div>
                                            <div name="div_dados_pedido_consultar_container_orelha1 div_aba_orelha" class="div_dados_pedido_consultar_container_orelha1 div_aba_orelha" idaba="div_dados_pedido_consultar_container_aba1">Dados Pedido</div>
                                        </div>
                                        <div name="div_dados_pedido_consultar_container_corpos div_abas_corpos" class="div_dados_pedido_consultar_container_corpos div_abas_corpos">
                                            <div name="div_dados_pedido_consultar_container_corpo0 div_aba_corpo" class="div_dados_pedido_consultar_container_corpo0 div_aba_corpo aberta" idaba="div_dados_pedido_consultar_container_aba0">
                                            Resultado Pesquisa
                                            <div name="div_resultado" class="div_resultado"></div>
                                            </div>
                                            <div name="div_dados_pedido_consultar_container_corpo1 div_aba_corpo" class="div_dados_pedido_consultar_container_corpo1 div_aba_corpo" idaba="div_dados_pedido_consultar_container_aba1">
                                            Dados Pedido
                                            <div name="div_dados_pedido_carregado_consultar_container div_abas" class="div_dados_pedido_carregado_consultar_container div_abas" style="width:100%;height:100%;overflow:hidden;">
                                                <div name="div_dados_pedido_carregado_consultar_container_orelhas div_abas_orelhas" class="div_dados_pedido_carregado_consultar_container_orelhas div_abas_orelhas">
                                                    <div name="div_dados_pedido_carregado_consultar_container_orelha0 div_aba_orelha" class="div_dados_pedido_carregado_consultar_container_orelha0 div_aba_orelha aberta" idaba="div_dados_pedido_carregado_consultar_container_aba0">Cabecalho</div>
                                                    <div name="div_dados_pedido_carregado_consultar_container_orelha1 div_aba_orelha" class="div_dados_pedido_carregado_consultar_container_orelha1 div_aba_orelha" idaba="div_dados_pedido_carregado_consultar_container_aba1">Itens</div>
                                                </div>
                                                <div name="div_dados_pedido_carregado_consultar_container_corpos div_abas_corpos" class="div_dados_pedido_carregado_consultar_container_corpos div_abas_corpos">
                                                    <div name="div_dados_pedido_carregado_consultar_container_corpo0 div_aba_corpo" class="div_dados_pedido_carregado_consultar_container_corpo0 div_aba_corpo aberta" idaba="div_dados_pedido_carregado_consultar_container_aba0"></div>
                                                    <div name="div_dados_pedido_carregado_consultar_container_corpo1 div_aba_corpo" class="div_dados_pedido_carregado_consultar_container_corpo1 div_aba_corpo aberta" idaba="div_dados_pedido_carregado_consultar_container_aba1"></div>
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
    import { fndt } from "/sjd/javascript/modulos/classes/data/FuncoesData.js";
    $("input.componente_data").eq(0).val(fndt.dataUSA(fndt.data_primeirodiames()));
    $("input.componente_data").eq(1).val(fndt.dataUSA(fndt.hoje()));
    $("input.inputano").val(fndt.dataBR_getAno(fndt.data_primeirodiames()));
</script>
</html>