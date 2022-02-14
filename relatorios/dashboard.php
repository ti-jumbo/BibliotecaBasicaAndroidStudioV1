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
    <title>SisJD - Dashboard</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/1.0/estilos.css" rel="stylesheet">
    <link href="/sjd/css/dashboard.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
         <div class="row p-0 m-0">
             <div class="col p-0 m-0">
                <div id="barra_superior" class="barra_superior bg-dark text-white text-center text-uppercase fw-bolder position-relative">                              
                    <text class="position-absolute top-50 start-50 translate-middle">
                        Dashboard
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
               <div class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                  <div class="row">
                     <div class="col">
                        <div class="div_conteudo_pagina container-fluid">
                            <div class="row mt-1 mb-1">
                                <div class="col text-end">
                                    <button class="btn btn-outline-primary btn-filtro collapsed" data-bs-toggle="collapse" data-bs-target="#row_filtro" aria-expanded="false" aria-controls="row_filtro">
                                        <svg class="bi bi-funnel" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z">
                                            </path>
                                        </svg>
                                    </button>   
                                </div>
                            </div>
                            <div id="row_filtro" class="row collapse collapsed">
                                <div class="col">
                                     <div class="card card_filtros_dashboard">
                                        <div class="card-header">Filtros</div>
                                        <div class="card-body">
                                            <div class="div_consultar_dashboard_filtros_corpo text-center">
                                                <div class="row div_consultar_dashboard_filtros_filtros ">
                                                    <div class="col div_consultar_dashboard_filtros_origem">
                                                        <div class="card card_origem h-100">
                                                            <div class="card-header">Origem</div>
                                                            <div class="card-body">
                                                                <div class="row div_consultar_dashboard_filtros_origem_corpo">
                                                                    <div class="col div_consultar_dashboard_filtros_periodo1 p-1">
                                                                        <div classe_botao="btn-secondary botao_dropdown_visao"  style="font-size:12px;" class="div_combobox" tem_inputs="1" tipo_inputs="checkbox" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_943278053" num_max_texto_botao="5">
                                                                            <button type="button" class="btn dropdown-toggle btn-secondary botao_dropdown_visao" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">AURORA,JUMBO</button>
                                                                            <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                <li opcoes_texto_opcao="AURORA" opcoes_texto_botao="AURORA" opcoes_valor_opcao="origem de dados=aurora" class="dropdown-item li" data-valor_opcao="AURORA" data-texto_botao="AURORA"><label textodepois="1"><input type="checkbox" name="_943278053" checked="1">AURORA</label></li>
                                                                                <li opcoes_texto_opcao="JUMBO" opcoes_texto_botao="JUMBO" opcoes_valor_opcao="origem de dados=jumbo" class="dropdown-item li" data-valor_opcao="JUMBO" data-texto_botao="JUMBO"><label textodepois="1"><input type="checkbox" name="_943278053" checked="1">JUMBO</label></li>                                                                                    
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col div_consultar_dashboard_filtros_filial">
                                                        <div class="card card_filtro_filial h-100">
                                                            <div class="card-header">Filial</div>
                                                            <div class="card-body">
                                                                <input class="div_consultar_dashboard_filtros_filial_corpo_edit input_entidade w-90" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregarDashboard(this)'})" placeholder="(Filtro)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col div_consultar_dashboard_filtros_superv">
                                                        <div class="card card_filtro_superv h-100">
                                                            <div class="card-header">Superv</div>
                                                            <div class="card-body">
                                                                <input class="div_consultar_dashboard_filtros_superv_corpo_edit input_entidade w-90" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregarDashboard(this)'})" placeholder="(Filtro)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col div_consultar_dashboard_filtros_rca">
                                                        <div class="card card_filtro_rca h-100">
                                                            <div class="card-header">Rca</div>
                                                            <div class="card-body">
                                                                <input class="div_consultar_dashboard_filtros_rca_corpo_edit input_entidade w-90" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregarDashboard(this)'})" placeholder="(Filtro)">
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="row div_consultar_dashboard_filtros_condicionantes ">
                                                    
                                                        
                                                </div>                                               
                                                <div class="row div_consultar_dashboard_filtros_periodos ">
                                                    <div class="col d-none">
                                                        <div class="card card_periodos h-100">
                                                            <div class="card-header">Periodo (Mes)</div>
                                                            <div class="card-body">
                                                                <div class="row div_consultar_dashboard_filtros_periodos_corpo">
                                                                    <div class="col div_consultar_dashboard_filtros_periodo1 p-1">
                                                                        <div id="div_mes" class="input-group">
                                                                            <div classe_botao="btn-secondary botao_dropdown_visao"  style="font-size:12px;" class="div_combobox" tem_inputs="1" tipo_inputs="radio" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_943278053" num_max_texto_botao="5">
                                                                                <button type="button" class="btn dropdown-toggle btn-secondary botao_dropdown_visao" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(mes)</button>
                                                                                <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                    <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_943278053">JANEIRO</label></li>
                                                                                    <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_943278053">FEVEREIRO</label></li>
                                                                                    <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_943278053">MARCO</label></li>
                                                                                    <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_943278053">ABRIL</label></li>
                                                                                    <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_943278053">MAIO</label></li>
                                                                                    <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_943278053">JUNHO</label></li>
                                                                                    <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_943278053">JULHO</label></li>
                                                                                    <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_943278053">AGOSTO</label></li>
                                                                                    <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_943278053">SETEMBRO</label></li>
                                                                                    <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_943278053">OUTUBRO</label></li>
                                                                                    <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_943278053">NOVEMBRO</label></li>
                                                                                    <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_943278053">DEZEMBRO</label></li>
                                                                                </ul>
                                                                            </div>
                                                                            <input class="form-control input_ano" value="(ano)" placeholder="(ano)" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregarDashboard(this)'})">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                    <button class="div_consultar_dashboard_filtros_botao_filtrar rounded bg-primary w-75 mt-2" onclick="window.fnsisjd.carregarDashboard(this)">Filtrar</button>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row mt-2">
                                <div class="col-9">
                                    <div class="card card_grafico_volume">
                                        <div class="card-header">
                                            Volume por ano/mes
                                            <button class="btn btn-outline-primary btn-filtro collapsed float-end" data-bs-toggle="collapse" data-bs-target="#row_opcoes_grafico_volume" aria-expanded="false" aria-controls="row_opcoes_grafico_volume">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div id="row_opcoes_grafico_volume" class="row row_opcoes_grafico_volume collapse collapsed mb-2">
                                                <div class="col-3">                                            
                                                    <div class="card card_anos_grafico_volume">
                                                        <div class="card-header">Anos considerar</div>
                                                        <div class="card-body">
                                                            <div tem_inputs="1" selecionar_todos="1" filtro="1" classe_botao="btn-dark" class="div_combobox" placeholder="(Selecione)" tipo_inputs="checkbox" multiplo="1" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">2021,2022</button>
                                                                <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                    <label class="label_selecionar_todos text-nowrap" textodepois="1">
                                                                        <input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">
                                                                        Selecionar Todos
                                                                    </label>
                                                                    <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                    <li opcoes_texto_opcao="2017" opcoes_texto_botao="2017" opcoes_valor_opcao="2017" class="dropdown-item li" data-valor_opcao="2017" data-texto_botao="2017">
                                                                        <label textodepois="1">
                                                                            <input type="checkbox">
                                                                            2017
                                                                        </label>
                                                                    </li>
                                                                    <li opcoes_texto_opcao="2018" opcoes_texto_botao="2018" opcoes_valor_opcao="2018" class="dropdown-item li" data-valor_opcao="2018" data-texto_botao="2018"><label textodepois="1"><input type="checkbox">2018</label></li>
                                                                    <li opcoes_texto_opcao="2019" opcoes_texto_botao="2019" opcoes_valor_opcao="2019" class="dropdown-item li" data-valor_opcao="2019" data-texto_botao="2019"><label textodepois="1"><input type="checkbox">2019</label></li>
                                                                    <li opcoes_texto_opcao="2020" opcoes_texto_botao="2020" opcoes_valor_opcao="2020" class="dropdown-item li" data-valor_opcao="2020" data-texto_botao="2020"><label textodepois="1"><input type="checkbox">2020</label></li>
                                                                    <li opcoes_texto_opcao="2021" opcoes_texto_botao="2021" opcoes_valor_opcao="2021" class="dropdown-item li" data-valor_opcao="2021" data-texto_botao="2021"><label textodepois="1"><input type="checkbox" checked="1">2021</label></li>
                                                                    <li opcoes_texto_opcao="2022" opcoes_texto_botao="2022" opcoes_valor_opcao="2022" class="dropdown-item li" data-valor_opcao="2022" data-texto_botao="2022">
                                                                        <label textodepois="1">
                                                                            <input type="checkbox" checked="1">
                                                                            2022
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="col-3">                                            
                                                    <div class="card card_unidade_grafico_volume">
                                                        <div class="card-header">Unidade</div>
                                                        <div class="card-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="unidade" id="unidade_quantidade" value="0">
                                                                <label class="form-check-label" for="unidade_quantidade">
                                                                    Quantidade (UN)
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="unidade" id="unidade_peso" checked="1" value="3">
                                                                <label class="form-check-label" for="unidade_peso">
                                                                    Peso (KG)
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="unidade" id="unidade_valor" value="5">
                                                                <label class="form-check-label" for="unidade_valor">
                                                                    Valor (R$)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                                <div class="col-2">
                                                    <button class="div_consultar_dashboard_filtros_botao_filtrar rounded bg-primary w-75 mt-2" onclick="window.fnsisjd.carregarGraficoVolume()">Executar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-11">
                                                    <div id="div_grafico_volume">
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-3">
                                    <div class="card card_grafico_positivacao_cliente">
                                        <div class="card-header">
                                            Positivação Cliente
                                            <button class="btn btn-outline-primary btn-filtro collapsed float-end" data-bs-toggle="collapse" data-bs-target="#row_opcoes_grafico_positivacao" aria-expanded="false" aria-controls="row_opcoes_grafico_positivacao">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="card-body">
                                            <div id="row_opcoes_grafico_positivacao" class="row row_opcoes_grafico_positivacao collapse collapsed mb-2">
                                                <div class="col">
                                                    <div class="row row_opcoes_grafico_positivacao_periodo">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <button class="div_consultar_dashboard_filtros_botao_filtrar rounded bg-primary mt-2" onclick="window.fnsisjd.carregarGraficoPositivacaoClientes()">Executar</button>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-11">
                                                    <div id="div_grafico_positivacao">
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
               <div id="div_data_aurora" class="div_data_aurora" style="color: white;flot: right;position: fixed;top: 2px;right: 19px;font-size: 11px;font-wheight: bolder;z-index: 1000;background-color: gray;border-radius: 5px;">
                  <text id="data_aurora" class="texto_data_aurora data_aurora">
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
    import { fnsisjd } from "/sjd/javascript/modulos/classes/sisjd/1.0.2/FuncoesSisJD.js";
    import { fndt } from "/sjd/javascript/modulos/classes/data/FuncoesData.js";
    fnsisjd.requisitar_data_aurora();
    let hoje = fndt.hoje();
    let div_mes = $("div.card_periodos");
    let mes = fndt.dataBR_getMes(hoje)-1;
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    let li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    let texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);
    div_mes.find("input").val(fndt.dataBR_getAno(hoje));
    let div_filtro_condicionantes = $("div.div_consultar_dashboard_filtros_condicionantes");
    
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Departamento",
        visoes_condic:"departamento",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Fornecedor",
        visoes_condic:"fornecedor",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });    
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Produto",
        visoes_condic:"produto",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Ramo",
        visoes_condic:"ramo de atividade",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Cidade",
        visoes_condic:"cidade",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Rota",
        visoes_condic:"rota",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Praca",
        visoes_condic:"praca",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Rede",
        visoes_condic:"rede de clientes",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });
    fnsisjd.inserir_condicionante_pesquisa({
        elemento:div_filtro_condicionantes,
        titulo:"Cliente",
        visoes_condic:"cliente",
        permite_incluir:false,
        permite_excluir:false,
        class_visao:"d-none",
        class_operacao:"d-none"
    });    
    let div_periodo_positivacao = $("div.row_opcoes_grafico_positivacao_periodo");
    div_periodo_positivacao.html(
        fnhtml.criar_elemento(
            fnsisjd.criarPeriodo({
                class:"p-0",
                titulo:"Periodo positivacao considerar",
                permite_incluir:false,
                permite_excluir:false
            })
        )
    );
    fnsisjd.carregarDashboard();
</script>
</html>