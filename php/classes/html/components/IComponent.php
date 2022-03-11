<?php
namespace SJD\php\classes\html\components;
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
interface IComponent {    
    public static function create(array|string $params = []) : string;
}
?>