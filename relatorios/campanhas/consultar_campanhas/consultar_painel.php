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
    <title>SisJD - Consultar Painel</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/estilos.css" rel="stylesheet">
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
                        Consultar Painel
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_23185050124603857 _0_058966329625195546">
                                <div></div>
                                <div name="div_consultar_sinergia2" class="div_consultar_sinergia2 container-fluid corpo-conteudo" ajuda_elemento="Escolha suas opcoes e consulte as metas em funcao das visoes disponiveis!" data-tit_aba="Painel" data-tit_aba_img="../images/img_aba_camp.png">
                                <div class="row mt-0 g-2">
                                    <div name="div_consultar_sinergia_grafico" class="div_consultar_sinergia_grafico col-9">
                                        <div class="card card_atingimento">
                                            <div class="card-header">Atingimento</div>
                                            <div class="card-body">
                                            <div name="div_consultar_sinergia_grafico_graficos" class="div_consultar_sinergia_grafico_graficos row">
                                                <div name="div_consultar_sinergia_grafico_grafico2" class="div_consultar_sinergia_grafico_grafico2 col">
                                                    <div name="div_consultar_sinergia_grafico_grafico2_tit" class="div_consultar_sinergia_grafico_grafico2_tit rounded text-center">Termometros (% Perc.)</div>
                                                    <div name="div_consultar_sinergia_grafico_grafico2_grafico" class="div_consultar_sinergia_grafico_grafico2_grafico text-center">
                                                        <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                                    </div>
                                                </div>
                                                <div name="div_consultar_sinergia_grafico_grafico3" class="div_consultar_sinergia_grafico_grafico3 col">
                                                    <div name="div_consultar_sinergia_grafico_grafico3_tit" class="div_consultar_sinergia_grafico_grafico3_tit rounded text-center">
                                                        Evolucao (Volume/Dia)
                                                        <div placeholder="Detalhar por" class="sm div_combobox" style="display:inline;margin-left:30px" multiplo="0" selecionar_todos="0" classe_botao="btn-secondary btn-sm" filtro="0" tipo_inputs="checkbox" num_max_texto_botao="5">
                                                        <button type="button" class="btn dropdown-toggle btn-secondary btn-sm" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Detalhar por</button>
                                                        <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                            <li opcoes_texto_opcao="Filial" onclick="window.fnsisjd.clicou_detalhar_evolucao({elemento:this})" opcoes_texto_botao="Filial" opcoes_valor_opcao="Filial" class="dropdown-item li" data-valor_opcao="Filial" data-texto_botao="Filial"><label textodepois="1">Filial</label></li>
                                                            <li opcoes_texto_opcao="Supervisor" onclick="window.fnsisjd.clicou_detalhar_evolucao({elemento:this})" opcoes_texto_botao="Supervisor" opcoes_valor_opcao="Supervisor" class="dropdown-item li" data-valor_opcao="Supervisor" data-texto_botao="Supervisor"><label textodepois="1">Supervisor</label></li>
                                                            <li opcoes_texto_opcao="Rca" onclick="window.fnsisjd.clicou_detalhar_evolucao({elemento:this})" opcoes_texto_botao="Rca" opcoes_valor_opcao="Rca" class="dropdown-item li" data-valor_opcao="Rca" data-texto_botao="Rca"><label textodepois="1">Rca</label></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    <div name="div_consultar_sinergia_grafico_grafico3_grafico" class="div_consultar_sinergia_grafico_grafico3_grafico _0_08275234718232427 _0_7597331689437572">
                                                        <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="div_consultar_sinergia_filtros" class="div_consultar_sinergia_filtros col-3">
                                        <div class="card card_filtros">
                                            <div class="card-header">Filtros</div>
                                            <div class="card-body">
                                            <div name="div_consultar_sinergia_filtros_corpo" class="div_consultar_sinergia_filtros_corpo text-center">
                                                <div name="div_consultar_sinergia_filtros_filtros" class="row div_consultar_sinergia_filtros_filtros ">
                                                    <div name="div_consultar_sinergia_filtros_filial" class="col div_consultar_sinergia_filtros_filial">
                                                        <div class="card card_filtro_filial">
                                                        <div class="card-header">Filial</div>
                                                        <div class="card-body"><input name="div_consultar_sinergia_filtros_filial_corpo_edit" class="div_consultar_sinergia_filtros_filial_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregar_painel(this)'})" placeholder="(Filtro)"></div>
                                                        </div>
                                                    </div>
                                                    <div name="div_consultar_sinergia_filtros_superv" class="col div_consultar_sinergia_filtros_superv">
                                                        <div class="card card_filtro_superv">
                                                        <div class="card-header">Superv</div>
                                                        <div class="card-body"><input name="div_consultar_sinergia_filtros_superv_corpo_edit" class="div_consultar_sinergia_filtros_superv_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregar_painel(this)'})" placeholder="(Filtro)"></div>
                                                        </div>
                                                    </div>
                                                    <div name="div_consultar_sinergia_filtros_rca" class="col div_consultar_sinergia_filtros_rca">
                                                        <div class="card card_filtro_rca">
                                                        <div class="card-header">Rca</div>
                                                        <div class="card-body"><input name="div_consultar_sinergia_filtros_rca_corpo_edit" class="div_consultar_sinergia_filtros_rca_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.carregar_painel(this)'})" placeholder="(Filtro)"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div name="div_consultar_sinergia_filtros_periodos" class="row div_consultar_sinergia_filtros_periodos">
                                                    <div class="col">
                                                        <div class="card card_periodos mt-2">
                                                        <div class="card-header">Periodo (Mes)</div>
                                                        <div class="card-body">
                                                            <div name="div_consultar_sinergia_filtros_periodos_corpo" class="row div_consultar_sinergia_filtros_periodos_corpo">
                                                                <div name="div_consultar_sinergia_filtros_periodo1" class="col div_consultar_sinergia_filtros_periodo1 p-1">
                                                                    <div name="div_consultar_sinergia_filtros_periodo1_corpo_mes_corpo" id="div_mes" class="input-group">
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
                                                                        <input class="form-control input_ano" value="(ano)">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button name="div_consultar_sinergia_filtros_botao_filtrar" class="div_consultar_sinergia_filtros_botao_filtrar rounded bg-secondary w-75 mt-2" onclick="window.fnsisjd.carregar_painel(this)">Filtrar</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div name="div_consultar_sinergia_campanhas_tabelas" class="row div_consultar_sinergia_campanhas_tabelas mt-0 g-2">
                                    <div name="div_consultar_sinergia_campanhas_itens_continente" class="col div_consultar_sinergia_campanhas_itens_continente">
                                        <div class="card card_campanhas_sinergia">
                                            <div class="card-header">Campanhas Sinergia<img name="div_consultar_sinergia_campanhas_itens_titulo_maximizar" class="div_consultar_sinergia_campanhas_itens_titulo_maximizar clicavel rounded img-tit-dir" src="\sjd/images/maximizar.png" onclick="window.fnsisjd.maximizar_div(this)"></div>
                                            <div class="card-body">
                                            <div name="div_consultar_sinergia_campanhas_itens" class="div_consultar_sinergia_campanhas_itens _0_4019953366159863 _0_24220404937519036">
                                                <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="div_consultar_sinergia_campanhas_estruturadas_container" class="col-5 div_consultar_sinergia_campanhas_estruturadas_container" style="max-height: 150px;">
                                        <div class="card card_campanhas_estruturadas">
                                            <div class="card-header">Campanhas Estruturadas<img name="div_consultar_sinergia_campanhas_itens_titulo_fechar" class="div_consultar_sinergia_campanhas_itens_titulo_fechar clicavel rounded img-tit-dir" src="\sjd/images/close16.png" onclick="window.fnsisjd.fechar_card(this)"><img name="div_consultar_sinergia_campanhas_itens_titulo_maximizar" class="div_consultar_sinergia_campanhas_itens_titulo_maximizar clicavel rounded img-tit-dir" src="\sjd/images/maximizar.png" onclick="window.fnsisjd.maximizar_div(this)"></div>
                                            <div class="card-body">
                                            <div name="div_consultar_sinergia_campanhas_estruturadas" class="div_consultar_sinergia_campanhas_estruturadas _0_6106034750063251 _0_5933083106528402">
                                                <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div name="div_consultar_painel_tabelas_positivacoes" class="row div_consultar_painel_tabelas_positivacoes mt-0 g-2">
                                    <div name="div_consultar_painel_tabelas_positivacoes_clientes_container" class="col-6 div_consultar_painel_tabelas_positivacoes_clientes_container">
                                        <div class="card card_positivacao_cliente">
                                            <div class="card-header">Principais clientes nao positivados<img name="div_consultar_sinergia_campanhas_itens_titulo_fechar" class="div_consultar_sinergia_campanhas_itens_titulo_fechar clicavel rounded img-tit-dir" src="\sjd/images/close16.png" onclick="window.fnsisjd.fechar_card(this)"><img name="div_consultar_sinergia_campanhas_itens_titulo_maximizar" class="div_consultar_sinergia_campanhas_itens_titulo_maximizar clicavel rounded img-tit-dir" src="\sjd/images/maximizar.png" onclick="window.fnsisjd.maximizar_div(this)"></div>
                                            <div class="card-body">
                                            <div name="div_consultar_painel_tabelas_positivacoes_clientes" class="div_consultar_painel_tabelas_positivacoes_clientes m-1 _0_7508202252184905 _0_030504259531297317">
                                                <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="div_consultar_painel_tabelas_positivacoes_produtos_container" class="col-6 div_consultar_painel_tabelas_positivacoes_produtos_container">
                                        <div class="card card_positivacao_produto">
                                            <div class="card-header">Principais produtos nao positivados<img name="div_consultar_sinergia_campanhas_itens_titulo_fechar" class="div_consultar_sinergia_campanhas_itens_titulo_fechar clicavel rounded img-tit-dir" src="\sjd/images/close16.png" onclick="window.fnsisjd.fechar_card(this)"><img name="div_consultar_sinergia_campanhas_itens_titulo_maximizar" class="div_consultar_sinergia_campanhas_itens_titulo_maximizar clicavel rounded img-tit-dir" src="\sjd/images/maximizar.png" onclick="window.fnsisjd.maximizar_div(this)"></div>
                                            <div class="card-body">
                                            <div name="div_consultar_painel_tabelas_positivacoes_produtos" class="div_consultar_painel_tabelas_positivacoes_produtos m-1 _0_9537168342233631 _0_767921176005872">
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
    import { fnsisjd } from "/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js";
    import { fndt } from "/sjd/javascript/modulos/classes/data/FuncoesData.js";
    window.fnsisjd.requisitar_data_aurora();
    let hoje = fndt.hoje();
    let div_mes = $("div.div_consultar_sinergia_filtros_periodos");
    let mes = fndt.dataBR_getMes(hoje)-1;
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    let li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    let texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);
    div_mes.find("input").val(fndt.dataBR_getAno(hoje));
    fnsisjd.carregar_painel();
</script>
</html>