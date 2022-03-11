<?php
    namespace SJD\comercial\vendas\faturamento\devolucao;
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    use SJD\php\classes\html\components\sjd\{
        AccordionHeaderOpcoesPesquisa,
        AccordionHeaderVisoes
    };    
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
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_9834866499309513 _0_2206728245164966">
                                <div></div>
                                <div name="div_cadastro_codigos_devolucao" class="div_cadastro_codigos_devolucao container-fluid corpo-conteudo" ajuda_elemento="Consulta e manutencao dos codigos de devolucao." data-tit_aba="div_cadastro_codigos_devolucao" data-nome="div_cadastro_codigos_devolucao">
                                <div class="div_opcoes_pesquisa_l1 row" titulo="Opcoes de Pesquisa" height="25px">
                                    <div class="div_opcoes_pesquisa m-1 col">
                                        <div class="accordion">
                                            <div titulo="Opcoes de Pesquisa" target="#painel_div_opcoes_pesquisa_corpo" class="accordion-item" aberto="1">
                                            <?php echo AccordionHeaderOpcoesPesquisa::create() ?>
                                            <div id="painel_div_opcoes_pesquisa_corpo" class="collapse show">
                                                <div class="accordion-body" aberto="1">
                                                    <div class="div_opcoes_pesquisa_simples row">
                                                        <div class="div_opcoes_pesquisa_simples_col col">
                                                        <div class="accordion">
                                                            <div class="div_visoes accordion-item" titulo="Filtros" target="#visoes" aberto="1">
                                                                <?php echo AccordionHeaderVisoes::create("Filtros") ?>
                                                                <div id="visoes" class="collapse show">
                                                                    <div class="accordion-body" aberto="1">
                                                                    <div class="row"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3"><button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="consulta_codigos_devolucao" onclick="window.fnsisjd.pesquisar_dados(this)" visao="lista codigos devolucao" codprocesso="10800">Pesquisar</button></div>
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
            </div>
         </div>
      </div>
   </main>
</body>
</html>