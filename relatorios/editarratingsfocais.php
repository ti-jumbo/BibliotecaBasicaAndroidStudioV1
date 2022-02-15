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
    <title>SisJD - Editar Ratings Focais</title>
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
                        Editar Ratings Focais
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_03750383564173643 _0_39573824067161023">
                                <div></div>
                                <div name="div_editar_ratingsfocais" class="div_editar_ratingsfocais container-fluid corpo-conteudo" style="height:100%;" ajuda_elemento="Altere os ratings foco e seus dados!">
                                <div class="div_manutencao_opcoes_sistema_arvore_opcoes_container_row row m-1">
                                    <div name="div_manutencao_opcoes_sistema_arvore_opcoes_container" id="div_ratingsfoco_itens_rating" class="div_manutencao_opcoes_sistema_arvore_opcoes_container split col-3 m-1">
                                        <div class="div_manutencao_opcoes_sistema_arvore_opcoes_titulo_row row">
                                            <div class="div_manutencao_opcoes_sistema_arvore_opcoes_titulo_col col rounded-top bg-gray">
                                            <text name="div_manutencao_opcoes_sistema_arvore_opcoes_titulo" class="div_manutencao_opcoes_sistema_arvore_opcoes_titulo">Itens Rating Foco</text>
                                            </div>
                                        </div>
                                        <div class="div_manutencao_opcoes_sistema_arvore_opcoes_row row" style="min-height:100% !important;">
                                            <div name="div_manutencao_opcoes_sistema_arvore_opcoes" class="div_manutencao_opcoes_sistema_arvore_opcoes col border">__FNV_MONTAR_TABELA_ITENS_RATING_FOCO__</div>
                                        </div>
                                    </div>
                                    <div name="div_manutencao_opcoes_sistema_dados_opcoes_container" id="div_ratings_foco_componentes" class="div_manutencao_opcoes_sistema_dados_opcoes_container split col-8 m-1">
                                        <div class="div_manutencao_opcoes_sistema_dados_opcoes_titulo_row row">
                                            <div class="div_manutencao_opcoes_sistema_dados_opcoes_titulo_col col rounded-top bg-gray">
                                            <text name="div_manutencao_opcoes_sistema_dados_opcoes_titulo" class="div_manutencao_opcoes_sistema_dados_opcoes_titulo">DADOS DO ITEM DO RATING</text>
                                            </div>
                                        </div>
                                        <div name="div_dados_grupo_alterar" class="div_dados_grupo_alterar row" style="min-height:100% !important;">
                                            <div class="div_dados_grupo_alterar_col col border">
                                            <div name="div_dados_grupo_alterar_container div_abas" class="div_dados_grupo_alterar_container div_abas" style="width:100%;height:100%;overflow:hidden;">
                                                <div name="div_dados_grupos_alterar_container_orelhas div_abas_orelhas" class="div_dados_grupos_alterar_container_orelhas div_abas_orelhas">
                                                    <div name="div_dados_grupos_alterar_container_orelha0 div_aba_orelha" class="div_dados_grupos_alterar_container_orelha0 div_aba_orelha aberta" idaba="div_dados_grupos_alterar_container_aba0">Dados Item</div>
                                                    <div name="div_dados_grupos_alterar_container_orelha1 div_aba_orelha" class="div_dados_grupos_alterar_container_orelha1 div_aba_orelha" idaba="div_dados_grupos_alterar_container_aba1">Componentes Item Rating</div>
                                                    <div name="div_dados_campanhas_alterar_container_orelha2 div_aba_orelha" class="div_dados_campanhas_alterar_container_orelha2 div_aba_orelha" idaba="div_dados_campanhas_alterar_container_aba2">Condicionantes Item Rating</div>
                                                </div>
                                                <div name="div_dados_grupos_alterar_container_corpos div_abas_corpos" class="div_dados_grupos_alterar_container_corpos div_abas_corpos">
                                                    <div name="div_dados_grupos_alterar_container_corpo0 div_aba_corpo" class="div_dados_grupos_alterar_container_corpo0 div_aba_corpo aberta" idaba="div_dados_grupos_alterar_container_aba0">Dados Item (Clique num Item a esquerda para carregar os dados aqui!)</div>
                                                    <div name="div_dados_grupos_alterar_container_corpo1 div_aba_corpo" class="div_dados_grupos_alterar_container_corpo1 div_aba_corpo" idaba="div_dados_grupos_alterar_container_aba1">Integrantes Grupo Produto (Clique num grupo a esquerda para carregar os dados aqui!)</div>
                                                    <div name="div_dados_campanhas_alterar_container_corpo2 div_aba_corpo" class="div_dados_campanhas_alterar_container_corpo2 div_aba_corpo" idaba="div_dados_campanhas_alterar_container_aba2">__FNV_MONTAR_DIV_BOX_OPCAO_PADRAO__(['titulo'=&gt;'Condicionantes','class'=&gt;'div_condicionantes','permite_incluir'=&gt;true,'permite_excluir'=&gt;true,'funcao_inclusao'=&gt;'window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})'])<button name="botao_salvar_condicionantes" class="botao_salvar_condicionantes botao_padrao" value="Salvar Condicionantes" onclick="window.fnsisjd.salvar_condicionantes_item_rating_foco(this)" type="button">Salvar Condicionantes</button></div>
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