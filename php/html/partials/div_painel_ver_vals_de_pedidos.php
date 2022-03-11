<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderVerValsDe;    
$painel =  '
<div class="painel_ver_vals_de accordion-item">
    '.AccordionHeaderVerValsDe::create("Ver Pedidos").'        
    <div id="painel_ver_vals_de" class="collapse">
        <div class="accordion-body">
            <div class="row">
                <div class="col">
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="0" checked="true">
                        R - Recebido
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="1">
                        C - Cancelados
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="2" checked="true">
                        B - Bloqueados
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="3" checked="true">
                        P - Pendentes
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="4" checked="true">
                        L - Liberados
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="5" checked="true">
                        M - Montados
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="6">
                        F - Faturados
                    </label>
                    <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                        <input type="checkbox" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)">
                        Todas as opcoes
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>';
$painel = str_replace("\r\n",'',$painel);
echo $painel;
?>