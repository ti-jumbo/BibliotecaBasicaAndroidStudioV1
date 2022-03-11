<?php
    namespace SJD;    
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/initial_loads_unsecure_page.php';
    $GLOBALS['title'] = 'Login';
    use SJD\php\classes\html\components\bootstrap\input\InputFloatingLabel;
    include $_SERVER['DOCUMENT_ROOT'] . '/sjd/php/html/partials/header.php';
?>
<body>
    <main name="main_login" class="main_login form-signin">
        <form name="form_login" class="form_login" onsubmit="window.fnsisjd.requisitar_login({elemento:this});return false;">
            <img name="img_login_logo" class="mb-4 rounded" src="/sjd/images/logo_login.png">
            <h1 name="login_titulo" class="h3 mb-3 fw-normal">Login SISJD</h1>
            <?php 
                echo InputFloatingLabel::create([
                    'textLabel'=>'Cód. Usuário',
                    'type'=>'number',
                    'placeholder'=>'(Cód. Usuário)',
                    'required'=>true
                ]); 
                echo InputFloatingLabel::create([
                    'textLabel'=>'Senha',
                    'type'=>'password',
                    'placeholder'=>'Senha',
                    'required'=>true
                ]);
            ?>                        
            <button name="botao_entrar" class="w-100 btn btn-lg btn-primary mt-3 botao_entrar" type="submit">Entrar</button>
            <p name="copyrigth" class="mt-5 mb-3 text-muted">Jumbo Alimentos Ltda- 2022</p>
        </form>
    </main>
</body>

<link href="/sjd/css/login.css?<?php echo VERSION_LOADS; ?>" rel="stylesheet">                

</html>