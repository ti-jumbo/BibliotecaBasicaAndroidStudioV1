<?php    
include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_unsecure_file.php';
    $header = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cache-control" content="no-cache, must-revalidate, post-check=0, pre-check=0" />
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        <title>SisJD - '.($_REQUEST['title'] ?? $GLOBALS['title'] ??'').'</title>
        <script type="module">
            /*load of modules*/
            window.version_loads = "<?php echo VERSION_LOADS; ?>";
        </script>    
        <link href="/bootstrap/5.1.3/css/bootstrap.min.css?<?php echo VERSION_LOADS; ?>" rel="stylesheet">        
        <link href="/sjd/css/estilos.css?<?php echo VERSION_LOADS; ?>" rel="stylesheet">                
        <script type="text/javascript" src="/sjd/javascript/polyfill.js?<?php echo VERSION_LOADS; ?>"></script>
        <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js?<?php echo VERSION_LOADS; ?>"></script>
        <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js?<?php echo VERSION_LOADS; ?>"></script>
        <script type="module">
            const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
            const {default:fnevt} = await import("/sjd/javascript/modulos/classes/eventos/FuncoesEventos.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});        
        </script>
        __OTHERS_LOADS__
    </head>
    ';
    $_REQUEST['loads'] = $_REQUEST['loads'] ?? '';    
    if (strlen(trim($_REQUEST['loads'])) > 0) { 
        $_REQUEST['loads'] = explode(',',$_REQUEST['loads']);    
        foreach($_REQUEST['loads'] as &$load) {
            if (strpos($load,'.css') != false) {
                $load = '<link href="'.$load.'?<?php echo VERSION_LOADS; ?>" rel="stylesheet">';
            } else {
                $load = '<script type="text/javascript" src="'.$load.'?<?php echo VERSION_LOADS; ?>"></script>';
            }                
        }
        $_REQUEST['loads'] = implode('',$_REQUEST['loads']);
    }
    $header = str_replace('__OTHERS_LOADS__',$_REQUEST['loads'],$header);
    echo $header;
?>