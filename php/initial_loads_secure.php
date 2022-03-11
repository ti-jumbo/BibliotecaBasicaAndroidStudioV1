<?php
namespace SJD\php;    
include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure.php';
use SJD\php\classes\Acess;
if (!Acess::logged()) {
    $url = 'http://' . $_SERVER['HTTP_HOST'].'/sjd/login.php';
    header('Location: ' . $url, true, 301);   
} 
?>