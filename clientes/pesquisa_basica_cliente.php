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
    <title>SisJD - Pesquisar Cliente</title>
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
                        Pesquisar Cliente
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_6872337544366837 _0_1196368710302056">
                                <div>
                                <form class="form m-2" onsubmit="return false;">
                                    <fieldset class="fieldset_filtros border p-2" nivel="basico" entity="cliente">
                                        <legend>Filtros</legend>
                                        <div class="row">
                                            <div title="Cód. Filial" type="number" class="form-group col-md-4" campo="pcclient.codfilialnf">
                                            <label class="control-label">Cód. Filial</label>
                                            <div title="Cód. Filial" type="number" class="row">
                                                <div class="col">
                                                    <div title="Cód. Filial" class="input-group"><input class="form-control" type="text" placeholder="(Cód. Filial)"><button type="button" onclick="fnsisjd.abrir_pesquisa_padrao(this)" class="btn btn-outline-secondary" title="Abrir pesquisa de filial" nomeops="pesquisa_basica_filial">...</button></div>
                                                </div>
                                            </div>
                                            </div>
                                            <div title="Cód. Rca" type="number" class="form-group col-md-4" campo="pcclient.codusur1">
                                            <label class="control-label">Cód. Rca</label>
                                            <div title="Cód. Rca" type="number" class="row">
                                                <div class="col">
                                                    <div title="Cód. Rca" class="input-group"><input class="form-control" type="text" placeholder="(Cód. Rca)"><button type="button" onclick="fnsisjd.abrir_pesquisa_padrao(this)" class="btn btn-outline-secondary" title="Abrir pesquisa de Rca" nomeops="pesquisa_basica_rca">...</button></div>
                                                </div>
                                            </div>
                                            </div>
                                            <div title="Cód. Cli" type="number" class="form-group col-md-4" campo="pcclient.codcli">
                                            <label class="control-label">Cód. Cli</label>
                                            <div title="Cód. Cli" type="number" class="row">
                                                <div class="col">
                                                    <div title="Cód. Cli" class="input-group"><input class="form-control" type="text" placeholder="(Cód. Cli)"><button type="button" onclick="fnsisjd.abrir_pesquisa_padrao(this)" class="btn btn-outline-secondary" title="Abrir pesquisa Avancada com mais campos e opções" nomeops="pesquisa_avancada_cliente">...</button></div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div title="Cnpj/CPF" type="number" class="form-group col-md-3" campo="pcclient.cgcent">
                                            <label class="control-label">Cnpj/CPF</label>
                                            <div title="Cnpj/CPF" type="number" class="row">
                                                <div class="col">
                                                    <div title="Cnpj/CPF" class="input-group"><input class="form-control" type="text" placeholder="(Cnpj/CPF)"></div>
                                                </div>
                                            </div>
                                            </div>
                                            <div title="Razão / Nome / Fantasia" type="text" class="form-group col-md-9" campo="pcclient.cliente_fantasia">
                                            <label class="control-label">Razão / Nome / Fantasia</label>
                                            <div title="Razão / Nome / Fantasia" type="text" class="row">
                                                <div class="col-3"><select type="text" class="form-control"></select></div>
                                                <div class="col">
                                                    <div title="Razão / Nome / Fantasia" class="input-group"><input class="form-control" type="text" placeholder="(Razão / Nome / Fantasia)"></div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <button title="Pesquisar" class="btn btn-lg d-block m-auto btn-primary w-25 mt-3 mb-2" onclick="fnsisjd.pesquisar_filtro_padrao({elemento:this,relatorio:'pesquisa_basica_cliente',entidade:'cliente',nivel:'basico'})">
                                                Pesquisar
                                            </button>
                                        </div>
                                    </fieldset>
                                </form>
                                </div>
                                <div name="div_pesquisa_basica_cliente" class="div_pesquisa_basica_cliente container-fluid corpo-conteudo" data-tit_aba="div_pesquisa_basica_cliente" data-nome="div_pesquisa_basica_cliente"></div>
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