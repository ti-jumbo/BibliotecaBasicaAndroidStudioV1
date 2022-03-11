<?php
    namespace SJD\pedidos;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/header.php';
?>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
        <?php include  $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/topbar.php'; ?>
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