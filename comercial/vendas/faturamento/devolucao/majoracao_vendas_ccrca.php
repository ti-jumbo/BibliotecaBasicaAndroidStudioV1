<?php
    namespace SJD\comercial\vendas\faturamento\devolucao;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Editar Majoracao Vendas CC RCA</title>
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
                        Editar Majoracao Vendas CC RCA
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_8147321203112683 _0_3801383893130946">
                                <div></div>
                                <div name="div_majorar_vendas_ccrca" class="div_majorar_vendas_ccrca container-fluid corpo-conteudo" ajuda_elemento="Consulta e manutencao das majoracoes de vendas em conta corrente de rca." data-tit_aba="div_majorar_vendas_ccrca" data-nome="div_majorar_vendas_ccrca">
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
                                                            <div class="div_visoes accordion-item" titulo="Filtros" target="#visoes" aberto="1">
                                                                <div class="accordion-header" titulo="Filtros" target="#visoes" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#visoes" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="visoes">Filtros</div>
                                                                </div>
                                                                <div id="visoes" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <div class="row"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="consulta_majorar_ccrca" onclick="window.fnsisjd.pesquisar_dados(this)" visao="lista_majorar_ccrca" codprocesso="10900">Pesquisar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="div_resultado_l2 row">
                                    <div class="div_resultado col _0_9450877609193559 _0_781216069382724">
                                        <table class="_1713807408 tabdados" data-id_opcoes="1713807408" data-opcoes="{__ASPD__tabeladb__ASPD__:__ASPD__sjdmajorarccrca__ASPD__,__ASPD__campos_visiveis__ASPD__:[],__ASPD__campos_ocultos__ASPD__:[],__ASPD__usar_arr_tit__ASPD__:true,__ASPD__tipoelemento__ASPD__:__ASPD__tabela_est__ASPD__,__ASPD__tb2__ASPD__:__ASPD__false__ASPD__,__ASPD__cabecalho__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__visivel__ASPD__:true,__ASPD__filtro__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__ordenacao__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__ocultarcolunas__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__comandos__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__exportacao__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__inclusao__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__tipo__ASPD__:__ASPD__linha__ASPD__},__ASPD__compartilhar__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__mostrarcolunasocultas__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__outroscomandos__ASPD__:[]},__ASPD__celulasextras__ASPD__:[]},__ASPD__corpo__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__linhas__ASPD__:{__ASPD__aoclicar__ASPD__:__ASPD____ASPD__,__ASPD__aoduploclicar__ASPD__:__ASPD____ASPD__,__ASPD__comandos__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__exclusao__ASPD__:{__ASPD__ativo__ASPD__:true,__ASPD__aoexcluirlinha__ASPD__:__ASPD__window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})__ASPD__},__ASPD__edicao__ASPD__:{__ASPD__ativo__ASPD__:true},__ASPD__salvar__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__aosalvarnovalinha__ASPD__:__ASPD__window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})__ASPD__,__ASPD__aosalvaredicaolinha__ASPD__:__ASPD__window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})__ASPD__,__ASPD__aosalvaredicaocelula__ASPD__:__ASPD____ASPD__},__ASPD__copiar__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__aocopiar__ASPD__:__ASPD____ASPD__},__ASPD__anexos__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__aoclicar__ASPD__:__ASPD____ASPD__}},__ASPD__linha_padrao__ASPD__:{__ASPD__dados__ASPD__:[]},__ASPD__valores_padrao__ASPD__:[],__ASPD__marcar__ASPD__:true,__ASPD__marcarmultiplo__ASPD__:false,__ASPD__classemarcacao__ASPD__:__ASPD__marcada__ASPD__,__ASPD__campos_combobox__ASPD__:[]},__ASPD__subelementos_colunas__ASPD__:[],__ASPD__classe_colunas__ASPD__:[],__ASPD__subelementos_linhas_colunas__ASPD__:[],__ASPD__branco_se_zero__ASPD__:false,__ASPD__celulasextras__ASPD__:[],__ASPD__propriedades_colunas__ASPD__:[]},__ASPD__valores_celulas_linhas_calculos__ASPD__:[],__ASPD__celulas_linhas_calculos__ASPD__:[],__ASPD__campo_contador__ASPD__:null,__ASPD__rodape__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__linhasextras__ASPD__:[],__ASPD__celulasextras__ASPD__:[]},__ASPD__selecao__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__tipo__ASPD__:__ASPD__checkbox__ASPD__,__ASPD__selecionar_pela_linha__ASPD__:true,__ASPD__selecionar_todos__ASPD__:true},__ASPD__subregistros__ASPD__:{__ASPD__ativo__ASPD__:false,__ASPD__aoabrir__ASPD__:__ASPD____ASPD__,__ASPD__campo_subregistro__ASPD__:__ASPD____ASPD__,__ASPD__campo_subregistro_pai__ASPD__:__ASPD____ASPD__},__ASPD__inclusao__ASPD__:{__ASPD__ativo__ASPD__:false},__ASPD__campos_chaves_primaria__ASPD__:[__ASPD__CODREG__ASPD__],__ASPD__campos_chaves_unica__ASPD__:[],__ASPD__aoincluirregistro__ASPD__:[],__ASPD__mantercombobox__ASPD__:false,__ASPD__numlinhaslimitrecursos__ASPD__:30000,__ASPD__usar_condicionantes_arr_tit__ASPD__:true}" tabeladb="sjdmajorarccrca" codprocesso="10900" mantercombobox="false" campos_chaves_primaria="codreg" campos_chaves_unica="" campos_visiveis="" subregistros="false" aoabrir="" campo_subregistro="" campo_subregistro_pai="" edicao_ativa="true" aosalvarnovalinha="window.fnhtml.fntabdados.incluir_dados_sql_padrao({elemento:this})" aosalvaredicaolinha="window.fnhtml.fntabdados.atualizar_dados_sql_padrao({elemento:this})" exclusao_ativa="true" aoexcluirlinha="window.fnhtml.fntabdados.excluir_dados_sql_padrao({elemento:this})" marcar="true" classemarcacao="marcada" marcarmultiplo="false" classemarcrequisitaracao="dados_sql" tipo_dados="tabelaest" inclusao_ativa="true" aoincluirregistro="" inclusao_tipo="linha">
                                            <colgroup>
                                            <col class="cel_numint">
                                            <col class="cel_texto">
                                            <col class="cel_numint">
                                            <col class="cel_perc">
                                            <col class="cel_perc">
                                            <col class="cel_valor">
                                            <col class="cel_valor">
                                            <col class="cel_valor">
                                            <col class="cel_valor">
                                            <col class="cel_texto">
                                            </colgroup>
                                            <thead>
                                            <tr class="linhacomandos">
                                                <th class="col_comandos" colspan="999" style="background-color:black;text-align:left;padding:2px;"><button class="btncomandos item_destaque_hover btn btn-secondary" onclick="window.fnhtml.fntabdados.acrescentar_registro(this)" title="Acrescentar" textodepois="1"><img class="imgbtncomandos" src="\sjd/images/maisverde32.png">Acrescentar</button><button class="btncomandos item_destaque_hover btn btn-secondary" onclick="window.fnhtml.fntabdados.exportar_dados(this)" title="Exportar" textodepois="1"><img class="imgbtncomandos" src="\sjd/images/exportar1_32.png">Exportar</button><button class="btncomandos item_destaque_hover btn btn-secondary" onclick="window.fnhtml.fntabdados.compartilhar_dados(event,this)" title="Compartilhar esta tabela" textodepois="1"><img class="imgbtncomandos" src="\sjd/images/tabela_est/compartilhar.png">Compartilhar</button></th>
                                            </tr>
                                            <tr class="linhatitulos">
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_numint" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="0" codsup="-1" data-campodb="codreg" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="0">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">CODREG</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_texto" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="1" codsup="-1" data-campodb="visao" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="1">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">VISAO</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_numint" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="2" codsup="-1" data-campodb="coditem" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="2">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">CODITEM</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_perc" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="3" codsup="-1" data-campodb="percdescmin" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="3">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">PERCDESCMIN</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_perc" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="4" codsup="-1" data-campodb="percdescmax" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="4">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">PERCDESCMAX</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_valor" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="5" codsup="-1" data-campodb="majorarvldesconto" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="5">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">MAJORARVLDESCONTO</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_valor" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="6" codsup="-1" data-campodb="majorarvlvenda" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="6">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">MAJORARVLVENDA</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_valor" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="7" codsup="-1" data-campodb="multiplicadorvalor" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="7">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">MULTIPLICADORVALOR</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_valor" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="8" codsup="-1" data-campodb="mantervalorpositivo" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="8">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">MANTERVALORPOSITIVO</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_tit_campodb clicavel celula_final_tit   cel_texto" visivel="1" visivel_inclusao="1" title="clique para ordenar" cod="9" codsup="-1" data-campodb="considmajoracaojumbo" onclick="window.fnhtml.fntabdados.ordenar_tabdados(event,this)" indexreal="9">
                                                    <div class="div_conteudo_celula_titulo d-flex">
                                                        <text class="txttit w-auto m-auto">CONSIDMAJORACAOJUMBO</text>
                                                        <img class="imgord item_destaque50pct_hover" src="\sjd/images/green-unsorted.gif"><img class="img_ocultar_col item_destaque50pct_hover" src="\sjd/images/esconder.png" onclick="window.fnhtml.fntabdados.ocultar_coluna(event,this)" style="width:16px;" title="Ocultar esta coluna">
                                                    </div>
                                                </th>
                                                <th class="cel_cmd_tit" cod="10" codsup="-1" indexreal="10">
                                                    <text class="txttit item_destaque_hover  w-auto m-auto">CMD</text>
                                                </th>
                                            </tr>
                                            <tr class="linhafiltros">
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_filtro"><input type="text" class="inputfiltro" placeholder="(filtro)" onkeyup="window.fnhtml.fntabdados.filtrar_tabdados(event,this)" title="filtro"><img class="imglimparfiltro clicavel invisivel" src="\sjd/images/deletar1_32.png" onclick="window.fnhtml.fntabdados.limpar_filtro_tabela_est(this)"></th>
                                                <th class="cel_tit_cmd_filtro"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="_0_16100120695314657"></tbody>
                                        </table>
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
</html>