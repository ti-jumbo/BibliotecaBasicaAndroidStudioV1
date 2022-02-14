<?php
    namespace SJD;
    
    //include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php"); erro: redirecionamento recursivo

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Login</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/login.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/sjd/javascript/modulos/ModuloPrincipal.js?3.00"></script>
</head>
<body>
    <main name="main_login" class="main_login form-signin">
        <form name="form_login" class="form_login" onsubmit="window.fnsisjd.requisitar_login({elemento:this});return false;">
            <img name="img_login_logo" class="mb-4 rounded" src="/sjd/images/logo_login.png">
            <h1 name="login_titulo" class="h3 mb-3 fw-normal">Login SISJD</h1>
            <div name="div_grupo_codusur" class="form-floating">
                <input name="inputCodUsuario" class="form-control" type="Number" placeholder="(Cod. Usuario)" onkeyup="window.fnjs.verificar_tecla(this,event,{}, ['1','2','3','4','5','6','7','8','9','0'])" required="true">
                <label name="labelCodusur" for="inputCodUsuario">Cod. Usuario:</label>
            </div>
            <div name="div_grupo_senha" class="form-floating">
                <input name="inputSenha" class="form-control" type="Password" placeholder="(Senha)" required="true">
                <label name="labelSenha" for="inputSenha">Senha:</label>
            </div>
            <button name="botao_entrar" class="w-100 btn btn-lg btn-primary mt-3 botao_entrar" type="submit">Entrar</button>
            <p name="copyrigth" class="mt-5 mb-3 text-muted">Jumbo Alimentos Ltda- 2022</p>
        </form>
    </main>
</body>
</html>