<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderVerValsZero;
if (($GLOBALS['tem_ver_vals_zero'] ?? false)== true) {
echo '
    <div class="painel_ver_vals_zero accordion-item" titulo="Ver Valores Zero" target="#painel_ver_vals_zero">
        '.AccordionHeaderVerValsZero::create(['title']).'        
        <div id="painel_ver_vals_zero" class="collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col">
                        <label class="rotulo_ver_valores_zero1" textodepois="1">
                            <input type="radio" class="radio_ver_valores_de" value="0" name="radio_ver_vals_zero">
                            Mostrar como Zero
                        </label>
                        <label class="rotulo_ver_valores_zero1" textodepois="1">
                            <input type="radio" class="radio_ver_valores_de" value="1" name="radio_ver_vals_zero" checked="true">
                            Mostra em branco
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}
?>