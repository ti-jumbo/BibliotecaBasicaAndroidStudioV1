<?php
    namespace SJD\comercial\vendas\precificacao;
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
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_509542177140671 _0_6503782750749454">
                                <div></div>
                                <div name="div_configuracoes_precificacao" class="div_configuracoes_precificacao container-fluid corpo-conteudo">
                                <div class="mt-2 card">
                                    <div class="card-header">Configuracoes Precificacao</div>
                                    <div class="card-body _0_8788039065628948 _0_9192868009952652">
                                        <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
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
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    fnsisjd.carregar_dados_processo({codprocesso:6000,seletor_local_retorno:"div.card-body"});
</script>
</html>