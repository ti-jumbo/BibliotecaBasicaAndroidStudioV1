<?php
   namespace SJD\relatorios;
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';    
   $GLOBALS["data-visao"] = "altera_pedido"; 
   $GLOBALS["tem_visoes"] = false;
   $GLOBALS["permite_incluir_periodo"] = false;
   $GLOBALS["tem_considerar_vals_de"] = false;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_painel_ver_vals_de_pedidos.php'; 
?>
<script type="text/javascript">
    $("div.painel_ver_vals_de").replaceWith('<?php include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/div_painel_ver_vals_de_pedidos.php';  ?>');
</script>