<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderVerValsDe;
if (($GLOBALS['tem_ver_vals_de']??true) == true) {
    $GLOBALS['tipos_check_ver_vals_de'] = $GLOBALS['tipos_check_ver_vals_de'] ?? 'checkbox';
    echo '
    <div class="painel_ver_vals_de accordion-item" titulo="Ver Valores de" target="#painel_ver_vals_de">
        '.AccordionHeaderVerValsDe::create().'
        <div id="painel_ver_vals_de" class="collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col">
                        <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                            <input type="'.$GLOBALS['tipos_check_ver_vals_de'].'" class="'.$GLOBALS['tipos_check_ver_vals_de'].'_ver_valores_de" value="0" ' . ($GLOBALS['tipos_check_ver_vals_de'] == "checkbox"?' onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" ':' name="radio_ver_vals_de" ').'>
                            Qtde
                        </label>
                        <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                            <input type="'.$GLOBALS['tipos_check_ver_vals_de'].'" class="'.$GLOBALS['tipos_check_ver_vals_de'].'_ver_valores_de" value="3" ' . ($GLOBALS['tipos_check_ver_vals_de'] == "checkbox"?' onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)"  ':' name="radio_ver_vals_de" ') . ' checked="true">
                            Peso Total
                        </label>
                        <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                            <input type="'.$GLOBALS['tipos_check_ver_vals_de'].'" class="'.$GLOBALS['tipos_check_ver_vals_de'].'_ver_valores_de" value="5" ' . ($GLOBALS['tipos_check_ver_vals_de'] == "checkbox"?' onchange="window.fnsisjd.verificar_marcou_todos_checkbox_ver_vals_de(this)" checked="true" ':' name="radio_ver_vals_de" ').'>
                            Valor Total
                        </label>';
                        if ($GLOBALS['tipos_check_ver_vals_de'] == 'checkbox') {
                            echo '
                            <label class="rotulo_ver_vals_de width_33pc" textodepois="1">
                                <input type="checkbox" class="checkbox_ver_valores_de" value="10" onchange="window.fnsisjd.marcar_todos_checkbox_ver_vals_de(this)">
                                Todos
                            </label>';
                        }
                    echo '
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>