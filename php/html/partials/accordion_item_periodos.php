<?php
namespace SJD\php;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\funcoes\FuncoesConversao;
use SJD\php\classes\html\components\sjd\AccordionHeaderPeriodos;
if (($GLOBALS['tem_periodos']??true) == true) {        
    $GLOBALS['permite_incluir_periodo'] = $GLOBALS['permite_incluir_periodo'] ?? true;
    echo '
    <div class="div_periodos accordion-item" titulo="Periodos" target="#periodos" aberto="1">
        '.AccordionHeaderPeriodos::create().'
        <div id="periodos" class="collapse show" permite_incluir="'.$GLOBALS["permite_incluir_periodo"].'">
            <div class="accordion-body" aberto="1">
                '.($GLOBALS["permite_incluir_periodo"] == true
                    ?'<img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_periodo_pesquisa({elemento:this})" title="Acrescentar um item">'
                    :'').'
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
    ';
}
?>