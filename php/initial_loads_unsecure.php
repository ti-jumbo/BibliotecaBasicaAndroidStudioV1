<?php
namespace SJD\php;    
/*custom autoload class*/
if (count(spl_autoload_functions()) === 0) {
    set_include_path(str_replace('/',DIRECTORY_SEPARATOR,$_SERVER['DOCUMENT_ROOT']));
    spl_autoload_extensions('.php');
    spl_autoload_register();
}
if (!defined('VERSION_LOADS')) define('VERSION_LOADS','v=11032022');     
$GLOBALS['title'] = $_REQUEST['title'] ?? $GLOBALS['title'] ?? ucwords(str_replace('_',' ',basename($_SERVER['SCRIPT_NAME'],'.php'))); 
?>