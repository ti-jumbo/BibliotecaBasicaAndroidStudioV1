<?php
    namespace SJD;      
    include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/initial_loads_secure_page.php';
    $GLOBALS['title'] = 'Inicio';
    include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/header.php';
?>
<body>
    <div class="div-main container-fluid p-0 m-0 h-100 w-100">
        <div class="row row-main p-0 m-0 h-100 w-100">
            <div class="col-3 bg-dark bg-gradient">
                <div id="barra_menus">                    
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col bg-white bg-gradient">
                <div class="row">
                    <div class="m-1 col">
                        <div class="mt-2 card_meus_valores card">
                            <div class="card-header" id="card_meus_valores">Meus Valores
                                <div class="d-flex justify-content-center spinner_mes_inicio">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div> 
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div unidade="R$" class="card" variacao="(variacao)">
                                            <div class="card-body">
                                                <div class="align-items-center gx-0 row">
                                                    <div class="col">
                                                        <h6 class="text-uppercase text-muted mb-2">Vendas</h6>
                                                        <span class="h5 mb-0">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="col-auto col">
                                                        <span class="h5 fe fe-dollar-sign text-muted mb-0">R$</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div unidade="KG" class="card" variacao="(variacao)">
                                            <div class="card-body">
                                                <div class="align-items-center gx-0 row">
                                                    <div class="col">
                                                        <h6 class="text-uppercase text-muted mb-2">Peso</h6>
                                                        <span class="h5 mb-0">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="col-auto col">
                                                        <span class="h5 fe fe-dollar-sign text-muted mb-0">KG</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div unidade="Cli" class="card" variacao="(variacao)">
                                            <div class="card-body">
                                                <div class="align-items-center gx-0 row">
                                                    <div class="col">
                                                        <h6 class="text-uppercase text-muted mb-2">Positivação</h6>
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0 fs-5">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        /
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div class="col-auto col">
                                                        <span class="h5 fe fe-dollar-sign text-muted mb-0">Cli</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div unidade="Prod" class="card" variacao="(variacao)">
                                            <div class="card-body">
                                                <div class="align-items-center gx-0 row">
                                                    <div class="col">
                                                        <h6 class="text-uppercase text-muted mb-2">Mix</h6>
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0 fs-5">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                        /
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="spinner-border" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <div class="col-auto col">
                                                        <span class="h5 fe fe-dollar-sign text-muted mb-0">Prod</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row w-100">
                    <div class="col m-1 w-100">
                        <div id="grafico_volume" class="w-100" style="min-height:300px;">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 text-end">
                            <a href="/sjd/relatorios/dashboard.php" target="_blank">Ver no dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="m-1 col">
                        <div class="card_mais_recentes card">
                            <div class="card-header">
                                Mais Recentes
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="m-1 col">
                        <div class="card_mais_acessados card">
                            <div class="card-header">
                                Mais Acessados
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="d-flex justify-content-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js?<?php echo VERSION_LOADS; ?>"></script>
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});
    const {default:fnevt} = await import("/sjd/javascript/modulos/classes/eventos/FuncoesEventos.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});        
    window.fnsisjd.carregar_valores_inicio();
    window.fnsisjd.carregarGraficoVolumeInicio();
</script>
</html>