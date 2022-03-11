<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderAvancado;
if (($GLOBALS['tem_avancado']??true) == true) {
    $GLOBALS['tipos_check_ver_vals_de'] = $GLOBALS['tipos_check_ver_vals_de'] ?? 'checkbox';
    $GLOBALS['tem_campos_avulsos'] = $GLOBALS['tem_campos_avulsos'] ?? false;
    $GLOBALS['tem_ver_vals_zero'] = $GLOBALS['tem_ver_vals_zero'] ?? false;
    echo '
    <div class="avancado div_avancado accordion-item" titulo="Avancado" target="#avancada">
        '.AccordionHeaderAvancado::create().'
        <div id="avancada" class="collapse">
            <div class="accordion-body">
                <div class="div_opcoes_pesquisa_avancada row">
                    <div class="div_opcoes_pesquisa_avancada_col col">
                        <div class="accordion">';
                            include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_painel_ver_vals_de.php';
                            include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_painel_ver_vals_zero.php';
                            include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_painel_considerar_vals_de.php';
                            include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_condicionantes.php';
                            include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_campos_avulsos.php';
                        echo
                        '</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>