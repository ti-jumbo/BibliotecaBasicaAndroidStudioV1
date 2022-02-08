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
    <title>SisJD - Consulta Ratings Focais</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/estilos.css" rel="stylesheet">
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
                        Consulta Ratings Focais
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_3034731937025692 _0_424779179197464">
                                <div></div>
                                <div name="div_consultar_ratingsfocais" class="div_consultar_ratingsfocais container-fluid corpo-conteudo" ajuda_elemento="Escolha uma ou mais visoes, um ou mais periodos, condicionantes, tipos de valores para ver seu rating!" data-tit_aba="consultar ratings focais" data-nome="aba_ratings_focais">
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
                                                            <div class="div_visoes accordion-item" titulo="Visualizar" target="#visoes" aberto="1">
                                                                <div class="accordion-header" titulo="Visualizar" target="#visoes" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#visoes" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="visoes">Visualizar</div>
                                                                </div>
                                                                <div id="visoes" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <div class="row">
                                                                        <div class="col-auto mt-2 div_visao col">
                                                                            <div funcao_inclusao="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
                                                                                <div class="card-header">Visao 01</div>
                                                                                <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div label="Visao 01" class="desabilitado div_combobox" tem_inputs="1" tipo_inputs="radio" multiplo="0" selecionar_todos="0" filtro="1" classe_botao="btn-dark" classe_dropdown="dropdown-visao " placeholder="(Selecione)" name_inpus="_361897207" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Rca</button>
                                                                                            <ul class="dropdown-menu dropdown-visao" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                            <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <li opcoes_texto_opcao="Origem de Dados" opcoes_texto_botao="Origem de Dados" opcoes_valor_opcao="Origem de Dados" class="dropdown-item li" data-valor_opcao="Origem de Dados" data-texto_botao="Origem de Dados"><label textodepois="1"><input type="radio" name="_361897207">Origem de Dados</label></li>
                                                                                            <li opcoes_texto_opcao="Empresa" opcoes_texto_botao="Empresa" opcoes_valor_opcao="Empresa" class="dropdown-item li" data-valor_opcao="Empresa" data-texto_botao="Empresa"><label textodepois="1"><input type="radio" name="_361897207">Empresa</label></li>
                                                                                            <li opcoes_texto_opcao="Filial" opcoes_texto_botao="Filial" opcoes_valor_opcao="Filial" class="dropdown-item li" data-valor_opcao="Filial" data-texto_botao="Filial"><label textodepois="1"><input type="radio" name="_361897207">Filial</label></li>
                                                                                            <li opcoes_texto_opcao="Fornecedor" opcoes_texto_botao="Fornecedor" opcoes_valor_opcao="Fornecedor" class="dropdown-item li" data-valor_opcao="Fornecedor" data-texto_botao="Fornecedor"><label textodepois="1"><input type="radio" name="_361897207">Fornecedor</label></li>
                                                                                            <li opcoes_texto_opcao="Cidade" opcoes_texto_botao="Cidade" opcoes_valor_opcao="Cidade" class="dropdown-item li" data-valor_opcao="Cidade" data-texto_botao="Cidade"><label textodepois="1"><input type="radio" name="_361897207">Cidade</label></li>
                                                                                            <li opcoes_texto_opcao="Supervisor" opcoes_texto_botao="Supervisor" opcoes_valor_opcao="Supervisor" class="dropdown-item li" data-valor_opcao="Supervisor" data-texto_botao="Supervisor"><label textodepois="1"><input type="radio" name="_361897207">Supervisor</label></li>
                                                                                            <li opcoes_texto_opcao="Rca" opcoes_texto_botao="Rca" opcoes_valor_opcao="Rca" class="dropdown-item li" data-valor_opcao="Rca" data-texto_botao="Rca"><label textodepois="1"><input type="radio" name="_361897207" checked="1">Rca</label></li>
                                                                                            <li opcoes_texto_opcao="Ramo de Atividade" opcoes_texto_botao="Ramo de Atividade" opcoes_valor_opcao="Ramo de Atividade" class="dropdown-item li" data-valor_opcao="Ramo de Atividade" data-texto_botao="Ramo de Atividade"><label textodepois="1"><input type="radio" name="_361897207">Ramo de Atividade</label></li>
                                                                                            <li opcoes_texto_opcao="Departamento" opcoes_texto_botao="Departamento" opcoes_valor_opcao="Departamento" class="dropdown-item li" data-valor_opcao="Departamento" data-texto_botao="Departamento"><label textodepois="1"><input type="radio" name="_361897207">Departamento</label></li>
                                                                                            <li opcoes_texto_opcao="Produto" opcoes_texto_botao="Produto" opcoes_valor_opcao="Produto" class="dropdown-item li" data-valor_opcao="Produto" data-texto_botao="Produto"><label textodepois="1"><input type="radio" name="_361897207">Produto</label></li>
                                                                                            <li opcoes_texto_opcao="Evolucao" opcoes_texto_botao="Evolucao" opcoes_valor_opcao="Evolucao" class="dropdown-item li" data-valor_opcao="Evolucao" data-texto_botao="Evolucao"><label textodepois="1"><input type="radio" name="_361897207">Evolucao</label></li>
                                                                                            <li opcoes_texto_opcao="Cliente" opcoes_texto_botao="Cliente" opcoes_valor_opcao="Cliente" class="dropdown-item li" data-valor_opcao="Cliente" data-texto_botao="Cliente"><label textodepois="1"><input type="radio" name="_361897207">Cliente</label></li>
                                                                                            <li opcoes_texto_opcao="Nota Fiscal" opcoes_texto_botao="Nota Fiscal" opcoes_valor_opcao="Nota Fiscal" class="dropdown-item li" data-valor_opcao="Nota Fiscal" data-texto_botao="Nota Fiscal"><label textodepois="1"><input type="radio" name="_361897207">Nota Fiscal</label></li>
                                                                                            <li opcoes_texto_opcao="Item de Nota Fiscal" opcoes_texto_botao="Item de Nota Fiscal" opcoes_valor_opcao="Item de Nota Fiscal" class="dropdown-item li" data-valor_opcao="Item de Nota Fiscal" data-texto_botao="Item de Nota Fiscal"><label textodepois="1"><input type="radio" name="_361897207">Item de Nota Fiscal</label></li>
                                                                                            <li opcoes_texto_opcao="Rota" opcoes_texto_botao="Rota" opcoes_valor_opcao="Rota" class="dropdown-item li" data-valor_opcao="Rota" data-texto_botao="Rota"><label textodepois="1"><input type="radio" name="_361897207">Rota</label></li>
                                                                                            <li opcoes_texto_opcao="Praca" opcoes_texto_botao="Praca" opcoes_valor_opcao="Praca" class="dropdown-item li" data-valor_opcao="Praca" data-texto_botao="Praca"><label textodepois="1"><input type="radio" name="_361897207">Praca</label></li>
                                                                                            <li opcoes_texto_opcao="Negocio Aurora" opcoes_texto_botao="Negocio Aurora" opcoes_valor_opcao="Negocio Aurora" class="dropdown-item li" data-valor_opcao="Negocio Aurora" data-texto_botao="Negocio Aurora"><label textodepois="1"><input type="radio" name="_361897207">Negocio Aurora</label></li>
                                                                                            <li opcoes_texto_opcao="Categoria Aurora" opcoes_texto_botao="Categoria Aurora" opcoes_valor_opcao="Categoria Aurora" class="dropdown-item li" data-valor_opcao="Categoria Aurora" data-texto_botao="Categoria Aurora"><label textodepois="1"><input type="radio" name="_361897207">Categoria Aurora</label></li>
                                                                                            <li opcoes_texto_opcao="Rede de clientes" opcoes_texto_botao="Rede de clientes" opcoes_valor_opcao="Rede de clientes" class="dropdown-item li" data-valor_opcao="Rede de clientes" data-texto_botao="Rede de clientes"><label textodepois="1"><input type="radio" name="_361897207">Rede de clientes</label></li>
                                                                                            </ul>
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
                                                                                            <div class="col"><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="radio" class="radio_ver_valores_de" value="0" name="radio_ver_vals_de_consultar_ratingsfocais">Qtde</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="radio" class="radio_ver_valores_de" value="3" name="radio_ver_vals_de_consultar_ratingsfocais" checked="true">Peso Total</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="radio" class="radio_ver_valores_de" value="5" name="radio_ver_vals_de_consultar_ratingsfocais">Valor Total</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="radio_ver_valores_de" value="10" name="opcao_ver_vals_de_consultar_ratingsfocais_opcao">Ver Valores</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="radio_ver_valores_de" value="11" name="opcao_ver_vals_de_consultar_ratingsfocais_ratings_detalhados">Ver Ratings Individuais</label></div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                </div>
                                                                                <div class="painel_considerar_vals_de accordion-item" titulo="Considerar Valores de" target="#painel_considerar_vals_de">
                                                                                <div class="accordion-header" titulo="Considerar Valores de" target="#painel_considerar_vals_de">
                                                                                    <div data-bs-toggle="collapse" data-bs-target="#painel_considerar_vals_de" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="painel_considerar_vals_de">Considerar Valores de</div>
                                                                                </div>
                                                                                <div id="painel_considerar_vals_de" class="collapse">
                                                                                    <div class="accordion-body">
                                                                                        <div class="row">
                                                                                            <div class="col"><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="0" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Vendas Normais</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="1" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Devolucoes Normais</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="2" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Devolucoes Avulsas</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="3" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)">Bonificacoes</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="10" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Todos</label></div>
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
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="consultar_ratingsfocais" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
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
                    <text name="data_aurora" id="data_aurora" class="texto_data_aurora data_aurora">[Data Aurora: 21/01/22]</text>
                </div>
            </div>
         </div>
      </div>
   </main>
</body>
</html>