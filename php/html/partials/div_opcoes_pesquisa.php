<?php
namespace SJD\php\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderOpcoesPesquisa;    
echo '
<div class="div_opcoes_pesquisa_l1 row" titulo="Opcoes de Pesquisa" height="25px">
    <div class="div_opcoes_pesquisa m-1 col">
        <div class="accordion">
            <div class="accordion-item">
                '.AccordionHeaderOpcoesPesquisa::create().'
                <div id="painel_div_opcoes_pesquisa_corpo" class="collapse show">
                    <div class="accordion-body">
                        <div class="div_opcoes_pesquisa_simples row">
                            <div class="div_opcoes_pesquisa_simples_col col">
                                <div class="accordion">';
                                    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/accordion_item_visoes.php';
                                    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/accordion_item_visoes2.php';
                                    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/accordion_item_periodos.php';
                                    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/accordion_item_avancado.php';
                                echo '
                                </div>
                                <div class="div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3">
                                    <button class="botao_pesquisar btn btn-primary" value="Pesquisar" data-visao="'.($GLOBALS["data-visao"]??"indefinido").'" onclick="window.fnsisjd.pesquisar_dados(this)">
                                    Pesquisar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';
?>