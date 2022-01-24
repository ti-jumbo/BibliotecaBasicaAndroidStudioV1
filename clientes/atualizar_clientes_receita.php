<?php
    namespace SJD\clientes;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Atualizar Dados Clientes da RFB</title>
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
                        Atualizar Dados Clientes da RFB
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_36980632246946166 _0_8128521101847173">
                                <div></div>
                                <div name="div_atualizar_clientes_rfb" class="div_atualizar_clientes_rfb container-fluid corpo-conteudo" data-tit_aba="Atualizar Clientes RFB" data-nome="aba_atualizar_clientes_rfb">
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
                                                            <div class="div_visoes accordion-item" titulo="Listar Clientes e Confrontar e ou Atualizar" target="#visoes" aberto="1">
                                                                <div class="accordion-header" titulo="Listar Clientes e Confrontar e ou Atualizar" target="#visoes" aberto="1">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#visoes" aberto="1" class="accordion-button" type="button" aria-expanded="true" aria-controls="visoes">Listar Clientes e Confrontar e ou Atualizar</div>
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
                                                                                        <div label="Visao 01" tem_inputs="1" tipo_inputs="radio" multiplo="0" selecionar_todos="0" filtro="1" classe_botao="btn-dark" classe_dropdown="dropdown-visao " class="div_combobox" placeholder="(Selecione)" name_inpus="_1656095551" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Cliente</button>
                                                                                            <ul class="dropdown-menu dropdown-visao" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                                                            <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                            <li opcoes_texto_opcao="Origem de Dados" opcoes_texto_botao="Origem de Dados" opcoes_valor_opcao="Origem de Dados" class="dropdown-item li" data-valor_opcao="Origem de Dados" data-texto_botao="Origem de Dados"><label textodepois="1"><input type="radio" name="_1656095551">Origem de Dados</label></li>
                                                                                            <li opcoes_texto_opcao="Empresa" opcoes_texto_botao="Empresa" opcoes_valor_opcao="Empresa" class="dropdown-item li" data-valor_opcao="Empresa" data-texto_botao="Empresa"><label textodepois="1"><input type="radio" name="_1656095551">Empresa</label></li>
                                                                                            <li opcoes_texto_opcao="Filial" opcoes_texto_botao="Filial" opcoes_valor_opcao="Filial" class="dropdown-item li" data-valor_opcao="Filial" data-texto_botao="Filial"><label textodepois="1"><input type="radio" name="_1656095551">Filial</label></li>
                                                                                            <li opcoes_texto_opcao="Fornecedor" opcoes_texto_botao="Fornecedor" opcoes_valor_opcao="Fornecedor" class="dropdown-item li" data-valor_opcao="Fornecedor" data-texto_botao="Fornecedor"><label textodepois="1"><input type="radio" name="_1656095551">Fornecedor</label></li>
                                                                                            <li opcoes_texto_opcao="Cidade" opcoes_texto_botao="Cidade" opcoes_valor_opcao="Cidade" class="dropdown-item li" data-valor_opcao="Cidade" data-texto_botao="Cidade"><label textodepois="1"><input type="radio" name="_1656095551">Cidade</label></li>
                                                                                            <li opcoes_texto_opcao="Supervisor" opcoes_texto_botao="Supervisor" opcoes_valor_opcao="Supervisor" class="dropdown-item li" data-valor_opcao="Supervisor" data-texto_botao="Supervisor"><label textodepois="1"><input type="radio" name="_1656095551">Supervisor</label></li>
                                                                                            <li opcoes_texto_opcao="Rca" opcoes_texto_botao="Rca" opcoes_valor_opcao="Rca" class="dropdown-item li" data-valor_opcao="Rca" data-texto_botao="Rca"><label textodepois="1"><input type="radio" name="_1656095551">Rca</label></li>
                                                                                            <li opcoes_texto_opcao="Ramo de Atividade" opcoes_texto_botao="Ramo de Atividade" opcoes_valor_opcao="Ramo de Atividade" class="dropdown-item li" data-valor_opcao="Ramo de Atividade" data-texto_botao="Ramo de Atividade"><label textodepois="1"><input type="radio" name="_1656095551">Ramo de Atividade</label></li>
                                                                                            <li opcoes_texto_opcao="Departamento" opcoes_texto_botao="Departamento" opcoes_valor_opcao="Departamento" class="dropdown-item li" data-valor_opcao="Departamento" data-texto_botao="Departamento"><label textodepois="1"><input type="radio" name="_1656095551">Departamento</label></li>
                                                                                            <li opcoes_texto_opcao="Produto" opcoes_texto_botao="Produto" opcoes_valor_opcao="Produto" class="dropdown-item li" data-valor_opcao="Produto" data-texto_botao="Produto"><label textodepois="1"><input type="radio" name="_1656095551">Produto</label></li>
                                                                                            <li opcoes_texto_opcao="Evolucao" opcoes_texto_botao="Evolucao" opcoes_valor_opcao="Evolucao" class="dropdown-item li" data-valor_opcao="Evolucao" data-texto_botao="Evolucao"><label textodepois="1"><input type="radio" name="_1656095551">Evolucao</label></li>
                                                                                            <li opcoes_texto_opcao="Cliente" opcoes_texto_botao="Cliente" opcoes_valor_opcao="Cliente" class="dropdown-item li" data-valor_opcao="Cliente" data-texto_botao="Cliente"><label textodepois="1"><input type="radio" name="_1656095551" checked="1">Cliente</label></li>
                                                                                            <li opcoes_texto_opcao="Nota Fiscal" opcoes_texto_botao="Nota Fiscal" opcoes_valor_opcao="Nota Fiscal" class="dropdown-item li" data-valor_opcao="Nota Fiscal" data-texto_botao="Nota Fiscal"><label textodepois="1"><input type="radio" name="_1656095551">Nota Fiscal</label></li>
                                                                                            <li opcoes_texto_opcao="Item de Nota Fiscal" opcoes_texto_botao="Item de Nota Fiscal" opcoes_valor_opcao="Item de Nota Fiscal" class="dropdown-item li" data-valor_opcao="Item de Nota Fiscal" data-texto_botao="Item de Nota Fiscal"><label textodepois="1"><input type="radio" name="_1656095551">Item de Nota Fiscal</label></li>
                                                                                            <li opcoes_texto_opcao="Rota" opcoes_texto_botao="Rota" opcoes_valor_opcao="Rota" class="dropdown-item li" data-valor_opcao="Rota" data-texto_botao="Rota"><label textodepois="1"><input type="radio" name="_1656095551">Rota</label></li>
                                                                                            <li opcoes_texto_opcao="Praca" opcoes_texto_botao="Praca" opcoes_valor_opcao="Praca" class="dropdown-item li" data-valor_opcao="Praca" data-texto_botao="Praca"><label textodepois="1"><input type="radio" name="_1656095551">Praca</label></li>
                                                                                            <li opcoes_texto_opcao="Negocio Aurora" opcoes_texto_botao="Negocio Aurora" opcoes_valor_opcao="Negocio Aurora" class="dropdown-item li" data-valor_opcao="Negocio Aurora" data-texto_botao="Negocio Aurora"><label textodepois="1"><input type="radio" name="_1656095551">Negocio Aurora</label></li>
                                                                                            <li opcoes_texto_opcao="Categoria Aurora" opcoes_texto_botao="Categoria Aurora" opcoes_valor_opcao="Categoria Aurora" class="dropdown-item li" data-valor_opcao="Categoria Aurora" data-texto_botao="Categoria Aurora"><label textodepois="1"><input type="radio" name="_1656095551">Categoria Aurora</label></li>
                                                                                            <li opcoes_texto_opcao="Rede de clientes" opcoes_texto_botao="Rede de clientes" opcoes_valor_opcao="Rede de clientes" class="dropdown-item li" data-valor_opcao="Rede de clientes" data-texto_botao="Rede de clientes"><label textodepois="1"><input type="radio" name="_1656095551">Rede de clientes</label></li>
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
                                                            <div class="avancado div_avancado accordion-item" titulo="Avancado" target="#avancada">
                                                                <div class="accordion-header" titulo="Avancado" target="#avancada">
                                                                    <div data-bs-toggle="collapse" data-bs-target="#avancada" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="avancada">Avancado</div>
                                                                </div>
                                                                <div id="avancada" class="collapse">
                                                                    <div class="accordion-body">
                                                                    <div class="div_opcoes_pesquisa_avancada row">
                                                                        <div class="div_opcoes_pesquisa_avancada_col col">
                                                                            <div class="accordion">
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
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="lista_clientes_atualizar_rfb" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button name="botao_pesquisar" class="botao_pesquisar botao_padrao" value="Atualizar a base" onclick="window.fnsisjd.atualizar_clientes_rfb(this)" type="button" data-visao="atualizar_clientes_rfb">Atualizar a base</button>
                                <div name="div_dados_cliente_rfb_consultar_container div_abas" class="div_dados_cliente_rfb_consultar_container div_abas" style="width:100%;height:100%;overflow:hidden;">
                                    <div name="div_dados_cliente_rfb_consultar_container_orelhas div_abas_orelhas" class="div_dados_cliente_rfb_consultar_container_orelhas div_abas_orelhas">
                                        <div name="div_dados_cliente_rfb_consultar_container_orelha0 div_aba_orelha" class="div_dados_cliente_rfb_consultar_container_orelha0 div_aba_orelha aberta" idaba="div_dados_cliente_rfb_consultar_container_aba0">Resultado Pesquisa Cliente</div>
                                        <div name="div_dados_cliente_rfb_consultar_container_orelha1 div_aba_orelha" class="div_dados_cliente_rfb_consultar_container_orelha1 div_aba_orelha" idaba="div_dados_cliente_rfb_consultar_container_aba1">Dados Cliente</div>
                                    </div>
                                    <div name="div_dados_cliente_rfb_consultar_container_corpos div_abas_corpos" class="div_dados_cliente_rfb_consultar_container_corpos div_abas_corpos">
                                        <div name="div_dados_cliente_rfb_consultar_container_corpo0 div_aba_corpo" class="div_dados_cliente_rfb_consultar_container_corpo0 div_aba_corpo aberta" idaba="div_dados_cliente_rfb_consultar_container_aba0">
                                            Resultado Pesquisa
                                            <div name="div_resultado" class="div_resultado"></div>
                                        </div>
                                        <div name="div_dados_cliente_rfb_consultar_container_corpo1 div_aba_corpo" class="div_dados_cliente_rfb_consultar_container_corpo1 div_aba_corpo" idaba="div_dados_cliente_rfb_consultar_container_aba1">
                                            Dados Cliente
                                            <div name="div_dados_cliente_rfb_carregado_consultar_container div_abas" class="div_dados_cliente_rfb_carregado_consultar_container div_abas" style="width:100%;height:100%;overflow:hidden;">
                                            <div name="div_dados_cliente_rfb_carregado_consultar_container_orelhas div_abas_orelhas" class="div_dados_cliente_rfb_carregado_consultar_container_orelhas div_abas_orelhas">
                                                <div name="div_dados_cliente_rfb_carregado_consultar_container_orelha0 div_aba_orelha" class="div_dados_cliente_rfb_carregado_consultar_container_orelha0 div_aba_orelha aberta" idaba="div_dados_cliente_rfb_carregado_consultar_container_aba0">Cliente</div>
                                            </div>
                                            <div name="div_dados_cliente_rfb_carregado_consultar_container_corpos div_abas_corpos" class="div_dados_cliente_rfb_carregado_consultar_container_corpos div_abas_corpos">
                                                <div name="div_dados_cliente_rfb_carregado_consultar_container_corpo0 div_aba_corpo" class="div_dados_cliente_rfb_carregado_consultar_container_corpo0 div_aba_corpo aberta" idaba="div_dados_cliente_rfb_carregado_consultar_container_aba0"></div>
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
</html>