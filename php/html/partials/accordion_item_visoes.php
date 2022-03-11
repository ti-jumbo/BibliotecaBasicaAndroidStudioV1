<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderVisoes;
if (($GLOBALS['tem_visoes'] ?? true) == true) {
    echo '
    <div class="div_visoes accordion-item" titulo="Visualizar" target="#visoes" aberto="1">
        '.AccordionHeaderVisoes::create().'
        <div id="visoes" class="collapse show" permite_incluir="'.($GLOBALS["permite_incluir_visao"]??true).'">
            <div class="accordion-body" aberto="1">
                '.(($GLOBALS["permite_incluir_visao"]??true) == true?'<img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" title="Acrescentar um item">':'').'
                <div class="row">                    
                </div>
            </div>
        </div>
    </div>
    ';
}
?>