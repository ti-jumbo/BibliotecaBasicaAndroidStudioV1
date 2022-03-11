<?php
   namespace SJD\relatorios;
   $GLOBALS['title'] = 'Positivação Personalizada';
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';       
   $GLOBALS['data-visao'] = 'positivacaopersonalizada'; 
   $GLOBALS['tipos_check_ver_vals_de'] = 'radio';
   $GLOBALS['inserir_visao_inicial'] = false;
   $GLOBALS['inserir_periodo_inicial'] = false;
   $GLOBALS['tem_ver_vals_zero'] = true;
   $GLOBALS['permite_incluir_periodo'] = false;
   $GLOBALS['tem_visoes2'] = true;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});    
    fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes img.btn_img_add_geral"),selecionado:"Produto"});
    fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes2 img.btn_img_add_geral"),selecionado:"Rca"});
    fnsisjd.inserir_periodo_pesquisa({elemento:$("div#periodos").children("div:first").children("div.row:first"),titulo:"Periodo Positivado"});    
</script>