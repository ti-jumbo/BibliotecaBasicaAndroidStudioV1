<?php
   namespace SJD\relatorios;
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';    
   $GLOBALS["data-visao"] = "consulta_relatorio_majoracao_cc_rca"; 
   $GLOBALS["tem_visoes"] = false;
   $GLOBALS["permite_incluir_periodo"] = false;
   $GLOBALS["tem_ver_vals_de"] = false;
   $GLOBALS["tem_considerar_vals_de"] = false;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>
<script type="module">
    const {default:vars} = await import("/sjd/javascript/modulos/classes/variaveis/Variaveis.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    vars.visoes_condicionantes = ["Filial","Rca"];
</script>