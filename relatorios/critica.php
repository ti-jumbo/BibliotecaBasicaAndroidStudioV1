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
    <title>SisJD - Relatorio Critica - Abastecimento Aurora</title>
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
                        Relatorio Critica - Abastecimento Aurora
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_679814857803575 _0_7723580609927548">
                                <div></div>
                                <div name="div_critica" class="div_critica container-fluid corpo-conteudo" ajuda_elemento="Critica mensal de objetivos e envios de produtos da Aurora." data-tit_aba="critica" data-nome="critica">
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
                                                            <div class="div_visoes accordion-item" titulo="Filtros" tipo="filtro" target="#visoes" aberto="1">
                                                                <div class="accordion-header" titulo="Filtros" target="#visoes" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#visoes" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="visoes">Filtros</div>
                                                                </div>
                                                                <div id="visoes" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <div class="row">
                                                                        <div class="col-auto mt-2 div_visao col">
                                                                            <div funcao_inclusao="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
                                                                                <div class="card-header">Filial</div>
                                                                                <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div label="Filial" visao="Filial" class="condicionante div_combobox" tipo_inputs="checkbox" selecionar_todos="1" multiplo="1" filtro="1" tem_inputs="1" placeholder="(Selecione)" classe_botao="btn-dark" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Todos (3)</button>
                                                                                            <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                            <label class="label_selecionar_todos" textodepois="1"><input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">Selecionar Todos</label><input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <li opcoes_texto_opcao="1-CASCAVEL" opcoes_valor_opcao="filial=1" opcoes_texto_botao="1" class="dropdown-item li" data-valor_opcao="filial=1" data-texto_botao="1"><label textodepois="1"><input type="checkbox" checked="1">1-CASCAVEL</label></li>
                                                                                            <li opcoes_texto_opcao="2-LONDRINA" opcoes_valor_opcao="filial=2" opcoes_texto_botao="2" class="dropdown-item li" data-valor_opcao="filial=2" data-texto_botao="2"><label textodepois="1"><input type="checkbox" checked="1">2-LONDRINA</label></li>
                                                                                            <li opcoes_texto_opcao="3-MUNDO NOVO" opcoes_valor_opcao="filial=3" opcoes_texto_botao="3" class="dropdown-item li" data-valor_opcao="filial=3" data-texto_botao="3"><label textodepois="1"><input type="checkbox" checked="1">3-MUNDO NOVO</label></li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="div_opcao_controles_btns_img col-md-auto w-auto"></div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto mt-2 div_visao col">
                                                                            <div funcao_inclusao="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
                                                                                <div class="card-header">Mes</div>
                                                                                <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div id="div_mes" label="Mes" class="div_combobox" tem_inputs="1" multiplo="0" tipo_inputs="radio" classe_botao="btn-dark" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_1817386746" num_max_texto_botao="5">
                                                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(mes)</button>
                                                                                            <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                            <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_1817386746">JANEIRO</label></li>
                                                                                            <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_1817386746">FEVEREIRO</label></li>
                                                                                            <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_1817386746">MARCO</label></li>
                                                                                            <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_1817386746">ABRIL</label></li>
                                                                                            <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_1817386746">MAIO</label></li>
                                                                                            <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_1817386746">JUNHO</label></li>
                                                                                            <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_1817386746">JULHO</label></li>
                                                                                            <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_1817386746">AGOSTO</label></li>
                                                                                            <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_1817386746">SETEMBRO</label></li>
                                                                                            <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_1817386746">OUTUBRO</label></li>
                                                                                            <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_1817386746">NOVEMBRO</label></li>
                                                                                            <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_1817386746">DEZEMBRO</label></li>
                                                                                            </ul>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="div_opcao_controles_btns_img col-md-auto w-auto"></div>
                                                                                </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-auto mt-2 div_visao col">
                                                                            <div funcao_inclusao="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
                                                                                <div class="card-header">Ano</div>
                                                                                <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div label="Ano" tem_inputs="1" tipo_inputs="radio" multiplo="0" selecionar_todos="0" filtro="1" classe_botao="btn-dark" classe_dropdown="dropdown-visao " class="div_combobox" placeholder="(Selecione)" name_inpus="_420333433" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">2022</button>
                                                                                            <ul class="dropdown-menu dropdown-visao" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                            <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <li opcoes_texto_opcao="2017" opcoes_texto_botao="2017" opcoes_valor_opcao="2017" class="dropdown-item li" data-valor_opcao="2017" data-texto_botao="2017"><label textodepois="1"><input type="radio" name="_420333433">2017</label></li>
                                                                                            <li opcoes_texto_opcao="2018" opcoes_texto_botao="2018" opcoes_valor_opcao="2018" class="dropdown-item li" data-valor_opcao="2018" data-texto_botao="2018"><label textodepois="1"><input type="radio" name="_420333433">2018</label></li>
                                                                                            <li opcoes_texto_opcao="2019" opcoes_texto_botao="2019" opcoes_valor_opcao="2019" class="dropdown-item li" data-valor_opcao="2019" data-texto_botao="2019"><label textodepois="1"><input type="radio" name="_420333433">2019</label></li>
                                                                                            <li opcoes_texto_opcao="2020" opcoes_texto_botao="2020" opcoes_valor_opcao="2020" class="dropdown-item li" data-valor_opcao="2020" data-texto_botao="2020"><label textodepois="1"><input type="radio" name="_420333433">2020</label></li>
                                                                                            <li opcoes_texto_opcao="2021" opcoes_texto_botao="2021" opcoes_valor_opcao="2021" class="dropdown-item li" data-valor_opcao="2021" data-texto_botao="2021"><label textodepois="1"><input type="radio" name="_420333433">2021</label></li>
                                                                                            <li opcoes_texto_opcao="2022" opcoes_texto_botao="2022" opcoes_valor_opcao="2022" class="dropdown-item li" data-valor_opcao="2022" data-texto_botao="2022"><label textodepois="1"><input type="radio" name="_420333433" checked="1">2022</label></li>
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
                                                            <div class="div_periodos accordion-item" titulo="Periodos de Venda" target="#periodos" aberto="1">
                                                                <div class="accordion-header" titulo="Periodos de Venda" target="#periodos" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#periodos" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="periodos">Periodos de Venda</div>
                                                                </div>
                                                                <div id="periodos" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" title="Acrescentar um item">
                                                                    <div class="row">
                                                                        <div class="col-auto mt-2 div_periodo col">
                                                                            <div dtini="2022-01-01" dtfim="2022-01-24" permite_incluir="1" permite_excluir="1" funcao_inclusao="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" funcao_exclusao="window.fnsisjd.deletar_controles({elemento:this})" class="card">
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
                                                                                    <div class="div_opcao_controles_btns_img col-md-auto w-auto"><img class="btn_img_add_ctrl mousehover clicavel rounded" src="/sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" title="Acrescentar ao lado deste"><img class="btn_img_excl_ctrl mousehover clicavel rounded" src="/sjd/images/img_del.png" onclick="window.fnsisjd.deletar_controles({elemento:this})" title="Excluir este controle"></div>
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
                                                                                            <div class="col"><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="0" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)">Qtde</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="1" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)">Unidade</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="2" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)">Peso UN</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="3" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" checked="true">Peso Total</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="4" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)">Valor UN</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="5" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" checked="true">Valor Total</label><label class="rotulo_ver_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_ver_valores_de" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)">Todos</label></div>
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
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="critica" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
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
    let hoje = fndt.hoje();
    let div_mes = $("div#div_mes");
    let mes = fndt.dataBR_getMes(hoje)-1;
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    let li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    let texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);
</script>
</html>