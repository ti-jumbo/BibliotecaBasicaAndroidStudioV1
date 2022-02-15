<?php
    namespace SJD\relatorios\campanhas\alterar_campanhas;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Processamentos Campanhas</title>
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
                        Processamentos Campanhas
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_4553626794470593 _0_31848698654436713">
                                <div></div>
                                <div name="div_processamentos_campanhas" class="div_processamentos_campanhas container-fluid corpo-conteudo" ajuda_elemento="Processamentos campanhas">
                                <div name="div_botao_atualizar_realizado_objetivos_sinergia" class="div_botao_atualizar_realizado_objetivos_sinergia borda_1px_cinza margin_5px">
                                    <div name="div_opcoes_periodo" class="div_opcoes periodos">
                                        <div name="div_opcoes_cab" class="div_opcoes_cab">
                                            <div name="div_opcoes_cab_tit" class="div_opcoes_cab_tit">Periodo</div>
                                            <img name="img_ajuda3" class="img_ajuda mousehover clicavel float_right" src="\sjd/images/ajuda16.png" onclick="window.ajuda_suspensa({event:event,elemento:this})" data-status="invisivel" data-tipo="periodo">
                                        </div>
                                        <div name="div_opcoes_corpo" class="div_opcoes_corpo">
                                            <div name="div_opcoes_corpo_opcoes" class="div_opcoes_corpo_opcoes" data-ind="1">
                                            <div name="div_opcao" class="div_opcao">
                                                <div name="div_opcao_tit" class="div_opcao_tit">Periodo 01</div>
                                                <div name="div_opcao_controles" class="div_opcao_controles">
                                                    <input name="caixa_texto" id="input_udtini" class="componente_data controle_input_texto" value="01/01/2022" title="Clique para abrir o calendario" type="text"><input name="caixa_texto" id="input_udtfim" class="componente_data controle_input_texto" value="24/01/2022" title="Clique para abrir o calendario" type="text">
                                                    <div name="div_meses_inf" class="div_meses_inf"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jan.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/fev.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/mar.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/abr.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/mai.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jun.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jul.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/ago.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/set.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/out.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/nov.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/dez.png" title="Preenche as datas com este mes inteiro" type="imagem"><input name="inputano" id="inputano" class="inputano" value="2022" title="Ano para preenchimento do mes inteiro" type="caixa_texto"></div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button name="botao_atualizar_realizado_objetivos_sinergia" class="botao_atualizar_realizado_objetivos_sinergia botao_padrao" onclick="window.fnsisjd.atualizar_realizado_objetivos_sinergia(this);">Atualizar realizado objetivos sinergia</button>
                                </div>
                                <div name="div_botao_atualizar_realizado_objetivos_campanhas_estruturadas" class="div_botao_atualizar_realizado_objetivos_campanhas_estruturadas borda_1px_cinza margin_5px padding_10px">
                                    <div name="div_opcoes_periodo" class="div_opcoes periodos">
                                        <div name="div_opcoes_cab" class="div_opcoes_cab">
                                            <div name="div_opcoes_cab_tit" class="div_opcoes_cab_tit">Periodo</div>
                                            <img name="img_ajuda3" class="img_ajuda mousehover clicavel float_right" src="\sjd/images/ajuda16.png" onclick="window.fnsisjd.ajuda_suspensa({event:event,elemento:this})" data-status="invisivel" data-tipo="periodo">
                                        </div>
                                        <div name="div_opcoes_corpo" class="div_opcoes_corpo">
                                            <div name="div_opcoes_corpo_opcoes" class="div_opcoes_corpo_opcoes" data-ind="1">
                                            <div name="div_opcao" class="div_opcao">
                                                <div name="div_opcao_tit" class="div_opcao_tit">Periodo 01</div>
                                                <div name="div_opcao_controles" class="div_opcao_controles">
                                                    <input name="caixa_texto" id="input_udtini" class="componente_data controle_input_texto" value="01/01/2022" title="Clique para abrir o calendario" type="text"><input name="caixa_texto" id="input_udtfim" class="componente_data controle_input_texto" value="24/01/2022" title="Clique para abrir o calendario" type="text">
                                                    <div name="div_meses_inf" class="div_meses_inf"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jan.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/fev.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/mar.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/abr.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/mai.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jun.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/jul.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/ago.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/set.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/out.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/nov.png" title="Preenche as datas com este mes inteiro" type="imagem"><img name="imgjan" id="imgjan" class="imagem_mes_calendario item_destaque100pct_hover" src="\sjd/images/calendario/dez.png" title="Preenche as datas com este mes inteiro" type="imagem"><input name="inputano" id="inputano" class="inputano" value="2022" title="Ano para preenchimento do mes inteiro" type="caixa_texto"></div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button name="botao_atualizar_realizado_objetivos_campanhas_estruturadas" class="botao_atualizar_realizado_objetivos_campanhas_estruturadas botao_padrao" onclick="window.fnsisjd.atualizar_realizado_objetivos_campanhas_estruturadas(this);">Atualizar realizado objetivos Campanhas Estruturadas</button>
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