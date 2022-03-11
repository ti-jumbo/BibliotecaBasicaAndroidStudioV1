<?php
   namespace SJD\relatorios;
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';    
   $GLOBALS['tem_visoes'] = false;
   $GLOBALS['data-visao'] = 'clientexfornecedor'; 
   $GLOBALS['tipos_check_ver_vals_de'] = 'radio';
   $GLOBALS['tem_ver_vals_zero'] = true;
   $GLOBALS['permite_incluir_periodo'] = false;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>