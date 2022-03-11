<?php
   namespace SJD\relatorios;
   include_once $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/defaultinit.php';    
   $GLOBALS['data-visao'] = 'consultar_ratingsfocais'; 
   $GLOBALS['tem_campos_avulsos'] = false;
   $GLOBALS['permite_incluir_periodo'] = false;
   $GLOBALS['permite_incluir_visao'] = false;
   $GLOBALS['inserir_visao_inicial'] = false;
   $GLOBALS['tipos_check_ver_vals_de'] = 'radio';
   include $_SERVER['DOCUMENT_ROOT'].'/SJD/php/html/partials/default_div_relatorio.php'; 
?>
<script type="module">
    const {default:fnsisjd} = await import("/sjd/javascript/modulos/classes/sisjd/FuncoesSisJD.js?"+window.version_loads).catch((error)=>{console.log(error);alert("Erro de carregamento de modulos.\nPor favor, tente atualizar a pagina novamente com Ctrl+F5.\nSe o erro persistir mesmo assim, tente limpar o historico do navegador.\nAinda Persistindo, contacte o administrador da pagina.");});    
    fnsisjd.inserir_visao_pesquisa({elemento:$("div#visoes").children("div").children("div"),selecionado:"Rca",permite_incluir:false,permite_excluir:false});
    $("div#painel_ver_vals_de").children("div").children("div.row").children("div.col").append(''+
        '<label class="rotulo_ver_vals_de width_33pc" textodepois="1">'+
            '<input type="checkbox" class="radio_ver_valores_de" value="10" name="opcao_ver_vals_de_consultar_ratingsfocais_opcao">'+
            'Ver Valores'+
        '</label>'+
        '<label class="rotulo_ver_vals_de width_33pc" textodepois="1">'+
            '<input type="checkbox" class="radio_ver_valores_de" value="11" name="opcao_ver_vals_de_consultar_ratingsfocais_ratings_detalhados">'+
            'Ver Ratings Individuais'+
        '</label>'
    );
</script>