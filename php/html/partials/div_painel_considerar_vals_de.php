<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderConsiderarValsDe;
if (($GLOBALS['tem_considerar_vals_de']??true)==true) {
    echo '
    <div class="painel_considerar_vals_de accordion-item" titulo="Considerar Valores de" target="#painel_considerar_vals_de">
        '.AccordionHeaderConsiderarValsDe::create().'        
        <div id="painel_considerar_vals_de" class="collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col">
                        <label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="0" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Vendas Normais</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="1" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Devolucoes Normais</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="2" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">Devolucoes Avulsas</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="3" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)">Bonificacoes</label><label class="rotulo_considerar_vals_de width_33pc" textodepois="1"><input type="checkbox" class="checkbox_considerar_valores_de" value="10" onchange="window.fnsisjd.verificar_marcou_todos_checkbox_considerar_vals_de(this)" checked="true">
                            Todos
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>