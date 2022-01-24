<?php
    namespace SJD\manutencao;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Atualizacoes Eventuais Sistema</title>
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
                        Atualizacoes Eventuais Sistema
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_11048522940770489 _0_468611124890721">
                                <div></div>
                                <div name="div_atualizacoes_eventuais" class="div_atualizacoes_eventuais container-fluid corpo-conteudo">
                                <fieldset name="fieldset_eventuais" class="fieldset_eventuais bordavermelha">
                                    <table>
                                        <tbody>
                                            <tr>
                                            <td><label class="clicavel" textodepois="1"><input type="checkbox">Gerar Historico Objetivos Sinergia</label><input class="componente_data controle_input_texto" type="date" value="2022-01-24"><input class="componente_data controle_input_texto" type="date" value="2022-01-24"></td>
                                            <td><img class="img_spin_check clicavel" src="\sjd/images/executaramarelo32x32.png" data-nomeatualizacao="gerar_historico_objetivos_sinergia" onclick="window.fnsisjd.funcoes_eventuais(this);"></td>
                                            </tr>
                                            <tr>
                                            <td><label class="clicavel" textodepois="1"><input type="checkbox">Atualizar dados clientes rfb (tabela clientes_verif_rfb)</label></td>
                                            <td><img class="img_spin_check clicavel" src="\sjd/images/executaramarelo32x32.png" data-nomeatualizacao="atualizar_clientes_rfb" onclick="window.fnsisjd.funcoes_eventuais(this);"></td>
                                            </tr>
                                            <tr>
                                            <td><label class="clicavel" textodepois="1"><input type="checkbox">Processar dados clientes rfb (tabela clientes_verif_rfb -&gt; dados_clientes_rfb)</label></td>
                                            <td><img class="img_spin_check clicavel" src="\sjd/images/executaramarelo32x32.png" data-nomeatualizacao="processar_dados_clientes_rfb" onclick="window.fnsisjd.funcoes_eventuais(this);"></td>
                                            </tr>
                                            <tr>
                                            <td><label class="clicavel" textodepois="1"><input type="checkbox">Importar Devolucoes Aurora</label></td>
                                            <td><img class="img_spin_check clicavel" src="\sjd/images/executaramarelo32x32.png" data-nomeatualizacao="importar_devolucoes_aurora" onclick="window.fnsisjd.funcoes_eventuais(this);"></td>
                                            </tr>
                                            <tr>
                                            <td><label class="clicavel" onchange="window.fnhtml.marcar_todos_mesmo_fieldset(this);" textodepois="1"><input type="checkbox">Selecionar Todos</label></td>
                                            <td><img class="img_spin_check clicavel" src="\sjd/images/executaramarelo32x32.png" data-nomeatualizacao="processar_dados_clientes_rfb" onclick="window.fnsisjd.funcoes_eventuais(this);"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <legend name="titulo_legenda" class="titulo_legenda">Funcoes de Manutencao Eventuais</legend>
                                </fieldset>
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