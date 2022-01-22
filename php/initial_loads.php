<?php
    namespace SJD;

    /*custom autoload class*/
    if (count(spl_autoload_functions()) === 0) {
        set_include_path(str_replace("/",DIRECTORY_SEPARATOR,$_SERVER["DOCUMENT_ROOT"]));
        spl_autoload_extensions(".php");
        spl_autoload_register();
    }

    use SJD\php\class\Acess;

    if (!Acess::logged()) {
        $url = 'http://' . $_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/login.php';
        header('Location: ' . $url, true, 301);   
    }


?>