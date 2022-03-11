<?php
    namespace SJD\produtos;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/header.php';
?>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/topbar.php'; ?>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_3929327658544043 _0_12453479092884734">
                                <div></div>
                                <div name="div_manutencao_grupos_produtos_equivalentes" class="div_manutencao_grupos_produtos_equivalentes container-fluid corpo-conteudo" style="height:100%;" ajuda_elemento="Altere os grupos de produtos equivalentes e seus dados!">
                                <div class="row">
                                    <div class="col-4 m-1 resize div_manutencao_grupos_prodequiv_arvore_opcoes col _0_7942653445300174 _0_9237892320567965">
                                        <div class="card">
                                            <div class="card-header">Grupos de Produtos</div>
                                            <div class="card-body">
                                            <div class="spinner-border" role="status"><span class="visually-hidden">Carregando...</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 m-1 resize div_dados_gruposprodequiv_consultar col">
                                        <div class="card">
                                            <div class="card-header">DADOS DO GRUPO</div>
                                            <div class="card-body">
                                            <div type_navs="pills" class="div_container_abas">
                                                <ul class="nav nav-pills mb-3" role="tablist" style="display:inline-block !important;white-space: nowrap !important">
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link active" id="pills-0-tab" data-bs-toggle="pill" href="#pills-0" role="tab" aria-controls="pills-0" aria-selected="true">Dados Grupo</a></li>
                                                    <li class="nav-item" style="display:inline-block !important"><a class="nav-link" id="pills-1-tab" data-bs-toggle="pill" href="#pills-1" role="tab" aria-controls="pills-1" aria-selected="false">Integrantes do Grupo</a></li>
                                                </ul>
                                                <div class="tab-content" id="pills-tabContent">
                                                    <div class="tab-pane fade show active div_dados_grupos_alterar_container_orelha0" id="pills-0" role="tabpanel" aria-labelledby="pills-0-tab"></div>
                                                    <div class="tab-pane fade   div_dados_grupos_alterar_container_orelha1" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab"></div>
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
   </main>
</body>
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    fnsisjd.carregar_dados_grupos_equivalentes();
</script>
</html>