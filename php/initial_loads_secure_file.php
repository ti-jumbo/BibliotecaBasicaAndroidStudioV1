<?php
namespace SJD\php;    
include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_secure.php';
if (!isset($_SERVER['SJD_RESOURCE'])) {
    echo ($_SERVER["REQUEST_URI"]??'')."\n"
    echo 'Acesso direto bloqueado. Acesse a pagina inicial para poder utilizar implicitamente este recurso.';
    exit();
}
?>