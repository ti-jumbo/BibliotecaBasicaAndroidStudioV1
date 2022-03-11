<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
    echo '
    <div class="div_relatorio_personalizado container-fluid corpo-conteudo">';
        $GLOBALS['data-visao'] = $GLOBALS['data-visao'] ?? 'indefinido';
        include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_opcoes_pesquisa.php'; 
        include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_resultado.php';
    echo '</div>';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultend.php';
    echo '<script type="module">
        const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
        window.fnsisjd.requisitar_data_aurora();';
    if (($GLOBALS["tem_visoes"] ?? true) == true && ($GLOBALS["inserir_visao_inicial"] ?? true) == true) {
        echo 'window.fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes img.btn_img_add_geral")});';
    }
    if (($GLOBALS["tem_periodos"] ?? true) == true && ($GLOBALS["inserir_periodo_inicial"] ?? true) == true) {
        echo 'window.fnsisjd.inserir_periodo_pesquisa({elemento:$("div#periodos").children("div:first").children("div.row:first")});';
    }
    echo '</script>
    </html>
    ';
?>