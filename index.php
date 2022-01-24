<?php
    namespace SJD;
    
    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Sistema Jumbo Distribuidor</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/estilos.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/sjd/javascript/modulos/ModuloPrincipal.js?2.00"></script>
</head>
<body>
    <div class="div-main container-fluid p-0 m-0 h-100 w-100">
        <div class="row row-main p-0 m-0 h-100 w-100">
            <div class="col-3 bg-dark bg-gradient">
                <div id="barra_menus">
                    <form id="form_pesquisa_opcoes" class="d-flex" onsubmit="return false;">
                        <input class="form-control me-2" type="search" placeholder="Pesquisa..." aria-label="Pesquisa no site..." list="lista_opcoes_sistema" onclick="window.fnsisjd.carregar_lista_opcoes_sistema(this);" oninput="window.fnsisjd.acessar_opcao_pesquisada(this);" oque="dados_literais" comando="consultar" tipo_objeto="lista_opcoes_sistema_pesquisa" objeto="lista_opcoes_sistema_pesquisa">
                        <datalist id="lista_opcoes_sistema">
                            <option></option>
                        </datalist>
                    </form>
                    <ul class="navbar-nav mr-auto ul_navbar_superior text-white">
                        <li carr_din="1" carregado="NAO" objeto="campanhas" nomeops="campanhas" seletor_conteudo="div.div_campanhas">
                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_3" aria-expanded="false">
                                Campanhas
                            </button>
                            <div class="collapse" id="collapse_3">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li carr_din="1" carregado="NAO" objeto="consultar_campanhas" nomeops="consultar_campanhas" seletor_conteudo="div.div_campanhas">
                                        <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_300" aria-expanded="false">
                                            Consultar Campanhas
                                        </button>
                                        <div class="collapse" id="collapse_300">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                <li carr_din="1" carregado="NAO" objeto="consultar_sinergia" nomeops="consultar_sinergia" seletor_conteudo="div.div_consultar_sinergia">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Sinergia
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="consultar_campanhas_estruturadas" nomeops="consultar_campanhas_estruturadas" seletor_conteudo="div.div_consultar_campanhas_estruturadas">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Consultar Campanhas Estruturadas
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="consultar_painel" nomeops="consultar_painel" seletor_conteudo="div.div_consultar_sinergia2">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Painel
                                                        </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="consultar_itens_campanha_giro" nomeops="consultar_itens_campanha_giro" seletor_conteudo="div.div_consultar_itens_campanha_giro">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Consultar Itens Campanha Giro
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li carr_din="1" carregado="NAO" objeto="alterar_campanhas" nomeops="alterar_campanhas" seletor_conteudo="div.div_alterar_campanhas">
                                        <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_301" aria-expanded="false">
                                            Alterar Campanhas
                                        </button>
                                        <div class="collapse" id="collapse_301">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                <li carr_din="1" carregado="NAO" objeto="alterar_campanhas_sinergia" nomeops="alterar_campanhas_sinergia" seletor_conteudo="div.div_alterar_sinergia">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Alterar Sinergia
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="alterar_campanhas_estruturadas" nomeops="alterar_campanhas_estruturadas" seletor_conteudo="div.div_alterar_campanhas_estruturadas">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Alterar Campanhas Estruturadas
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="processamentos_campanhas" nomeops="processamentos_campanhas" seletor_conteudo="div.div_processamentos_campanhas">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Processamentos Campanhas
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li carr_din="1" carregado="NAO" objeto="relatorios" nomeops="relatorios">
                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_4" aria-expanded="false">
                                Relatorios
                            </button>
                            <div class="collapse" id="collapse_4">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li carr_din="1" carregado="NAO" objeto="relatorio_personalizado" nomeops="relatorio_personalizado" seletor_conteudo="div.div_relatorio_personalizado">
                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                            Relatorio personalizado
                                        </button>
                                    </li>
                                    <li carr_din="1" carregado="NAO" objeto="positivacoes" nomeops="positivacoes">
                                        <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_401" aria-expanded="false">
                                            Positivacoes
                                        </button>
                                        <div class="collapse" id="collapse_401">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                <li carr_din="1" carregado="NAO" objeto="produtoxrca" nomeops="produtoxrca" seletor_conteudo="div.div_produtoxrca">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Produtoxrca
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="clientexproduto" nomeops="clientexproduto" seletor_conteudo="div.div_clientexproduto">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Cliente x produto
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="clientexfornecedor" nomeops="clientexfornecedor" seletor_conteudo="div.div_clientexfornecedor">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Cliente x fornecedor
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="clientesnaopositivados" nomeops="clientesnaopositivados" seletor_conteudo="div.div_clientesnaopositivados">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Clientes nao positivados
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="produtosnaopositivados" nomeops="produtosnaopositivados" seletor_conteudo="div.div_produtosnaopositivados">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Produtos nao positivados
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="positivacaopersonalizada" nomeops="positivacaopersonalizada" seletor_conteudo="div.div_positivacaopersonalizada">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Positivacao personalizada
                                                    </button>
                                                </li>
                                                <li carr_din="1" carregado="NAO" objeto="clientesativosxpositivados" nomeops="clientesativosxpositivados" seletor_conteudo="div.div_clientesativosxpositivados">
                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                        Clientes ativos x positivados
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                        <li carr_din="1" carregado="NAO" objeto="cispe" nomeops="cispe" seletor_conteudo="div.div_cispe">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Cispe
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="promotoras" nomeops="promotoras" seletor_conteudo="div.div_promotoras">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Promotoras
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="freezers" nomeops="freezers" seletor_conteudo="div.div_freezers">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Freezers
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="critica" nomeops="critica" seletor_conteudo="div.div_critica">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Critica
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="ratingsfoco" nomeops="ratingsfoco">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_406" aria-expanded="false">
                                                Ratings Foco
                                            </button>
                                            <div class="collapse" id="collapse_406">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="consultarratingsfocais" nomeops="consultarratingsfocais" seletor_conteudo="div.div_consultar_ratingsfocais">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Consultar Ratings Foco
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="editarratingsfocais" nomeops="editarratingsfocais" seletor_conteudo="div.div_editar_ratingsfocais">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Editar Ratings Foco
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="clientes" nomeops="clientes" seletor_conteudo="div.clientes">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_2" aria-expanded="false">
                                    Clientes
                                </button>
                                <div class="collapse" id="collapse_2">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="pesquisa_basica_cliente" nomeops="pesquisa_basica_cliente" seletor_conteudo="div.div_pesquisa_basica_cliente">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Pesquisa basica cliente
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="atualizar_clientes_receita" nomeops="atualizar_clientes_receita" seletor_conteudo="div.atualizar_clientes_rfb">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Atualizar da RFB
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="pesquisa_avancada_cliente" nomeops="pesquisa_avancada_cliente" seletor_conteudo="div.div_pesquisa_avancada_cliente">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Pesquisa avancada cliente
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="produtos" nomeops="produtos">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_5" aria-expanded="false">
                                    Produtos
                                </button>
                                <div class="collapse" id="collapse_5">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="manutencao_grupos_produtos_equivalentes" nomeops="manutencao_grupos_produtos_equivalentes" seletor_conteudo="div.div_manutencao_grupos_produtos_equivalentes">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Manut. Grupos Prod. Equivalentes
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="manutencao_grupos_produtos_giro" nomeops="manutencao_grupos_produtos_giro" seletor_conteudo="div.div_manutencao_grupos_produtos_giro">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Manut. Grupos Prod. Giro
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="pedidos" nomeops="pedidos" seletor_conteudo="div.pedidos">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_22" aria-expanded="false">
                                    Pedidos
                                </button>
                                <div class="collapse" id="collapse_22">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="consultar_pedidos" nomeops="consultar_pedidos" seletor_conteudo="div.div_consultar_pedido">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Consultar pedidos
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="alterar_pedidos" nomeops="alterar_pedidos" seletor_conteudo="div.div_alterar_pedido">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Alterar pedidos
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="importacao_pedidos" nomeops="importacao_pedidos" seletor_conteudo="div.div_importacao_pedidos">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_2203" aria-expanded="false">
                                                Importacao pedidos
                                            </button>
                                            <div class="collapse" id="collapse_2203">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="validacoes_pedidos" nomeops="validacoes_pedidos" seletor_conteudo="div.div_validacoes_pedidos">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Validacoes pedidos
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="configuracoes_pedidos" nomeops="configuracoes_pedidos" seletor_conteudo="div.div_configuracoes_pedidos">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Configuracoes pedidos
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="estoque" nomeops="estoque" seletor_conteudo="div.div_estoque">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_21" aria-expanded="false">
                                    Estoque
                                </button>
                                <div class="collapse" id="collapse_21">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="consultaestoque" nomeops="consultaestoque" seletor_conteudo="div.div_consulta_estoque">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Consulta Estoque
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="faturamento" nomeops="faturamento" seletor_conteudo="div.div_faturamento">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_17" aria-expanded="false">
                                    Faturamento
                                </button>
                                <div class="collapse" id="collapse_17">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="devolucao" nomeops="devolucao" seletor_conteudo="div.div_devolucao">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_1700" aria-expanded="false">
                                                Devolucao
                                            </button>
                                            <div class="collapse" id="collapse_1700">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="cadastro_codigos_devolucao" nomeops="cadastro_codigos_devolucao" seletor_conteudo="div.div_cadastro_codigos_devolucao">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Cadastro codigos devolucao
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="vendas" nomeops="vendas" seletor_conteudo="div.div_vendas">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_1701" aria-expanded="false">
                                                Vendas
                                            </button>
                                            <div class="collapse" id="collapse_1701">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="majoracao_vendas_ccrca" nomeops="majoracao_vendas_ccrca" seletor_conteudo="div.div_majorar_vendas_ccrca">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Majoracao vendas cc rca
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="relatoio_majoracao_vendas_ccrca" nomeops="relatoio_majoracao_vendas_ccrca" seletor_conteudo="div.div_relatorio_majorarcao_vendas_ccrca">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Relatorio majoracao vendas cc rca
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_vendas" nomeops="configuracoes_vendas" seletor_conteudo="div.div_configuracoes_vendas">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Configuracoes vendas
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="logistica" nomeops="logistica" seletor_conteudo="div.div_logistica">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_70" aria-expanded="false">
                                    Logistica
                                </button>
                                <div class="collapse" id="collapse_70">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="relatorios_logistica" nomeops="relatorios_logistica" seletor_conteudo="div.div_relatorios_logistica">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_7000" aria-expanded="false">
                                                Relatorios
                                            </button>
                                            <div class="collapse" id="collapse_7000">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="veiculo_reserva" nomeops="veiculo_reserva" seletor_conteudo="div.div_veiculo_reserva">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Veiculo Reserva
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="entregas" nomeops="entregas" seletor_conteudo="div.div_entregas">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Entregas
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="precificacao" nomeops="precificacao" seletor_conteudo="div.div_precificacao">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_18" aria-expanded="false">
                                    Precificacao
                                </button>
                                <div class="collapse" id="collapse_18">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="configuracoes_precificacao" nomeops="configuracoes_precificacao" seletor_conteudo="div.div_configuracoes_precificacao">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Configuracoes precificacao
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="compras" nomeops="compras" seletor_conteudo="div.div_compras">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_20" aria-expanded="false">
                                    Compras
                                </button>
                                <div class="collapse" id="collapse_20">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="configuracoes_compras" nomeops="configuracoes_compras" seletor_conteudo="div.div_configuracoes_compras">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Configuracoes compras
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="reltorios_precos_medios" nomeops="reltorios_precos_medios" seletor_conteudo="div.div_relatorios_precos_medios">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Configuracoes compras
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="gestao" nomeops="gestao" seletor_conteudo="div.div_gestao">
                                <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                    Gestao
                                </button>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="downloads" nomeops="downloads" seletor_conteudo="div.div_downloads">
                                <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                    Downloads
                                </button>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="configuracoes" nomeops="configuracoes" seletor_conteudo="div.div_configuracoes">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_9999" aria-expanded="false">
                                    Configuracoes
                                </button>
                                <div class="collapse" id="collapse_9999">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="configuracoes_banco_de_dados" nomeops="configuracoes_banco_de_dados" seletor_conteudo="div.div_configuracoes_banco_de_dados">
                                            <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_999900" aria-expanded="false">
                                                Banco de Dados
                                            </button>
                                            <div class="collapse" id="collapse_999900">
                                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_banco_de_dados_bancos" nomeops="configuracoes_banco_de_dados_bancos" seletor_conteudo="div.div_configuracoes_bancos_de_dados">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Bancos de Dados
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_db_usuariuosdb" nomeops="configuracoes_db_usuariuosdb" seletor_conteudo="div.div_configuracoes_db_usuariuosdb">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Usuarios DB
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_db_tabelassis" nomeops="configuracoes_db_tabelassis" seletor_conteudo="div.div_configuracoes_db_tabelassis">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Tabelas Sistema
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_db_tabelasdb" nomeops="configuracoes_db_tabelasdb" seletor_conteudo="div.div_configuracoes_db_tabelasdb">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Tabelas DB
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_visoes" nomeops="configuracoes_visoes" seletor_conteudo="div.div_configuracoes_visoes">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Visoes
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_processos" nomeops="configuracoes_processos" seletor_conteudo="div.div_configuracoes_processos">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Processos
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_relacionamentos" nomeops="configuracoes_relacionamentos" seletor_conteudo="div.div_configuracoes_relacionamentos">
                                                        <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                            Relacionamentos
                                                        </button>
                                                    </li>
                                                    <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes" nomeops="configuracoes_ligacoes" seletor_conteudo="div.div_configuracoes_ligacoes">
                                                        <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_99990007" aria-expanded="false">
                                                            Ligacoes
                                                        </button>
                                                        <div class="collapse" id="collapse_99990007">
                                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                                                <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes_tabelasis" nomeops="configuracoes_ligacoes_tabelasis" seletor_conteudo="div.div_configuracoes_ligacoes_tabelasis">
                                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                                        Ligacoes tabela sistema
                                                                    </button>
                                                                </li>
                                                                <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes_camposis" nomeops="configuracoes_ligacoes_camposis" seletor_conteudo="div.div_configuracoes_ligacoes_camposis">
                                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                                        Ligacoes campo sistema
                                                                    </button>
                                                                </li>
                                                                <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes_tabeladb" nomeops="configuracoes_ligacoes_tabeladb" seletor_conteudo="div.div_configuracoes_ligacoes_tabeladb">
                                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                                        Ligacoes tabela db
                                                                    </button>
                                                                </li>
                                                                <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes_campodb" nomeops="configuracoes_ligacoes_campodb" seletor_conteudo="div.div_configuracoes_ligacoes_campodb">
                                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                                        Ligacoes campo db
                                                                    </button>
                                                                </li>
                                                                <li carr_din="1" carregado="NAO" objeto="configuracoes_ligacoes_relacionamentos" nomeops="configuracoes_ligacoes_relacionamentos" seletor_conteudo="div.div_configuracoes_ligacoes_relacionamentos">
                                                                    <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                                        Ligacoes relacionamentos
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="meus_dados" nomeops="meus_dados" seletor_conteudo="div.meus_dados">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Meus dados
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li carr_din="1" carregado="NAO" objeto="manutencao" nomeops="manutencao" seletor_conteudo="div.div_manutencao">
                                <button class="btn align-items-center rounded collapsed btn_menu btn-toggle" data-bs-toggle="collapse" data-bs-target="#collapse_10000" aria-expanded="false">
                                    Manutencao
                                </button>
                                <div class="collapse" id="collapse_10000">
                                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                        <li carr_din="1" carregado="NAO" objeto="atualizacoes_sistema" nomeops="atualizacoes_sistema" seletor_conteudo="div.div_atualizacoes_sistema">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Atualizacoes sistema
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="editar_catalogos" nomeops="editar_catalogos" seletor_conteudo="div.div_editar_catalogos">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Editar catalogos
                                            </button>
                                        </li>
                                        <li carr_din="1" carregado="NAO" objeto="atualizacoes_eventuais" nomeops="atualizacoes_eventuais" seletor_conteudo="div.atualizacoes_eventuais">
                                            <button class="btn align-items-center rounded collapsed btn_menu" onclick="window.fnevt.clicou_link_abrir_itemmenu(this,event)">
                                                Atualizacoes_eventuais sistema
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
            <div class="col bg-info bg-gradient">
                <div class="row">
                    <div class="m-1 col">
                        <div class="mt-2 card_meus_valores card">
                            <div class="card-header">Meus Valores
                                <div style="float:right;" classe_botao="btn-secondary" aoselecionaropcao="window.fnsisjd.selecionou_mes_inicio(this)" class="div_combobox" tem_inputs="1" multiplo="0" tipo_inputs="radio" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_179483021" num_max_texto_botao="5">
                                    <button type="button" class="btn dropdown-toggle btn-secondary" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">
                                        JANEIRO
                                    </button>
                                    <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)" aoselecionaropcao="window.fnsisjd.selecionou_mes_inicio(this)">
                                        <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO">
                                            <label textodepois="1"><input type="radio" name="_179483021" checked="1">JANEIRO</label>
                                        </li>
                                        <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO">
                                            <label textodepois="1"><input type="radio" name="_179483021">FEVEREIRO</label>
                                        </li>
                                        <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO">
                                            <label textodepois="1"><input type="radio" name="_179483021">MARCO</label>
                                        </li>
                                        <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL">
                                            <label textodepois="1"><input type="radio" name="_179483021">ABRIL</label>
                                        </li>
                                        <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO">
                                            <label textodepois="1"><input type="radio" name="_179483021">MAIO</label>
                                            /li>
                                        <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO">
                                            <label textodepois="1"><input type="radio" name="_179483021">JUNHO</label>
                                        </li>
                                        <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO">
                                            <label textodepois="1"><input type="radio" name="_179483021">JULHO</label>
                                        </li>
                                        <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO">
                                            <label textodepois="1"><input type="radio" name="_179483021">AGOSTO</label>
                                        </li>
                                        <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO">
                                            <label textodepois="1"><input type="radio" name="_179483021">SETEMBRO</label>
                                        </li>
                                        <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO">
                                            <label textodepois="1"><input type="radio" name="_179483021">OUTUBRO</label>
                                        </li>
                                        <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO">
                                            <label textodepois="1"><input type="radio" name="_179483021">NOVEMBRO</label>
                                        </li>
                                        <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO">
                                            <label textodepois="1"><input type="radio" name="_179483021">DEZEMBRO</label>
                                        </li>
                                    </ul>
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
                                                        <span class="h5 mb-0">7.640.002,17</span>
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
                                                        <span class="h5 mb-0">576.675,96</span>
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
                                                            3.963
                                                            <span class="position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10">JAN</span>
                                                        </button>
                                                        /
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0">
                                                            4.812
                                                            <span class="position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10">DEZ</span>
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
                                                            179
                                                            <span class="position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10">JAN</span>
                                                        </button>
                                                        /
                                                        <button type="button" class="btn-outline position-relative bg-transparent border-0">
                                                            224
                                                            <span class="position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10">DEZ</span>
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
                <div class="row">
                    <div class="m-1 col">
                        <div class="card_mais_recentes card">
                            <div class="card-header">Mais Recentes</div>
                            <div class="card-body">
                                <div class="row">
                                <div title="21/01/2022 15:43:08" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="entregas" seletorconteudo="div.div_entregas">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/devolucao.png"></div>
                                        <div class="card-footer">Entregas</div>
                                    </div>
                                </div>
                                <div title="20/01/2022 15:31:50" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="relatorio_personalizado" seletorconteudo="div.div_relatorio_personalizado">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/relatorio_personalizado.png"></div>
                                        <div class="card-footer">relatorio personalizado</div>
                                    </div>
                                </div>
                                <div title="18/01/2022 15:35:54" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_sinergia" seletorconteudo="div.div_consultar_sinergia">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/sinergia.png"></div>
                                        <div class="card-footer">Sinergia</div>
                                    </div>
                                </div>
                                <div title="18/01/2022 11:54:02" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_campanhas_estruturadas" seletorconteudo="div.div_consultar_campanhas_estruturadas">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/campanhas_estruturadas.png"></div>
                                        <div class="card-footer">Consultar Campanhas Estruturadas</div>
                                    </div>
                                </div>
                                <div title="18/01/2022 08:29:08" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_painel" seletorconteudo="div.div_consultar_sinergia2">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/painel.png"></div>
                                        <div class="card-footer">Painel</div>
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
                            <div class="card-header">Mais Acessados</div>
                            <div class="card-body">
                                <div class="row">
                                <div title="460" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_painel" seletorconteudo="div.div_consultar_sinergia2">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/painel.png"></div>
                                        <div class="card-footer">Painel</div>
                                    </div>
                                </div>
                                <div title="427" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_campanhas_estruturadas" seletorconteudo="div.div_consultar_campanhas_estruturadas">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/campanhas_estruturadas.png"></div>
                                        <div class="card-footer">Consultar Campanhas Estruturadas</div>
                                    </div>
                                </div>
                                <div title="359" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="relatorio_personalizado" seletorconteudo="div.div_relatorio_personalizado">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/relatorio_personalizado.png"></div>
                                        <div class="card-footer">relatorio personalizado</div>
                                    </div>
                                </div>
                                <div title="67" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="consultar_sinergia" seletorconteudo="div.div_consultar_sinergia">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/sinergia.png"></div>
                                        <div class="card-footer">Sinergia</div>
                                    </div>
                                </div>
                                <div title="26" class="col card_atalho_inicio" onclick="window.fnsisjd.acessar_atalho_menu({elemento:this})" nomeops="clientesativosxpositivados" seletorconteudo="div.div_clientesativosxpositivados">
                                    <div class="card col card_atalho_inicio">
                                        <div class="card-body"><img src="/sjd/images/clienteativoxposit.png"></div>
                                        <div class="card-footer">clientes ativos x positivados</div>
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
</html>