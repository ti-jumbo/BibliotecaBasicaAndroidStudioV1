<?php
    namespace SJD\manutencao;
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
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_9436768653749492 _0_047314220280372354">
                                <div></div>
                                <div name="div_meus_dados" class="div_meus_dados container-fluid corpo-conteudo">
                                <div class="mt-2 card">
                                    <div class="card-header">Meus Dados</div>
                                    <div class="card-body _0_07096989382573782 _0_029724254768286773">
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
    fnsisjd.carregar_dados_processo({codprocesso:6002,seletor_local_retorno:"div.card-body",condicionantestab:"sjdusuariosis[sjdusuariosis.codusuariosis=__CODUSUR__]"});
</script>
</html>