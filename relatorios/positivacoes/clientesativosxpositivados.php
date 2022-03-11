<?php
    namespace SJD\relatorios\positivacoes;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/header.php';
?>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/topbar.php'; ?>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_09957336080642598 _0_1404455053826672">
                                <div></div>
                                <div name="div_clientesativosxpositivados" class="div_clientesativosxpositivados container-fluid corpo-conteudo" ajuda_elemento="Escolha suas opcoes e consulte os clientes positivados !" data-tit_aba="clientes ativos" data-tit_aba_img="../images/img_aba_camp.png">
                                <div name="div_consultar_sinergia_subtitulo" class="div_consultar_sinergia_subtitulo row">
                                    <div name="div_consultar_sinergia_subtitulo_col" class="div_consultar_sinergia_subtitulo_col col m-1">
                                        <div name="div_consultar_sinergia_filtros" class="div_consultar_sinergia_filtros row">
                                            <div name="div_consultar_sinergia_filtros" class="div_consultar_sinergia_filtros col border rounded mr-1">
                                            <div name="div_consultar_sinergia_filtros_titulo" class="div_consultar_sinergia_filtros_titulo  background_cinza rounded-top text-center">Filtros</div>
                                            <div name="div_consultar_sinergia_filtros_corpo" class="div_consultar_sinergia_filtros_corpo text-center">
                                                <div name="div_consultar_sinergia_filtros_filtros" class="div_consultar_sinergia_filtros_filtros ">
                                                    <div name="div_consultar_sinergia_filtros_filial" class="div_consultar_sinergia_filtros_filial">
                                                        <div name="div_consultar_sinergia_filtros_filial_tit" class="div_consultar_sinergia_filtros_filial_tit rounded-top bg-gray">Filial</div>
                                                        <div name="div_consultar_sinergia_filtros_filial_corpo" class="div_consultar_sinergia_filtros_filial_corpo border"><input name="div_consultar_sinergia_filtros_filial_corpo_edit" class="div_consultar_sinergia_filtros_filial_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.filtrar_clientesativosxposit(this)'})"></div>
                                                    </div>
                                                    <div name="div_consultar_sinergia_filtros_superv" class="div_consultar_sinergia_filtros_superv">
                                                        <div name="div_consultar_sinergia_filtros_superv_tit" class="div_consultar_sinergia_filtros_superv_tit rounded-top bg-gray">Supervisor</div>
                                                        <div name="div_consultar_sinergia_filtros_superv_corpo" class="div_consultar_sinergia_filtros_superv_corpo border"><input name="div_consultar_sinergia_filtros_superv_corpo_edit" class="div_consultar_sinergia_filtros_superv_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.filtrar_clientesativosxposit(this)'})"></div>
                                                    </div>
                                                    <div name="div_consultar_sinergia_filtros_rca" class="div_consultar_sinergia_filtros_rca">
                                                        <div name="div_consultar_sinergia_filtros_rca_tit" class="div_consultar_sinergia_filtros_rca_tit rounded-top bg-gray">Rca</div>
                                                        <div name="div_consultar_sinergia_filtros_rca_corpo" class="div_consultar_sinergia_filtros_rca_corpo border"><input name="div_consultar_sinergia_filtros_rca_corpo_edit" class="div_consultar_sinergia_filtros_rca_corpo_edit input_entidade" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:'window.fnsisjd.filtrar_clientesativosxposit(this)'})"></div>
                                                    </div>
                                                </div>
                                                <div name="div_consultar_sinergia_filtros_periodos" class="div_consultar_sinergia_filtros_periodos">
                                                    <div name="div_consultar_sinergia_filtros_periodos_titulo" class="div_consultar_sinergia_filtros_periodos_titulo rounded">Periodos</div>
                                                    <div name="div_consultar_sinergia_filtros_periodos_corpo" class="div_consultar_sinergia_filtros_periodos_corpo">
                                                        <div name="div_consultar_sinergia_filtros_periodo1" class="div_consultar_sinergia_filtros_periodo1">
                                                        <div name="div_consultar_sinergia_filtros_periodo1_tit" class="div_consultar_sinergia_filtros_periodo1_tit rounded-top bg-gray">Inicio</div>
                                                        <div id="div_mes1" name="div_consultar_sinergia_filtros_periodo1_corpo" class="div_consultar_sinergia_filtros_periodo1_corpo border">
                                                            <div name="div_consultar_sinergia_filtros_periodo1_corpo_mes" class="div_consultar_sinergia_filtros_periodo1_corpo_mes">
                                                                <div name="div_consultar_sinergia_filtros_periodo1_corpo_mes_tit" class="div_consultar_sinergia_filtros_periodo1_corpo_mes_tit rounded">Mes</div>
                                                                <div name="div_consultar_sinergia_filtros_periodo1_corpo_mes_corpo" class="div_consultar_sinergia_filtros_periodo1_corpo_mes_corpo">
                                                                    <div classe_botao="btn-dark" class="div_combobox" tem_inputs="1" tipo_inputs="radio" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_1533093521" num_max_texto_botao="5">
                                                                    <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(mes)</button>
                                                                    <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                        <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_1533093521">JANEIRO</label></li>
                                                                        <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_1533093521">FEVEREIRO</label></li>
                                                                        <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_1533093521">MARCO</label></li>
                                                                        <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_1533093521">ABRIL</label></li>
                                                                        <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_1533093521">MAIO</label></li>
                                                                        <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_1533093521">JUNHO</label></li>
                                                                        <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_1533093521">JULHO</label></li>
                                                                        <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_1533093521">AGOSTO</label></li>
                                                                        <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_1533093521">SETEMBRO</label></li>
                                                                        <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_1533093521">OUTUBRO</label></li>
                                                                        <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_1533093521">NOVEMBRO</label></li>
                                                                        <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_1533093521">DEZEMBRO</label></li>
                                                                    </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div name="div_consultar_sinergia_filtros_periodo1_corpo_ano" class="div_consultar_sinergia_filtros_periodo1_corpo_ano">
                                                                <div name="div_consultar_sinergia_filtros_periodo1_corpo_ano_tit" class="div_consultar_sinergia_filtros_periodo1_corpo_ano_tit rounded">Ano</div>
                                                                <div name="div_consultar_sinergia_filtros_periodo1_corpo_ano_corpo" class="div_consultar_sinergia_filtros_periodo1_corpo_ano_corpo"><input class="input_ano" type="number" value="2022"></div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        <div name="div_consultar_sinergia_filtros_periodo2" class="div_consultar_sinergia_filtros_periodo2">
                                                        <div name="div_consultar_sinergia_filtros_periodo2_tit" class="div_consultar_sinergia_filtros_periodo2_tit rounded-top bg-gray">Fim</div>
                                                        <div id="div_mes2" name="div_consultar_sinergia_filtros_periodo2_corpo" class="div_consultar_sinergia_filtros_periodo2_corpo border">
                                                            <div name="div_consultar_sinergia_filtros_periodo2_corpo_mes" class="div_consultar_sinergia_filtros_periodo2_corpo_mes">
                                                                <div name="div_consultar_sinergia_filtros_periodo2_corpo_mes_tit" class="div_consultar_sinergia_filtros_periodo2_corpo_mes_tit rounded">Mes</div>
                                                                <div name="div_consultar_sinergia_filtros_periodo2_corpo_mes_corpo" class="div_consultar_sinergia_filtros_periodo2_corpo_mes_corpo">
                                                                    <div classe_botao="btn-dark" class="div_combobox" tem_inputs="1" tipo_inputs="radio" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_895784230" num_max_texto_botao="5">
                                                                    <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(mes)</button>
                                                                    <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                        <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_895784230">JANEIRO</label></li>
                                                                        <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_895784230">FEVEREIRO</label></li>
                                                                        <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_895784230">MARCO</label></li>
                                                                        <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_895784230">ABRIL</label></li>
                                                                        <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_895784230">MAIO</label></li>
                                                                        <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_895784230">JUNHO</label></li>
                                                                        <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_895784230">JULHO</label></li>
                                                                        <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_895784230">AGOSTO</label></li>
                                                                        <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_895784230">SETEMBRO</label></li>
                                                                        <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_895784230">OUTUBRO</label></li>
                                                                        <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_895784230">NOVEMBRO</label></li>
                                                                        <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_895784230">DEZEMBRO</label></li>
                                                                    </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div name="div_consultar_sinergia_filtros_periodo2_corpo_ano" class="div_consultar_sinergia_filtros_periodo2_corpo_ano">
                                                                <div name="div_consultar_sinergia_filtros_periodo2_corpo_ano_tit" class="div_consultar_sinergia_filtros_periodo2_corpo_ano_tit rounded">Ano</div>
                                                                <div name="div_consultar_sinergia_filtros_periodo2_corpo_ano_corpo" class="div_consultar_sinergia_filtros_periodo2_corpo_ano_corpo"><input class="input_ano" type="number" value="2022"></div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div name="div_botao_pesquisar" class="div_botao_pesquisar row"><button name="botao_pesquisar" class="btn btn-primary botao_pesquisar botao_padrao" value="Filtrar" onclick="window.fnsisjd.filtrar_clientesativosxposit(this)" type="button">Filtrar</button></div>
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
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    const {default:fndt} = await import("/sjd/javascript/modulos/classes/data/FuncoesData.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    fnsisjd.requisitar_data_aurora();
    let hoje = fndt.hoje();
    let div_mes = $("div#div_mes1");
    let mes = fndt.dataBR_getMes(hoje)-1;
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    let li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    let texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);

    div_mes = $("div#div_mes2");
    div_mes.find("ul.dropdown-menu").find("input").prop("checked",false);
    div_mes.find("ul.dropdown-menu").find("input").removeAttr("checked");
    li = div_mes.find("ul.dropdown-menu").children("li").eq(mes);
    li.find("input").prop("checked",true);
    texto = li.attr("opcoes_texto_opcao");
    div_mes.find("button").text(texto);
    //div_mes.find("input").val(fndt.dataBR_getAno(hoje));
</script>
</html>