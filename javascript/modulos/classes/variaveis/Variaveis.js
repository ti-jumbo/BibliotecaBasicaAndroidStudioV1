/**Classe Variaveis */
class Variaveis{
    constructor() {
        try {
            console.log("Inicio " + this.constructor.name);
            this.num_limite_recursoes = 100;
            this.iniciou_inclusao_tabela_est = false;
            this.terminou_inclusao_tabela_est = false;
            this.altura_div_conteudo_pagina = 80;
            this.hexadecimais = "0123456789ABCDEF";
            this.sjdreq = [];
            this.bloco_catch = ' } catch(e) { console.log(e);alert(e.message || e); }';
            this.dados = [];
            this.zindexcombobox = 10;
            this.reqs = {
                requisicoes:[]
            };
            this.nome_recurso = null;            
            this.classe_padrao_botao = "btn-dark";
            this.classes = {
                ajuda_suspensa : "ajuda_suspensa",
                ancora : "ancora",
                bloqueado : "bloqueado",
                botao_padrao : "botao_padrao",
                btn_ajuda_fechar : "btn_ajuda_fechar",
                btn_img_add_ctrl : "btn_img_add_ctrl",
                btn_img_excl_ctrl : "btn_img_excl_ctrl",
                btn_img_opcoes_comando : "btn_img_opcoes_comando",
                carregando:"carregando",
                clicavel : "clicavel",
                controle_input_texto : "controle_input_texto",
                desabilitado : "desabilitado",
                div_ano : "div_ano",
                div_calendario : "div_calendario",
                div_carregando : "div_carregando",
                div_combobox:"div_combobox",
                div_opcao : "div_opcao",
                div_opcao_controles : "div_opcao_controles",
                div_opcao_controles_btns_img : "div_opcao_controles_btns_img",			
                div_opcao_tit : "div_opcao_tit",
                div_opcoes : "div_opcoes",
                div_opcoes_corpo : "div_opcoes_corpo",
                div_opcoes_corpo_opcoes : "div_opcoes_corpo_opcoes",
                div_opcoes_pesquisa: "div_opcoes_pesquisa",
                div_resultado : "div_resultado",			
                float_right : "float_right",
                img_ajuda : "img_ajuda",			
                img_btn_menu_esquerdo : "img_btn_menu_esquerdo",		
                img_controle : "img_controle",
                img_dir_opcao_menu : "img_dir_opcao_menu",
                invisivel : "invisivel",
                item_menu : "item_menu",
                linhacomandos : "linhacomandos",
                linhafiltros : "linhafiltros",
                mousehover : "mousehover",
                naomostrar : "naomostrar",
                oculto : "oculto",
                operacao : "operacao",
                simples : "simples",
                tabcorpo : "tabcorpo",
                tabela_est : "tabela_est",            
                tb2 : "tb2",
                ver_valores_de : "ver_valores_de",
                ver_valores_zero : "ver_valores_zero",
                visoes : "visoes"
            },
            this.constantes = {
                meses:["JANEIRO","FEVEREIRO","MARCO","ABRIL","MAIO","JUNHO","JULHO","AGOSTO","SETEMBRO","OUTUBRO","NOVEMBRO","DEZEMBRO"],
                meses_abrev:["JAN","FEV","MAR","ABR","MAI","JUN","JUL","AGO","SET","OUT","NOV","DEZ"],
                anos:[2017,2018,2019],			
                dias_da_semana : ["DOMINGO","SEGUNDA","TERCA","QUARTA","QUINTA","SEXTA","SABADO"],
                dias_da_semana_abrev : ["DOM","SEG","TER","QUA","QUI","SEX","SAB"],
                horas_8_18 : ["08:00","09:00","10:00","11:00","12:00","13:00","14:00","15:00","16:00","17:00","18:00"],
                numeros : [0,1,2,3,4,5,6,7,8,9],
                numstr : ["0","1","2","3","4","5","6","7","8","9"],
                teclas_especiais : ["Home","End","Enter","ArrowUp","ArrowDown","ArrowLeft","ArrowRight","PageUp","PageDown","Backspace","Delete","Escape","Tab","Shift","NumLock","Undefined","Unidentified"]			
            };
            this.seletores = {
                atalho_inicio : "div.atalho_inicio",
                botao_filtrar : "button.botao_filtrar",
                botao_pesquisar : "button.botao_pesquisar",
                div_atualizar : "div.div_atualizar",
                div_barra_inf : "div.div_barra_inf",
                div_barra_inf_img_ajuda : "img.div_barra_inf_img_ajuda",
                div_barra_inf_img_mostrar_barra : "img.div_barra_inf_img_mostrar_barra",
                div_barra_sup : "div.div_barra_sup",
                div_conteudo_barra_sup : "div.div_conteudo_barra_sup",
                div_calendario : "div.div_calendario",
                div_carregando : "div.carregando",
                div_clientesnaopositivados : "div.div_clientesnaopositivados",
                div_combobox : "div.div_combobox",
                div_conteudo_pagina : "div.div_conteudo_pagina",			
                div_item_suspenso : "div.item_suspenso",			
                div_menu_esquerdo : "div.div_menu_esquerdo",
                div_menu_esquerdo_conteudo : "div.div_menu_esquerdo_conteudo",
                div_mostrar_barra_sup : "div.div_mostrar_barra_sup",
                div_opcao_controles : "div.div_opcao_controles",
                div_opcoes : "div.div_opcoes",
                div_opcoes_pesquisa_avancada : "div.div_opcoes_pesquisa_avancada",
                div_recuperar_login : "div.div_recuperar_login",
                div_recuperar_login_conteudo : "div.div_recuperar_login_conteudo",
                div_resultado : "div.div_resultado",
                e_target : "e.target",
                first : "first",
                img_btn_home_rodape : "img.img_btn_home_rodape",
                img_btn_menu_esquerdo : "img.img_btn_menu_esquerdo",
                img_esq_opcao_menu : "img.img_esq_opcao_menu",
                img_mostrar_barra_sup : "img.img_mostrar_barra_sup",
                input_text : "input[type=text]",
                last : "last",
                linha_menu : "div.linha_menu",
                not : "not",
                nth_child : "nth-child",
                tabela_est : "table.tabdados",
                textologprocesso : "textarea.textologprocesso",
                titulo_barra_sup : "text.titulo_barra_sup",
                visible : "visible"
            };
            this.abertura_excel = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets>';
            this.abertura_excel += '<x:ExcelWorksheet><x:Name>Planilha</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>';
            this.fechamento_excel = '</table></html>';
            this.tipo_aplicacao_excel = 'application/vnd.ms-excel';
            this.kg = 'KG';
            this.numdecm2 = 'numdecm2';
            this.numint = 'numint';
            this.pct = '%';
            this.px = 'px';
            this.quebra_linha = '\n';
            this.r$ = "R$";
            this.sepdata = '/';
            this.sepdir='/';
            this.sep_dir=this.sepdir;
            this.sep_end='/';
            this.sepn1 = '_1N_,_N1_';
            this.sepn2 = '_2N_,_N2_';
            this.subst_virg = 'nvirg_nvirg';
            this.extensoes = {
                html : "html",
                gif : "gif",
                js : "js",
                php : "php",
                png : "png",
                xls : "xls"
            };
            this.nex = this.extensoes;

            this.tcomhttp = {
                id_carregando:"",
                id : "",
                requisicao:{
                    id:"",
                    requisitar:{
                        oque:"",
                        qual:{
                            comando:"",
                            tipo_objeto:"",
                            objeto:"",
                            tabela:"",
                            campo:"",
                            valor:"",
                            condicionantes:{}
                        }
                    }
                },
                retorno:{
                    id:"",
                    dados_retornados:"",
                    logs:"",
                    erros:""
                },
                eventos:{
                    aposretornar:""
                },
                opcoes_requisicao:{
                    tipo_carregando:"completo",
                    tipo_alvo_carregando:"tela",
                    mostrar_carregando:true,
                    objeto_carregando:"body"
                },
                opcoes_retorno:{
                    seletor_local_retorno:"",
                    parar_por_erros_sql:true,
                    parar_por_erros_codigo:true,
                    botao_exportar_superior:true,
                    branco_se_zero:false,
                    ignorar_tabela_est:false,
                    subreg:{
                        ativado:false,
                        aoabrir:""
                    },
                    filtro:{
                        ativado:true
                    },
                    ordenacao:{
                        ativado:true
                    }
                },
            };
            this.str_tcomhttp = JSON.stringify(this.tcomhttp);
            this.mensagens = {
                atingido_limite_recursoes : "atingido o numero limite de recursoes: ",
                atualizando_larguras : "atualizando larguas",
                em_andamento : "em andamento",
                erro_dados_retornados_undefined : "comhttp.retorno.dados_retornados e undefined",
                executando_eval : "executando eval: ",
                falha_requisicao : "falha na requisicao: ",
                funcao_nao_existe : "funcao nao existe : ",
                implementar : "implementar",
                nao_imlementado: " nao implementado: ",
                processo_concluido : "processo concluido",
                sem_resultados : "sem resultados",
                tecla_nao_permitida : "tecla nao permitida: "
            };
            this.nomes_funcoes_javascript = {
                after : "after",
                afterend : "afterend",
                append : "append",
                beforeend : "beforeend",
                click : "click",
                closest : "closest",			
                erro : "erro",
                focus : "focus",
                htmlDecode : "window.fnhtml.htmlDecode",
                prevAll : "prevAll",
                prevObject : "prevObject",
                processar_retorno_como_texto_html : "processar_retorno_como_texto_html",
                setTimeout : "setTimeout",
                __proto__ : "__proto__"
            };
            this.nomes_arquivos = {
                carregando : "carregando" + '.' + this.nex.gif,
                carregando128x128 : "carregando128x128" + '.' + this.nex.gif,
                carregar_utilidades_basicas : "carregar_utilidades_basicas" + '.' + this.nex.js,
                checkbox : "checkbox" + '.' + this.nex.png,
                checkbox_checked : "checkbox_checked" + '.' + this.nex.png,
                filesaver : "FileSaver" + '.' + this.nex.js,
                funcoes_abas : "funcoes_abas" + '.' + this.nex.js,
                funcoes_ambiente : "funcoes_ambiente" + '.' + this.nex.js,
                funcoes_arquivo : "funcoes_arquivo" + '.' + this.nex.js,
                funcoes_array : "funcoes_array" + '.' + this.nex.js,
                funcoes_base : "funcoes_base" + '.' + this.nex.js,
                funcoes_calendario : "funcoes_calendario" + '.' + this.nex.js,	
                funcoes_combobox : "funcoes_combobox" + '.' + this.nex.js,
                funcoes_data : "funcoes_data" + '.' + this.nex.js,
                funcoes_erro : "funcoes_erro" + '.' + this.nex.js,
                funcoes_eventos : "funcoes_eventos" + '.' + this.nex.js,
                funcoes_grafico : "funcoes_grafico" + '.' + this.nex.js,
                funcoes_html : "funcoes_html" + '.' + this.nex.js,	
                fnhtml : "window.fnhtml" + '.' + this.nex.js,	
                funcoes_input_combobox : "funcoes_input_combobox" + '.' + this.nex.js,
                funcoes_javascript : "funcoes_javascript" + '.' + this.nex.js,	
                funcoes_listbox : "funcoes_listbox" + '.' + this.nex.js,
                funcoes_matematica : "funcoes_matematica" + '.' + this.nex.js,	
                funcoes_manutencao : "funcoes_manutencao" + '.' + this.nex.js,	
                funcoes_menu_suspenso : "funcoes_menu_suspenso" + '.' + this.nex.js,	
                funcoes_modal : "funcoes_modal" + '.' + this.nex.js,
                funcoes_mover : "funcoes_mover" + '.' + this.nex.js,	
                funcoes_objeto : "funcoes_objeto" + '.' + this.nex.js,	
                funcoes_requisicao : "funcoes_requisicao" + '.' + this.nex.js,
                funcoes_sisjd : "funcoes_sisjd" + '.' + this.nex.js,
                funcoes_string : "funcoes_string" + '.' + this.nex.js,
                funcoes_tabela_est : "funcoes_tabela_est" + '.' + this.nex.js,
                funcoes_tab_reg_uni : "funcoes_tab_reg_uni" + '.' + this.nex.js,
                funcoes_split : "funcoes_split" + '.' + this.nex.js,
                funcoes_basicas : "FuncoesBasicas" + '.' + this.nex.js,
                img_1 : "1" + '.' + this.nex.gif,
                img_abaixo_duplo128 : "abaixo_duplo128" + '.' + this.nex.png,
                img_acima_duplo128 : "img_acima_duplo128" + '.' + this.nex.png,
                img_ajuda16 : "ajuda16" + '.' + this.nex.png,
                img_anexos : "clip" + '.' + this.nex.png,
                img_close16 : "close16" + '.' + this.nex.png,
                img_copiar1_32 : "copiar1_32" + '.' + this.nex.png,
                img_del : "img_del" + '.' + this.nex.png,
                img_deletar1_32 : "deletar1_32" + '.' + this.nex.png,
                img_down32 : "down32" + '.' + this.nex.png,
                img_editar1_32 : "editar1_32" + '.' + this.nex.png,
                img_fechar_cinza : "fechar_cinza" + '.' + this.nex.jpg,	
                img_folder : "folder" + '.' + this.nex.png,	
                green_asc : "green-asc" + '.' + this.nex.gif,	
                green_desc : "green-desc" + '.' + this.nex.gif,	
                green_unsorted : "green-unsorted" + '.' + this.nex.gif,	
                img_mais : "mais" + '.' + this.nex.png,
                img_maisverde32 : "maisverde32" + '.' + this.nex.png,
                img_menu : "gestao" + '.' + this.nex.png,
                img_menos : "menos" + '.' + this.nex.png,
                img_right32 : "right32" + '.' + this.nex.png,
                img_salvar : "salvar" + '.' + this.nex.png,
                img_seta_dropdown : "seta_dropdown" + '.' + this.nex.png,
                img_seta_dropdown_abaixo : "seta_dropdown_abaixo" + '.' + this.nex.png,
                img_seta_dropdown_acima : "seta_dropdown_acima" + '.' + this.nex.png,                    
                login : "login" + '.' + this.nex.html,
                logs : "logs" + '.' + this.nex.png,
                radio : "radio" + '.' + this.nex.png,
                radio_checked : "radio_checked" + '.' + this.nex.png,	
                requisicao_php : "requisicao" + '.' + this.nex.php
            };   
            this.nomes_diretorios = {
                ambiente : "ambiente",
                arquivo : "arquivo",
                array : "array",
                data : "data",
                erro : "erro",
                funcoes : "funcoes",			
                html : "html",
                images : "images",
                javascript : "javascript",	
                matematica : "matematica",
                objeto : "objeto",
                php : "php",
                requisicao : "requisicao",
                sjd : "sjd",
                string : "string",
                arquivos_de_terceiros : "arquivos_de_terceiros"	
            };             
            this.nomes_caminhos_diretorios = {
                sjd : "/SJD"
            };            
            this.nomes_caminhos_diretorios.javascript = this.nomes_caminhos_diretorios.sjd + this.sepdir + this.nomes_diretorios.javascript;
            this.nomes_caminhos_diretorios.php = this.nomes_caminhos_diretorios.sjd + this.sepdir + this.nomes_diretorios.php;
            this.nomes_caminhos_diretorios.images = this.nomes_caminhos_diretorios.sjd + this.sep_dir + this.nomes_diretorios.images;
            this.nomes_caminhos_diretorios.html = this.nomes_caminhos_diretorios.sjd + this.sep_dir + this.nomes_diretorios.html;                
            this.nomes_caminhos_diretorios.arquivos_de_terceiros = this.nomes_caminhos_diretorios.javascript + this.sepdir + this.nomes_diretorios.arquivos_de_terceiros;
            this.nomes_caminhos_diretorios.javascript_funcoes = this.nomes_caminhos_diretorios.javascript + this.sepdir + this.nomes_diretorios.funcoes;
            this.nomes_caminhos_diretorios.php_funcoes = this.nomes_caminhos_diretorios.php + this.sepdir + this.nomes_diretorios.funcoes;
            this.nomes_caminhos_diretorios.funcoes_javascript = this.nomes_caminhos_diretorios.javascript_funcoes + this.sepdir + this.nomes_diretorios.javascript;
            this.nomes_caminhos_diretorios.funcoes_requisicao = this.nomes_caminhos_diretorios.javascript_funcoes + this.sepdir + this.nomes_diretorios.requisicao;
            this.nomes_caminhos_diretorios.funcoes_requisicao_php = this.nomes_caminhos_diretorios.php_funcoes + this.sepdir + this.nomes_diretorios.requisicao;
            this.nomes_caminhos_diretorios.funcoes_ambiente = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.ambiente;
            this.nomes_caminhos_diretorios.funcoes_arquivo = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.arquivo;	
            this.nomes_caminhos_diretorios.funcoes_array = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.array;
            this.nomes_caminhos_diretorios.funcoes_data = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.data;
            this.nomes_caminhos_diretorios.funcoes_erro = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.erro;
            this.nomes_caminhos_diretorios.funcoes_html = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.html;
            this.nomes_caminhos_diretorios.funcoes_matematica = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.matematica;
            this.nomes_caminhos_diretorios.funcoes_objeto = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.objeto;
            this.nomes_caminhos_diretorios.funcoes_sisjd = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.sjd;
            this.nomes_caminhos_diretorios.funcoes_string = this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_diretorios.string;

            this.nomes_caminhos_arquivos = {
                funcoes_javascript : this.nomes_caminhos_diretorios.funcoes_javascript + this.sepdir + this.nomes_arquivos.funcoes_javascript,
                funcoes_requisicao : this.nomes_caminhos_diretorios.funcoes_requisicao + this.sepdir + this.nomes_arquivos.funcoes_requisicao,
                requisicao_php : this.nomes_caminhos_diretorios.funcoes_requisicao_php + this.sepdir + this.nomes_arquivos.requisicao_php,
                requisicao_php_sjd : this.nomes_caminhos_diretorios.funcoes_requisicao_php + this.sepdir + this.nomes_arquivos.requisicao_php,
                carregando : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.carregando,	
                carregando128x128 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.carregando128x128,	
                carregar_utilidades_basicas : this.nomes_caminhos_diretorios.sjd + this.sep_dir + this.nomes_arquivos.carregar_utilidades_basicas,
                checkbox : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.checkbox,
                checkbox_checked : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.checkbox_checked,
                funcoes_abas : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_abas,
                funcoes_ambiente : this.nomes_caminhos_diretorios.funcoes_ambiente + this.sep_dir + this.nomes_arquivos.funcoes_ambiente,	
                funcoes_arquivo : this.nomes_caminhos_diretorios.funcoes_arquivo + this.sep_dir + this.nomes_arquivos.funcoes_arquivo,	
                funcoes_array : this.nomes_caminhos_diretorios.funcoes_array + this.sep_dir + this.nomes_arquivos.funcoes_array,	
                funcoes_base : this.nomes_caminhos_diretorios.funcoes_sisjd + this.sep_dir + this.nomes_arquivos.funcoes_base,	
                funcoes_calendario : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_calendario,
                funcoes_combobox : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_combobox,
                funcoes_input_combobox : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_input_combobox,
                funcoes_data : this.nomes_caminhos_diretorios.funcoes_data + this.sep_dir + this.nomes_arquivos.funcoes_data,
                funcoes_erro : this.nomes_caminhos_diretorios.funcoes_erro + this.sep_dir + this.nomes_arquivos.funcoes_erro,
                funcoes_eventos : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_eventos,
                funcoes_grafico : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_grafico,
                funcoes_html : this.nomes_caminhos_diretorios.funcoes_html + this.sep_dir + this.nomes_arquivos.funcoes_html,
                fnhtml : this.nomes_caminhos_diretorios.funcoes_html + this.sep_dir + this.nomes_arquivos.fnhtml,
                funcoes_listbox : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_listbox,
                funcoes_manutencao : this.nomes_caminhos_diretorios.funcoes_sisjd + this.sep_dir + this.nomes_arquivos.funcoes_manutencao,
                funcoes_matematica : this.nomes_caminhos_diretorios.funcoes_matematica + this.sep_dir + this.nomes_arquivos.funcoes_matematica,
                funcoes_menu_suspenso : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_menu_suspenso,
                funcoes_modal : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_modal,
                funcoes_mover : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_mover,
                funcoes_objeto : this.nomes_caminhos_diretorios.funcoes_objeto + this.sep_dir + this.nomes_arquivos.funcoes_objeto,
                funcoes_sisjd : this.nomes_caminhos_diretorios.funcoes_sisjd + this.sep_dir + this.nomes_arquivos.funcoes_sisjd,
                funcoes_string : this.nomes_caminhos_diretorios.funcoes_string + this.sep_dir + this.nomes_arquivos.funcoes_string,
                funcoes_tabela_est : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_tabela_est,		
                funcoes_tab_reg_uni : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_tab_reg_uni,		
                funcoes_split : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.funcoes_split,		
                funcoes_basicas : this.nomes_caminhos_diretorios.javascript_funcoes + this.sep_dir + this.nomes_arquivos.funcoes_basicas,		
                img_1 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_1,	
                img_anexos : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_anexos,	
                img_abaixo_duplo128 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_abaixo_duplo128,	
                img_acima_duplo128 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_acima_duplo128,	
                img_ajuda16 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_ajuda16,	
                img_close16 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_close16,	
                img_copiar1_32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_copiar1_32,	
                img_del : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_del,	
                img_deletar1_32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_deletar1_32,	
                img_down32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_down32,	
                img_editar1_32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_editar1_32,	
                img_fechar_cinza : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_fechar_cinza,	
                img_folder : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_folder,	
                green_asc : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.green_asc,	
                green_desc : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.green_desc,	
                green_unsorted : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.green_unsorted,	
                img_mais : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_mais,	
                img_maisverde32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_maisverde32,	
                img_menu : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_menu,	
                img_menos : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_menos,	
                img_right32 : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_right32,	
                img_salvar : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_salvar,	
                img_seta_dropdown : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_seta_dropdown,	
                img_seta_dropdown_abaixo : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_seta_dropdown_abaixo,	
                img_seta_dropdown_acima : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.img_seta_dropdown_acima,	
                login : this.nomes_caminhos_diretorios.html + this.sep_dir + this.nomes_arquivos.login,
                logs : this.nomes_caminhos_diretorios.funcoes_javascript + this.sep_dir + this.nomes_arquivos.logs,	
                radio : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.radio,
                radio_checked : this.nomes_caminhos_diretorios.images + this.sep_dir + this.nomes_arquivos.radio_checked                    
            };                
            this.nomes_caminhos_relativos = {};  
            this.consts = this.constantes;             
            this.nfj = this.nomes_funcoes_javascript;
            this.ncl = this.classes;
            this.na = this.nomes_arquivos;
            this.ncd = this.nomes_caminhos_diretorios;
            this.nca = this.nomes_caminhos_arquivos;
            this.ncr = this.nomes_caminhos_relativos;
            this.var_sis = this;
            this.visoes = null;
            this.dados_filtros = {
                "filtros":{
                    "basico":{
                        "cliente":{
                            "title":"Pesquisa Basica Cliente",
                            "filters":[
                                {
                                "title":"Cód. Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codfilialnf"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de filial"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_filial"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Rca",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codusur1"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de Rca"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_rca"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Cli",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codcli"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Avancada com mais campos e opções"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_avancada_cliente"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cnpj/CPF",
                                "type":"number",
                                "class":"col-md-3",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.cgcent"
                                    }
                                ]
                                },
                                {
                                "title":"Razão / Nome / Fantasia",
                                "type":"text",
                                "row":1,
                                "class":"col-md-9",
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.cliente_fantasia"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ],
                            "expressoes":{
                                "pcclient.cliente_fantasia":"(lower(pcclient.cliente) __OP__ __VALUE__ __JUNCAO__ lower(pcclient.fantasia) __OP__ __VALUE__)",
                                "pcclient.codfilialnf":"pcclient.codfilialnf __OP__ __VALUE__"
                            }
                        },
                        "filial":{
                            "title":"Pesquisa Basica Filial",
                            "filters":[
                                {
                                "title":"Cód. Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.codigo"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa avançada de filial"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_avancada_filial"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cidade Filial",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.cidade"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa basica de cidade"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_cidade"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cnpj Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.cgc"
                                    }
                                ]
                                },
                                {
                                "title":"Razão / Nome / Fantasia - Filial",
                                "type":"text",
                                "row":1,
                                "class":"col-md-8",
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.razaosocial_nome_fant"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ],
                            "expressoes":{
                                "pcfilial.codigo":"pcfilial.codigo __OP__ __VALUE__",
                                "pcfilial.cidade":"lower(pcfilial.cidade) __OP__ __VALUE__",
                                "pcfilial.cgc":"pcfilial.cgc __OP__ __VALUE__",
                                "pcfilial.razaosocial_nome_fant":"(lower(pcfilial.razaosocial) __OP__ __VALUE__ __JUNCAO__ lower(pcfilial.fantasia) __OP__ __VALUE__)"
                            }
                        },
                        "cidade":{
                            "title":"Pesquisa Basica Cidade",
                            "filters":[
                                {
                                "title":"Estado",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pccidade.uf"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de estados"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_estado"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cidade",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pccidade.nomecidade"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "estado":{
                            "title":"Pesquisa Basica Estado",
                            "filters":[
                                {
                                "title":"Sigla Estado",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcestado.codigo"
                                    }
                                ]
                                },
                                {
                                "title":"Estado",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcestado.estado"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "rca":{
                            "title":"Pesquisa Basica Rca",
                            "filters":[
                                {
                                "title":"Cod Rca",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcusuari.codusur"
                                    }
                                ]
                                },
                                {
                                "title":"Nome",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcusuari.nome"
                                    }
                                ]
                                },
                                {
                                "title":"Cod Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcusuari.codfilial"
                                    }
                                ]
                                },
                                {
                                "title":"Cod Supervisor",
                                "type":"number",
                                "class":"col-md-4",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcusuari.codsupervisor"
                                    }
                                ]
                                },
                                {
                                "title":"Cod Praça",
                                "type":"number",
                                "class":"col-md-4",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcpraca.codpraca"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "gerente":{
                            "title":"Pesquisa Basica Gerente",
                            "filters":[
                                {
                                "title":"Cód Gerente",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcgerente.codgerente"
                                    }
                                ]
                                },
                                {
                                "title":"nomegerente",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcgerente.nomegerente"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "supervisor":{
                            "title":"Pesquisa Basica supervisor",
                            "filters":[
                                {
                                "title":"Cód Supervisor",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcsuperv.codsupervisor"
                                    }
                                ]
                                },
                                {
                                "title":"nome",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcsuperv.nome"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "regiao":{
                            "title":"Pesquisa Basica Regiao",
                            "filters":[
                                {
                                "title":"Num Regiao",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcregiao.numregiao"
                                    }
                                ]
                                },
                                {
                                "title":"regiao",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcregiao.regiao"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "praca":{
                            "title":"Pesquisa Basica Praca",
                            "filters":[
                                {
                                "title":"Cód praca",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcpraca.codpraca"
                                    }
                                ]
                                },
                                {
                                "title":"praca",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcpraca.praca"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        },
                        "rota":{
                            "title":"Pesquisa Basica Rota",
                            "filters":[
                                {
                                "title":"Cód Rota",
                                "type":"text",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcrotaexp.codrota"
                                    }
                                ]
                                },
                                {
                                "title":"rota",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcrotaexp.descricao"
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":2
                                }
                            ]
                        }
                    },
                    "avancado":{
                        "filial":{
                            "title":"Pesquisa Avançada Filial",
                            "filters":[
                                {
                                "title":"Cód. Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.codigo"
                                    }
                                ]
                                },
                                {
                                "title":"Cidade Filial",
                                "type":"text",
                                "class":"col",
                                "row":0,
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.cidade"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa basica de cidade"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_cidade"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cnpj Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.cgc"
                                    }
                                ]
                                },
                                {
                                "title":"Razão / Nome / Fantasia - Filial",
                                "type":"text",
                                "row":1,
                                "class":"col-md-8",
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.razaosocial_nome_fant"
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Gerente",
                                "type":"number",
                                "class":"col",
                                "row":2,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcgerente.codgerente"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa basica de Gerente"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_gerente"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Supervisor",
                                "type":"number",
                                "class":"col",
                                "row":2,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcsuperv.codsuperv"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa basica de Supervisor"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_supervisor"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Rca",
                                "type":"number",
                                "class":"col",
                                "row":2,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcusuari.codusur"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de Rca"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_rca"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Cli Filial",
                                "type":"number",
                                "class":"col",
                                "row":2,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcfilial.codcli"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Basica Cliente"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_cliente"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Cli Existente na Filial",
                                "type":"number",
                                "class":"col",
                                "row":3,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codcli"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Basica Cliente"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_cliente"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Regiao",
                                "type":"number",
                                "class":"col",
                                "row":3,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcregiao.codregiao"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Basica Regiao"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_regiao"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Praça",
                                "type":"number",
                                "class":"col",
                                "row":3,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcpraca.codpraca"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Basica Praça"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_praca"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Rota",
                                "type":"number",
                                "class":"col",
                                "row":3,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcrotaexp.codrota"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa Basica Rota"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_rota"
                                            }
                                        ]
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":4
                                }
                            ],
                            "expressoes":{
                                "pcfilial.codigo":"pcfilial.codigo __OP__ __VALUE__",
                                "pcfilial.cidade":"lower(pcfilial.cidade) __OP__ __VALUE__",
                                "pcfilial.cgc":"pcfilial.cgc __OP__ __VALUE__",
                                "pcfilial.razaosocial_nome_fant":"(lower(pcfilial.razaosocial) __OP__ __VALUE__ __JUNCAO__ lower(pcfilial.fantasia) __OP__ __VALUE__)",
                                "pcgerente.codgerente":"pcfilial.codigo in (select u.codfilial from jumbo.pcusuari u where u.codusur in (select g.cod_cadrca from jumbo.pcgerente g where g.codgerente __OP__ __VALUE__))",
                                "pcsuperv.codsuperv":"pcfilial.codigo in (select u.codfilial from jumbo.pcusuari u where u.codusur in (select s.cod_cadrca from jumbo.pcsuperv s where s.codsupervisor __OP__ __VALUE__))",
                                "pcusuari.codusur":"pcfilial.codigo in (select u.codfilial from jumbo.pcusuari u where u.codusur __OP__ __VALUE__)",
                                "pcfilial.codcli":"pcfilial.codcli __OP__ __VALUE__",
                                "pcclient.codcli":"pcfilial.codigo in (select c.codfilialnf from jumbo.pcclient c where c.codcli __OP__ __VALUE__)",
                                "pcregiao.codregiao":"pcfilial.codigo in (select r.codfilial from jumbo.pcregiao r where r.numregiao __OP__ __VALUE__)",
                                "pcpraca.codpraca":"pcfilial.codigo in (select r.codfilial from jumbo.pcregiao r where r.numregiao in (select p.numregiao from jumbo.pcpraca p where p.codpraca __OP__ __VALUE__))",
                                "pcrotaexp.codrota":"pcfilial.codigo in (select r.codfilial from jumbo.pcregiao r where r.numregiao in (select p.numregiao from jumbo.pcpraca p where p.rota __OP__ __VALUE__))"
                            }
                        },
                        "cliente":{
                            "title":"Pesquisa Avançada Cliente",
                            "filters":[
                                {
                                "title":"Cód. Filial",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codfilialnf"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de filial"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_filial"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Rca",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codusur1"
                                    }
                                ],
                                "buttons_right":[
                                    {
                                        "tag":"button",
                                        "type":"button",
                                        "content":"...",
                                        "onclick":"fnsisjd.abrir_pesquisa_padrao(this)",
                                        "props":[
                                            {
                                            "prop":"title",
                                            "value":"Abrir pesquisa de Rca"
                                            },
                                            {
                                            "prop":"nomeops",
                                            "value":"pesquisa_basica_rca"
                                            }
                                        ]
                                    }
                                ]
                                },
                                {
                                "title":"Cód. Cli",
                                "type":"number",
                                "class":"col-md-4",
                                "row":0,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.codcli"
                                    }
                                ]
                                },
                                {
                                "title":"Cnpj/CPF",
                                "type":"number",
                                "class":"col-md-3",
                                "row":1,
                                "has_filter_criterion":false,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.cgcent"
                                    }
                                ]
                                },
                                {
                                "title":"Razão / Nome / Fantasia",
                                "type":"text",
                                "row":1,
                                "class":"col-md-9",
                                "has_filter_criterion":true,
                                "props":[
                                    {
                                        "prop":"campo",
                                        "value":"pcclient.cliente_fantasia"
                                    }
                                ]
                                },
                                {
                                "title":"Endereço",
                                "collapsable":true,
                                "row":2,
                                "filters":[
                                    {
                                        "title":"Estado",
                                        "type":"text",
                                        "row":0,
                                        "class":"col",
                                        "has_filter_criterion":true,
                                        "props":[
                                            {
                                            "prop":"campo",
                                            "value":"pcclient.estent"
                                            }
                                        ]
                                    },
                                    {
                                        "title":"Cidade",
                                        "type":"text",
                                        "row":0,
                                        "class":"col",
                                        "has_filter_criterion":true,
                                        "props":[
                                            {
                                            "prop":"campo",
                                            "value":"pcclient.municent"
                                            }
                                        ]
                                    }
                                ]
                                }
                            ],
                            "buttons":[
                                {
                                "title":"Pesquisar",
                                "content":"Pesquisar",
                                "class":"w-25 mt-3 mb-2",
                                "onclick":"fnsisjd.pesquisar_filtro_padrao(this)",
                                "row":3
                                }
                            ],
                            "expressoes":{
                                "pcclient.cliente_fantasia":"(lower(pcclient.cliente) __OP__ __VALUE__ __JUNCAO__ lower(pcclient.fantasia) __OP__ __VALUE__)",
                                "pcclient.estent":"lower(pcclient.estent) __OP__ __VALUE__"
                            }
                        }
                    }
                }
            };
            console.log("Fim " + this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };
};

var vars = new Variaveis();

window.vars = vars;

export { vars }; 

