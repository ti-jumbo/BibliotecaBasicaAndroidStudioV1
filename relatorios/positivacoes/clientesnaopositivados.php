<?php
   namespace SJD\relatorios;
   $GLOBALS['title'] = 'Clientes Não Positivados';
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';       
   $GLOBALS['data-visao'] = 'clientesnaopositivados'; 
   $GLOBALS['tem_campos_avulsos'] = true;
   $GLOBALS['inserir_visao_inicial'] = false;
   $GLOBALS['inserir_periodo_inicial'] = false;
   $GLOBALS['permite_incluir_periodo'] = false;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});    
    fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes img.btn_img_add_geral"),selecionado:"Cliente"});
    fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes img.btn_img_add_geral"),selecionado:"Rca"});
    fnsisjd.inserir_periodo_pesquisa({elemento:$("div#periodos").children("div:first").children("div.row:first"),titulo:"Periodo Positivado"});
    fnsisjd.inserir_periodo_pesquisa({elemento:$("div#periodos").children("div:first").children("div.row:first"),titulo:"Periodo Nao Positivado"});
    const {default:fndt} = await import("/sjd/javascript/modulos/classes/data/FuncoesData.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    $("input.componente_data").eq(0).val(fndt.dataUSA(fndt.data_primeirodiames_anterior()));
    $("input.componente_data").eq(1).val(fndt.dataUSA(fndt.setar_ultimo_dia_mes(fndt.data_primeirodiames_anterior())));
    $("input.componente_data").eq(2).val(fndt.dataUSA(fndt.data_primeirodiames()));
    $("input.componente_data").eq(3).val(fndt.dataUSA(fndt.hoje()));
    $("input.inputano").val(fndt.dataBR_getAno(fndt.data_primeirodiames()));
</script>