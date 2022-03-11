<?php
   namespace SJD\relatorios;
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';    
   $GLOBALS['data-visao'] = 'promotor'; 
   $GLOBALS['tem_campos_avulsos'] = true;
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>
<text name="texto1" style="padding-left:10px;margin-top:10px;display:block;font-family:Calibri;">
    <ul name="lista1">
        <li name="item_lista1">Atencao: aqui somente serao listadas as vendas efetuadas a clientes que tenham promotoras.</li>
    </ul>
</text>