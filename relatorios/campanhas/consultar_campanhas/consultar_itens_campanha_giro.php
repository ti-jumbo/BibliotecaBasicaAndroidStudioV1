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
    <title>SisJD - Consultar Itens Giro - Objetivos</title>
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
                        Consultar Itens Giro - Objetivos
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_11843160727774216 _0_494820783090123">
                                <div></div>
                                <div name="div_consultar_itens_campanha_giro" class="div_consultar_itens_campanha_giro container-fluid corpo-conteudo" ajuda_elemento="Escolha suas opcoes e consulte os grupos giro!" data-tit_aba="Consultar Itens Campanha Giro" data-tit_aba_img="../images/img_aba_camp.png">
                                <div name="div_consultar_sinergia_subtitulo" class="div_consultar_sinergia_subtitulo row">
                                    <div name="div_consultar_sinergia_subtitulo_col" class="div_consultar_sinergia_subtitulo_col col m-1">
                                        <div name="div_consultar_sinergia_filtros" class="div_consultar_sinergia_filtros row">
                                            <div name="div_consultar_sinergia_filtros" class="div_consultar_sinergia_filtros col border rounded mr-1">
                                            <div name="div_consultar_sinergia_filtros_titulo" class="div_consultar_sinergia_filtros_titulo  background_cinza rounded-top text-center">Filtros</div>
                                            <div name="div_consultar_sinergia_filtros_corpo" class="div_consultar_sinergia_filtros_corpo text-center">
                                                <div name="div_consultar_sinergia_filtros_periodos" class="div_consultar_sinergia_filtros_periodos">
                                                    <div name="div_consultar_sinergia_filtros_periodos_titulo" class="div_consultar_sinergia_filtros_periodos_titulo rounded">Periodos</div>
                                                    <div name="div_consultar_sinergia_filtros_periodos_corpo" class="div_consultar_sinergia_filtros_periodos_corpo">
                                                        <div class="m-auto inputgroup input_group_mes_ano" style="max-width:max-content;" mes="0" ano="2022">
                                                        <div multiplo="0" class="div_combobox" id="div_mes" tem_inputs="1" tipo_inputs="radio" classe_botao="btn-dark" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_173992606" num_max_texto_botao="5">
                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(mes)</button>
                                                            <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_173992606" >JANEIRO</label></li>
                                                                <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_173992606">FEVEREIRO</label></li>
                                                                <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_173992606">MARCO</label></li>
                                                                <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_173992606">ABRIL</label></li>
                                                                <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_173992606">MAIO</label></li>
                                                                <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_173992606">JUNHO</label></li>
                                                                <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_173992606">JULHO</label></li>
                                                                <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_173992606">AGOSTO</label></li>
                                                                <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_173992606">SETEMBRO</label></li>
                                                                <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_173992606">OUTUBRO</label></li>
                                                                <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_173992606">NOVEMBRO</label></li>
                                                                <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_173992606">DEZEMBRO</label></li>
                                                            </ul>
                                                        </div>
                                                        <input class="form-control input_ano" type="number" step="1" value="2022">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div name="div_botao_pesquisar" class="div_botao_pesquisar row"><button name="botao_pesquisar" class="botao_pesquisar botao_padrao btn btn-primary w-50" value="Pesquisar" onclick="window.fnsisjd.pesquisar_itens_campanha_giro(this)" type="button" data-visao="consultar_itens_campanha_giro">Pesquisar</button></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div name="div_resultado_l1" class="div_resultado_l1 row">
                                    <div name="div_resultado" class="div_resultado col"></div>
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
    let hoje = fndt.hoje();
    let div_mes = $("div#div_mes");
    let mes = fndt.dataBR_getMes(hoje)-1;
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    let li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    let texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);
    //div_mes.find("input").val(fndt.dataBR_getAno(hoje));
</script>
</html>