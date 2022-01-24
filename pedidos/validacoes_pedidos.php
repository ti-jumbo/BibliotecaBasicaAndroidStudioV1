<?php
    namespace SJD\pedidos;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Editar Validacoes Pedidos</title>
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
                        Editar Validacoes Pedidos
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_47441370313259634 _0_5573730305869059">
                                <div></div>
                                <div name="div_validacoes_pedidos" class="div_validacoes_pedidos container-fluid corpo-conteudo" style="height:100%;" ajuda_elemento="Altere as validacoes dos pedidos: Clique em uma validacao a esquerda para carregar os dados da validacao. Altere as datas na aba Dados Validacao!">
                                <div class="row">
                                    <div class="col-3 m-1 resize div_arvore_opcoes_validacoes_pedidos_alterar col">
                                        <div class="card">
                                            <div class="card-header">VALIDACOES</div>
                                            <div class="card-body">__FNV_MONTAR_TABELA_ALTERAR_VALIDACOES_PEDIDOS__</div>
                                        </div>
                                    </div>
                                    <div class="col-8 m-1 resize div_dados_validacoes_pedidos_alterar col">
                                        <div class="card">
                                            <div class="card-header">ITENS VALIDACOES</div>
                                            <div class="card-body">(clique em um item a esquerda)</div>
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