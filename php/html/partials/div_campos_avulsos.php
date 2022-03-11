<?php
namespace SJD\php\html\partials;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
use SJD\php\classes\html\components\sjd\AccordionHeaderCamposAvulsos;
if (($GLOBALS['tem_campos_avulsos']??false)==true) {
    echo '
    <div class="div_campos_avulsos accordion-item" titulo="Campos Avulsos" target="#painel_campos_avulsos">
        '.AccordionHeaderCamposAvulsos::create().'
        <div id="painel_campos_avulsos" class="collapse">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-auto mt-2 div_visao">
                        <div class="card">
                            <div class="card-header ps-2 pt-0 pb-1 cor_titulo_campos_avulsos">
                                Campos Avulsos
                            </div>
                            <div class="card-body ps-2 pt-1 pb-1">
                                <div class="row">
                                    <div class="col">
                                        <div label="Campos Avulsos" classe_botao="btn-dark" aoabrir="window.fnsisjd.incluir_options_campo_avulso(this)" tem_inputs="1" tipo_inputs="checkbox" multiplo="1" selecionar_todos="1" filtro="1" class="div_combobox" data-visao="" data-visao_atual="campos_avulsos" placeholder="(Selecione)" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                            <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">
                                                (Selecione)
                                            </button>
                                            <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                <label class="label_selecionar_todos" textodepois="1">
                                                    <input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">
                                                    Selecionar Todos
                                                </label>
                                                <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="div_opcao_controles_btns_img col-md-auto w-auto">
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
}
?>