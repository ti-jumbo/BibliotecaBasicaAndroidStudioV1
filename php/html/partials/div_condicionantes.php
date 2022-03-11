<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderCondicionantes;
echo '
<div class="div_condicionantes accordion-item" titulo="Condicionantes" target="#painel_condicionantes">
    '.AccordionHeaderCondicionantes::create().'
    <div id="painel_condicionantes" class="collapse">
        <div class="accordion-body">
            <img class="btn_img_add_geral mousehover clicavel rounded" src="\sjd/images/maisverde32.png" onclick="window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})" title="Acrescentar um item">
            <div class="row">
            </div>
        </div>
    </div>
</div>
';
?>