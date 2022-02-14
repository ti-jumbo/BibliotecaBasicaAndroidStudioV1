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
    <title>SisJD - Relatorio Personalizado</title>
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
                        relatorio personalizado
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
               <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                  <div name="div_grid_linha_corpo_pagina" class="row">
                     <div name="div_grid_col_corpo_pagina" class="col">
                        <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_38420515675307443 _0_1897069491958141">
                           <div></div>
                           <div name="div_relatorio_personalizado" class="div_relatorio_personalizado container-fluid corpo-conteudo" ajuda_elemento="Escolha uma ou mais visoes, um ou mais periodos, condicionantes, tipos de valores para ver seu relatorio personalizado!" data-tit_aba="Relatorio Personalizado Teste" data-nome="aba_rel_person">
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
                                                                  <img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" title="Acrescentar um item">
                                                                  <div class="row">
                                                                     
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
                                                                  <img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" title="Acrescentar um item">
                                                                  <div class="row">
                                                                     
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
                                                                                       <div class="col">
                                                                                          <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                                                                                             <input type="checkbox" class="checkbox_ver_valores_de" value="0" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)">Qtde
                                                                                          </label>
                                                                                          <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                                                                                                <input type="checkbox" class="checkbox_ver_valores_de" value="3" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" checked="true">Peso Total
                                                                                          </label>
                                                                                          <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                                                                                                <input type="checkbox" class="checkbox_ver_valores_de" value="5" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" checked="true">Valor Total
                                                                                          </label>
                                                                                          <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                                                                                                <input type="checkbox" class="checkbox_ver_valores_de" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)">Todos
                                                                                          </label>
                                                                                       </div>
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
                                                                           <div class="div_campos_avulsos accordion-item" titulo="Campos Avulsos" target="#painel_campos_avulsos">
                                                                              <div class="accordion-header" titulo="Campos Avulsos" target="#painel_campos_avulsos">
                                                                                 <div data-bs-toggle="collapse" data-bs-target="#painel_campos_avulsos" class="accordion-button collapsed" type="button" aria-expanded="false" aria-controls="painel_campos_avulsos">Campos Avulsos</div>
                                                                              </div>
                                                                              <div id="painel_campos_avulsos" class="collapse">
                                                                                 <div class="accordion-body">
                                                                                    <div class="row">
                                                                                       <div class="col-auto mt-2 div_visao">
                                                                                          <div class="card">
                                                                                             <div class="card-header">Campos Avulsos</div>
                                                                                             <div class="card-body">
                                                                                                <div class="row">
                                                                                                   <div class="col">
                                                                                                      <div label="Campos Avulsos" classe_botao="btn-dark" aoabrir="window.fnsisjd.incluir_options_campo_avulso(this)" tem_inputs="1" tipo_inputs="checkbox" multiplo="1" selecionar_todos="1" filtro="1" class="div_combobox" data-visao="" data-visao_atual="campos_avulsos" placeholder="(Selecione)" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                                                                         <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">(Selecione)</button>
                                                                                                         <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)"><label class="label_selecionar_todos" textodepois="1"><input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">Selecionar Todos</label><input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)"></ul>
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
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="relatorio_personalizado" onclick="window.fnsisjd.pesquisar_dados(this)">Pesquisar</button></div>
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
   window.fnsisjd.requisitar_data_aurora();
   window.fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes img.btn_img_add_geral")});
   window.fnsisjd.inserir_periodo_pesquisa({elemento:$("div#periodos img.btn_img_add_geral")});
</script>
</html>