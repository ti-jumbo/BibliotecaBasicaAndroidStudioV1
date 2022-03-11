<?php     
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderVisoes;
if (($GLOBALS['tem_visoes2'] ?? false) == true) {
    echo '
    <div class="div_visoes2 accordion-item" titulo="Visualizar como Colunas" target="#visoes2" aberto="1">
        '.AccordionHeaderVisoes::create(["title"=>"Visualizar como Colunas","target"=>"#visoes2"]).'
        <div id="visoes2" class="collapse show">
            <div class="accordion-body" aberto="1">
                <img class="btn_img_add_geral btn_img_add_geral2 mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_visao_pesquisa({elemento:this})" title="Acrescentar um item">
                <div class="row">                    
                </div>
            </div>
        </div>
    </div>
    ';
}
?>