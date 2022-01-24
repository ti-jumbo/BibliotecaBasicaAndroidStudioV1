<?php
    namespace SJD\relatorios\campanhas\consultar_campanhas;

    include_once($_SERVER['DOCUMENT_ROOT']."/SJD/php/initial_loads.php");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SisJD - Consultar Sinergia - Objetivos</title>
    <link href="/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/sjd/css/estilos.css" rel="stylesheet">
    <script type="text/javascript" src="/sjd/javascript/polyfill.js"></script>
    <script type="text/javascript" src="/jquery/3.6.0/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="/sjd/javascript/modulos/ModuloPrincipal.js?2.00"></script>
</head>
<body>
   <main style="display: block;">
      <div class="container-fluid p-0 m-0">
         <div class="row p-0 m-0">
             <div class="col p-0 m-0">
                <div id="barra_superior" class="barra_superior bg-dark text-white text-center text-uppercase fw-bolder position-relative">                              
                    <text class="position-absolute top-50 start-50 translate-middle">
                        Consultar Sinergia - Objetivos
                    </text>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div name="div_pagina" class="div_pagina container-fluid" style="width: 100%; min-width: 100%; inset: 50px 0px 0px;">
                    <div name="div_grid_linha_corpo_pagina" class="row">
                        <div name="div_grid_col_corpo_pagina" class="col">
                            <div name="div_conteudo_pagina" class="div_conteudo_pagina container-fluid _0_08210330281966982 _0_5719079048194048">
                                <div></div>
                                <div name="div_consultar_sinergia" class="div_consultar_sinergia container-fluid corpo-conteudo" ajuda_elemento="Escolha suas opcoes e consulte as metas em funcao das visoes disponiveis!" data-tit_aba="Campanhas" data-tit_aba_img="../images/img_aba_camp.png">
                                <div name="div_objetivos" class="div_objetivos" data-tit_aba="Campanha Jumbo">
                                    <div name="div_opcoes_pesquisa" class="div_opcoes_pesquisa">
                                        <div name="div_opcoes" class="div_opcoes">
                                            <div name="div_opcoes" class="div_opcoes_cab_escondida naomostrar" style="display: none">
                                            <div name="div_opcoes_cab_tit_escondida" class="div_opcoes_cab_tit_escondida"></div>
                                            <div name="div_opcoes_cab_comandos_escondida" class="div_opcoes_cab_comandos_escondida"></div>
                                            </div>
                                            <div name="div_opcoes_corpo" class="div_opcoes_corpo" style="border-top: none;margin-top: 0px;box-shadow:none">
                                            <div name="div_opcoes_corpo_opcoes" class="div_opcoes_corpo_opcoes row" data-ind="1">
                                                <div name="div_opcao" class="div_opcao col">
                                                    <div name="div_opcao_tit" class="div_opcao_tit">Visualizar Por</div>
                                                    <div name="div_opcao_controles" class="div_opcao_controles">
                                                        <div tem_inputs="1" multiplo="0" selecionar_todos="0" filtro="1" classe_botao="btn-dark" class="div_combobox" placeholder="(Selecione)" tipo_inputs="radio" name_inpus="_822940177" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                        <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Produto</button>
                                                        <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                            <input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                            <li opcoes_texto_opcao="Filial" opcoes_texto_botao="Filial" opcoes_valor_opcao="Filial" class="dropdown-item li" data-valor_opcao="Filial" data-texto_botao="Filial"><label textodepois="1"><input type="radio" name="_822940177">Filial</label></li>
                                                            <li opcoes_texto_opcao="Supervisor" opcoes_texto_botao="Supervisor" opcoes_valor_opcao="Supervisor" class="dropdown-item li" data-valor_opcao="Supervisor" data-texto_botao="Supervisor"><label textodepois="1"><input type="radio" name="_822940177">Supervisor</label></li>
                                                            <li opcoes_texto_opcao="RCA" opcoes_texto_botao="RCA" opcoes_valor_opcao="RCA" class="dropdown-item li" data-valor_opcao="RCA" data-texto_botao="RCA"><label textodepois="1"><input type="radio" name="_822940177">RCA</label></li>
                                                            <li opcoes_texto_opcao="Departamento" opcoes_texto_botao="Departamento" opcoes_valor_opcao="Departamento" class="dropdown-item li" data-valor_opcao="Departamento" data-texto_botao="Departamento"><label textodepois="1"><input type="radio" name="_822940177">Departamento</label></li>
                                                            <li opcoes_texto_opcao="Produto" opcoes_texto_botao="Produto" opcoes_valor_opcao="Produto" class="dropdown-item li" data-valor_opcao="Produto" data-texto_botao="Produto"><label textodepois="1"><input type="radio" name="_822940177" checked="1">Produto</label></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    <div name="div_opcao_controles_deletar" class="div_opcao_controles_deletar"></div>
                                                </div>
                                                <div name="div_opcao" class="div_opcao col">
                                                    <div name="div_opcao_tit" class="div_opcao_tit">RCA</div>
                                                    <div name="div_opcao_controles" class="div_opcao_controles">
                                                        <div tem_inputs="1" multiplo="1" selecionar_todos="1" filtro="1" classe_botao="btn-dark" class="div_combobox" placeholder="(Selecione)" tipo_inputs="checkbox" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                        <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">Todos (60)</button>
                                                        <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                            <label class="label_selecionar_todos" textodepois="1"><input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">Selecionar Todos</label><input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                            <li opcoes_texto_opcao="101" opcoes_texto_botao="101" opcoes_valor_opcao="101" class="dropdown-item li" data-valor_opcao="101" data-texto_botao="101"><label textodepois="1"><input type="checkbox" checked="1">101</label></li>
                                                            <li opcoes_texto_opcao="102" opcoes_texto_botao="102" opcoes_valor_opcao="102" class="dropdown-item li" data-valor_opcao="102" data-texto_botao="102"><label textodepois="1"><input type="checkbox" checked="1">102</label></li>
                                                            <li opcoes_texto_opcao="104" opcoes_texto_botao="104" opcoes_valor_opcao="104" class="dropdown-item li" data-valor_opcao="104" data-texto_botao="104"><label textodepois="1"><input type="checkbox" checked="1">104</label></li>
                                                            <li opcoes_texto_opcao="105" opcoes_texto_botao="105" opcoes_valor_opcao="105" class="dropdown-item li" data-valor_opcao="105" data-texto_botao="105"><label textodepois="1"><input type="checkbox" checked="1">105</label></li>
                                                            <li opcoes_texto_opcao="106" opcoes_texto_botao="106" opcoes_valor_opcao="106" class="dropdown-item li" data-valor_opcao="106" data-texto_botao="106"><label textodepois="1"><input type="checkbox" checked="1">106</label></li>
                                                            <li opcoes_texto_opcao="107" opcoes_texto_botao="107" opcoes_valor_opcao="107" class="dropdown-item li" data-valor_opcao="107" data-texto_botao="107"><label textodepois="1"><input type="checkbox" checked="1">107</label></li>
                                                            <li opcoes_texto_opcao="108" opcoes_texto_botao="108" opcoes_valor_opcao="108" class="dropdown-item li" data-valor_opcao="108" data-texto_botao="108"><label textodepois="1"><input type="checkbox" checked="1">108</label></li>
                                                            <li opcoes_texto_opcao="109" opcoes_texto_botao="109" opcoes_valor_opcao="109" class="dropdown-item li" data-valor_opcao="109" data-texto_botao="109"><label textodepois="1"><input type="checkbox" checked="1">109</label></li>
                                                            <li opcoes_texto_opcao="110" opcoes_texto_botao="110" opcoes_valor_opcao="110" class="dropdown-item li" data-valor_opcao="110" data-texto_botao="110"><label textodepois="1"><input type="checkbox" checked="1">110</label></li>
                                                            <li opcoes_texto_opcao="112" opcoes_texto_botao="112" opcoes_valor_opcao="112" class="dropdown-item li" data-valor_opcao="112" data-texto_botao="112"><label textodepois="1"><input type="checkbox" checked="1">112</label></li>
                                                            <li opcoes_texto_opcao="113" opcoes_texto_botao="113" opcoes_valor_opcao="113" class="dropdown-item li" data-valor_opcao="113" data-texto_botao="113"><label textodepois="1"><input type="checkbox" checked="1">113</label></li>
                                                            <li opcoes_texto_opcao="115" opcoes_texto_botao="115" opcoes_valor_opcao="115" class="dropdown-item li" data-valor_opcao="115" data-texto_botao="115"><label textodepois="1"><input type="checkbox" checked="1">115</label></li>
                                                            <li opcoes_texto_opcao="117" opcoes_texto_botao="117" opcoes_valor_opcao="117" class="dropdown-item li" data-valor_opcao="117" data-texto_botao="117"><label textodepois="1"><input type="checkbox" checked="1">117</label></li>
                                                            <li opcoes_texto_opcao="118" opcoes_texto_botao="118" opcoes_valor_opcao="118" class="dropdown-item li" data-valor_opcao="118" data-texto_botao="118"><label textodepois="1"><input type="checkbox" checked="1">118</label></li>
                                                            <li opcoes_texto_opcao="121" opcoes_texto_botao="121" opcoes_valor_opcao="121" class="dropdown-item li" data-valor_opcao="121" data-texto_botao="121"><label textodepois="1"><input type="checkbox" checked="1">121</label></li>
                                                            <li opcoes_texto_opcao="122" opcoes_texto_botao="122" opcoes_valor_opcao="122" class="dropdown-item li" data-valor_opcao="122" data-texto_botao="122"><label textodepois="1"><input type="checkbox" checked="1">122</label></li>
                                                            <li opcoes_texto_opcao="124" opcoes_texto_botao="124" opcoes_valor_opcao="124" class="dropdown-item li" data-valor_opcao="124" data-texto_botao="124"><label textodepois="1"><input type="checkbox" checked="1">124</label></li>
                                                            <li opcoes_texto_opcao="127" opcoes_texto_botao="127" opcoes_valor_opcao="127" class="dropdown-item li" data-valor_opcao="127" data-texto_botao="127"><label textodepois="1"><input type="checkbox" checked="1">127</label></li>
                                                            <li opcoes_texto_opcao="129" opcoes_texto_botao="129" opcoes_valor_opcao="129" class="dropdown-item li" data-valor_opcao="129" data-texto_botao="129"><label textodepois="1"><input type="checkbox" checked="1">129</label></li>
                                                            <li opcoes_texto_opcao="130" opcoes_texto_botao="130" opcoes_valor_opcao="130" class="dropdown-item li" data-valor_opcao="130" data-texto_botao="130"><label textodepois="1"><input type="checkbox" checked="1">130</label></li>
                                                            <li opcoes_texto_opcao="180" opcoes_texto_botao="180" opcoes_valor_opcao="180" class="dropdown-item li" data-valor_opcao="180" data-texto_botao="180"><label textodepois="1"><input type="checkbox" checked="1">180</label></li>
                                                            <li opcoes_texto_opcao="201" opcoes_texto_botao="201" opcoes_valor_opcao="201" class="dropdown-item li" data-valor_opcao="201" data-texto_botao="201"><label textodepois="1"><input type="checkbox" checked="1">201</label></li>
                                                            <li opcoes_texto_opcao="202" opcoes_texto_botao="202" opcoes_valor_opcao="202" class="dropdown-item li" data-valor_opcao="202" data-texto_botao="202"><label textodepois="1"><input type="checkbox" checked="1">202</label></li>
                                                            <li opcoes_texto_opcao="203" opcoes_texto_botao="203" opcoes_valor_opcao="203" class="dropdown-item li" data-valor_opcao="203" data-texto_botao="203"><label textodepois="1"><input type="checkbox" checked="1">203</label></li>
                                                            <li opcoes_texto_opcao="204" opcoes_texto_botao="204" opcoes_valor_opcao="204" class="dropdown-item li" data-valor_opcao="204" data-texto_botao="204"><label textodepois="1"><input type="checkbox" checked="1">204</label></li>
                                                            <li opcoes_texto_opcao="205" opcoes_texto_botao="205" opcoes_valor_opcao="205" class="dropdown-item li" data-valor_opcao="205" data-texto_botao="205"><label textodepois="1"><input type="checkbox" checked="1">205</label></li>
                                                            <li opcoes_texto_opcao="206" opcoes_texto_botao="206" opcoes_valor_opcao="206" class="dropdown-item li" data-valor_opcao="206" data-texto_botao="206"><label textodepois="1"><input type="checkbox" checked="1">206</label></li>
                                                            <li opcoes_texto_opcao="207" opcoes_texto_botao="207" opcoes_valor_opcao="207" class="dropdown-item li" data-valor_opcao="207" data-texto_botao="207"><label textodepois="1"><input type="checkbox" checked="1">207</label></li>
                                                            <li opcoes_texto_opcao="208" opcoes_texto_botao="208" opcoes_valor_opcao="208" class="dropdown-item li" data-valor_opcao="208" data-texto_botao="208"><label textodepois="1"><input type="checkbox" checked="1">208</label></li>
                                                            <li opcoes_texto_opcao="209" opcoes_texto_botao="209" opcoes_valor_opcao="209" class="dropdown-item li" data-valor_opcao="209" data-texto_botao="209"><label textodepois="1"><input type="checkbox" checked="1">209</label></li>
                                                            <li opcoes_texto_opcao="210" opcoes_texto_botao="210" opcoes_valor_opcao="210" class="dropdown-item li" data-valor_opcao="210" data-texto_botao="210"><label textodepois="1"><input type="checkbox" checked="1">210</label></li>
                                                            <li opcoes_texto_opcao="211" opcoes_texto_botao="211" opcoes_valor_opcao="211" class="dropdown-item li" data-valor_opcao="211" data-texto_botao="211"><label textodepois="1"><input type="checkbox" checked="1">211</label></li>
                                                            <li opcoes_texto_opcao="212" opcoes_texto_botao="212" opcoes_valor_opcao="212" class="dropdown-item li" data-valor_opcao="212" data-texto_botao="212"><label textodepois="1"><input type="checkbox" checked="1">212</label></li>
                                                            <li opcoes_texto_opcao="213" opcoes_texto_botao="213" opcoes_valor_opcao="213" class="dropdown-item li" data-valor_opcao="213" data-texto_botao="213"><label textodepois="1"><input type="checkbox" checked="1">213</label></li>
                                                            <li opcoes_texto_opcao="214" opcoes_texto_botao="214" opcoes_valor_opcao="214" class="dropdown-item li" data-valor_opcao="214" data-texto_botao="214"><label textodepois="1"><input type="checkbox" checked="1">214</label></li>
                                                            <li opcoes_texto_opcao="215" opcoes_texto_botao="215" opcoes_valor_opcao="215" class="dropdown-item li" data-valor_opcao="215" data-texto_botao="215"><label textodepois="1"><input type="checkbox" checked="1">215</label></li>
                                                            <li opcoes_texto_opcao="217" opcoes_texto_botao="217" opcoes_valor_opcao="217" class="dropdown-item li" data-valor_opcao="217" data-texto_botao="217"><label textodepois="1"><input type="checkbox" checked="1">217</label></li>
                                                            <li opcoes_texto_opcao="218" opcoes_texto_botao="218" opcoes_valor_opcao="218" class="dropdown-item li" data-valor_opcao="218" data-texto_botao="218"><label textodepois="1"><input type="checkbox" checked="1">218</label></li>
                                                            <li opcoes_texto_opcao="220" opcoes_texto_botao="220" opcoes_valor_opcao="220" class="dropdown-item li" data-valor_opcao="220" data-texto_botao="220"><label textodepois="1"><input type="checkbox" checked="1">220</label></li>
                                                            <li opcoes_texto_opcao="221" opcoes_texto_botao="221" opcoes_valor_opcao="221" class="dropdown-item li" data-valor_opcao="221" data-texto_botao="221"><label textodepois="1"><input type="checkbox" checked="1">221</label></li>
                                                            <li opcoes_texto_opcao="223" opcoes_texto_botao="223" opcoes_valor_opcao="223" class="dropdown-item li" data-valor_opcao="223" data-texto_botao="223"><label textodepois="1"><input type="checkbox" checked="1">223</label></li>
                                                            <li opcoes_texto_opcao="224" opcoes_texto_botao="224" opcoes_valor_opcao="224" class="dropdown-item li" data-valor_opcao="224" data-texto_botao="224"><label textodepois="1"><input type="checkbox" checked="1">224</label></li>
                                                            <li opcoes_texto_opcao="225" opcoes_texto_botao="225" opcoes_valor_opcao="225" class="dropdown-item li" data-valor_opcao="225" data-texto_botao="225"><label textodepois="1"><input type="checkbox" checked="1">225</label></li>
                                                            <li opcoes_texto_opcao="226" opcoes_texto_botao="226" opcoes_valor_opcao="226" class="dropdown-item li" data-valor_opcao="226" data-texto_botao="226"><label textodepois="1"><input type="checkbox" checked="1">226</label></li>
                                                            <li opcoes_texto_opcao="228" opcoes_texto_botao="228" opcoes_valor_opcao="228" class="dropdown-item li" data-valor_opcao="228" data-texto_botao="228"><label textodepois="1"><input type="checkbox" checked="1">228</label></li>
                                                            <li opcoes_texto_opcao="229" opcoes_texto_botao="229" opcoes_valor_opcao="229" class="dropdown-item li" data-valor_opcao="229" data-texto_botao="229"><label textodepois="1"><input type="checkbox" checked="1">229</label></li>
                                                            <li opcoes_texto_opcao="230" opcoes_texto_botao="230" opcoes_valor_opcao="230" class="dropdown-item li" data-valor_opcao="230" data-texto_botao="230"><label textodepois="1"><input type="checkbox" checked="1">230</label></li>
                                                            <li opcoes_texto_opcao="232" opcoes_texto_botao="232" opcoes_valor_opcao="232" class="dropdown-item li" data-valor_opcao="232" data-texto_botao="232"><label textodepois="1"><input type="checkbox" checked="1">232</label></li>
                                                            <li opcoes_texto_opcao="301" opcoes_texto_botao="301" opcoes_valor_opcao="301" class="dropdown-item li" data-valor_opcao="301" data-texto_botao="301"><label textodepois="1"><input type="checkbox" checked="1">301</label></li>
                                                            <li opcoes_texto_opcao="302" opcoes_texto_botao="302" opcoes_valor_opcao="302" class="dropdown-item li" data-valor_opcao="302" data-texto_botao="302"><label textodepois="1"><input type="checkbox" checked="1">302</label></li>
                                                            <li opcoes_texto_opcao="303" opcoes_texto_botao="303" opcoes_valor_opcao="303" class="dropdown-item li" data-valor_opcao="303" data-texto_botao="303"><label textodepois="1"><input type="checkbox" checked="1">303</label></li>
                                                            <li opcoes_texto_opcao="304" opcoes_texto_botao="304" opcoes_valor_opcao="304" class="dropdown-item li" data-valor_opcao="304" data-texto_botao="304"><label textodepois="1"><input type="checkbox" checked="1">304</label></li>
                                                            <li opcoes_texto_opcao="305" opcoes_texto_botao="305" opcoes_valor_opcao="305" class="dropdown-item li" data-valor_opcao="305" data-texto_botao="305"><label textodepois="1"><input type="checkbox" checked="1">305</label></li>
                                                            <li opcoes_texto_opcao="306" opcoes_texto_botao="306" opcoes_valor_opcao="306" class="dropdown-item li" data-valor_opcao="306" data-texto_botao="306"><label textodepois="1"><input type="checkbox" checked="1">306</label></li>
                                                            <li opcoes_texto_opcao="307" opcoes_texto_botao="307" opcoes_valor_opcao="307" class="dropdown-item li" data-valor_opcao="307" data-texto_botao="307"><label textodepois="1"><input type="checkbox" checked="1">307</label></li>
                                                            <li opcoes_texto_opcao="308" opcoes_texto_botao="308" opcoes_valor_opcao="308" class="dropdown-item li" data-valor_opcao="308" data-texto_botao="308"><label textodepois="1"><input type="checkbox" checked="1">308</label></li>
                                                            <li opcoes_texto_opcao="309" opcoes_texto_botao="309" opcoes_valor_opcao="309" class="dropdown-item li" data-valor_opcao="309" data-texto_botao="309"><label textodepois="1"><input type="checkbox" checked="1">309</label></li>
                                                            <li opcoes_texto_opcao="310" opcoes_texto_botao="310" opcoes_valor_opcao="310" class="dropdown-item li" data-valor_opcao="310" data-texto_botao="310"><label textodepois="1"><input type="checkbox" checked="1">310</label></li>
                                                            <li opcoes_texto_opcao="311" opcoes_texto_botao="311" opcoes_valor_opcao="311" class="dropdown-item li" data-valor_opcao="311" data-texto_botao="311"><label textodepois="1"><input type="checkbox" checked="1">311</label></li>
                                                            <li opcoes_texto_opcao="312" opcoes_texto_botao="312" opcoes_valor_opcao="312" class="dropdown-item li" data-valor_opcao="312" data-texto_botao="312"><label textodepois="1"><input type="checkbox" checked="1">312</label></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    <div name="div_opcao_controles_deletar" class="div_opcao_controles_deletar"></div>
                                                </div>
                                                <div name="div_opcao" class="div_opcao col">
                                                    <div name="div_opcao_tit" class="div_opcao_tit">Mes</div>
                                                    <div name="div_opcao_controles" class="div_opcao_controles">
                                                        <div classe_botao="btn-dark" class="div_combobox" tem_inputs="1" multiplo="0" tipo_inputs="radio" placeholder="(Selecione)" filtro="0" selecionar_todos="0" name_inpus="_701889779" num_max_texto_botao="5">
                                                        <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">JANEIRO</button>
                                                        <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                            <li opcoes_texto_opcao="JANEIRO" opcoes_texto_botao="JANEIRO" opcoes_valor_opcao="JANEIRO" class="dropdown-item li" data-valor_opcao="JANEIRO" data-texto_botao="JANEIRO"><label textodepois="1"><input type="radio" name="_701889779" checked="1">JANEIRO</label></li>
                                                            <li opcoes_texto_opcao="FEVEREIRO" opcoes_texto_botao="FEVEREIRO" opcoes_valor_opcao="FEVEREIRO" class="dropdown-item li" data-valor_opcao="FEVEREIRO" data-texto_botao="FEVEREIRO"><label textodepois="1"><input type="radio" name="_701889779">FEVEREIRO</label></li>
                                                            <li opcoes_texto_opcao="MARCO" opcoes_texto_botao="MARCO" opcoes_valor_opcao="MARCO" class="dropdown-item li" data-valor_opcao="MARCO" data-texto_botao="MARCO"><label textodepois="1"><input type="radio" name="_701889779">MARCO</label></li>
                                                            <li opcoes_texto_opcao="ABRIL" opcoes_texto_botao="ABRIL" opcoes_valor_opcao="ABRIL" class="dropdown-item li" data-valor_opcao="ABRIL" data-texto_botao="ABRIL"><label textodepois="1"><input type="radio" name="_701889779">ABRIL</label></li>
                                                            <li opcoes_texto_opcao="MAIO" opcoes_texto_botao="MAIO" opcoes_valor_opcao="MAIO" class="dropdown-item li" data-valor_opcao="MAIO" data-texto_botao="MAIO"><label textodepois="1"><input type="radio" name="_701889779">MAIO</label></li>
                                                            <li opcoes_texto_opcao="JUNHO" opcoes_texto_botao="JUNHO" opcoes_valor_opcao="JUNHO" class="dropdown-item li" data-valor_opcao="JUNHO" data-texto_botao="JUNHO"><label textodepois="1"><input type="radio" name="_701889779">JUNHO</label></li>
                                                            <li opcoes_texto_opcao="JULHO" opcoes_texto_botao="JULHO" opcoes_valor_opcao="JULHO" class="dropdown-item li" data-valor_opcao="JULHO" data-texto_botao="JULHO"><label textodepois="1"><input type="radio" name="_701889779">JULHO</label></li>
                                                            <li opcoes_texto_opcao="AGOSTO" opcoes_texto_botao="AGOSTO" opcoes_valor_opcao="AGOSTO" class="dropdown-item li" data-valor_opcao="AGOSTO" data-texto_botao="AGOSTO"><label textodepois="1"><input type="radio" name="_701889779">AGOSTO</label></li>
                                                            <li opcoes_texto_opcao="SETEMBRO" opcoes_texto_botao="SETEMBRO" opcoes_valor_opcao="SETEMBRO" class="dropdown-item li" data-valor_opcao="SETEMBRO" data-texto_botao="SETEMBRO"><label textodepois="1"><input type="radio" name="_701889779">SETEMBRO</label></li>
                                                            <li opcoes_texto_opcao="OUTUBRO" opcoes_texto_botao="OUTUBRO" opcoes_valor_opcao="OUTUBRO" class="dropdown-item li" data-valor_opcao="OUTUBRO" data-texto_botao="OUTUBRO"><label textodepois="1"><input type="radio" name="_701889779">OUTUBRO</label></li>
                                                            <li opcoes_texto_opcao="NOVEMBRO" opcoes_texto_botao="NOVEMBRO" opcoes_valor_opcao="NOVEMBRO" class="dropdown-item li" data-valor_opcao="NOVEMBRO" data-texto_botao="NOVEMBRO"><label textodepois="1"><input type="radio" name="_701889779">NOVEMBRO</label></li>
                                                            <li opcoes_texto_opcao="DEZEMBRO" opcoes_texto_botao="DEZEMBRO" opcoes_valor_opcao="DEZEMBRO" class="dropdown-item li" data-valor_opcao="DEZEMBRO" data-texto_botao="DEZEMBRO"><label textodepois="1"><input type="radio" name="_701889779">DEZEMBRO</label></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    <div name="div_opcao_controles_deletar" class="div_opcao_controles_deletar"></div>
                                                </div>
                                                <div name="div_opcao" class="div_opcao col">
                                                    <div name="div_opcao_tit" class="div_opcao_tit">Ano</div>
                                                    <div name="div_opcao_controles" class="div_opcao_controles">
                                                        <div tem_inputs="1" selecionar_todos="1" filtro="1" classe_botao="btn-dark" class="div_combobox" placeholder="(Selecione)" tipo_inputs="checkbox" multiplo="1" num_max_texto_botao="5" funcao_filtro="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                        <button type="button" class="btn dropdown-toggle btn-dark" data-bs-toggle="dropdown" aria-expanded="false" num_max_texto_botao="5" data-bs-auto-close="outside">2022</button>
                                                        <ul class="dropdown-menu" onclick="window.fnhtml.fndrop.clicou_dropdown(event,this)">
                                                            <label class="label_selecionar_todos" textodepois="1"><input type="checkbox" class="input_selecionar_todos" onchange="window.fnhtml.fndrop.selecionou_todos_dropdown(event,this)">Selecionar Todos</label><input type="text" class="input_filtro_dropdown rounded" placeholder="(filtro)" onkeyup="window.fnhtml.fndrop.filtrar_dropdown(this)">
                                                            <li opcoes_texto_opcao="2017" opcoes_texto_botao="2017" opcoes_valor_opcao="2017" class="dropdown-item li" data-valor_opcao="2017" data-texto_botao="2017"><label textodepois="1"><input type="checkbox">2017</label></li>
                                                            <li opcoes_texto_opcao="2018" opcoes_texto_botao="2018" opcoes_valor_opcao="2018" class="dropdown-item li" data-valor_opcao="2018" data-texto_botao="2018"><label textodepois="1"><input type="checkbox">2018</label></li>
                                                            <li opcoes_texto_opcao="2019" opcoes_texto_botao="2019" opcoes_valor_opcao="2019" class="dropdown-item li" data-valor_opcao="2019" data-texto_botao="2019"><label textodepois="1"><input type="checkbox">2019</label></li>
                                                            <li opcoes_texto_opcao="2020" opcoes_texto_botao="2020" opcoes_valor_opcao="2020" class="dropdown-item li" data-valor_opcao="2020" data-texto_botao="2020"><label textodepois="1"><input type="checkbox">2020</label></li>
                                                            <li opcoes_texto_opcao="2021" opcoes_texto_botao="2021" opcoes_valor_opcao="2021" class="dropdown-item li" data-valor_opcao="2021" data-texto_botao="2021"><label textodepois="1"><input type="checkbox">2021</label></li>
                                                            <li opcoes_texto_opcao="2022" opcoes_texto_botao="2022" opcoes_valor_opcao="2022" class="dropdown-item li" data-valor_opcao="2022" data-texto_botao="2022"><label textodepois="1"><input type="checkbox" checked="1">2022</label></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    <div name="div_opcao_controles_deletar" class="div_opcao_controles_deletar"></div>
                                                </div>
                                                <div name="div_atualizar" class="div_atualizar col-12 m-2"><button name="botao_pesquisar" class="botao_pesquisar botao_padrao btn btn-primary w-50" value="Pesquisar" onclick="window.fnsisjd.pesquisar_sinergia(this)" type="button" data-visao="sinergia">Pesquisar</button></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div name="div_resultado_sinergia" class="div_resultado div_resultado_sinergia">
                                        <ul name="lista1">
                                            <li name="texto_escolha" style="margin-left:15px">ESCOLHA SUAS OPCOES E CLIQUE EM PESQUISAR PARA CARREGAR OS VALORES</li>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div name="div_data_aurora" id="div_data_aurora" class="div_data_aurora" style="color: white;flot: right;position: fixed;top: 2px;right: 19px;font-size: 11px;font-wheight: bolder;z-index: 1000;background-color: gray;border-radius: 5px;">
                    <text name="data_aurora" id="data_aurora" class="texto_data_aurora data_aurora">[Data Aurora: 21/01/22]</text>
                </div>
            </div>
         </div>
      </div>
   </main>
</body>
</html>