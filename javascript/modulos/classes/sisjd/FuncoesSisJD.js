import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';
import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';
import { fnreq } from '/sjd/javascript/modulos/classes/requisicao/Funcoesrequisicao.js';
import { fnobj } from '/sjd/javascript/modulos/classes/objeto/FuncoesObjeto.js';
import { fnhtml } from '/sjd/javascript/modulos/classes/html/FuncoesHtml.js';
import { fndt } from '/sjd/javascript/modulos/classes/data/FuncoesData.js';
import { fnarr } from '/sjd/javascript/modulos/classes/array/FuncoesArray.js';
import { fnmat } from '/sjd/javascript/modulos/classes/matematica/FuncoesMatematica.js';
import { fngraf } from '/sjd/javascript/modulos/classes/grafico/FuncoesGrafico.js';
import { fnstr } from '/sjd/javascript/modulos/classes/string/FuncoesString.js';

class FuncoesSisJD{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.nomes_variaveis = {
                FuncoesSisJD : "FuncoesSisJD"
            };
            this.nomes_variaveis.fnsisjd_pt = this.nomes_variaveis.FuncoesSisJD + '.';
            this.nomes_funcoes = {
                acessar_atalho_menu : "acessar_atalho_menu",
                acessar_item_menu : "acessar_item_menu",
                adicionar_favorito_inicio : "adicionar_favorito_inicio",						
                carregar_conteudo_dinamico : "carregar_conteudo_dinamico",
                carregar_conteudo_dinamico_opcao_sistema : "carregar_conteudo_dinamico_opcao_sistema",			
                como_tab : "como_tab",
                efetuar_pesquisa : "efetuar_pesquisa",
                enviar_cadastro : "enviar_cadastro",
                enviar_whatsapp : "enviar_whatsapp",
                esconder_menu_esquerdo : "esconder_menu_esquerdo",
                fechar_ajuda : "fechar_ajuda",
                gerar_ancora : "gerar_ancora",
                id_random : "id_random",
                limpar_dados : "limpar_dados",
                limpar_dados_recuperar_login : "limpar_dados_recuperar_login",
                most_esc_barra_inf : "most_esc_barra_inf",
                most_esc_barra_superior : "most_esc_barra_superior",
                mostrar_esconder_subs : "mostrar_esconder_subs",
                opcao_cadastrarse : "opcao_cadastrarse",
                opcao_recuperar_login : "opcao_recuperar_login",
                reabrir_janela_pai : "reabrir_janela_pai",
                recarregar_opcao_sistema : "recarregar_opcao_sistema",
                remover_favorito_inicio : "remover_favorito_inicio",
                requisitar_login : "requisitar_login",
                requisitar_recuperar_login : "requisitar_recuperar_login",
                texto_barra_inf : "texto_barra_inf",
                verificar_login : "verificar_login",
                verificar_tecla : "verificar_tecla",
                
            };
            this.nomes_completos_funcoes = {
                acessar_atalho_menu : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.acessar_atalho_menu,
                acessar_item_menu : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.acessar_item_menu,
                adicionar_favorito_inicio : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.adicionar_favorito_inicio,
                carregar_conteudo_dinamico : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.carregar_conteudo_dinamico,
                carregar_conteudo_dinamico_opcao_sistema : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.carregar_conteudo_dinamico_opcao_sistema,
                como_tab : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.como_tab,
                efetuar_pesquisa : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.efetuar_pesquisa,
                enviar_cadastro : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.enviar_cadastro,
                enviar_whatsapp : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.enviar_whatsapp,
                esconder_menu_esquerdo : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.esconder_menu_esquerdo,
                fechar_ajuda : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.fechar_ajuda,                
                gerar_ancora : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.gerar_ancora,
                id_random : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.id_random,
                limpar_dados : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.limpar_dados,
                limpar_dados_recuperar_login : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.limpar_dados_recuperar_login,
                most_esc_barra_inf : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.most_esc_barra_inf,
                most_esc_barra_superior : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.most_esc_barra_superior,
                mostrar_esconder_subs : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.mostrar_esconder_subs,
                opcao_cadastrarse : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.opcao_cadastrarse,
                opcao_recuperar_login : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.opcao_recuperar_login,
                reabrir_janela_pai : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.reabrir_janela_pai,
                recarregar_opcao_sistema : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.recarregar_opcao_sistema,
                remover_favorito_inicio : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.remover_favorito_inicio,
                requisitar_login : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.requisitar_login,
                requisitar_recuperar_login : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.requisitar_recuperar_login,
                texto_barra_inf : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.texto_barra_inf,
                verificar_login : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.verificar_login,
                verificar_tecla : this.nomes_variaveis.fnsisjd_pt + this.nomes_funcoes.verificar_tecla
            };
            this.classes = {
                div_aviso_temporario : "div_aviso_temporario"
            };
            this.seletores = {
                div_aviso_temporario : "div.div_aviso_temporario",
                div_cadastrarse : "div.div_cadastrarse"
            };
            this.mensagens = {
                nao_logou : "Nao foi possivel logar: "
            };
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };    

    /**
     * Funcao que carrega a pagina inicial de cada recurso
     * @param {opject} params - parametros
     */
    iniciar_pagina(params) { 
        try{
            fnjs.logi(this.constructor.name,"iniciar_pagina");
            params = params || {};
            params.efetuar_pesquisa = fnjs.first_valid([params.efetuar_pesquisa,false]);
            vars.nome_recurso = params.elemento;
            fnreq.requisitar_inicio(params);	
            fnjs.logf(this.constructor.name,"iniciar_pagina");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }

    requisitar_login(params) {
        try {
            fnjs.logi(this.constructor.name,"requisitar_login");
            let params_req = {
                async: false,
                comhttp: null
            };
            let form_login = fnjs.obterJquery(params.elemento).closest("form.form_login");
            params_req.comhttp=JSON.parse(vars.str_tcomhttp);
            params_req.comhttp.requisicao.requisitar.oque = 'logar';
            params_req.comhttp.requisicao.requisitar.qual.condicionantes = [];			
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push('usuario=' + form_login.find('input').eq(0).val());
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push('senha=' + form_login.find('input').eq(1).val());
            params_req.comhttp.eventos.aposretornar = [];
            params_req.comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:'window.fnsisjd.verificar_login'
            });
            vars.nome_usuario_logado = form_login.find('input').eq(0).val();
            vars.cod_usuario_logado = form_login.find('input').eq(0).val();
            
            fnreq.requisitar_servidor(params_req);
            fnjs.logf(this.constructor.name,"requisitar_login");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }							
    }

    verificar_login(params) {
        try {
            fnjs.logi(this.constructor.name,"verificar_login");
            if (params.comhttp.retorno.dados_retornados.conteudo_html.trim().toLowerCase() === 'logado') {
                
                vars.nomes_caminhos_arquivos.requisicao = vars.ultimo_destino_requisicao;
                vars.usuariosis = params.comhttp.retorno.dados_retornados.dados.usuariosis;
                vars.usuarios_subordinados = params.comhttp.retorno.dados_retornados.dados.usuarios_subordinados;
                let params_req = {
                    async: false,
                    comhttp:vars.ultima_requisicao
                };
                if (typeof params_req.comhttp !== "undefined" && params_req.comhttp != null) {
                    params_req.comhttp.retorno = {};
                    fnjs.obterJquery("main.main_login").remove();
                    window.fnreq.carregando({
                        acao:"esconder",
                        id:(params.comhttp.id_carregando || params.id_carregando || "todos")
                    })
                    fnreq.requisitar_servidor(params_req);				
                } else {                    
                    window.location.href = "/sjd";
                }
            } else {
                alert("Nao logado: "+params.comhttp.retorno.dados_retornados.conteudo_html);
                fnreq.carregando({
                    texto:'processo_concluido',
                    acao:'esconder',
                    id:params.comhttp.id_carregando
                });
            }
            fnjs.logf(this.constructor.name,"verificar_login");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }							
    }

    acessar_item_menu(params) {
        try {
            fnjs.logi(this.constructor.name,"acessar_item_menu");
            if (typeof params.elemento === "object" && params.elemento !== null) {
                params.elemento = fnjs.obterJquery(params.elemento).closest('li' );
                if (typeof params.elemento === "object" && params.elemento !== null && params.length) {
                    params.title = params.title || params.elemento.text() || params.nomeops;
                    params.nomeops = params.attr("nomeops");					
                }
            }

            params.inicial = params.inicial || false;
            params.efetuar_pesquisa = params.efetuar_pesquisa || false;
            if (params.inicial === true && params.nomeops !== "inicio") {	

                /*esconde a barra de menus e transforma em barra de titulo */
                fnjs.obterJquery("body>main:first").css("display","block");                
                let div_barra_menus = fnjs.obterJquery("div#barra_menus");
                div_barra_menus.css("width","100%");
                div_barra_menus.css("max-width","100%");
                div_barra_menus.css("height","50px");
                div_barra_menus.css("text-align","center");
                div_barra_menus.css("text-transform","capitalize");
                div_barra_menus.css("font-weight","bolder");
                div_barra_menus.css("overflow","hidden");
                div_barra_menus.children('*').hide();
                div_barra_menus.children('form').hide();
                let form_pesquisa_opcoes = fnjs.obterJquery("form#form_pesquisa_opcoes");
                form_pesquisa_opcoes.hide();
                form_pesquisa_opcoes.children("*").hide();
                div_barra_menus.append((params.title || params.nomeops).replace(/_/g," "));					
                let div_pagina = fnjs.obterJquery("div.div_pagina");
                div_pagina.css("width","100%");
                div_pagina.css("min-width","100%");
                div_pagina.css("top","50px");
                div_pagina.css("left","0px");
                div_pagina.css("right","0px");
                div_pagina.css("bottom","0px");
            }            
            this.carregar_conteudo_dinamico_opcao_sistema(params);  
            fnjs.logf(this.constructor.name,"acessar_item_menu");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }						
    }


    acessar_atalho_menu(params) {
        try {
            fnjs.logi(this.constructor.name,"acessar_atalho_menu");
            params.elemento = fnjs.obterJquery(params.elemento || params);            
            if (typeof params.elemento !== "undefined" && params.elemento !== null && params.elemento.length) {
                params.nomeops = params.elemento.attr("nomeops");
                this.acessar_item_menu(params);
            }
            fnjs.logf(this.constructor.name,"acessar_atalho_menu");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }						
    }

    abrir_opcao_sistema(params){
        try {			
            fnjs.logi(this.constructor.name,"abrir_opcao_sistema");
            let params_req = {
                async:false,
                comhttp:JSON.parse(vars.str_tcomhttp)
            };
            params_req.comhttp.requisicao.requisitar.oque = 'conteudo_html';
            params_req.comhttp.requisicao.requisitar.qual.comando = "consultar";
            params_req.comhttp.requisicao.requisitar.qual.tipo_objeto = 'opcao_sistema';
            params_req.comhttp.requisicao.requisitar.qual.objeto =  params.nomeops;				
            params_req.comhttp.requisicao.requisitar.qual.condicionantes = [];
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push("comando=" + 'consultar');
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push('tipo_objeto=opcao_sistema');					
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push("objeto"  +  params.nomeops);
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push('seletor_conteudo='  +  params.seletor_conteudo );
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push("inicial="  + fnjs.como_booleano(params.inicial,'string'));
            params_req.comhttp.requisicao.requisitar.qual.condicionantes.push('efetuar_pesquisa='  + fnjs.como_booleano(params.efetuar_pesquisa,'string'));
            params_req.comhttp.opcoes_retorno.seletor_local_retorno = params.seletor_local_retorno || "body";
            params_req.comhttp.opcoes_retorno.metodo_insersao = params.metodo_insersao || 'html';
            params_req.comhttp.eventos.aposretornar=[];
            params_req.comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            });
            if (fnjs.como_booleano(params.efetuar_pesquisa) === true) {
                params_req.comhttp.eventos.aposretornar.push({
                    arquivo:null,
                    funcao:'this.efetuar_pesquisa'
                });
            }
            params_req.comhttp.opcoes_requisicao.mostrar_carregando = false;
            fnreq.requisitar_servidor(params_req);
            fnjs.logf(this.constructor.name,"abrir_opcao_sistema");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    carregar_conteudo_dinamico_opcao_sistema(params) {
        try {
            fnjs.logi(this.constructor.name,"carregar_conteudo_dinamico_opcao_sistema");
            let alvo = null;
            let class_random = 'requisicao_'+Math.random().toString().replace('.','_');
            let seletor_local_retorno = "div.div_conteudo_pagina";
        let status_carr_din = "nao carregado";
        params.elemento = fnjs.obterJquery(params.elemento);
        if (typeof params.elemento === "object" && params.elemento !== null && params.elemento.length) {
            status_carr_din = params.elemento.attr('data-status_carr_din')||params.elemento.attr('status_carr_din')||params.elemento.attr('status_car_din');
            params.elemento.attr( 'data-status_carr_din' , 'carregando' );
            params.nomeops = params.nomeops || params.elemento.attr("nomeops");
        } else {
            status_carr_din = "carregando";
        }
        
        params.recarregar = params.recarregar || false;
        params.inicial = params.inicial || false;
        params.efetuar_pesquisa = params.efetuar_pesquisa || false;
        if (typeof status_carr_din !== 'undefined') {
            status_carr_din = status_carr_din.trim().toLowerCase();
        } else {
            status_carr_din = 'nao_carregado';
            if (typeof params.elemento === "object" && params.elemento !== null && params.elemento.length) {
                params.elemento.attr('data-status_carr_din',status_carr_din);
            }
        }
        params.seletor_local_retorno = params.seletor_local_retorno || seletor_local_retorno;
        params.metodo_insersao = "html";
        this.abrir_opcao_sistema(params);
            fnjs.logf(this.constructor.name,"carregar_conteudo_dinamico_opcao_sistema");
        } catch(e) {
        console.log(e);
        alert(e.message || e);
        }				
    } 	


    /**
     * Executa requisicao ao servidor para processar atualizações de banco de dados do sistema.
     * @param {object} obj - o elemento html clicado para executar a funcao inicial
     */
    funcoes_iniciais(obj){
        try{
            fnjs.logi(this.constructor.name,"funcoes_iniciais");
            let nomeatualizacao = null,
                comhttp={},
                selecionados = [];
            obj = fnjs.obterJquery(obj);
            nomeatualizacao = obj.attr("data-nomeatualizacao").trim();
            comhttp = JSON.parse(vars.str_tcomhttp);		
            comhttp.requisicao.requisitar.oque="processar_atualizacao";
            comhttp.requisicao.requisitar.qual.nomeatualizacao = nomeatualizacao;
            comhttp.requisicao.requisitar.qual.condicionantes=[];
            comhttp.requisicao.requisitar.qual.condicionantes.push("nomeatualizacao"+'='+nomeatualizacao);	
            if (obj.closest('td').prev('td').find(vars.seletores.div_combobox).length) {
                selecionados = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(obj.closest('td').prev('td').find(vars.seletores.div_combobox));
                comhttp.requisicao.requisitar.qual.condicionantes.push('selecionados=' + selecionados.join(','));	
            }
            comhttp.opcoes_retorno.parar_por_erros_sql=false;
            if(nomeatualizacao==='executar'&&tipo_objeto==='selecionados'&&objeto==='todos'){				
                comhttp = JSON.parse(vars.str_tcomhttp);		
                comhttp.requisicao.requisitar.oque='funcoes_iniciais';
                comhttp.requisicao.requisitar.qual.condicionantes=[];				
                let btns=fnjs.obterJquery(obj).closest('fieldset').find('img').not(obj),
                nomesatualizacoes=[];
                btns.each(function(){
                    if(fnjs.obterJquery(this).closest('tr').find('input').prop('checked')===true){
                        nomesatualizacoes.push(fnjs.obterJquery(this).attr("data-nomeatualizacao"));
                    }
                });
                comhttp.requisicao.requisitar.qual.nomeatualizacao = nomesatualizacoes;
                comhttp.requisicao.requisitar.qual.condicionantes.push("nomeatualizacao"+'='+nomesatualizacoes);	
                comhttp.opcoes_retorno.parar_por_erros_sql=false;				
                comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:'window.fnreq.processar_retorno_como_log'
                },{
                        arquivo:null,
                        funcao:'window.fnsisjd.recarregar_opcao_sistema',
                        parametros:{opcao_sistema:'manutencao'}
                }];			
            } else if(nomeatualizacao==='CARREGAR_COMANDOS'){
                comhttp.opcoes_retorno.seletor_local_retorno=vars.seletores.div_atualizar;
                comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:vars.nfj.processar_retorno_como_texto_html
                }];							
            } else {
                comhttp.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:'window.fnreq.processar_retorno_como_log'
                }];
                if(nomeatualizacao==='executar_limpar'||(nomeatualizacao==='inserir_dados'&&tipo_objeto==='tabela'&&objeto==='comandos')){
                    comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:'window.fnreq.processar_retorno_como_msg'
                    },{
                        arquivo:null,
                        funcao:'window.fnsisjd.recarregar_opcao_sistema',
                        parametros:{opcao_sistema:'manutencao'}
                    }];
                }
            }
            fnreq.requisitar_servidor({comhttp:comhttp});
            obj.closest('tr').css({color:"gray"});
            fnjs.logf(this.constructor.name,"funcoes_iniciais");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }							
    }	

    fhtml_div_controles_btns( tipo , classe_extra, forcar_quebra, visoes_condic){
        try{
            fnjs.logi(this.constructor.name,"fhtml_div_controles_btns");
            let retorno ;
            let onclick_add ; 
            let onclick_excl ;
            tipo = fnjs.first_valid([ tipo , 'visao']);
            classe_extra = fnjs.first_valid([ classe_extra , '' ]) ;
            visoes_condic = fnjs.first_valid([visoes_condic,[]]);
            retorno = '';
            onclick_add = '';
            onclick_excl = 'window.fnsisjd.deletar_controles({elemento:this})';
            switch( tipo){
                case 'visao':
                    onclick_add='window.fnsisjd.inserir_visao_pesquisa({elemento:this})';
                    break;
                case 'periodo':
                    onclick_add='window.fnsisjd.inserir_periodo_pesquisa(this)';
                    break;
                case 'condicionante':
                    if (visoes_condic.length > 0) {						
                        onclick_add="window.fnsisjd.inserir_condicionante_pesquisa({elemento:this,visoes_condic:['"+visoes_condic.join("','")+"'],forcar_quebra:"+forcar_quebra+"})";
                    } else {
                        onclick_add="window.fnsisjd.inserir_condicionante_pesquisa({elemento:this,forcar_qubra:"+forcar_quebra+"})";
                    }
                    break;
                case 'condicionante_rca':
                    onclick_add='window.fnsisjd.inserir_condicionante_pesquisa('+"{elemento:this,visoes_condic:["+'rca'.toUpperCase()+"],forcar_quebra:"+forcar_quebra+"}"+')';
                    break;

            }
            retorno ='<div class='+fnstr.aspas_duplas(vars.classes.div_opcao_controles_btns_img+' '+classe_extra)+' style="display:inline-block;">'+ 
                        '<img class='+fnstr.aspas_duplas(vars.classes.btn_img_add_ctrl+' '+vars.classes.mousehover+' '+vars.classes.clicavel)+' src='+fnstr.aspas_duplas(vars.nomes_caminhos_arquivos.img_maisverde32)+' onclick='+fnstr.aspas_duplas(onclick_add)+' title='+fnstr.aspas_duplas(fnstr.primeira_maiuscula('acrescenta')+' ao lado deste')+'><br />'+ 
                        '<img class='+fnstr.aspas_duplas(vars.classes.btn_img_excl_ctrl+' '+vars.classes.mousehover+' '+vars.classes.clicavel)+' src='+fnstr.aspas_duplas(vars.nomes_caminhos_arquivos.img_del)+' onclick='+fnstr.aspas_duplas(onclick_excl)+' title='+fnstr.aspas_duplas(fnstr.primeira_maiuscula('exclui')+' este controle')+'>'+
                    '</div>';
            fnjs.logf(this.constructor.name,"fhtml_div_controles_btns");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    deletar_controles(params){
        try{
            fnjs.logi(this.constructor.name,"deletar_controles");
            if (params !== null) {
                params.elemento = params.elemento || params.obj || params.elem || params;
                let div=fnjs.obterJquery(params.elemento).closest('div.div_container_combobox');
                if (typeof div !== "undefined" && div !== null && div.length) {
                    div.remove(); 	
                } else {
                    div = fnjs.obterJquery(params.elemento).closest("div.card").parent();
                    div.remove();
                }
            }
            fnjs.logf(this.constructor.name,"deletar_controles");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    receber_visoes(params) {
        try {
            fnjs.logi(this.constructor.name,"receber_visoes");
            vars.visoes = params.comhttp.retorno.dados_retornados.conteudo_html.dados.toString().split(",");
            fnreq.carregando({
                texto:'',
                acao:"esconder",
                id:"todos"
            });		
            fnjs.logf(this.constructor.name,"receber_visoes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }


    requisitar_visoes(params){
        try {
            fnjs.logi(this.constructor.name,"requisitar_visoes");
            let comhttp={};
            let idrand = fnjs.id_random();
            fnjs.obterJquery(params.elemento).addClass(idrand);
            comhttp=JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='dados_literais';
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "visoes";
            comhttp.requisicao.requisitar.qual.objeto = params.relatorio;
            comhttp.opcoes_retorno.seletor_local_retorno = "." + idrand;
            comhttp.opcoes_requisicao.mostrar_carregando = false;
            comhttp.eventos.aposretornar=[];
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:"window.fnsisjd.receber_visoes"
            });

            fnobj.transformar_elemento_classe_seletor(params.parametros);
            
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:params.funcao_retorno,
                parametros:params.parametros
                
            });
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"requisitar_visoes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }


    inserir_visao_pesquisa(params){
        try{
            fnjs.logi(this.constructor.name,"inserir_visao_pesquisa");
            params = params || {};
            params.contador_recursao = params.contador_recursao || 0;
            if (params.contador_recursao > vars.num_limite_recursoes) {
                alert("processo interrompido por excesso de recursao");
                return;
            }            
            if (typeof vars.visoes === 'undefined' || vars.visoes === null || vars.visoes.length === 0) {
                params.contador_recursao++;
                this.requisitar_visoes({elemento:params.elemento,funcao_retorno:"window.fnsisjd.inserir_visao_pesquisa",parametros:params});
                return; 
            }
            params.visoes = params.visoes || vars.visoes;
            if (typeof params.elemento !== 'undefined') {
                params.elemento = fnjs.obterJquery(params.elemento);
            } else {
                if (typeof params.comhttp.opcoes_retorno !== 'undefined') {
                    params.elemento = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
                } 
            }
            let ind,
                div;

            div	= params.elemento.closest("div.div_visao").parent();	
            if (typeof div === "undefined" || div === null || !div.length) {
                div = params.elemento.closest("div.accordion-body").children("div:first");
            }
            ind	= div.attr("data-ind") || div.children().length || 0;	
            ind++;
            div.attr( "data-ind" , Number(ind));
            if(ind < 9){
                ind = '0'+ind.toString();
            }
            params.tit = "Visao " + ind;
            params.retornar_como = "string";
            params.selecionado = params.visoes[0];
            params.permite_incluir = fnjs.first_valid([params.permite_incluir,true]);
            params.permite_excluir = fnjs.first_valid([params.permite_excluir,true]);
            let nova_div_opcao = null;            
            if (params.elemento.hasClass("btn_img_add_ctrl")) {
                let visao_atual = params.elemento.closest("div.div_visao").find("input[type=radio]:checked").closest("li").attr("data-valor_opcao");
                let ind_prox = params.visoes.indexOf(visao_atual) + 1;
                let nova_visao = params.visoes[ind_prox] || params.visoes[0];
                params.selecionado = nova_visao;
                nova_div_opcao = $(this.criar_controle_combobox_visao(params)).insertAfter(params.elemento.closest("div.div_visao"));
            } else if (params.elemento.hasClass("btn_img_add_geral")) {
                let ult_combobox = div.find("div.div_visao:last");
                let visao_atual = ult_combobox.find("input[type=radio]:checked").closest("li").attr("data-valor_opcao");
                let ind_prox = params.visoes.indexOf(visao_atual) + 1;
                let nova_visao = params.visoes[ind_prox] || params.visoes[0];
                params.selecionado = nova_visao;
                div.append(this.criar_controle_combobox_visao(params));
                nova_div_opcao = div.find("div.div_visao:last");
            }
            fnreq.carregando({acao:"esconder"});
            fnhtml.elemento_inserido_dinamicamente(nova_div_opcao)			
            fnjs.logf(this.constructor.name,"inserir_visao_pesquisa");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    inserir_periodo_pesquisa(params){		
        try{			
            fnjs.logi(this.constructor.name,"inserir_periodo_pesquisa");
        if (typeof params !== "undefined" && params !== null) {
            params.elemento = params.elemento || params.obj || params.elem || params;
            let elem = fnjs.obterJquery(params.elemento);
            if (typeof elem !== "undefined" && elem !== null && elem.length) {                   
                let div	= elem.closest('div.card').closest("div.row");
                if (typeof div === "undefined" || div === null || !div.length) {
                    div = elem.closest("div.accordion-body").children("div:first");
                }
                let periodo_anterior     = null;
                let input_celula_ant_dtini = {};
                let input_celula_ant_dtfim = {};
                let dtini_ant=null;
                let dtfim_ant=null;
                let novas_datas=[];
                let nova_div_opcao	= '' ;
                let ind = div.attr('data-ind') || div.find("div.div_periodo").length || 0;

                if (elem.hasClass("btn_img_add_ctrl")) {
                        periodo_anterior = elem.closest("div.div_periodo");      
                } else {
                        periodo_anterior = div.find("div.div_periodo:last");      
                }
                
                if (periodo_anterior.length) {
                    input_celula_ant_dtini = periodo_anterior.find("input.componente_data").eq(0);
                    input_celula_ant_dtfim = periodo_anterior.find("input.componente_data").eq(1);
                    dtini_ant = input_celula_ant_dtini.val();
                    dtfim_ant = input_celula_ant_dtfim.val();	
                    if (input_celula_ant_dtini.attr("type") === "date") {
                        dtini_ant = fndt.dataBR(dtini_ant);
                        dtfim_ant = fndt.dataBR(dtfim_ant);
                    } 
                    novas_datas=fndt.incrementar_datas(dtini_ant,dtfim_ant);
                    } else {
                        novas_datas.push(fndt.data_primeirodiames());
                        novas_datas.push(fndt.hoje());
                    }
                    ind++;
                    div.attr("data-ind",Number(ind));
                    if(ind < 9){
                        ind = '0'+ind.toString();
                    }
                    let nova_dtini=fndt.dataUSA(novas_datas[0]);
                    let nova_dtfim=fndt.dataUSA(novas_datas[1]);
                    let params = {
                        retornar_como:"string",
                        tag:"div",
                        class:"col-auto mt-2 div_periodo",
                        sub:[
                            {
                                tag:"div",
                                class:"card",
                                sub:[
                                    {
                                        tag:"div",
                                        class:"card-header",
                                        content:"Período " + ind
                                    },
                                    {
                                        tag:"div",
                                        class:"card-body",
                                        sub:[
                                            {
                                                tag:"div",
                                                class:"row",
                                                sub:[
                                                    {
                                                        tag:"div",
                                                        class:"col",
                                                        sub:[
                                                            {
                                                                tag:"div",
                                                                class:"row",
                                                                sub:[
                                                                    {
                                                                        tag:"div",
                                                                        class:"col-auto",
                                                                        sub:[
                                                                            {
                                                                                tag:"input",
                                                                                class:"componente_data controle_input_texto input_calendario",
                                                                                type:"date",
                                                                                value:nova_dtini
                                                                            }
                                                                        ]
                                                                    },
                                                                    {
                                                                        tag:"div",
                                                                        class:"col-auto",
                                                                        sub:[
                                                                            {
                                                                                tag:"input",
                                                                                class:"componente_data controle_input_texto input_calendario",
                                                                                type:"date",
                                                                                value:nova_dtfim
                                                                            }
                                                                        ]
                                                                    }
                                                                ]
                                                            },
                                                            {
                                                                tag:"div",
                                                                class:"row align-items-center",
                                                                sub:[
                                                                    {
                                                                        tag:"col",
                                                                        sub:[
                                                                            {
                                                                                tag:"div",
                                                                                class:"w-100 text-center",
                                                                                sub:[
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/jan.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/fev.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/mar.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/abr.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/mai.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/jun.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/jul.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/ago.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/set.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/out.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/nov.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"img",
                                                                                        class:"imagem_mes_calendario item_destaque100pct_hover",
                                                                                        src:"/sjd/images/calendario/dez.png",
                                                                                        title:"Preenche as datas com este mes inteiro",
                                                                                        onclick:"window.fnhtml.fncal.clicou_mes_calendario({elemento:this})"
                                                                                    },
                                                                                    {
                                                                                        tag:"input",
                                                                                        class:"inputano",
                                                                                        type:"number",
                                                                                        value:fndt.getAno(),
                                                                                        title:"Ano para preenchimento do mes inteiro",
                                                                                        props:[
                                                                                            {
                                                                                                prop:"step",
                                                                                                value:1
                                                                                            },
                                                                                            {
                                                                                                prop:"min",
                                                                                                value:0
                                                                                            }
                                                                                        ]
                                                                                    }
                                                                                ]
                                                                            }
                                                                        ]
                                                                    }
                                                                ]
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        tag:"div",
                                                        class:"div_opcao_controles_btns_img col-md-auto w-auto",
                                                        sub:[
                                                            {
                                                                tag:"img",
                                                                class:"btn_img_add_ctrl mousehover clicavel rounded",
                                                                src:"/sjd/images/maisverde32.png",
                                                                onclick:"window.fnsisjd.inserir_periodo_pesquisa({elemento:this})",
                                                                title:"Acrescentar após deste"
                                                            },
                                                            {
                                                                tag:"img",
                                                                class:"btn_img_excl_ctrl mousehover clicavel rounded",
                                                                src:"/sjd/images/img_del.png",
                                                                onclick:"window.fnsisjd.deletar_controles({elemento:this})",
                                                                title:"Excluir este controle"
                                                            }
                                                        ]
                                                    }
                                                ]
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                    }

                    if (elem.hasClass("btn_img_add_ctrl")) {
                        nova_div_opcao = $(fnhtml.criar_elemento(params)).insertAfter(elem.closest("div.div_periodo"));
                    } else {
                        div.append(fnhtml.criar_elemento(params)) ;	
                        nova_div_opcao = div.find("div.div_periodo:last");
                    }
                    fnhtml.elemento_inserido_dinamicamente(nova_div_opcao);
                }
        }
            fnjs.logf(this.constructor.name,"inserir_periodo_pesquisa");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }

    requisitar_visoes_condicionantes(params) {
        try {
            fnjs.logi(this.constructor.name,"requisitar_visoes_condicionantes");
            let comhttp={};
            let idrand = fnjs.id_random();
            fnjs.obterJquery(params.elemento).addClass(idrand);
            comhttp=JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='dados_literais';
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "visoes_condicionantes";
            comhttp.requisicao.requisitar.qual.objeto = params.relatorio;
            comhttp.opcoes_retorno.seletor_local_retorno = "." + idrand;
            comhttp.opcoes_requisicao.mostrar_carregando = false;
            comhttp.eventos.aposretornar=[];
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:"window.fnsisjd.receber_visoes_condicionantes"
            });
            fnobj.transformar_elemento_classe_seletor(params.parametros);
            
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:params.funcao_retorno,
                parametros:params.parametros
                
            });
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"requisitar_visoes_condicionantes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }


    receber_visoes_condicionantes(params) {
        try {
            fnjs.logi(this.constructor.name,"receber_visoes_condicionantes");
            vars.visoes_condicionantes = params.comhttp.retorno.dados_retornados.conteudo_html.dados.toString().split(",");			
            fnreq.carregando({
                texto:'',
                acao:"esconder",
                id:"todos"
            });		
            fnjs.logf(this.constructor.name,"receber_visoes_condicionantes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_condicionante_pesquisa(params) {
        try{			
            fnjs.logi(this.constructor.name,"inserir_condicionante_pesquisa");
            params = params || {};
            params.contador_recursao = fnjs.first_valid([params.contador_recursao,0]);
            if (params.contador_recursao > vars.num_limite_recursoes) {
                alert("processo interrompido por excesso de recursao");
                return;
            }
            if (typeof vars.visoes_condicionantes === 'undefined' || vars.visoes_condicionantes === null || vars.visoes_condicionantes.length === 0) {
                params.contador_recursao++;                
                this.requisitar_visoes_condicionantes({elemento : params.elemento, funcao_retorno:"window.fnsisjd.inserir_condicionante_pesquisa", parametros:params});
                return;
            } 
            params.visoes_condic = params.visoes_condic || vars.visoes_condicionantes;
            if (typeof params.elemento !== 'undefined') {
                params.elemento = fnjs.obterJquery(params.elemento);
            } else {
                if (typeof params.comhttp.opcoes_retorno !== 'undefined') {
                    params.elemento = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
                } 
            }
            let div	= params.elemento.closest("div.div_opcoes").find("div.div_opcoes_corpo");	
            if (typeof div === "undefined" || div === null || !div.length) {
                div = params.elemento.closest("div.accordion-body").children("div.row:first");
            }
            let nova_condicionante  = '' ;
            let ind			= Number(div.attr('data-ind')||0);
            let nova_div_opcao;
            if(typeof params.visoes_condic === "undefined" || params.visoes_condic === null){
                params.visoes_condic = [];
            }else{
                if(typeof params.visoes_condic !== "object"){
                    params.visoes_condic = params.visoes_condic.split(',');
                }
            }
            if(typeof params.comparacoes === "undefined"){
                params.comparacoes = [];
            }else{
                if(typeof params.comparacoes !== "object"){
                    params.comparacoes = params.comparacoes.split(',');
                }
            }
            ind++;
            div.attr('data-ind',Number(ind));
            if(ind < 9){
                ind = '0'+ind.toString();
            }
            if (fnjs.como_booleano(params.forcar_quebra) === true) {
                nova_condicionante = '<br />';
            }

            /*obtem os dados da condicionante atual*/
            params.selecionado = params.visoes_condic[0];
            let container_condic_atual = null;
            let combobox_visao_atual = null;
            if (params.elemento.hasClass("btn_img_add_ctrl")) {
                container_condic_atual = params.elemento.closest("div.div_condicionante");                                
            } else if (params.elemento.hasClass("btn_img_add_geral")) {
                container_condic_atual = div.find("div.div_condicionante:last");                
            }
            if (container_condic_atual !== null && container_condic_atual.length) {
                combobox_visao_atual = container_condic_atual.find("button.botao_dropdown_visao").next("ul");
                if (combobox_visao_atual !== null && combobox_visao_atual.length) {
                    let visao_atual = combobox_visao_atual.find("input[type=radio]:checked").closest("li").attr("data-valor_opcao");
                    let ind_prox = params.visoes_condic.indexOf(visao_atual) + 1;
                    let nova_visao = params.visoes_condic[ind_prox] || params.visoes_condic[0];
                    params.selecionado = nova_visao;
                }
            }

            /*monta o dropdown visao*/
            let dropdown_visao = null;
            let params_dropdown_visao = {};
            params_dropdown_visao.visoes = params.visoes_condic;
            params_dropdown_visao.selecionado = params.selecionado;
            params_dropdown_visao.classe_botao = vars.classe_padrao_botao;
            params_dropdown_visao.props = [
                {
                    prop:"aoselecionaropcao",
                    value:"window.fnsisjd.selecionou_visao_condicionante(this)"
                }
            ];
            params_dropdown_visao.filter = true;            
            dropdown_visao = this.criar_combobox_visao(params_dropdown_visao);

            /*monta o dropdown operacoes*/
            let dropdown_operacao = null;
            let params_dropdown_operacao = {};
            params_dropdown_operacao.class = "operacao";
            params_dropdown_operacao.itens = ["Igual a","Diferente de"];
            params_dropdown_operacao.selecionado = "Igual a";
            params_dropdown_operacao.classe_botao = vars.classe_padrao_botao;
            dropdown_operacao = fnhtml.fndrop.criar_dropdown(params_dropdown_operacao);

            /*monta o dropdown valores*/
            let dropdown_valores = null;
            let params_dropdown_valores = {};
            params_dropdown_valores.filter = true;
            params_dropdown_valores.classe_botao = vars.classe_padrao_botao;
            dropdown_valores = fnhtml.fndrop.criar_dropdown(params_dropdown_valores);



            let params_condic = {
                retornar_como:"string",
                tag:"div",
                class:"col-auto mt-2 div_condicionante",
                sub:[                   
                    {
                        tag:"div",
                        class:"card",
                        sub:[
                            {
                                tag:"div",
                                class:"card-header",
                                content:"Condicionante " + ind
                            },
                            {
                                tag:"div",
                                class:"card-body",
                                sub:[
                                    {
                                        tag:"div",
                                        class:"row",
                                        sub:[
                                            {
                                                tag:"div",
                                                class:"col",
                                                sub:[
                                                    {
                                                        tag:"div",
                                                        class:"div_opcao_controles row",
                                                        sub:[
                                                            {
                                                                tag:"div",
                                                                class:"div_opcao_controles_comp col-auto",
                                                                sub:[
                                                                    {
                                                                        tag:"div",
                                                                        class:"row",
                                                                        sub:[
                                                                            {
                                                                                tag:"div",
                                                                                class:"col-auto",
                                                                                content:dropdown_visao
                                                                            },
                                                                            {
                                                                                tag:"div",
                                                                                class:"col-auto",
                                                                                content:dropdown_operacao
                                                                            },
                                                                            {
                                                                                tag:"div",
                                                                                class:"col-auto",
                                                                                content:dropdown_valores
                                                                            }
                                                                        ]
                                                                    }
                                                                ]

                                                            }                                                                    
                                                        ]
                                                    }                                                            
                                                ]
                                            },
                                            {
                                                tag:"div",
                                                class:"div_opcao_controles_btns_img col-md-auto w-auto",
                                                sub:[
                                                    {
                                                        tag:"img",
                                                        class:"btn_img_add_ctrl mousehover clicavel rounded",
                                                        src:"/sjd/images/maisverde32.png",
                                                        onclick:"window.fnsisjd.inserir_condicionante_pesquisa({elemento:this})",
                                                        title:"Acrescentar após deste"
                                                    },
                                                    {
                                                        tag:"img",
                                                        class:"btn_img_excl_ctrl mousehover clicavel rounded",
                                                        src:"/sjd/images/img_del.png",
                                                        onclick:"window.fnsisjd.deletar_controles({elemento:this})",
                                                        title:"Excluir este controle"
                                                    }
                                                ]
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                    }
                ]
            }

            if (params.elemento.hasClass("btn_img_add_ctrl")) {
                nova_div_opcao = $(fnhtml.criar_elemento(params_condic)).insertAfter(params.elemento.closest("div.div_condicionante"));
            } else {
                div.append(fnhtml.criar_elemento(params_condic)) ;	
                nova_div_opcao = div.find("div.div_condicionante:last");
            }
            let div_combobox_valores = nova_div_opcao.find("div.div_combobox:last");
            div_combobox_valores.attr('aoabrir',"window.fnsisjd.incluir_options_condicionante(this)");
            fnreq.carregando({acao:"esconder"});
            fnhtml.elemento_inserido_dinamicamente(nova_div_opcao);            
            fnjs.logf(this.constructor.name,"inserir_condicionante_pesquisa");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }


    criar_card_atalho_inicio(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_card_atalho_inicio");
            params = params || {};
            params.retornar_como = params.retornar_como || 'string';
            params.tag = 'div',
            params.class = 'col card_atalho_inicio'
            params.onclick='window.fnsisjd.acessar_atalho_menu({elemento:this})';
            params.sub = [
                {
                    tag:'div',
                    class : 'card ' + (params.class || ''),
                    sub : [
                        {
                            tag:'div',
                            class:'card-body',
                            sub:[
                                {
                                    tag:'img',
                                    src:params.icone
                                }
                            ]
                        },
                        {
                            tag:'div',
                            class:'card-footer',
                            content:params.footer
                        }
                    ]
                }
            ];
            fnjs.logf(this.constructor.name,"criar_card_atalho_inicio");
            return fnhtml.criar_elemento(params);            
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    criar_combobox_visao(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_combobox_visao");
            params = params || {};
            params.itens = params.itens || params.visoes || vars.visoes;
            params.retornar_como = params.retornar_como || 'string';
            params.class_botao = (params.class_botao || params.classe_botao || '') + ' botao_dropdown_visao';
            params.classe_botao = params.class_botao;
            params.class_dropdown = (params.class_dropdown || '') + ' dropdown-visao';
            params.filter = fnjs.first_valid([params.filter,params.filtro,params.filtrar,true]);
            fnjs.logf(this.constructor.name,"criar_combobox_visao");
            return fnhtml.fndrop.criar_dropdown(params);            
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }


    /**
     * Limpa os valores e texto do dropdown valores condicionante se for alterado a visao da condicionante
     * @param {json object} params 
     */
    selecionou_visao_condicionante(params) {
        try {
            fnjs.logi(this.constructor.name,"selecionou_visao_condicionante");
            params = params || {};
            params.elemento = params.elemento || params;
            params.elemento = fnjs.obterJquery(params.elemento);
            let div_combobox = params.elemento.closest("div.div_combobox");
            let visao_atual = div_combobox.attr("data-visao_atual");            
            let btn = div_combobox.children("button");
            let nova_visao = btn.text();
            if (visao_atual !== nova_visao) {
                let tr = params.elemento.closest("tr");
                let div_valores_condic = tr.children("td:last").find("div.div_combobox");
                let dropdow_valores_condic = div_valores_condic.find("ul");
                dropdow_valores_condic.find("li").remove(); 
                dropdow_valores_condic.prev("button").text(dropdow_valores_condic.prev("div.div_combobox").attr("placeholder") || "(Selecione)");
                div_combobox.attr("data-visao_atual",btn.text());
            }
            fnjs.logf(this.constructor.name,"selecionou_visao_condicionante");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    criar_controle_combobox_visao(params) {
        try {            
            fnjs.logi(this.constructor.name,"criar_controle_combobox_visao");
            params = params || {};
            params.visoes = params.visoes || vars.visoes;
            params.retornar_como = params.retornar_como || 'string';
            params.tag = params.tag || 'div';
            params.class = "col-auto mt-2 div_visao " + (params.class || "");

            params.sub = params.sub || [];
            

            let params_combobox = {};
            params_combobox.visoes = params.visoes;
            params_combobox.selecionado = params.selecionado;
            params_combobox.classe_botao = vars.classe_padrao_botao;
            let sub_permite_operacoes = [
                {
                    tag:"div",
                    class:"div_opcao_controles_btns_img col-md-auto w-auto",
                    sub:[]
                }
            ];
            params.permite_incluir = fnjs.first_valid([params.permite_incluir,true]);
            params.permite_excluir = fnjs.first_valid([params.permite_excluir,true]);
            if (params.permite_incluir) {
                sub_permite_operacoes[0].sub.push({
                    tag:"img",
                    class:"btn_img_add_ctrl mousehover clicavel rounded",
                    src:"/sjd/images/maisverde32.png",
                    onclick:"window.fnsisjd.inserir_visao_pesquisa({elemento:this})",
                    title:"Acrescentar ao lado deste"
                });
            }
            if (params.permite_excluir) {
                sub_permite_operacoes[0].sub.push({
                    tag:"img",
                    class:"btn_img_excl_ctrl mousehover clicavel rounded",
                    src:"/sjd/images/img_del.png",
                    onclick:"window.fnsisjd.deletar_controles({elemento:this})",
                    title:"Excluir este controle"
                });
            }
            params.sub.push(
                {
                    tag:"div",
                    class:"card",
                    sub:[
                        {
                            tag:"div",
                            class:"card-header",
                            content:params.tit || "Visao 01"
                        },
                        {
                            tag:"div",
                            class:"card-body",
                            sub:[
                                {
                                    tag:"div",
                                    class:"div_opcao_controles row",
                                    sub:[
                                        {
                                            tag:"div",
                                            class:"col",
                                            content:this.criar_combobox_visao(params_combobox)
                                        },
                                        sub_permite_operacoes[0]
                                    ]
                                }
                            ]
                        }
                    ]
                }
            ); 
            fnjs.logf(this.constructor.name,"criar_controle_combobox_visao");
            return fnhtml.criar_elemento(params);
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }


    coletar_dados_para_pesquisa(botao_clicado){
        try{
            fnjs.logi(this.constructor.name,"coletar_dados_para_pesquisa");
            botao_clicado = fnjs.obterJquery(botao_clicado);
            let relatorio=botao_clicado.attr('data-visao'),
                div_pesquisa = botao_clicado.closest('div.div_opcoes_pesquisa'),
                divs_visoes = null,
                visaobtnpesq = "",
                visoes=[],
                divs_visoes_positivadoras = null,
                divs_visoes_nunca_positivados = null,
                visoes_nunca_positivados = null,
                visoes_positivadoras=[],
                divs_periodos = null,
                inputs_datas = null,
                datas=[],
                condicionantestab = [],
                condsup = [],
                divs_condicionantes = null,
                condicionantes=[],
                divs_operacoes = null,
                operacoes=[],
                divs_campos_avulsos = null,
                campos_avulsos=[],
                divs_ver_valores_de = null,
                mostrar_vals_de = '',
                divs_considerar_valores_de = null,
                considerar_vals_de = null,
                divs_ver_valores_zero = null,
                branco_se_zero = null,
                comhttp = null,
                vis_duplic=[],
                datas_erradas=[],
                erros_preenchimento = [],
                cont_erros=0,
                usar_arr_tit=false,
                codprocesso = null;
            visaobtnpesq = botao_clicado.attr("visao") || botao_clicado.attr("data-visao");
            codprocesso = botao_clicado.attr("codprocesso")||null;
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque="dados_sql";
            divs_visoes=div_pesquisa.find('div.div_visoes');			
            divs_visoes_positivadoras = div_pesquisa.find('div.div_visoes2');
            divs_condicionantes = div_pesquisa.find('div.div_condicionante');	
            divs_periodos = div_pesquisa.find('div.div_periodos');            
            divs_ver_valores_de = div_pesquisa.find('div.painel_ver_vals_de');
            divs_considerar_valores_de = div_pesquisa.find('div.painel_considerar_vals_de');
            divs_ver_valores_zero = div_pesquisa.find('div.painel_ver_vals_zero');
            divs_campos_avulsos = div_pesquisa.find('div#painel_campos_avulsos').find('div.div_combobox');
            divs_visoes_nunca_positivados = divs_visoes.find('input.check_visoes_nunca_positivados:checked');
            divs_visoes = divs_visoes.find('div.div_combobox');
            divs_visoes_positivadoras = divs_visoes_positivadoras.find('div.div_combobox');
            divs_condicionantes = divs_condicionantes.find('div.div_combobox');			
            divs_periodos = divs_periodos.find("input.componente_data");
            divs_operacoes = divs_condicionantes.filter('div.operacao');
            divs_condicionantes = divs_condicionantes.filter('div.condicionante');			
            inputs_datas=divs_periodos;
            mostrar_vals_de = divs_ver_valores_de.find('input:checked');
            considerar_vals_de = divs_considerar_valores_de.find('input:checked');	
            branco_se_zero = divs_ver_valores_zero.find('input:checked');
            mostrar_vals_de = this.pegar_valores_elementos(mostrar_vals_de);
            considerar_vals_de = this.pegar_valores_elementos(considerar_vals_de);
            branco_se_zero = this.pegar_valores_elementos(branco_se_zero);
            datas=this.pegar_valores_elementos(inputs_datas);
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno',
            }];
            comhttp.opcoes_retorno.branco_se_zero=true;	
        
            if (inputs_datas.length) {
                for (let i = 0; i < inputs_datas.length; i++) {
                    if (inputs_datas.eq(i).attr("type") === "date") {
                        datas[i] = fndt.dataBR(datas[i]);
                    }
                }
            }
            
            visoes=this.pegar_valores_elementos(divs_visoes);
            visoes_positivadoras = this.pegar_valores_elementos(divs_visoes_positivadoras);
            $.each(divs_condicionantes,function(index,element){
                condicionantes.push(window.fnsisjd.pegar_valores_elementos(divs_condicionantes.eq(index)).toString().replace(/,/g,vars.sepn2));
                if(condicionantes[condicionantes.length-1].trim().length===0){
                    erros_preenchimento[ cont_erros ] = "Ha condicionantes sem valores escolhidos. \n"+
                        "Verifique e escolha ao menos um valor para a condicionante ou exclua-a." ;
                    cont_erros ++ ;
                    return false;
                }
            });
            if(visoes.length){
                let visoestemp;
                $.each(visoes,function(index,element){
                    visoestemp=visoes.slice();
                    visoestemp.splice(index,1);
                    if(visoestemp.indexOf(element)>-1){
                        if(vis_duplic.indexOf(element)===-1){			
                            vis_duplic.push(element);
                        }
                    }
                });
                if(vis_duplic.length){
                    erros_preenchimento[ cont_erros ] = "Nao e possivel pesquisar visoes duplicadas. \n"+
                        "Verifique e exclua ou altere as visoes duplicadas de: \n - "+
                        vis_duplic.join("\n - ");
                    cont_erros ++;
                }
                switch(relatorio){					 					
                    case 'positivacaopersonalizada':
                        comhttp.opcoes_retorno.filtro.ativado=false;
                        comhttp.opcoes_retorno.ordenacao.ativado=false;					
                        comhttp.eventos.aposretornar.push({
                            arquivo:null,
                            funcao:"window.fnsisjd.destacar_celulas_zeradas"
                        });
                        break;
                        case 'clientescispenaojumbo':
                            visoes=[fnstr.primeira_maiuscula('cliente')];
                        break;
                    case "consultar_ratingsfocais":
                        comhttp.eventos.aposretornar.push({
                            arquivo:null,
                            funcao:"window.fnsisjd.centralizar_colunas_valores"
                        });
                            break;
                    case "lista_clientes_atualizar_rfb":
                        visoes=["lista_clientes"];
                        break;                    
                }				
            }else{
                let inputs_filtro = null;
                let condtabi = null;
                let condtabc = null;
                let condtab = null;
                let indtab = 0;
                switch(relatorio){					
                    case 'produtoxrca':
                        visoes=[fnstr.primeira_maiuscula('produto')];
                        visoes_positivadoras=['rca'.toUpperCase()];					
                        comhttp.opcoes_retorno.filtro.ativado=false;
                        comhttp.opcoes_retorno.ordenacao.ativado=false;
                        comhttp.eventos.aposretornar.push({
                            arquivo:null,
                            funcao:"window.fnsisjd.destacar_celulas_zeradas"
                        });
                        break;
                    case 'clientexproduto':
                        visoes=[fnstr.primeira_maiuscula('cliente')];
                        visoes_positivadoras=[fnstr.primeira_maiuscula('produto')];
                        comhttp.opcoes_retorno.filtro.ativado=false;
                        comhttp.opcoes_retorno.ordenacao.ativado=false;					
                        comhttp.eventos.aposretornar.push({
                            arquivo:null,
                            funcao:"window.fnsisjd.destacar_celulas_zeradas"
                        });
                        break;					
                    case 'clientexfornecedor':
                        visoes=[fnstr.primeira_maiuscula('cliente')];
                        visoes_positivadoras=[fnstr.primeira_maiuscula('fornecedor')];
                        comhttp.opcoes_retorno.filtro.ativado=false;
                        comhttp.opcoes_retorno.ordenacao.ativado=false;						
                        comhttp.eventos.aposretornar.push({
                            arquivo:null,
                            funcao:"window.fnsisjd.destacar_celulas_zeradas"
                        });
                        break;                
                    case 'positivacaopersonalizada':
                        comhttp.opcoes_retorno.filtro.ativado=false;
                        comhttp.opcoes_retorno.ordenacao.ativado=false;					
                        break;
                    case 'clientescispenaojumbo':
                        visoes=[fnstr.primeira_maiuscula('cliente')];
                    case 'critica':
                        break;
                    case 'gestao_acessos':                    
                        break;
                    case "consulta_estoque":	
                        visoes=[visaobtnpesq];
                        break;
                    case "consulta_codigos_devolucao":
                        visoes=[visaobtnpesq];
                        inputs_filtro = div_pesquisa.find("input.input_filtro_pesquisa");
                        condtabi = [];
                        condtabc = [];
                        condtab = [];
                        indtab = 0;
                        for (let i = 0; i < inputs_filtro.length; i++) {
                            if (inputs_filtro.eq(i).val().trim().length > 0) {
                                indtab = condtabc.indexOf(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase())
                                if (indtab === -1) {
                                    condtabc.push(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase());
                                    indtab = condtabc.indexOf(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase());
                                }
                                if (typeof condtabi[indtab] === "undefined") {
                                    condtabi[indtab] = [];
                                }
                                condtabi[indtab].push(inputs_filtro.eq(i).attr("expressao_campo_filtro").replace("__VALOR__",inputs_filtro.eq(i).val()));								
                            }
                        }
                        for (let i = 0; i < condtabc.length; i++) {
                            condicionantestab.push(condtabc[i].toString() + "[" + condtabi[i].join(" and ").replace(",",vars.subst_virg) + "]");
                        }
                        break;
                    case "consulta_majorar_ccrca":
                        visoes=[visaobtnpesq];
                        inputs_filtro = div_pesquisa.find("input.input_filtro_pesquisa");
                        condtabi = [];
                        condtabc = [];
                        condtab = [];
                        indtab = 0;
                        for (let i = 0; i < inputs_filtro.length; i++) {
                            if (inputs_filtro.eq(i).val().trim().length > 0) {
                                indtab = condtabc.indexOf(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase())
                                if (indtab === -1) {
                                    condtabc.push(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase());
                                    indtab = condtabc.indexOf(inputs_filtro.eq(i).attr("tabela_filtro").trim().toLowerCase());
                                }
                                if (typeof condtabi[indtab] === "undefined") {
                                    condtabi[indtab] = [];
                                }
                                condtabi[indtab].push(inputs_filtro.eq(i).attr("expressao_campo_filtro").replace("__VALOR__",inputs_filtro.eq(i).val()));								
                            }
                        }
                        for (let i = 0; i < condtabc.length; i++) {
                            condicionantestab.push(condtabc[i].toString() + "[" + condtabi[i].join(" and ").replace(",",vars.subst_virg) + "]");
                        }
                        break;	
                    case "consulta_relatorio_majoracao_cc_rca":
                        visoes=[visaobtnpesq];
                        break;
                    case "consulta_cliente":
                        visoes=["Cliente"];
                        break;						
                    case "consulta_pedido":
                    case "altera_pedido":
                        visoes=["lista pedidos"];
                        condtabi = [];
                        condtabc = [];
                        condtab = [];
                        condtabc.push("pcpedc.data between '" + datas[0] + "' and '" + datas[1]+ "'");
                        condtab.push("pcpedc[" + condtabc.join(" and ") + "]");
                        condtab.push("pcpedcfv[to_date(pcpedcfv.dtinclusao) between to_date('" + datas[0] + "','dd/mm/YYYY') and to_date('" + datas[1]+ "','dd/mm/YYYY')]");
                        condtab.push("pcnfcan[to_date(pcnfcan.dataemissao) between to_date('" + datas[0] + "','dd/mm/YYYY') and to_date('" + datas[1]+ "','dd/mm/YYYY')]");
                        condicionantestab.push(condtab.join(vars.sepn1));
                        break;												
                    default:
                        erros_preenchimento[ cont_erros ] = "Por favor, adicione pelo menos uma visao para a pesquisa.";
                        cont_erros ++ ;
                        break;
                }
            }
            visoes_nunca_positivados=this.pegar_valores_elementos(divs_visoes_nunca_positivados);
            if(div_pesquisa.find('.condicionante[value=""]').length){
                erros_preenchimento[ cont_erros ] = "Ha condicionantes sem valores escolhidos (=(Selecione)). \n"+
                    "Verifique e escolha ao menos um valor para a condicionante ou exclua-a." ;
                cont_erros ++ ;
            }
        
            //esta em sub registro
            if (fnjs.obterJquery(botao_clicado).closest("tr.linha_sub").length) {
                let linhasub = fnjs.obterJquery(botao_clicado).closest("tr.linha_sub"),
                    linhasup = {},
                    tabdadossup = {},
                    tabdadossuptit = {},
                    visoessup = [],
                    temsubregistro = 1,
                    indcampodb = -1,
                    valcelssup = [];
                linhasup = linhasub.prev("tr");
                tabdadossup = linhasup.closest("table.tabdados");
                tabdadossuptit = tabdadossup.children("thead");
                visoessup = this.obter_visoes_tabela(tabdadossup);
                visoessup = this.corrigir_visoes_relatorio_personalizado(visoessup);
                if (visoessup.length === 0) {					
                    let nome_primeirocampo = fnhtml.fntabdados.obter_nomecampodb(tabdadossuptit.children("tr.linhatitulos").children("th:not(.cel_sub_tit)").eq(0));
                    nome_primeirocampo = nome_primeirocampo.toLowerCase().trim();
                    if (nome_primeirocampo.indexOf("numnota") > -1) {
                        let nome_segundocampo = fnhtml.fntabdados.obter_nomecampodb(tabdadossuptit.children("tr.linhatitulos").children("th:not(.cel_sub_tit)").eq(5));
                        nome_segundocampo = nome_segundocampo.toLowerCase().trim();
                        if (nome_segundocampo.indexOf("codprod") > -1) {
                            visoessup.push("item de nota fiscal");
                        } else {
                            visoessup.push("nota fiscal");
                        }
                    } else {
                        visoessup.push("evolucao");
                    }
                }
                for (let i = 0 ; i < visoessup.length ; i++) {
                    indcampodb = Number((Number((tabdadossuptit.children("tr.linhatitulos").prev().children("th:not(.cel_cmd_tit):not(.cel_sub_tit)").eq(i).attr("indexreal")).trim())||0) ) + temsubregistro;					
                    if (visoessup[i].indexOf("item de") > -1) {
                        indcampodb += 5;
                    }
                    valcelssup.push(visoessup[i].trim().toLowerCase() + "='"+linhasup.children("td:nth-child("+indcampodb+")").text().trim().toLowerCase()+"'");
                }
                if (typeof div_pesquisa.find('div.div_condicionantes').attr("condicionantessup") !== "undefined") {
                    if (div_pesquisa.find('div.div_condicionantes').attr("condicionantessup").trim().length > 0) {
                        condsup = div_pesquisa.find('div.div_condicionantes').attr("condicionantessup").trim().toLowerCase();
                        condsup = condsup.split(vars.sepn1.trim().toLowerCase());
                        for(let i = 0; i < condsup.length; i++) {
                            condicionantes.push(condsup[i]);
                        }
                    }
                }
                for(let i = 0; i < valcelssup.length ; i++) {
                    if (fnarr.procurar_array({array:condsup,valor:valcelssup[i]}) === -1) {
                        condsup.push(valcelssup[i]);
                        condicionantes.push(valcelssup[i]);
                    }
                }
                condsup = condsup.join(vars.sepn1.trim().toLowerCase());
                div_pesquisa.find('div.div_condicionantes').attr("condicionantessup", condsup);
            }
            for( let cont_datas = 0 ; cont_datas < datas.length ; cont_datas = cont_datas + 2){
                if(fndt.diferenca_datas( datas[ cont_datas ] , datas[ cont_datas + 1 ] ) < 0){
                    datas_erradas.push(datas[ cont_datas ] + "-" + datas[ cont_datas + 1 ] );
                }
            }
            if(datas_erradas.length){
                erros_preenchimento[ cont_erros ] = "Ha datas preenchidas de forma incorreta: data inicial maior que data final.\n"+
                    "Verifique os seguintes periodos:\n - "+
                    datas_erradas.join("\n - ");
                cont_erros ++ ;
            }
            if(datas.length === 0){
                switch(relatorio){
                    case 'critica': 
                    case "lista_clientes_atualizar_rfb":
                    case "consulta_estoque":
                    case "consulta_cliente":
                    case "consulta_pedido":
                    case "altera_pedido":
                    case "consulta_codigos_devolucao":
                    case "consulta_majorar_ccrca":
                        break;
                    default:
                        erros_preenchimento[ cont_erros ] = "Nao e possivel pesquisar sem determinar um periodo. Inclua ao menos um periodo.";
                        cont_erros++;
                        break;						
                }
            }
            if(cont_erros > 0){
                alert( "Por favor, verifique os seguintes erros de preenchimento:\n\n"+
                    erros_preenchimento.join( "\n \n " ) ) ;
                return false;
            }			
            operacoes=this.pegar_valores_elementos(divs_operacoes);	
            campos_avulsos=this.pegar_valores_elementos(divs_campos_avulsos);
            fnjs.obterJquery(condicionantes).each(function(index){
                if(operacoes[index]==="Diferente de"){
                    condicionantes[index]=condicionantes[index].toString().replace(/=/g,"!=");
                }
            });
            comhttp.requisicao.requisitar.qual.condicionantes=[];

            let tipo_visoes = div_pesquisa.find('div.div_visoes').attr("tipo") || "visoes";
            
            if (tipo_visoes.trim().toLowerCase() === "filtro") {
                let divs_combobox_cond = divs_visoes.filter("div.div_combobox");
                let filtros = [];
                if (typeof divs_combobox_cond !== "undefined" && divs_combobox_cond.length) {
                    for(let i = 0; i < divs_combobox_cond.length; i++) {
                        let valores = this.pegar_valores_elementos(divs_combobox_cond.eq(i));
                        filtros.push(valores.join(vars.sepn2));
                    }
                }
                let inputs = div_pesquisa.find("div.card-body").children("div.row").children("div.col").children("input");
                if (typeof inputs !== "undefined" && inputs !== null && inputs.length) {
                    for (let i = 0; i < inputs.length; i++) {
                        filtros.push((inputs.attr("filtro") || "filtro") + "=" + inputs.eq(i).val());
                    }
                }
                if (filtros.length > 0) {
                    condicionantes.push(filtros.join(vars.sepn1));
                }
            }

            switch(relatorio){
                case 'relatorio_personalizado':
                    usar_arr_tit=true;
                    break;
                case 'critica':
                    //let divs_combobox_cond = divs_visoes.filter("div.div_combobox");
                    //let filiais = divs_combobox_cond.eq(0);
                    //let mes = divs_combobox_cond.eq(1);
                    //let ano = divs_combobox_cond.eq(2);
                    //filiais = this.pegar_valores_elementos(filiais);
                    //condicionantes.push(filiais.join(vars.sepn2));
                    //mes = this.pegar_valores_elementos(mes);
                    //ano = this.pegar_valores_elementos(ano);
                    //mes = mes.join(",");
                    //ano = ano.join(",");
                    visoes=["Filial","Produto"];
                    //comhttp.requisicao.requisitar.qual.condicionantes.push("mes="+mes);
                    //comhttp.requisicao.requisitar.qual.condicionantes.push("ano="+ano);
                    mostrar_vals_de=3; //peso total
                    break;
                default:
                    break;
            }
            let dtini = datas[0];
            let dtfim = datas[1];
            visoes = visoes.join();
            visoes = visoes.replace(/aurora/ig,"origem");
            datas = datas.join();
            visoes_nunca_positivados = visoes_nunca_positivados.join();
            visoes_nunca_positivados = visoes_nunca_positivados.replace(/aurora/ig,"origem");
            condicionantes = condicionantes.join(vars.sepn1);
            visoes_positivadoras = visoes_positivadoras.join();
            campos_avulsos = campos_avulsos.join();            				
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "visao";
            comhttp.requisicao.requisitar.qual.objeto = visoes;
            if (typeof codprocesso !== "undefined" && codprocesso !== null) {
                comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=" + codprocesso);
            }
            comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp.requisicao.requisitar.qual.condicionantes.push('relatorio='+relatorio);
            comhttp.requisicao.requisitar.qual.condicionantes.push('visoes='+visoes);
            comhttp.requisicao.requisitar.qual.condicionantes.push('visoes_nunca_positivados='+visoes_nunca_positivados);
            comhttp.requisicao.requisitar.qual.condicionantes.push('datas='+datas);
            comhttp.requisicao.requisitar.qual.condicionantes.push('dtini='+dtini);
            comhttp.requisicao.requisitar.qual.condicionantes.push('dtfim='+dtfim);
            comhttp.requisicao.requisitar.qual.condicionantes.push("campos avulsos"+'='+campos_avulsos);
            comhttp.requisicao.requisitar.qual.condicionantes.push('visoes_positivadoras='+visoes_positivadoras);
            comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantes='+condicionantes);
            comhttp.requisicao.requisitar.qual.condicionantes.push('mostrar_vals_de='+mostrar_vals_de);
            comhttp.requisicao.requisitar.qual.condicionantes.push("considerar_vals_de"+'='+considerar_vals_de);
            comhttp.requisicao.requisitar.qual.condicionantes.push("branco_se_zero"+'='+branco_se_zero);
            comhttp.requisicao.requisitar.qual.condicionantes.push('usar_arr_tit='+usar_arr_tit);
            if (condicionantestab.length > 0) {
                comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=" + condicionantestab.join(vars.sepn1));
            }
            comhttp.opcoes_retorno.botao_exportar_superior=true;
            comhttp.opcoes_retorno.html_entities=true;		
            comhttp.opcoes_retorno.subreg.ativado=false;
            if (typeof fnjs.obterJquery(botao_clicado).attr("seletor_local_retorno") !== "undefined") {
                comhttp.opcoes_retorno.seletor_local_retorno=fnjs.obterJquery(fnjs.obterJquery(botao_clicado).attr("seletor_local_retorno"));
            } else {
                comhttp.opcoes_retorno.seletor_local_retorno=fnjs.obterJquery(botao_clicado).closest("div.div_opcoes_pesquisa").parent().next().children('div.'+vars.classes.div_resultado).eq(0);
                
                if (typeof comhttp.opcoes_retorno.seletor_local_retorno === "undefined" || comhttp.opcoes_retorno.seletor_local_retorno === null || !comhttp.opcoes_retorno.seletor_local_retorno.length) {				
                    comhttp.opcoes_retorno.seletor_local_retorno=fnjs.obterJquery(botao_clicado).closest("div.div_opcoes_pesquisa").parent().next('div.'+vars.classes.div_resultado).eq(0);
                    if (typeof comhttp.opcoes_retorno.seletor_local_retorno === "undefined" || comhttp.opcoes_retorno.seletor_local_retorno === null || !comhttp.opcoes_retorno.seletor_local_retorno.length) {									
                        comhttp.opcoes_retorno.seletor_local_retorno=fnjs.obterJquery(botao_clicado).closest("div.div_opcoes_pesquisa").closest("div.div_conteudo_pagina").find('div.'+vars.classes.div_resultado).eq(0);		
                    }
                }
            }
            
            comhttp.opcoes_retorno.seletor_local_retorno.html('');
            fnjs.logf(this.constructor.name,"coletar_dados_para_pesquisa");
            return comhttp;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }

    pesquisar_dados(obj){
        try{
            fnjs.logi(this.constructor.name,"pesquisar_dados");
            let comhttp=this.coletar_dados_para_pesquisa(obj);
            obj = fnjs.obterJquery(obj);
            if(comhttp===false){
                /*houveram erros de preenchimento, coleta retorna false*/
                return;
            }
            /*limpa o local do resultado se houver dados nele*/
            if(obj.closest("div.div_opcoes_pesquisa").nextAll("div.div_resultado").length){
                obj.closest("div.div_opcoes_pesquisa").nextAll("div.div_resultado").html('');
            }
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"pesquisar_dados");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }


    filtrar_clientesativosxposit(){
        try {
            let 
                comhttp = JSON.parse(vars.str_tcomhttp),
                condicionantes = [],
                div_filtros = fnjs.obterJquery("div.div_consultar_sinergia_filtros"),
                div_filtros_entidades = {},
                div_filtros_periodos = {},
                inputs_entidades = {},
                input_filial = {},
                input_superv = {},
                input_rca = {},
                filial = null,
                superv = null,
                rca = null,
                combo_boxes = {},
                inputs_anos = {},
                combobox_periodo1 = {},
                combobox_periodo2 = {},
                input_ano_periodo1 = {},
                input_ano_periodo2 = {},
                mes_periodo1 = null,
                mes_periodo2 = null,
                ano_periodo1 = null,
                ano_periodo2 = null,
                filtros_painel = {};
            fnjs.obterJquery("button.div_consultar_sinergia_filtros_botao_filtrar").css("max-height","2em");
            div_filtros_entidades = div_filtros.find("div.div_consultar_sinergia_filtros_filtros");
            div_filtros_periodos = div_filtros.find("div.div_consultar_sinergia_filtros_periodos");				
            inputs_entidades = div_filtros_entidades.find("input") ;
            input_filial = inputs_entidades.eq(0);
            input_superv = inputs_entidades.eq(1);
            input_rca = inputs_entidades.eq(2);		
            filial = input_filial.val().trim();
            superv = input_superv.val().trim();
            rca = input_rca.val().trim();
            combo_boxes = div_filtros_periodos.find("div.div_combobox") ;
            inputs_anos = div_filtros_periodos.find("input.input_ano") ;	
            combobox_periodo1 = combo_boxes.eq(0);
            combobox_periodo2 = combo_boxes.eq(1);
            input_ano_periodo1 = inputs_anos.eq(0);
            input_ano_periodo2 = inputs_anos.eq(1);
            mes_periodo1 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo1);
            mes_periodo2 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo2);
            ano_periodo1 = input_ano_periodo1.val();
            ano_periodo2 = input_ano_periodo2.val();		
            filtros_painel.filial = filial;
            filtros_painel.superv = superv;
            filtros_painel.rca = rca;
            filtros_painel.mes_periodo1 = mes_periodo1;
            filtros_painel.mes_periodo2 = mes_periodo2;
            filtros_painel.ano_periodo1 = ano_periodo1;
            filtros_painel.ano_periodo2 = ano_periodo2;
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = "clientesativosxpositivados";
            comhttp.requisicao.requisitar.qual.condicionantes=[];
            comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp.requisicao.requisitar.qual.condicionantes.push("relatorio=clientesativosxpositivados");		
            comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+ filtros_painel.mes_periodo1);
            comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+ filtros_painel.mes_periodo2);
            comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+ filtros_painel.ano_periodo1);
            comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+ filtros_painel.ano_periodo2);
            if (filtros_painel.filial.trim().length > 0) {
                condicionantes.push("filial=" + filtros_painel.filial);
                comhttp.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
            } 
            if (filtros_painel.superv.trim().length > 0) {
                condicionantes.push("supervisor=" + filtros_painel.superv);
                comhttp.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
            } 
            if (filtros_painel.rca.trim().length > 0) {
                condicionantes.push("rca=" + filtros_painel.rca);
                comhttp.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
            } 
            if (condicionantes.length > 0) {
                condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                comhttp.requisicao.requisitar.qual.condicionantes.push(condicionantes);
            }	
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_resultado";
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp});	
                fnjs.logf(this.constructor.name,"filtrar_clientesativosxposit");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }


    /**
     * Retorna array com os valores selecionados, val do input, ou text dos elementos passados como parametro
     * @param {object} elementos - elementos html
     * @returns {array} - os valores dos elementos
     */
    pegar_valores_elementos(elementos){
        try{
            fnjs.logi(this.constructor.name,"pegar_valores_elementos");
            let retorno=[],
                elemento={},
                qt = 0;
            qt = elementos.length;
            for(let i = 0 ; i < qt; i ++) {
                if(elementos.eq(i).hasClass('div_combobox')){ 
                    elemento=elementos.eq(i);
                    let valores = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(elemento),
                        qt2=0;
                    qt2 = valores.length;
                    for(let j = 0 ; j < qt2 ; j++ ) {
                        retorno.push(valores[j]);
                    }
                }else{
                    retorno.push(typeof elementos.eq(i).val==='undefined'?elementos.eq(i).attr('value'):elementos.eq(i).val());
                }
            };
            fnjs.logf(this.constructor.name,"pegar_valores_elementos");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }



    incluir_options_condicionante(obj){
        try{
            fnjs.logi(this.constructor.name,"incluir_options_condicionante");
            obj = fnjs.obterJquery(obj);
            let combobox = obj.closest("div.div_combobox");
            let linha = combobox.closest("div.row");
            let celula_visao = linha.children("div.col-auto").eq(0);
            let dropdown_visao = celula_visao.find("ul.dropdown-menu");
            let visao_atual = dropdown_visao.find("input[type=radio]:checked").eq(0).closest("label").text() || "";
            let visao_carregada = combobox.attr("data-visao") || "";
            let comhttp={};
            let idrand = fnjs.id_random();
            if(visao_carregada.toLowerCase().trim() !== visao_atual.toLowerCase().trim() || (visao_atual === visao_carregada && visao_carregada === "")){
                combobox.find("ul").eq(0).children("li").remove();
            combobox.addClass(idrand);
            comhttp=JSON.parse(vars.str_tcomhttp);
            comhttp.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
            comhttp.opcoes_requisicao.objeto_carregando = "div."+idrand+">div.div_combobox_dropdown";
            comhttp.opcoes_requisicao.tipo_carregando = "simples";			
            comhttp.requisicao.requisitar.oque='dados_literais';
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "valores_para_condicionantes";
            comhttp.requisicao.requisitar.qual.objeto = visao_atual;
            comhttp.eventos.aposretornar=[];
            comhttp.eventos.aposretornar.push({
                    arquivo:null,
                    funcao:'window.fnsisjd.atualizar_opcoes',
                    parametros:{seletor_objeto:idrand}
            });
            fnreq.requisitar_servidor({comhttp:comhttp});
            } 
            fnjs.logf(this.constructor.name,"incluir_options_condicionante");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }

    /**
     * Substitui um dropdown ou combobox retornado de uma consulta ao servidor
     * @param {json object} params 
     */
    atualizar_opcoes(params) {
        try{
            fnjs.logi(this.constructor.name,"atualizar_opcoes");
            let combobox=fnjs.obterJquery("div."+params.seletor_objeto);

            /*remove da variavel glogal de dados */
            let id_dados = combobox.attr("id_dados");
            if (typeof id_dados !== 'undefined') {
            if (typeof dados[id_dados] !== 'undefined') {
                delete dados[id_dados];
            }
            }

            combobox = fnjs.obterJquery(params.comhttp.retorno.dados_retornados.conteudo_html).replaceAll(combobox);
            bootstrap.Dropdown.getOrCreateInstance(combobox.find("button.dropdown-toggle")[0]).show();
            fnreq.carregando({
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(this.constructor.name,"atualizar_opcoes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }


    incluir_options_campo_avulso( obj ){
        try{
            fnjs.logi(this.constructor.name,"incluir_options_campo_avulso");
            let combobox = fnjs.obterJquery(obj).closest("div.div_combobox");
            let nome_item = combobox.attr("data-visao") || "";
            let nome_item_atual = combobox.attr("data-visao_atual") || "x";
            let comhttp={};
            let idrand = fnjs.id_random();
            if(nome_item !== nome_item_atual){
                if (nome_item.trim() === ""){
                    nome_item = "relatorio_venda_lista_campos_avulsos";
                }
                combobox.addClass(idrand);
                comhttp=JSON.parse(vars.str_tcomhttp);
                comhttp.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
                comhttp.opcoes_requisicao.objeto_carregando = "div."+idrand+">div.div_combobox_dropdown";
                comhttp.opcoes_requisicao.tipo_carregando = "simples";			
                comhttp.requisicao.requisitar.oque="dados_literais";
                comhttp.requisicao.requisitar.qual.comando = "consultar";
                comhttp.requisicao.requisitar.qual.tipo_objeto = "valores_para_campo_avulso";
                comhttp.requisicao.requisitar.qual.objeto = nome_item;
                comhttp.eventos.aposretornar=[];
                comhttp.eventos.aposretornar.push({
                    arquivo:null,
                    funcao:'window.fnsisjd.atualizar_opcoes',
                    parametros:{seletor_objeto:idrand}
                });
                fnreq.requisitar_servidor({comhttp:comhttp});
            }
            fnjs.logf(this.constructor.name,"incluir_options_campo_avulso");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_valores_venda_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_valores_venda_inicio");
            let destino = fnjs.obterJquery("div.card.card_meus_valores").find("div.card:first").find("span:first");
            destino.text(((params.comhttp.retorno.dados_retornados.conteudo_html.dados[0] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2}));
            let destino2 = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(1).find("span:first");
            destino2.text(((params.comhttp.retorno.dados_retornados.conteudo_html.dados[1] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2}));
            fnjs.logf(this.constructor.name,"inserir_valores_venda_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }    

    inserir_positivacao_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_positivacao_inicio");
            let destino = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(2).children("div.card-body").children("div.row").children("div.col:first").children(":first");
            let destinotemp = destino.clone();
            let parent = destino.parent();
            parent.children().remove();
            parent.html("");
            parent.append(destinotemp);
            let valor1 = ((params.comhttp.retorno.dados_retornados.conteudo_html.dados[0] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0});
            let valor2 = ((params.comhttp.retorno.dados_retornados.conteudo_html.dados[1] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0});
            parent.append(fnhtml.criar_elemento({
                tag:"button",
                type:"button",
                class:"btn-outline position-relative bg-transparent border-0 fs-5",
                text:valor1,
                sub:[
                    {
                        tag:"span",
                        class:"position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10",
                        text:(params.comhttp.retorno.dados_retornados.conteudo_html.dados[2] || "(m)")                            
                    }
                ]
            }) + "/" + fnhtml.criar_elemento({
                tag:"button",
                type:"button",
                class:"btn-outline position-relative bg-transparent border-0",
                text:valor2, 
                sub:[
                    {
                        tag:"span",
                        class:"position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10",
                        text:(params.comhttp.retorno.dados_retornados.conteudo_html.dados[3] || "(m)")                            
                    }
                ]
            }));
            fnjs.logf(this.constructor.name,"inserir_positivacao_inicio");

        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_mix_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_mix_inicio");
            /*let destino = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(3).find("span:first");
            destino.text(((params.comhttp.retorno.dados_retornados.conteudo_html.dados[0] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0}));
            destino.append('/<span class="h6">'+((params.comhttp.retorno.dados_retornados.conteudo_html.dados[1] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0})+"</span>");*/

            let destino = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(3).children("div.card-body").children("div.row").children("div.col:first").children(":first");
            let destinotemp = destino.clone();
            let parent = destino.parent();
            parent.children().remove();
            parent.html("");
            parent.append(destinotemp);
            
            let valor1 = ((params.comhttp.retorno.dados_retornados.conteudo_html.dados[0] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0});
            let valor2 = ((params.comhttp.retorno.dados_retornados.conteudo_html.dados[1] || 0).toString().replace(",",".") - 0).toLocaleString('pt-BR',{minimumFractionDigits:0,maximumFractionDigits:0});
            parent.append(fnhtml.criar_elemento({
                tag:"button",
                type:"button",
                class:"btn-outline position-relative bg-transparent border-0 fs-5",
                text:valor1,
                sub:[
                    {
                        tag:"span",
                        class:"position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10",
                        text:(params.comhttp.retorno.dados_retornados.conteudo_html.dados[2] || "(m)")                            
                    }
                ]
            }) + "/" + fnhtml.criar_elemento({
                tag:"button",
                type:"button",
                class:"btn-outline position-relative bg-transparent border-0",
                text:valor2, 
                sub:[
                    {
                        tag:"span",
                        class:"position-absolute top-0 start-50 translate-middle badge bg-transparent text-secondary fw-lighter fs-10",
                        text:(params.comhttp.retorno.dados_retornados.conteudo_html.dados[3] || "(m)")                            
                    }
                ]
            }));
            fnjs.logf(this.constructor.name,"inserir_mix_inicio");

        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }


    inserir_menu(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_menu");           
            let barra_menus = fnjs.obterJquery("div#barra_menus");
            barra_menus.html(params.comhttp.retorno.dados_retornados.conteudo_html);                                 
            fnjs.logf(this.constructor.name,"inserir_menu");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_mes_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_mes_inicio");           
            let card_meus_valores = fnjs.obterJquery("div#card_meus_valores");
            card_meus_valores.children("div.spinner_mes_inicio").remove();
            card_meus_valores.append(params.comhttp.retorno.dados_retornados.conteudo_html);                                 
            fnjs.logf(this.constructor.name,"inserir_mes_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_mais_recentes_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_mais_recentes_inicio");
            let dados = params.comhttp.retorno.dados_retornados.conteudo_html.dados;
            let qt = dados.length;
            let card_pai = fnjs.obterJquery("div.card.card_mais_recentes").find('div.card-body:first');
            card_pai.text('');
            card_pai.append('<div class="row"></div>');
            let div_pai = card_pai.find('div:first');
            if (qt > 5) {
                qt = 5;
            }
            for(let i = 0 ; i < qt; i++) {
                this.criar_card_atalho_inicio({
                    title:dados[i].data_acesso,
                    icone:dados[i].icone.replace("__NOMEDIRSISJD__",vars.nomes_diretorios.sjd),
                    parent:div_pai[0],
                    footer:dados[i].nomeopcaovisivel,
                    props:[
                        {
                            prop:"nomeops",
                            value:dados[i].nomeops
                        },
                        {
                            prop:"seletorconteudo",
                            value:dados[i].seletorconteudo
                        }
                    ]
                });
            }                        
            fnjs.logf(this.constructor.name,"inserir_mais_recentes_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_mais_acessados_inicio(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_mais_acessados_inicio");
            let dados = params.comhttp.retorno.dados_retornados.conteudo_html.dados;
            let qt = dados.length;
            let card_pai = fnjs.obterJquery("div.card.card_mais_acessados").find('div.card-body:first');
            card_pai.text('');
            card_pai.append('<div class="row"></div>');
            let div_pai = card_pai.find('div:first');
            if (qt > 5) {
                qt = 5;
            }
            for(let i = 0 ; i < qt; i++) {
                this.criar_card_atalho_inicio({
                    title:dados[i].qtacessos,
                    icone:(dados[i].icone||'').replace("__NOMEDIRSISJD__",vars.nomes_diretorios.sjd),
                    parent:div_pai[0],
                    footer:dados[i].nomeopcaovisivel,
                    props:[
                        {
                            prop:"nomeops",
                            value:dados[i].nomeops
                        },
                        {
                            prop:"seletorconteudo",
                            value:dados[i].seletorconteudo
                        }
                    ]
                });
            }                        
            fnjs.logf(this.constructor.name,"inserir_mais_acessados_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    requisitar_valores_inicio(params){
        try {
            /*requisita os valores de venda e peso */
            let destino = fnjs.obterJquery("div.card.card_meus_valores").find("div.card:first").find("span:first");
            let destino1 = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(1).find("span:first");
            let destino2 = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(2).find("span:first");
            let destino3 = fnjs.obterJquery("div.card.card_meus_valores").find("div.card").eq(3).find("span:first");            
            destino.html(fnhtml.criar_spinner());
            destino1.html(fnhtml.criar_spinner());
            destino2.html(fnhtml.criar_spinner());
            destino3.html(fnhtml.criar_spinner());
            params = params || {};
            let comhttp_req_vals = JSON.parse(vars.str_tcomhttp);
            comhttp_req_vals.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_vals.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_vals.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_vals.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_vals.requisicao.requisitar.qual.objeto = "valores_venda_inicio";			
            if (typeof params.mes !== "undefined" && params.mes !== null && params.mes.length > 0) {
                comhttp_req_vals.requisicao.requisitar.qual.condicionantes.push("mes="+params.mes)
            }
            comhttp_req_vals.opcoes_retorno.seletor_local_retorno = "body";

            comhttp_req_vals.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_vals.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_valores_venda_inicio'
                }
            ];			
            let params_req_vals = {comhttp:comhttp_req_vals};
            fnreq.requisitar_servidor(params_req_vals);


            /*requisita a positivacao de clientes*/
            let comhttp_req_positcli = JSON.parse(vars.str_tcomhttp);
            comhttp_req_positcli.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_positcli.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_positcli.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_positcli.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_positcli.requisicao.requisitar.qual.objeto = "positivacao_inicio";			
            comhttp_req_positcli.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_positcli.opcoes_requisicao.mostrar_carregando = false;
            if (typeof params.mes !== "undefined" && params.mes !== null && params.mes.length > 0) {
                comhttp_req_positcli.requisicao.requisitar.qual.condicionantes.push("mes="+params.mes)
            }
            comhttp_req_positcli.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_positivacao_inicio'
                }
            ];			
            let params_req_positcli = {comhttp:comhttp_req_positcli};
            fnreq.requisitar_servidor(params_req_positcli);


            /*requisita o mix de produtos*/
            let comhttp_req_mixprod = JSON.parse(vars.str_tcomhttp);
            comhttp_req_mixprod.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_mixprod.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_mixprod.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_mixprod.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_mixprod.requisicao.requisitar.qual.objeto = "mix_inicio";			
            comhttp_req_mixprod.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_mixprod.opcoes_requisicao.mostrar_carregando = false;
            if (typeof params.mes !== "undefined" && params.mes !== null && params.mes.length > 0) {
                comhttp_req_mixprod.requisicao.requisitar.qual.condicionantes.push("mes="+params.mes)
            }
            comhttp_req_mixprod.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_mix_inicio'
                }
            ];			
            let params_req_mixprod = {comhttp:comhttp_req_mixprod};
            fnreq.requisitar_servidor(params_req_mixprod);
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }


    carregar_valores_inicio(){
        try {
            fnjs.logi(this.constructor.name,"carregar_valores_inicio");


            /*requisita menu*/
            let comhttp_req_menu = JSON.parse(vars.str_tcomhttp);
            comhttp_req_menu.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_menu.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_menu.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_menu.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_menu.requisicao.requisitar.qual.objeto = "menu";			
            comhttp_req_menu.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_menu.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_menu.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_menu'
                }
            ];			
            let params_req_menu = {comhttp:comhttp_req_menu};
            fnreq.requisitar_servidor(params_req_menu);


            /*requisita mes inicio*/
            let comhttp_req_mes_inicio = JSON.parse(vars.str_tcomhttp);
            comhttp_req_mes_inicio.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_mes_inicio.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_mes_inicio.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_mes_inicio.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_mes_inicio.requisicao.requisitar.qual.objeto = "mes_inicio";			
            comhttp_req_mes_inicio.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_mes_inicio.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_mes_inicio.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_mes_inicio'
                }
            ];			
            let params_req_mes_inicio = {comhttp:comhttp_req_mes_inicio};
            fnreq.requisitar_servidor(params_req_mes_inicio);


            /*requisita mais recentes*/
            let comhttp_req_maisrecentes = JSON.parse(vars.str_tcomhttp);
            comhttp_req_maisrecentes.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_maisrecentes.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_maisrecentes.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_maisrecentes.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_maisrecentes.requisicao.requisitar.qual.objeto = "mais_recentes_inicio";			
            comhttp_req_maisrecentes.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_maisrecentes.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_maisrecentes.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_mais_recentes_inicio'
                }
            ];			
            let params_req_maisrecentes = {comhttp:comhttp_req_maisrecentes};
            fnreq.requisitar_servidor(params_req_maisrecentes);


            /*requisita mais acessados*/
            let comhttp_req_masacessados = JSON.parse(vars.str_tcomhttp);
            comhttp_req_masacessados.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_masacessados.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_masacessados.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_masacessados.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_masacessados.requisicao.requisitar.qual.objeto = "mais_acessados_inicio";			
            comhttp_req_masacessados.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_masacessados.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_masacessados.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_mais_acessados_inicio'
                }
            ];			
            let params_req_maisacessados = {comhttp:comhttp_req_masacessados};
            fnreq.requisitar_servidor(params_req_maisacessados);

            fnsisjd.requisitar_valores_inicio();
            fnjs.logf(this.constructor.name,"carregar_valores_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    inserir_data_aurora(params){
        try {
            fnjs.logi(this.constructor.name,"inserir_data_aurora");           
            let data_aurora = fnjs.obterJquery("text#data_aurora");
            data_aurora.html("Data Aurora: " + params.comhttp.retorno.dados_retornados.conteudo_html);                                 
            fnjs.logf(this.constructor.name,"inserir_data_aurora");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    requisitar_data_aurora(){
        try {
            fnjs.logi(this.constructor.name,"carregar_valores_inicio");


            /*requisita menu*/
            let comhttp_req_menu = JSON.parse(vars.str_tcomhttp);
            comhttp_req_menu.requisicao.requisitar.oque = 'dados_sql';
            comhttp_req_menu.requisicao.requisitar.qual.condicionantes = [];
            comhttp_req_menu.requisicao.requisitar.qual.comando = "consultar";
            comhttp_req_menu.requisicao.requisitar.qual.tipo_objeto = 'visao';
            comhttp_req_menu.requisicao.requisitar.qual.objeto = "data_aurora";			
            comhttp_req_menu.opcoes_retorno.seletor_local_retorno = "body";
            comhttp_req_menu.opcoes_requisicao.mostrar_carregando = false;
            comhttp_req_menu.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnsisjd.inserir_data_aurora'
                }
            ];			
            let params_req_menu = {comhttp:comhttp_req_menu};
            fnreq.requisitar_servidor(params_req_menu);
            fnjs.logf(this.constructor.name,"carregar_valores_inicio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    marcar_todos_checkbox_ver_vals_de(obj){
        try{
            fnjs.logi(this.constructor.name,"marcar_todos_checkbox_ver_vals_de");
        let div_continente = fnjs.obterJquery(obj).closest("div");
        let demais_elementos = div_continente.find("input[type=checkbox]");
        let checked = obj.checked;
        $.each(demais_elementos,function(index,element){
            demais_elementos.eq(index)[0].checked=checked;
        });
            fnjs.logf(this.constructor.name,"marcar_todos_checkbox_ver_vals_de");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	
    verificar_marcou_todos_checkbox_ver_vals_de(obj){
        try{
            fnjs.logi(this.constructor.name,"verificar_marcou_todos_checkbox_ver_vals_de");
        let div_continente = fnjs.obterJquery(obj).closest("div");
        let demais_elementos = div_continente.find("input[type=checkbox]").not(":last");
        let checkbox_todos = div_continente.find("input:last").filter(":last");
        let checou_todos = obj.checked;
        $.each(demais_elementos,function(index,element){
            if (!demais_elementos.eq(index)[0].checked) {					
                checou_todos=false;
                return false;
            }
        });
        checkbox_todos[0].checked = checou_todos; 		
            fnjs.logf(this.constructor.name,"verificar_marcou_todos_checkbox_ver_vals_de");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	

    marcar_todos_checkbox_considerar_vals_de(obj){
        try{
            fnjs.logi(this.constructor.name,"marcar_todos_checkbox_considerar_vals_de");
        let div_continente = fnjs.obterJquery(obj).closest("div");
        let demais_elementos = div_continente.find("input[type=checkbox]");
        let checked = obj.checked;
        $.each(demais_elementos,function(index,element){
            demais_elementos.eq(index)[0].checked=checked;
        });
            fnjs.logf(this.constructor.name,"marcar_todos_checkbox_considerar_vals_de");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	
    verificar_marcou_todos_checkbox_considerar_vals_de(obj){
        try{
            fnjs.logi(this.constructor.name,"verificar_marcou_todos_checkbox_considerar_vals_de");
        let div_continente = fnjs.obterJquery(obj).closest("div");
        let demais_elementos = div_continente.find("input[type=checkbox]").not(":last");
        let checkbox_todos = div_continente.find("input:last").filter(":last");
        let checou_todos = obj.checked;
        $.each(demais_elementos,function(index,element){
            if (!demais_elementos.eq(index)[0].checked) {					
                checou_todos=false;
                return false;
            }
        });
        checkbox_todos[0].checked = checou_todos; 		
            fnjs.logf(this.constructor.name,"verificar_marcou_todos_checkbox_considerar_vals_de");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }




    pesquisar_sub_registro_linha_relatorio(params) {
        try {
            fnjs.logi(this.constructor.name,"pesquisar_sub_registro_linha_relatorio");
            if (typeof vars.visoes === 'undefined' || vars.visoes === null || vars.visoes.length === 0) {
                this.requisitar_visoes({elemento:params.elemento,funcao_retorno:"window.fnsisjd.pesquisar_sub_registro_linha_relatorio",parametros:params});
                return; 
            }
            params.elemento = fnjs.obterJquery(params.elemento||params.obj||params.comhttp.opcoes_retorno.seletor_local_retorno);
            let linhasub = {},
                celsub = {},
                tabdados = {},
                div_continente = {},
                div_opcoes_pesq_orig = {},
                nova_div_opcoes_pesq = {},
                nova_div_resultado = {},
                idrand = fnjs.id_random(),
                btnpesq = {},
                comboboxvisao = {},
                visaosub = "",
                linhanovavisao={};
            params.elemento = params.elemento.closest("tr");			
            tabdados = params.elemento.closest("table.tabdados");
            div_continente = tabdados.closest("div");
            div_opcoes_pesq_orig = div_continente.prevAll("div.div_opcoes_pesquisa").eq(0);
            if (typeof div_opcoes_pesq_orig === "undefined" || div_opcoes_pesq_orig === null || !div_opcoes_pesq_orig.length) {
                div_opcoes_pesq_orig = fnjs.obterJquery("div.div_opcoes_pesquisa").eq(0);
            }
            linhasub = params.elemento.next("tr");
            celsub = linhasub.children("td.cel_sub_registro");
            celsub.css("padding","30px");
            
            nova_div_opcoes_pesq = div_opcoes_pesq_orig.clone(true);
            nova_div_opcoes_pesq.find("div.div_visoes").eq(0).find("div.div_visao:not(:first)").remove();
            comboboxvisao = nova_div_opcoes_pesq.find("div.div_visoes").find("div.div_combobox").eq(0);
            visaosub = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(comboboxvisao);
            visaosub = visaosub.join(",").trim().toLowerCase();
            visaosub = vars.visoes[vars.visoes.join(",").trim().toLowerCase().split(",").indexOf(visaosub.trim().toLowerCase())+1];
            if (typeof visaosub === "undefined") {
                visaosub = vars.visoes[0];
            }

            let params_dropdown_visao = {};
            params_dropdown_visao.visoes = vars.visoes;
            params_dropdown_visao.selecionado = visaosub;
            params_dropdown_visao.filter = true;
            params_dropdown_visao.classe_botao = "btn-dark";
            comboboxvisao.replaceWith(this.criar_combobox_visao(params_dropdown_visao));


            nova_div_opcoes_pesq.find("div.div_periodos").hide();
            nova_div_opcoes_pesq.find("div.div_avancado").hide();


            let btns_accordion = nova_div_opcoes_pesq.find(".accordion-button[data-bs-target]");
            let novo_id = null;
            for(let i = 0; i < btns_accordion.length; i++) {
                novo_id = fnjs.id_random();
                btns_accordion.eq(i).attr("data-bs-target","#" + novo_id);
                btns_accordion.eq(i).parent().next().attr("id",novo_id);
            }


            nova_div_resultado = '<div class="div_resultado ' + idrand + '"></div>';
            
            celsub.html(nova_div_opcoes_pesq);
            celsub.append(nova_div_resultado);		
            nova_div_opcoes_pesq = celsub.find("div.div_opcoes_pesquisa").eq(0);
            btnpesq = nova_div_opcoes_pesq.find("button.botao_pesquisar").eq(0);
            btnpesq.attr("seletor_local_retorno","div." + idrand);
            btnpesq.attr("apresentargrafico",false);
            if (nova_div_opcoes_pesq.find("div.div_opcoes_cab").eq(0).attr("data-status") === "aberto") {			
                nova_div_opcoes_pesq.find("div.div_opcoes_cab").eq(0).click();
            }
            btnpesq.closest("div.accordion-item").children("div.accordion-header").children(".accordion-button").eq(0).addClass("collapsed").attr("aria-expanded",false);
            btnpesq.closest("div.accordion-body").parent("div.show").removeClass("show");

            btnpesq.click();
            fnjs.logf(this.constructor.name,"pesquisar_sub_registro_linha_relatorio");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    pesquisar_sinergia( obj , visoes  , condicionantes  , obj_loc_res ){
        try{
            fnjs.logi(this.constructor.name,"pesquisar_sinergia");
            let comhttp ;
            let div_pesq ;
            let divs_sel;
            let rca;
            let mes;
            let ano;
            let visao ;
            let combo_boxes={};
            let combobox_visao={};
            let combobox_rca={};
            let combobox_mes={};
            let combobox_ano={};
            let i=0;
            let j=0;
            let qt=0;
            let qt2=0;
            div_pesq = fnjs.obterJquery( obj ).closest( 'div.div_opcoes_pesquisa') ;
            if(div_pesq.length){
            }else{
                setTimeout(this.pesquisar_sinergia, 5000 , obj , visoes  , condicionantes  , obj_loc_res );
                return ;
            }
            combo_boxes = div_pesq.find( 'div.div_combobox' ) ;
            if(combo_boxes.length){
            }else{
                setTimeout(this.pesquisar_sinergia, 5000 , obj , visoes  , condicionantes  , obj_loc_res );
                return ;
            }
            combobox_visao=combo_boxes[0];
            combobox_rca=combo_boxes[1];
            combobox_mes=combo_boxes[2];
            combobox_ano=combo_boxes[3];
            rca = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_rca);
            mes = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_mes);
            ano = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_ano);
            visao = 'sinergia';
            visoes = fnjs.first_valid([visoes , null],false);
            if(visoes === null){
                visoes = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_visao);
            }
            if(mes.indexOf('março'.toUpperCase)>-1){
                mes[mes.indexOf('março'.toUpperCase)]=vars.constantes.meses[2];
            }
            condicionantes = fnjs.first_valid([condicionantes , null]);
            obj_loc_res = fnjs.first_valid([obj_loc_res , '.'+vars.classes.div_resultado+'.div_resultado_sinergia' ]);
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='dados_sql';
        comhttp.requisicao.requisitar.qual.comando = "consultar";
        comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
        comhttp.requisicao.requisitar.qual.objeto = "sinergia";
            comhttp.requisicao.requisitar.qual.condicionantes=[];
        comhttp.requisicao.requisitar.qual.condicionantes.push("mostrar_vals_de=3");
            comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp.requisicao.requisitar.qual.condicionantes.push('relatorio=sinergia');
            comhttp.requisicao.requisitar.qual.condicionantes.push('visoes='+visoes);
            comhttp.requisicao.requisitar.qual.condicionantes.push('mes='+mes);
            comhttp.requisicao.requisitar.qual.condicionantes.push('ano='+ano);
            comhttp.requisicao.requisitar.qual.condicionantes.push('rca='+rca);			
            comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantes='+condicionantes);
            comhttp.opcoes_retorno.seletor_local_retorno=obj_loc_res;
            comhttp.opcoes_retorno.subreg.aoabrir='window.fnsisjd.abrir_sub_sinergia';
        comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            },{
                arquivo:null,
                funcao:"window.fnsisjd.grafico_sinergia"
        }];
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"pesquisar_sinergia");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	

    mostrar_opcoes_pesquisa(params) {
        try{
            fnjs.logi(this.constructor.name,"mostrar_opcoes_pesquisa");
            let status;
            let elem = null;
            let img = null;
            if (typeof params !== "undefined" && params !== null) {
                params.elemento = params.elemento || params.elem || params.obj || params;
                elem = fnjs.obterJquery(params.elemento);
                if (typeof elem !== "undefined" && elem !== null && elem.length) {					
                    img = elem.find('img');
                    acao = fnjs.first_valid([params.acao,'']);
                    status = elem.attr('data-status');
                    if(status === "aberto" || acao === "fechar"){
                        img.fadeOut(100,function(){
                            fnjs.obterJquery(this).attr('src',vars.nomes_caminhos_arquivos.img_right32).fadeIn();
                        });
                        elem.attr( 'data-status' , "fechado" ) ;
                        elem.nextAll(".div_opcoes_pesquisa_simples" ).eq(0).fadeOut(500);
                    }else if(status === "fechado" || acao === "abrir"){
                        img.fadeOut(100,function(){
                            fnjs.obterJquery(this).attr('src',vars.nomes_caminhos_arquivos.img_down32).fadeIn();
                        });
                        elem.attr( 'data-status' , "aberto" ) ;
                        elem.nextAll(".div_opcoes_pesquisa_simples" ).eq(0).fadeIn(500);
                    }	
                }
            }
            fnjs.logf(this.constructor.name,"mostrar_opcoes_pesquisa");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }


    obter_visoes_tabela(tabdados){
        try {			
            fnjs.logi(this.constructor.name,"obter_visoes_tabela");
            let 
                prms_array = {},
                prms_retorno = {};
            if (typeof tabdados.hasClass !== "function") {
                tabdados = fnjs.obterJquery(tabdados);
            }
            prms_array.array = fnhtml.obter_text_como_array(tabdados.children("thead").children("tr.linhatitulos").prev().children("th:not(.cel_cmd_tit):not(.cel_sub_tit)"));
            prms_array.quantidade = 1;
            prms_retorno.array = [];
            prms_retorno.quantidade = 0;
            for (let i = 0; i < prms_array.array.length; i++) {
                if (prms_array.array[i].trim().toLowerCase().indexOf("de ") > -1 &&  prms_array.array[i].trim().toLowerCase().indexOf("/") > -1) {
                } else {
                    prms_retorno.array.push(prms_array.array[i]);
                }
            }
            fnjs.logf(this.constructor.name,"obter_visoes_tabela");
            return prms_retorno.array;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    corrigir_visoes_relatorio_personalizado(visoes_corrigir) {
        try {
            fnjs.logi(this.constructor.name,"corrigir_visoes_relatorio_personalizado");
            /*let qt = visoes_corrigir.length;
            for (let i = 0; i < qt; i ++) {
                visoes_corrigir[i] = visoes_corrigir[i].toLowerCase().trim().replace(/\s/ig,"_");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/origemdedados/ig,"origem_de_dados");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/produtos/ig,"produto");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/empresas/ig,"empresa");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/supervisores/ig,"supervisor");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/usuarios/ig,"rca");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/ramosatividade/ig,"ramo_de_atividade");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/departamentos/ig,"departamento");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/clientes/ig,"cliente");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/rotas/ig,"rota");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/pracas/ig,"praca");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/negocioaurora/ig,"negocio_aurora");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/rede_de_cliente/ig,"rede_de_clientes");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/rededecliente/ig,"rede_de_clientes");
                visoes_corrigir[i] = visoes_corrigir[i].replace(/categoriaaurora/ig,"categoria_aurora");
            }*/
            fnjs.logf(this.constructor.name,"corrigir_visoes_relatorio_personalizado");
            return visoes_corrigir;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }


    grafico_sinergia(params) {
        try {
            fnjs.logi(this.constructor.name,"grafico_sinergia");
            let grafico = "";
            let contexto = {};
            let div_ref = fnjs.obterJquery("div.div_resultado_sinergia");
            let tabelaest = {};
            tabelaest = div_ref.children("table.tabdados");
            if (tabelaest.length && tabelaest instanceof ($ || null)) {
                if (tabelaest.attr("carregamento") !== "carregado") {
                    setTimeout(this.grafico_sinergia,1000,params);
                    return;
                }
            } else {
                setTimeout(this.grafico_sinergia,1000,params);
                return;
            }
            tabelaest.css("display","inline-block");
            tabelaest.css("float","left");
            div_ref.css("display","inline-flex");
            div_ref.append('<div id="div_grafico_sinergia" style="display:inline-block;margin:50px;margin-top:0px;"><h3>Grafico atingimento</h3><br /><canvas id="grafico_sinergia" width="300" height="300" style="dipsplay:inline-block"></canvas></div>');
            let indcampodb = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"% realiz.0");
            let celulas_valores = tabelaest.children("tbody").children("tr:not(.linha_padrao)").children("td:nth-child("+(indcampodb+1)+")");
            let celulas_nomes = tabelaest.chilidren("tbody").children("tr:not(.linha_padrao)").children("td:nth-child(1)");
            let dados = [];
            let nomes = [];
            $.each(celulas_valores, function(index) {
                dados.push(fnmat.como_numero(celulas_valores.eq(index).text()));
                nomes.push(celulas_nomes.eq(index).text().trim().substr(0,5));
            });
            grafico = fngraf.criarGrafico("grafico_sinergia",30, dados, "#696","horizontal",false,nomes);			
            fnjs.obterJquery(grafico).css("display","inline-block");
            fnjs.obterJquery(grafico).css("float","right");
            fnjs.obterJquery(grafico).after('<ul style="display:inline-block;float:right;white-space:nowrap;"><li style="color:red;">vermelho - abaixo de 25%</li><li style="color:orange;">laranja - entre 25 e 49,99%</li><li style="color:royalblue;">azul - entre 50 e 99,99%</li><li style="color:green">verde - 100% ou acima</li></ul>');
            fnjs.logf(this.constructor.name,"grafico_sinergia");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    criar_grafico_sinergia2(params){
        try {
            fnjs.logi(this.constructor.name,"criar_grafico_sinergia2");
            let opcoes_grafico1 = {}, opcoes_grafico2={}, opcoes_grafico3={};
            
            /*migrar para google charts*/
            google.charts.load('current', {'packages':['gauge']});
            google.charts.setOnLoadCallback(desenharGraficosTermometros);
            
            function desenharGraficosTermometros() {
                let corpo_tabelaest = window.fnjs.obterJquery("div.div_consultar_sinergia_campanhas_itens").find("table.tabdados").children("tbody"),
                    percentual2,percentual1,percentual3,
                    data,
                    temsubreg = 1;	
                if (!corpo_tabelaest.length) {
                    params.contador_recursao = params.contador_recursao || 0;
                    params.contador_recursao++;
                    if (params.contador_recursao < window.vars.num_limite_recursoes) {
                        setTimeout(window.fnsisjd.criar_grafico_sinergia2,500,params);
                    } else {
                        console.log("criar_grafico_sinergia2 encerrado por excesso de recursoes");
                    }
                    return;
                }
                percentual2 = Math.round(fnmat.como_numero(corpo_tabelaest.children("tr").eq(0).children("td").eq(4+temsubreg).text()));
                percentual1 = Math.round(fnmat.como_numero(corpo_tabelaest.children("tr").eq(1).children("td").eq(4+temsubreg).text()));
                percentual3 = Math.round(fnmat.como_numero(corpo_tabelaest.children("tr").eq(2).children("td").eq(4+temsubreg).text()));
                
                data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['Posit. Cliente', percentual1],
                ['Volume', percentual2],
                ['Mix Produto', percentual3]
                ]);

                let options = {
                width: 400, height: 120,
                redFrom: 0, redTo: 20,
                greenFrom: 80, greenTo: 100,
                minorTicks: 5
                };
                let chart = new google.visualization.Gauge(window.fnjs.obterJquery('div.div_consultar_sinergia_grafico_grafico2_grafico')[0]);

                chart.draw(data, options);
            }
            fnjs.logf(this.constructor.name,"criar_grafico_sinergia2");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }


    atualizar_grafico_velocimetro_sinergia(params){
        try {
            fnjs.logi(this.constructor.name,"atualizar_grafico_velocimetro_sinergia");
            this.criar_grafico_sinergia2(params);
            fnjs.logf(this.constructor.name,"atualizar_grafico_velocimetro_sinergia");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_painel_campanhas_sinergia(filtros_painel) {
        try {
            fnjs.logi(this.constructor.name,"carregar_painel_campanhas_sinergia");
            $("div.div_consultar_sinergia_campanhas_itens, div.div_consultar_sinergia_grafico_grafico2_grafico").html(fnhtml.criar_spinner());
            let comhttp_campanha_sinergia = JSON.parse(vars.str_tcomhttp),
                condicionantes = [];
            comhttp_campanha_sinergia.requisicao.requisitar.oque="dados_sql";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.comando = "consultar";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.objeto = "sinergia2";
            comhttp_campanha_sinergia.opcoes_requisicao.tipo_carregando = "simples";
            comhttp_campanha_sinergia.opcoes_requisicao.tipo_alvo_carregando = 'string';
            comhttp_campanha_sinergia.opcoes_requisicao.objeto_carregando = "div.div_consultar_sinergia_campanhas_itens, div.div_consultar_sinergia_grafico_grafico2_grafico";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes=[];
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("relatorio=sinergia2");		
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+ filtros_painel.mes_periodo1);
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+ filtros_painel.mes_periodo2);
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+ filtros_painel.ano_periodo1);
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+ filtros_painel.ano_periodo2);
            if (filtros_painel.filial.trim().length > 0) {
                condicionantes.push("filial=" + filtros_painel.filial);
                comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
            } 
            if (filtros_painel.superv.trim().length > 0) {
                condicionantes.push("supervisor=" + filtros_painel.superv);
                comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
            } 
            if (filtros_painel.rca.trim().length > 0) {
                condicionantes.push("rca=" + filtros_painel.rca);
                comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
            } 
            if (condicionantes.length > 0) {
                condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push(condicionantes);
            }	
            comhttp_campanha_sinergia.opcoes_retorno.seletor_local_retorno="div.div_consultar_sinergia_campanhas_itens";
            comhttp_campanha_sinergia.opcoes_retorno.subreg.aoabrir="window.fnsisjd.abrir_sub_sinergia2";
            comhttp_campanha_sinergia.opcoes_retorno.metodo_insersao = "html";					
            comhttp_campanha_sinergia.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            },{
                    arquivo:null,
                    funcao:"window.fnsisjd.atualizar_grafico_velocimetro_sinergia"
            },{
                    arquivo:null,
                    funcao:"window.fnsisjd.atualizar_cores_linhas_tabelaest"
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp_campanha_sinergia});		
            fnjs.logf(this.constructor.name,"carregar_painel_campanhas_sinergia");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }

    obter_filtros_painel() {
        try {
            fnjs.logi(this.constructor.name,"obter_filtros_painel");
            let filtros_painel = {},
                div_filtros = fnjs.obterJquery("div.div_consultar_sinergia_filtros"),
                div_filtros_entidades,
                div_filtros_periodos,
                inputs_entidades,
                input_filial,
                input_superv,
                input_rca,
                filial = null,
                superv = null,
                rca = null,
                combo_boxes = {},
                inputs_anos = {},
                combobox_periodo1 = {},
                combobox_periodo2 = {},
                input_ano_periodo1 = {},
                input_ano_periodo2 = {},
                mes_periodo1 = null,
                mes_periodo2 = null,
                ano_periodo1 = null,
                ano_periodo2 = null;
            div_filtros_entidades = div_filtros.find("div.div_consultar_sinergia_filtros_filtros");
            div_filtros_periodos = div_filtros.find("div.div_consultar_sinergia_filtros_periodos");				
            inputs_entidades = div_filtros_entidades.find("input") ;
            input_filial = inputs_entidades.eq(0);
            input_superv = inputs_entidades.eq(1);
            input_rca = inputs_entidades.eq(2);		
            filial = input_filial.val().trim();
            superv = input_superv.val().trim();
            rca = input_rca.val().trim();		
            combo_boxes = div_filtros_periodos.find("div.div_combobox") ;
            inputs_anos = div_filtros_periodos.find("input.input_ano") ;	
            combobox_periodo1 = combo_boxes.eq(0);
            combobox_periodo2 = combo_boxes.eq(0);
            input_ano_periodo1 = inputs_anos.eq(0);
            input_ano_periodo2 = inputs_anos.eq(0);
            mes_periodo1 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo1);
            mes_periodo2 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo2);
            ano_periodo1 = input_ano_periodo1.val();
            ano_periodo2 = input_ano_periodo2.val();		
            filtros_painel.filial = filial;
            filtros_painel.superv = superv;
            filtros_painel.rca = rca;
            filtros_painel.mes_periodo1 = mes_periodo1;
            filtros_painel.mes_periodo2 = mes_periodo2;
            filtros_painel.ano_periodo1 = ano_periodo1;
            filtros_painel.ano_periodo2 = ano_periodo2;
            fnjs.logf(this.constructor.name,"obter_filtros_painel");
            return filtros_painel;            
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }

    criar_grafico_sinergia_evolucao(params){
        try {
            fnjs.logi(this.constructor.name,"criar_grafico_sinergia_evolucao");
            let opcoes_grafico1 = {}, opcoes_grafico2={}, opcoes_grafico3={};
            
            /*migrar para google charts*/
            google.charts.load('current', {'packages':['corechart','line']});
            google.charts.setOnLoadCallback(desenharGraficosEvolucao);
            
            function desenharGraficosEvolucao() {
                let corpo_tabelaest = fnjs.obterJquery("div.div_consultar_sinergia_campanhas_itens").find("table.tabdados").children("tbody"),
                    percentual2,percentual1,percentual3,
                    data,
                    temsubreg = 1;
                let qt = (params.comhttp.retorno.dados_retornados.dados[0] ||[]).length;
                for(let i = 0; i < qt; i++) {
                    params.comhttp.retorno.dados_retornados.dados[0][i][0] = eval(params.comhttp.retorno.dados_retornados.dados[0][i][0]);
                    params.comhttp.retorno.dados_retornados.dados[0][i][1] = parseFloat(params.comhttp.retorno.dados_retornados.dados[0][i][1]);
                    params.comhttp.retorno.dados_retornados.dados[0][i][2] = parseFloat(params.comhttp.retorno.dados_retornados.dados[0][i][2]);
                    /*if (i > 0) {
                        params.comhttp.retorno.dados_retornados.dados[0][i][2] = params.comhttp.retorno.dados_retornados.dados[0][i][2] + params.comhttp.retorno.dados_retornados.dados[0][i-1][2];
                    }*/
                }
                
                data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Realizado');
                data.addColumn('number', 'Esperado');

                data.addRows((params.comhttp.retorno.dados_retornados.dados[0] || []));

                let options = {
                    hAxis: {
                        title: 'Dias',
                        format:'dd/MM'
                    },
                    vAxis: {
                        title: 'Realizado',
                        minValue:0
                    },
                    legend: { position: 'top' }
                };

                let chart = new google.visualization.LineChart(fnjs.obterJquery('div.div_consultar_sinergia_grafico_grafico3_grafico')[0]);

                chart.draw(data, options);
            }
            fnjs.logf(this.constructor.name,"criar_grafico_sinergia_evolucao");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    atualizar_grafico_evolucao_sinergia(params){
        try {
            fnjs.logi(this.constructor.name,"atualizar_grafico_evolucao_sinergia");
            this.criar_grafico_sinergia_evolucao(params);
            fnjs.logf(this.constructor.name,"atualizar_grafico_evolucao_sinergia");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    processar_retorno_painel_campanhas_estruturadas(params) {
        try {
            let conteudo_html = params.comhttp.retorno.dados_retornados.conteudo_html;
            if (typeof conteudo_html === "object") {
                if (Object.keys(conteudo_html).length > 0) {
                    $("div.div_consultar_sinergia_campanhas_estruturadas_container").show();
                    window.fnsisjd.atualizar_cores_linhas_tabelaest(params);
                } else {
                    $("div.div_consultar_sinergia_campanhas_estruturadas_container").hide();
                }
            }
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    atualizar_cores_linhas_tabelaest(params) {
        try {
            fnjs.logi(this.constructor.name,"atualizar_cores_linhas_tabelaest");
            let tabelaest = {},
                corpotabelaest = {},
                linhas = {},
                indcolperc = 0,
                valperc = 0;            
            tabelaest = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).find("table.tabdados");
            if (!tabelaest.length) {
                params.contador_recursao = params.contador_recursao || 0;
                params.contador_recursao++;
                console.log("atualizar_cores_linhas_tabelaest recursao " + params.contador_recursao);
                if (params.contador_recursao < 30) {
                    setTimeout(window.fnsisjd.atualizar_cores_linhas_tabelaest,1000,params);
                } else {
                    console.log("atualizar_cores_linhas_tabelaest encerrado por excesso de recursoes");
                }
                return;
            }
            for (let i = 0; i < tabelaest.length; i++) {
                corpotabelaest = tabelaest.eq(i).children("tbody");
                linhas = corpotabelaest.children("tr");
                if (linhas.length) {
                    indcolperc = linhas.eq(0).children("td").length - 1;
                    for (let j = 0; j < linhas.length; j++) {
                        valperc = fnmat.como_numero(linhas.eq(j).children("td").eq(indcolperc).text());
                        if (valperc < 50) {
                            linhas.eq(j).addClass("texto_vermelho");
                        } else if (valperc >= 50 && valperc < 100) {
                            linhas.eq(j).addClass("texto_azul");
                        } else if (valperc >= 100) {
                            linhas.eq(j).addClass("texto_verde");
                        }

                    }
                }
            }
            fnjs.logf(this.constructor.name,"atualizar_cores_linhas_tabelaest");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_painel_evolucao_sinergia(filtros_painel){
        try {
            fnjs.logi(this.constructor.name,"carregar_painel_evolucao_sinergia");
            fnjs.obterJquery("div.div_consultar_sinergia_grafico_grafico3_grafico").html(fnhtml.criar_spinner());
            let comhttp_evolucao_sinergia = JSON.parse(vars.str_tcomhttp),
                condicionantes = [];
            comhttp_evolucao_sinergia.requisicao.requisitar.oque="dados_sql";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.comando = "consultar";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.objeto = "sinergia2evolucao";
            comhttp_evolucao_sinergia.opcoes_requisicao.tipo_carregando = "simples";
            comhttp_evolucao_sinergia.opcoes_requisicao.tipo_alvo_carregando = 'string';
            comhttp_evolucao_sinergia.opcoes_requisicao.objeto_carregando = "div.div_consultar_sinergia_grafico_grafico3_grafico";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes=[];
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("relatorio=sinergia2evolucao");		
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+ filtros_painel.mes_periodo1);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+ filtros_painel.mes_periodo2);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+ filtros_painel.ano_periodo1);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+ filtros_painel.ano_periodo2);
            if (filtros_painel.filial.trim().length > 0) {
                condicionantes.push("filial=" + filtros_painel.filial);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
            } 
            if (filtros_painel.superv.trim().length > 0) {
                condicionantes.push("supervisor=" + filtros_painel.superv);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
            } 
            if (filtros_painel.rca.trim().length > 0) {
                condicionantes.push("rca=" + filtros_painel.rca);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
            } 
            if (condicionantes.length > 0) {
                condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push(condicionantes);
            }	
            comhttp_evolucao_sinergia.opcoes_retorno.seletor_local_retorno="div.div_consultar_sinergia_grafico_grafico3_grafico";
            comhttp_evolucao_sinergia.opcoes_retorno.ignorar_tabela_est=true;
            comhttp_evolucao_sinergia.opcoes_retorno.metodo_insersao = "html";
            comhttp_evolucao_sinergia.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:"window.fnsisjd.atualizar_grafico_evolucao_sinergia"
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp_evolucao_sinergia});		
            fnjs.logf(this.constructor.name,"carregar_painel_evolucao_sinergia");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }


    carregar_painel_campanhas_estruturadas(filtros_painel){
        try {
            fnjs.logi(this.constructor.name,"carregar_painel_campanhas_estruturadas");
            if (fnjs.obterJquery("div.div_consultar_sinergia_campanhas_estruturadas_container>div").length) {
                fnjs.obterJquery("div.div_consultar_sinergia_campanhas_estruturadas").html(fnhtml.criar_spinner());
                let comhttp_campestr = JSON.parse(vars.str_tcomhttp),
                    condicionantes = [];
                comhttp_campestr.requisicao.requisitar.oque="dados_sql";		
                comhttp_campestr.requisicao.requisitar.qual.comando = "consultar";
                comhttp_campestr.requisicao.requisitar.qual.tipo_objeto = "tabela";
                comhttp_campestr.requisicao.requisitar.qual.objeto = "painel_campestr";
                comhttp_campestr.opcoes_requisicao.tipo_carregando = "simples";
                comhttp_campestr.opcoes_requisicao.tipo_alvo_carregando = 'string';
                comhttp_campestr.opcoes_requisicao.objeto_carregando = "div.div_consultar_sinergia_campanhas_estruturadas";		
                comhttp_campestr.requisicao.requisitar.qual.condicionantes=[];
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("relatorio=painel_campestr");
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("mesperiodo1=" + filtros_painel.mes_periodo1);
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("anoperiodo1=" + filtros_painel.ano_periodo1);
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("mesperiodo2=" + filtros_painel.mes_periodo2);
                comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("anoperiodo2=" + filtros_painel.ano_periodo2);
                if (filtros_painel.filial.trim().length > 0) {
                    condicionantes.push("filial=" + filtros_painel.filial);
                    comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
                } 
                if (filtros_painel.superv.trim().length > 0) {
                    condicionantes.push("supervisor=" + filtros_painel.superv);
                    comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
                } 
                if (filtros_painel.rca.trim().length > 0) {
                    condicionantes.push("rca=" + filtros_painel.rca);
                    comhttp_campestr.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
                } 
                if (condicionantes.length > 0) {
                    condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                    comhttp_campestr.requisicao.requisitar.qual.condicionantes.push(condicionantes);
                }
                comhttp_campestr.opcoes_retorno.seletor_local_retorno="div.div_consultar_sinergia_campanhas_estruturadas";
                comhttp_campestr.opcoes_retorno.metodo_insersao = "html";			
                comhttp_campestr.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:'window.fnreq.inserir_retorno'
                },{
                    arquivo:null,
                    funcao:'window.fnsisjd.processar_retorno_painel_campanhas_estruturadas'
                }];
                fnjs.obterJquery("div.div_consultar_sinergia_campanhas_estruturadas_container").css("max-height","150px");
                //fnjs.obterJquery("div.div_consultar_sinergia_campanhas_estruturadas").css("max-height","120px");
                fnreq.requisitar_servidor({comhttp:comhttp_campestr});			
            }
            fnjs.logf(this.constructor.name,"carregar_painel_campanhas_estruturadas");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
        * Funcao que eh chamada quando do carregamento do conteudo dinamico do painel, tabela clientes positivados, para ocultar
        * colunas especificas da tabela para ajustar a visualizacao.
        * @param comhttp TComHttp o protocolo de comunicacao padrao cliente-servidor
        * @created 12/02/2019
        * @status desenvolvimento
    */
    ocultar_campos_painel_positiv_clientes(params) {
        try {
            fnjs.logi(this.constructor.name,"ocultar_campos_painel_positiv_clientes");
            let tabelaest = {},
                ind_col = 0,
                titulotabest = {},
                corpotabest = {},
                linhastit = {},
                rodapetabest = {},
                linhasrod = {},
                ultlintit = {},
                qtcelstit = 0;
            tabelaest = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).find("table.tabdados");
            if (!(typeof tabelaest !== "undefined" && tabelaest !== null & tabelaest.length)) {
                params.contador_recursao = params.contador_recursao || 0;                
                if (params.contador_recursao > vars.num_limite_recursoes) {
                    alert("processo interrompido por excesso de recursao");
                    return;
                }
                params.contador_recursao++;
                setTimeout(this.ocultar_campos_painel_positiv_clientes,500,params);                
                return;
            }
            titulotabest = tabelaest.children("thead");
            linhastit = titulotabest.children("tr")
            linhastit.eq(2).children("th").eq(2).hide();
            linhastit.eq(2).children("th").eq(4).hide();
            linhastit.eq(1).children("th").eq(2).hide();
            linhastit.eq(1).children("th").eq(4).hide();
            linhastit.eq(0).children("th").eq(2).hide();
            linhastit.eq(0).children("th").eq(0).attr("colspan",linhastit.eq(0).children("th").eq(0).attr("colspan") - 1);
            rodapetabest = tabelaest.children("tfoot");
            linhasrod = rodapetabest.children("tr");
            linhasrod.eq(0).children("th").eq(2).hide();
            linhasrod.eq(0).children("th").eq(4).hide();
            
            corpotabest = tabelaest.children("tbody");
            corpotabest.find("td:nth-child(3)").hide();
            corpotabest.find("td:nth-child(5)").hide();
            corpotabest.find("td:nth-child(2)").css("max-width","250px");
            corpotabest.find("td:nth-child(2)").css("text-overflow","ellipsis");
            //fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_clientes_container").css("max-width","49%");			 
            fnjs.obterJquery("div.div_consultar_sinergia_campanhas_titulo").css("margin-bottom","0px");
            fnjs.obterJquery("div.div_consultar_sinergia_campanhas_tabelas").css("margin-top","0px");
            fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_titulo").css("margin-bottom","0px");
            fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes").css("margin-top","0px");
            linhastit.eq(1).children("th").eq(3).click().click();
            fnjs.logf(this.constructor.name,"ocultar_campos_painel_positiv_clientes");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }
    /**
        * Funcao que eh chamada quando do carregamento do conteudo dinamico do painel, tabela produtos positivados, para ocultar
        * colunas especificas da tabela para ajustar a visualizacao.
        * @param comhttp TComHttp o protocolo de comunicacao padrao cliente-servidor
        * @created 12/02/2019
        * @status desenvolvimento
    */
    ocultar_campos_painel_positiv_produtos(params) {
        try {
            fnjs.logi(this.constructor.name,"ocultar_campos_painel_positiv_produtos");
            let tabelaest = {},
                ind_col = 0,
                titulotabest = {},
                corpotabest = {},
                rodapetabest = {},
                linhastit = {},
                linhasrod = {},
                ultlintit = {},
                qtcelstit = 0;
            tabelaest = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).find("table.tabdados");
            if (!(typeof tabelaest !== "undefined" && tabelaest !== null & tabelaest.length)) {
                params.contador_recursao = params.contador_recursao || 0;                
                if (params.contador_recursao > vars.num_limite_recursoes) {
                    alert("processo interrompido por excesso de recursao");
                    return;
                }
                params.contador_recursao++;
                setTimeout(this.ocultar_campos_painel_positiv_produtos,500,params);                
                return;
            }
            titulotabest = tabelaest.children("thead");
            linhastit = titulotabest.children("tr")
            linhastit.eq(2).children("th").eq(3).hide();
            linhastit.eq(1).children("th").eq(3).hide();
            linhastit.eq(0).children("th").eq(2).hide();
            rodapetabest = tabelaest.children("tfoot");
            linhasrod = rodapetabest.children("tr");
            linhasrod.eq(0).children("th").eq(3).hide();
            corpotabest = tabelaest.children("tbody");
            corpotabest.find("td:nth-child(4)").hide();
            corpotabest.find("td:nth-child(2)").css("max-width","250px");
            corpotabest.find("td:nth-child(2)").css("text-overflow","ellipsis");

            //fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_produtos_container").css("max-width","49%");
            linhastit.eq(1).children("th").eq(2).click().click();
            fnjs.logf(this.constructor.name,"ocultar_campos_painel_positiv_produtos");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }	

    carregar_painel_clientes_nao_positivados(filtros_painel){
        try {
            fnjs.logi(this.constructor.name,"carregar_painel_clientes_nao_positivados");
            if (fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_clientes_container>div").length) {
                fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_clientes").html(fnhtml.criar_spinner());
                let comhttp_clientesnaoposit = JSON.parse(vars.str_tcomhttp),
                    condicionantes = [];
                comhttp_clientesnaoposit.requisicao.requisitar.oque="dados_sql";
                comhttp_clientesnaoposit.requisicao.requisitar.qual.comando = "consultar";
                comhttp_clientesnaoposit.requisicao.requisitar.qual.tipo_objeto = "tabela";
                comhttp_clientesnaoposit.requisicao.requisitar.qual.objeto = "painel_clientesnaoposit";
                comhttp_clientesnaoposit.opcoes_requisicao.tipo_carregando = "simples";
                comhttp_clientesnaoposit.opcoes_requisicao.tipo_alvo_carregando = 'string';
                comhttp_clientesnaoposit.opcoes_requisicao.objeto_carregando = "div.div_consultar_painel_tabelas_positivacoes_clientes";
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes=[];		
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("relatorio=painel_clientesnaoposit");
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("mesperiodo1=" + filtros_painel.mes_periodo1);
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("anoperiodo1=" + filtros_painel.ano_periodo1);
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("mesperiodo2=" + filtros_painel.mes_periodo2);
                comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("anoperiodo2=" + filtros_painel.ano_periodo2);
                if (filtros_painel.filial.trim().length > 0) {
                    condicionantes.push("filial=" + filtros_painel.filial);
                    comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
                } 
                if (filtros_painel.superv.trim().length > 0) {
                    condicionantes.push("supervisor=" + filtros_painel.superv);
                    comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
                } 
                if (filtros_painel.rca.trim().length > 0) {
                    condicionantes.push("rca=" + filtros_painel.rca);
                    comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
                } 
                if (condicionantes.length > 0) {
                    condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                    comhttp_clientesnaoposit.requisicao.requisitar.qual.condicionantes.push(condicionantes);
                }
                comhttp_clientesnaoposit.opcoes_retorno.seletor_local_retorno="div.div_consultar_painel_tabelas_positivacoes_clientes";
                comhttp_clientesnaoposit.opcoes_retorno.metodo_insersao = "html";			
                comhttp_clientesnaoposit.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:'window.fnreq.inserir_retorno'
                },
                {
                    arquivo:null,
                    funcao: "window.fnsisjd.ocultar_campos_painel_positiv_clientes"
                }];
                fnreq.requisitar_servidor({comhttp:comhttp_clientesnaoposit});	
            }
            fnjs.logf(this.constructor.name,"carregar_painel_clientes_nao_positivados");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_painel_produtos_nao_positivados(filtros_painel){
        try {
            fnjs.logi(this.constructor.name,"carregar_painel_produtos_nao_positivados");
            if (fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_produtos_container>div").length) {
                fnjs.obterJquery("div.div_consultar_painel_tabelas_positivacoes_produtos").html(fnhtml.criar_spinner());
                let comhttp_produtosnaoposit = JSON.parse(vars.str_tcomhttp),
                    condicionantes = [];	
                comhttp_produtosnaoposit.requisicao.requisitar.oque="dados_sql";
                comhttp_produtosnaoposit.requisicao.requisitar.qual.comando = "consultar";
                comhttp_produtosnaoposit.requisicao.requisitar.qual.tipo_objeto = "tabela";
                comhttp_produtosnaoposit.requisicao.requisitar.qual.objeto = "painel_produtosnaoposit";
                comhttp_produtosnaoposit.opcoes_requisicao.tipo_carregando = "simples";
                comhttp_produtosnaoposit.opcoes_requisicao.tipo_alvo_carregando = 'string';
                comhttp_produtosnaoposit.opcoes_requisicao.objeto_carregando = "div.div_consultar_painel_tabelas_positivacoes_produtos";
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes=[];		
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("relatorio=painel_produtosnaoposit");
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("mesperiodo1=" + filtros_painel.mes_periodo1);
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("anoperiodo1=" + filtros_painel.ano_periodo1);
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("mesperiodo2=" + filtros_painel.mes_periodo2);
                comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("anoperiodo2=" + filtros_painel.ano_periodo2);
                if (filtros_painel.filial.trim().length > 0) {
                    condicionantes.push("filial=" + filtros_painel.filial);
                    comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("filial=" + filtros_painel.filial);
                } 
                if (filtros_painel.superv.trim().length > 0) {
                    condicionantes.push("supervisor=" + filtros_painel.superv);
                    comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("supervisor=" + filtros_painel.superv);
                } 
                if (filtros_painel.rca.trim().length > 0) {
                    condicionantes.push("rca=" + filtros_painel.rca);
                    comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push("rca=" + filtros_painel.rca);
                } 
                if (condicionantes.length > 0) {
                    condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                    comhttp_produtosnaoposit.requisicao.requisitar.qual.condicionantes.push(condicionantes);
                }
                comhttp_produtosnaoposit.opcoes_retorno.seletor_local_retorno="div.div_consultar_painel_tabelas_positivacoes_produtos";
                comhttp_produtosnaoposit.opcoes_retorno.metodo_insersao = "html";			
                comhttp_produtosnaoposit.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:'window.fnreq.inserir_retorno'
                },
                {
                    arquivo:null,
                    funcao: "window.fnsisjd.ocultar_campos_painel_positiv_produtos"
                }];
                fnreq.requisitar_servidor({comhttp:comhttp_produtosnaoposit});	
            }
            fnjs.logf(this.constructor.name,"carregar_painel_produtos_nao_positivados");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }


    receber_visoes_painel(params) {
        try {
            fnjs.logi(this.constructor.name,"receber_visoes_painel");
            vars.visoes_painel = params.comhttp.retorno.dados_retornados.conteudo_html.dados.toString().split(",");
            fnreq.carregando({
                acao:"esconder",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });					
            fnjs.logf(this.constructor.name,"receber_visoes_painel");
        }catch(e){
            console.log(e);
            alert(e.message || e);
            fnreq.carregando({
                acao:"esconder",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });					
        }
    }

    requisitar_visoes_painel(params){
        try {
            fnjs.logi(this.constructor.name,"requisitar_visoes_painel");
            let comhttp={};
            let idrand = fnjs.id_random();
            fnjs.obterJquery(params.elemento).addClass(idrand);
            comhttp=JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='dados_literais';
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "visoes_painel";
            comhttp.requisicao.requisitar.qual.objeto = params.relatorio;
            comhttp.opcoes_retorno.seletor_local_retorno = "." + idrand;
            comhttp.opcoes_requisicao.mostrar_carregando = false;
            comhttp.eventos.aposretornar=[];
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:"window.fnsisjd.receber_visoes_painel"
            });
            fnobj.transformar_elemento_classe_seletor(params.parametros);
            comhttp.eventos.aposretornar.push({
                arquivo:null,
                funcao:params.funcao_retorno,
                parametros:params.parametros					
            });
            
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"requisitar_visoes_painel");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    pesquisar_subregistro_painel(params) {
        try{
            fnjs.logi(this.constructor.name,"pesquisar_subregistro_painel");
        if (typeof vars.visoes_painel === 'undefined' || vars.visoes_painel.length === 0) {
            this.requisitar_visoes_painel({elemento:params.elemento,funcao_retorno:"window.fnsisjd.pesquisar_subregistro_painel",parametros:params});
            return; 
        }
        if (typeof params.elemento !== 'undefined') {
            params.elemento = fnjs.obterJquery(params.elemento);
        } else {
            if (typeof params.comhttp.opcoes_retorno !== 'undefined') {
                params.elemento = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
            } 
        }
            let comhttp,
            div_filtros,div_filtros_entidades,div_filtros_periodos,
            divs_sel,
            rca,
            superv,
            filial,
            mes,
            visao,
            combo_boxes={},
            combobox_visao={},
            combobox_rca={},
            combobox_mes={},
            combobox_ano={},
            i=0,
            j=0,
            qt=0,
            qt2=0,
            inputs_entidades,
            input_filial,
            input_superv,
            input_rca,
            condicionantes,
            tabelaest={},
            visao_sub="",
            cel_sub_registro={},
            idrand=fnjs.id_random(),
            campanha="",
            codfilial = "",
            codsupervisor="",
            codrca="",
            codgrupogiro = "",
            codepto = "", 
            opcoes_combobox={},
            div_resultado = "",
            condicionantestab=[];
        tabelaest=params.elemento.closest("table.tabdados");
        visao = tabelaest.attr("visao").trim().toLowerCase();
        condicionantestab = (tabelaest.attr("condicionantestab"));
        if (typeof condicionantestab === "undefined") {
            condicionantestab = [];
        } else {
            condicionantestab = condicionantestab.substr(condicionantestab.indexOf("[")).replace("[","").replace("]","").split(" and ");
        }
        condicionantes = [];

        /*obtem os filtros da tabela anterior*/
        filial = tabelaest.attr("filtro_filial").trim();
        superv = tabelaest.attr("filtro_supervisor").trim();
        rca = tabelaest.attr("filtro_rca").trim();
        let mesperiodo1 = tabelaest.attr("filtro_mes_periodo1").trim();
        let mesperiodo2 = tabelaest.attr("filtro_mes_periodo2").trim();
        let anoperiodo1 = tabelaest.attr("filtro_ano_periodo1").trim();
        let anoperiodo2 = tabelaest.attr("filtro_ano_periodo2").trim();

        /*obtem a proxima visao baseado na atual*/
        if (visao.trim().toLowerCase() !== "produto") {
            visao_sub = vars.visoes_painel[vars.visoes_painel.join(",").trim().toLowerCase().split(",").indexOf(visao)+1]
        } else {
            visao_sub = vars.visoes_painel[0];
        }
        cel_sub_registro = params.elemento.closest("tr").next().children("td.cel_sub_registro");
        
        cel_sub_registro.html("<div></div>");
        let params_combobox_visao = {
                tit:"Visao 01",
                retornar_como:"string",
                visoes: vars.visoes_painel,
                selecionado:visao_sub,
                permite_incluir:false,
                permite_excluir:false
                
        };
        let params_body_visoes = {
            tag:"div",
            class:"div_opcoes div_visoes row",
            sub:[
                {
                    tag:"div",
                    class:"div_opcoes_col m-1 col",
                    sub:[
                        {
                            tag:"div",
                            class:"div_opcoes_corpo row",
                            props:[
                                {
                                    prop:"data-ind",
                                    value:1
                                }
                            ],
                            text:this.criar_controle_combobox_visao(params_combobox_visao)
                        }
                    ]
                }
            ]
        }
        let params_accord_visao = {
            items:[
                {
                        title:"Visões",
                        open:true,
                        text_body:fnhtml.criar_elemento(params_body_visoes)
                }
            ]
        }
        let opcoes_accord_pesq = {
                class:"div_opcoes_pesquisa",
            items:[
                    {
                        title:"Opções de Pesquisa",                        
                        text_body:fnhtml.criar_accordion(params_accord_visao),
                        sub:[
                            {
                                tag:"div",
                                class:"div_botao_pesquisar d-grid gap-2 col-6 mx-auto mt-3",
                                sub:[
                                    {
                                        tag:"button",
                                        class:"botao_pesquisar btn btn-primary",
                                        onclick:"window.fnsisjd.pesquisar_subregistro_painel_visao(this)",
                                        type:"button",
                                        text:"Pesquisar",
                                        props:[
                                            {
                                                prop:"data-visao",
                                                value:"painel"
                                            },
                                            {
                                                prop:"apresentargrafico",
                                                value:"false"
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                        
                    } 
            ]
        }
        let div_opcoes_pesq = fnhtml.criar_accordion(opcoes_accord_pesq);
        cel_sub_registro.html(div_opcoes_pesq);
        cel_sub_registro.append('<div class="div_resultado"></div>');
        fnreq.carregando({
                acao:"esconder",
                id:"todos"
            });
        
        div_resultado = cel_sub_registro.children("div.div_resultado");
        div_resultado.addClass(idrand);
        campanha = tabelaest.attr("campanha") || params.elemento.children("td").eq(1).text();

        /*se esta numa linha hierarquicamente subordinada a outra, aloca a condicionante referente a essa linha*/
        if (visao === "filial") {
            codfilial = params.elemento.children("td").eq(1).text();				
        } else if (visao === "supervisor") {
            codsupervisor = params.elemento.children("td").eq(1).text();
        } else if (visao === "rca") {
            codrca = params.elemento.children("td").eq(1).text();				
        } else if (visao === "grupo giro") {
            codgrupogiro = params.elemento.children("td").eq(1).text();								
        } else if (visao === "departamento") {
            codepto = params.elemento.children("td").eq(1).text();								
        }							 
        comhttp = JSON.parse(vars.str_tcomhttp);
        comhttp.requisicao.requisitar.oque='dados_sql';
        comhttp.requisicao.requisitar.qual.comando = "consultar";
        comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
        comhttp.requisicao.requisitar.qual.objeto = "painel_subregistros";
        comhttp.requisicao.requisitar.qual.condicionantes=[];
        comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
        comhttp.requisicao.requisitar.qual.condicionantes.push("relatorio=painel_subregistros");
        comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+mesperiodo1);
        comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+anoperiodo1);
        comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+mesperiodo2);
        comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+anoperiodo2);
        comhttp.requisicao.requisitar.qual.condicionantes.push("visao="+visao_sub);
        comhttp.requisicao.requisitar.qual.condicionantes.push("campanha="+campanha);
        
        //condicionantes da linha superior
        if (codfilial.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("codfilial="+codfilial);
            if (codfilial.trim() === "1") {
                condicionantestab.push("sjdobjetivossinergia.codentidade<200");
            } else {
                condicionantestab.push("sjdobjetivossinergia.codentidade>200");
            }
        }

        if (codsupervisor.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("codsupervisor="+codsupervisor);
            condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor = " + codsupervisor + ")");
        }
        if (codrca.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("codrca="+codrca);
            condicionantestab.push("sjdobjetivossinergia.codentidade=" + codrca);
        }
        if (codgrupogiro.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("codgrupogiro="+codgrupogiro);
            condicionantestab.push("sjdobjetivossinergia.codgrupogiro=" + codgrupogiro);
        }
        
        if (codepto.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("codepto="+codepto);
        }
        
        //condicionantes do filtro da pagina
        if (filial.trim().length > 0) {
            condicionantes.push("filial="+filial);
            comhttp.requisicao.requisitar.qual.condicionantes.push("filial="+filial);
            if (filial.trim() === "1") {
                condicionantestab.push("sjdobjetivossinergia.codentidade<200");
            } else {
                condicionantestab.push("sjdobjetivossinergia.codentidade>200");
            }
        } 
        if (superv.trim().length > 0) {
            condicionantes.push("supervisor="+superv);
            comhttp.requisicao.requisitar.qual.condicionantes.push("supervisor="+superv);
            condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor = " + superv + ")");
        } 
        if (rca.trim().length > 0) {
            condicionantes.push("rca="+rca);
            comhttp.requisicao.requisitar.qual.condicionantes.push("rca="+rca);
            condicionantestab.push("sjdobjetivossinergia.codentidade=" + rca);
        } 
        
        if (condicionantes.length > 0) {
            condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
            comhttp.requisicao.requisitar.qual.condicionantes.push(condicionantes);
        }
        if (condicionantestab.length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdobjetivossinergia["+condicionantestab.join(" and ")+"]");
        }
        comhttp.opcoes_retorno.seletor_local_retorno="div.div_resultado."+idrand;
        comhttp.opcoes_retorno.metodo_insersao = "html";			
        comhttp.eventos.aposretornar=[{
            arquivo:null,
            funcao:'window.fnreq.inserir_retorno'
        }];
        comhttp.opcoes_retorno.padding_right = 10;
        comhttp.opcoes_retorno.padding_left = 10;
        fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"pesquisar_subregistro_painel");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }


    pesquisar_subregistro_painel_visao(obj){
    try{
        fnjs.logi(this.constructor.name,"pesquisar_subregistro_painel_visao");
        let comhttp,
        div_filtros,div_filtros_entidades,div_filtros_periodos,
        divs_sel,
        rca,
        superv,
        filial,
        mes,
        visao,
        combo_boxes={},
        combobox_visao={},
        combobox_rca={},
        combobox_mes={},
        combobox_ano={},
        i=0,
        j=0,
        qt=0,
        qt2=0,
        inputs_entidades,
        input_filial,
        input_superv,
        input_rca,
        condicionantes,
        tabelaest={},
        visao_sup="",
        visao_sub="",
        cel_sub_registro={},
        idrand=fnjs.id_random(),
        campanha="",
        codfilial = "",
        codsupervisor="",
        codrca="",
        codgrupogiro = "",
        opcoes_combobox={},
        div_resultado = "",
        condicionantestab=[],
        linha_sup = {};
    obj = fnjs.obterJquery(obj);
    let div_opcoes_pesq = obj.closest("div.div_opcoes_pesquisa");
    cel_sub_registro = obj.closest("td.cel_sub_registro");
    linha_sup = obj.closest("tr.linha_sub").prev("tr");
    tabelaest=obj.closest("table.tabdados");
    combobox_visao = div_opcoes_pesq.find("div.div_combobox");
    div_resultado = cel_sub_registro.find("div.div_resultado");
    visao = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_visao).join(",").trim().toLowerCase();
    visao_sup = tabelaest.attr("visao");
    condicionantestab = (tabelaest.attr("condicionantestab"));
    if (typeof condicionantestab === "undefined") {
        condicionantestab = [];
    } else {
        condicionantestab = condicionantestab.substr(condicionantestab.indexOf("[")).replace("[","").replace("]","").split(" and ");
    }
    condicionantes = [];
    filial = tabelaest.attr("filtro_filial").trim();
    superv = tabelaest.attr("filtro_supervisor").trim();
    rca = tabelaest.attr("filtro_rca").trim();
    let mesperiodo1 = tabelaest.attr("filtro_mes_periodo1").trim();
    let mesperiodo2 = tabelaest.attr("filtro_mes_periodo2").trim();
    let anoperiodo1 = tabelaest.attr("filtro_ano_periodo1").trim();
    let anoperiodo2 = tabelaest.attr("filtro_ano_periodo2").trim();
    div_resultado.html("<div></div>");
    div_resultado.addClass(idrand);
    campanha = tabelaest.attr("campanha") || linha_sup.children("td").eq(1).text();

    /*se esta numa linha hierarquicamente subordinada a outra, aloca a condicionante referente a essa linha*/
    if (visao_sup === "filial") {
        codfilial = linha_sup.children("td").eq(1).text();				
    } else if (visao_sup === "supervisor") {
        codsupervisor = linha_sup.children("td").eq(1).text();
    } else if (visao_sup === "rca") {
        codrca = linha_sup.children("td").eq(1).text();				
    } else if (visao_sup === "grupo giro") {
        codgrupogiro = linha_sup.children("td").eq(1).text();								
    }


    comhttp = JSON.parse(vars.str_tcomhttp);
    comhttp.requisicao.requisitar.oque='dados_sql';
    comhttp.requisicao.requisitar.qual.comando = "consultar";
    comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
    comhttp.requisicao.requisitar.qual.objeto = "painel_subregistros";
    comhttp.requisicao.requisitar.qual.condicionantes=[];
    comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
    comhttp.requisicao.requisitar.qual.condicionantes.push("relatorio=painel_subregistros");
    comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+mesperiodo1);
    comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+anoperiodo1);
    comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+mesperiodo2);
    comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+anoperiodo2);
    comhttp.requisicao.requisitar.qual.condicionantes.push("visao="+visao);
    comhttp.requisicao.requisitar.qual.condicionantes.push("campanha="+campanha);
    
    //condicionantes da linha superior
    if (codfilial.trim().length > 0) {
        comhttp.requisicao.requisitar.qual.condicionantes.push("codfilial="+codfilial);
        if (codfilial.trim() === "1") {
            condicionantestab.push("sjdobjetivossinergia.codentidade<200");
        } else {
            condicionantestab.push("sjdobjetivossinergia.codentidade>200");
        }
    }

    if (codsupervisor.trim().length > 0) {
        comhttp.requisicao.requisitar.qual.condicionantes.push("codsupervisor="+codsupervisor);
        condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor="+codsupervisor+")");
    }
    if (codrca.trim().length > 0) {
        comhttp.requisicao.requisitar.qual.condicionantes.push("codrca="+codrca);
        condicionantestab.push("sjdobjetivossinergia.codentidade=" + codrca);
    }
    if (codgrupogiro.trim().length > 0) {
        comhttp.requisicao.requisitar.qual.condicionantes.push("codgrupogiro="+codgrupogiro);
        condicionantestab.push("sjdobjetivossinergia.codgrupogiro=" + codgrupogiro);
    }
    
    //condicionantes do filtro da pagina
    if (filial.trim().length > 0) {
        condicionantes.push("filial="+filial);
        comhttp.requisicao.requisitar.qual.condicionantes.push("filial="+filial);
        if (filial.trim() === "1") {
            condicionantestab.push("sjdobjetivossinergia.codentidade<200");
        } else {
            condicionantestab.push("sjdobjetivossinergia.codentidade>200");
        }
    } 
    if (superv.trim().length > 0) {
        condicionantes.push("supervisor="+superv);
        comhttp.requisicao.requisitar.qual.condicionantes.push("supervisor="+superv);
        condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor="+superv+")");
    } 
    if (rca.trim().length > 0) {
        condicionantes.push("rca="+rca);
        comhttp.requisicao.requisitar.qual.condicionantes.push("rca="+rca);
        condicionantestab.push("sjdobjetivossinergia.codentidade=" + rca);
    } 
    
    if (condicionantes.length > 0) {
        condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
        comhttp.requisicao.requisitar.qual.condicionantes.push(condicionantes);
    }
    if (condicionantestab.length > 0) {
        comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdobjetivossinergia["+condicionantestab.join(" and ")+"]");
    }
    comhttp.opcoes_retorno.seletor_local_retorno="div.div_resultado."+idrand;
    comhttp.opcoes_retorno.metodo_insersao = "html";			
    comhttp.eventos.aposretornar=[{
        arquivo:null,
        funcao:'window.fnreq.inserir_retorno'
    }];
    comhttp.opcoes_retorno.padding_right = 10;
    comhttp.opcoes_retorno.padding_left = 10;
    fnreq.requisitar_servidor({comhttp:comhttp});
        fnjs.logf(this.constructor.name,"pesquisar_subregistro_painel_visao");
    }catch(e){
        console.log(e);
        alert(e.message || e);
    }
    }

    preencher_dados_janela_maximizada(janela,dados) {
        try {
            fnjs.logi(this.constructor.name,"preencher_dados_janela_maximizada");
            if (fnjs.obterJquery(janela.document.body).find("div.div_conteudo_pagina").length) {
                dados = dados.clone();
                dados.css("width","100%");
                dados.css("height","100%");		
                dados.css("max-width","100%");
                dados.css("max-height","100%");		
                if (dados.find("div.div_consultar_sinergia_campanhas_estruturadas").length) {
                    dados.find("div.div_consultar_sinergia_campanhas_estruturadas").css("max-height","100%");
                }			
                if (dados.find("div.div_consultar_painel_tabelas_positivacoes_clientes").length) {
                    dados.find("div.div_consultar_painel_tabelas_positivacoes_clientes").css("max-height","100%");
                }
                if (dados.find("div.div_consultar_painel_tabelas_positivacoes_produtos").length) {
                    dados.find("div.div_consultar_painel_tabelas_positivacoes_produtos").css("max-height","100%");
                }
                if (dados.find("div.div_consultar_sinergia_campanhas_itens").length) {
                    dados.find("div.div_consultar_sinergia_campanhas_itens").css("overflow","initial");
                }
                fnjs.obterJquery(janela.document.body).find("div.div_conteudo_pagina").html(dados.children().clone());
            } else {
                setTimeout(this.preencher_dados_janela_maximizada,1000,janela,dados);
            }
            fnjs.logf(this.constructor.name,"preencher_dados_janela_maximizada");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    maximizar_div(obj) {
        try {
            fnjs.logi(this.constructor.name,"maximizar_div");
            let div_container = {};
            obj = fnjs.obterJquery(obj);
            div_container = obj.parent().parent();
            let nova_janela = window.open("/" + __CAMINHOBASESISREL__ + "/php/maximizada.php");
            this.preencher_dados_janela_maximizada(nova_janela,div_container);
            fnjs.logf(this.constructor.name,"maximizar_div");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_painel(){
        try {
            fnjs.logi(this.constructor.name,"carregar_painel");
            let filtros_painel = {};
            filtros_painel = this.obter_filtros_painel();		
            this.carregar_painel_campanhas_sinergia(filtros_painel);
            this.carregar_painel_evolucao_sinergia(filtros_painel);            
            this.carregar_painel_clientes_nao_positivados(filtros_painel);
            this.carregar_painel_produtos_nao_positivados(filtros_painel);
            this.carregar_painel_campanhas_estruturadas(filtros_painel);
            fnjs.logf(this.constructor.name,"carregar_painel");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }

    destacar_celulas_zeradas(params) {
        try {
            fnjs.logi(this.constructor.name,"destacar_celulas_zeradas");
            let tabelaest = {},
                corpotabest = {},
                linhas = {},
                cels = {};
            tabelaest = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).find("table.tabdados");
            params.contador_recursao = params.contador_recursao || 0;
            corpotabest = tabelaest.children("tbody");
            linhas = corpotabest.children("tr");
            $.each(linhas,function(index,element){				
                cels = window.fnjs.obterJquery(element).children("td");
                $.each(cels,function(index2,element2){
                    if (window.fnjs.obterJquery(element2).text().trim().length === 0) {
                        window.fnjs.obterJquery(element2).addClass("celula_destaque_zerada");
                    } else {
                        if (fnmat.como_numero(window.fnjs.obterJquery(element2).text().trim()) === 0) {
                            window.fnjs.obterJquery(element2).addClass("celula_destaque_zerada");
                        }							
                    }
                });
            });			
            fnjs.logf(this.constructor.name,"destacar_celulas_zeradas");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }


    centralizar_colunas_valores(params) {
        try {
            fnjs.logi(this.constructor.name,"centralizar_colunas_valores");
            let tabelaest = {},
                corpotabest = {},
                linhas = {},
                cels = {},
                rodapetabest = {};
            params.contador_recursao = params.contador_recursao || 0;
            tabelaest = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).find("table.tabdados");
            corpotabest = tabelaest.children("tbody");
            rodapetabest = tabelaest.children("tfoot");
            linhas = corpotabest.children("tr");
            $.each(linhas,function(index,element){				
                cels = window.fnjs.obterJquery(element).children("td");
                $.each(cels,function(index2,element2){					
                    if (window.fnjs.obterJquery(element2).hasClass("cel_quantdec_med")) {
                        element2.style.textAlign = "center";
                    }
                });
            });
            linhas = rodapetabest.children("tr.linhacalculos");
            $.each(linhas,function(index,element){				
                cels = window.fnjs.obterJquery(element).children("th");
                $.each(cels,function(index2,element2){					
                    if (window.fnjs.obterJquery(element2).hasClass("cel_quantdec_med")) {
                        element2.style.textAlign = "center";
                    }
                });
            });
            fnjs.logf(this.constructor.name,"centralizar_colunas_valores");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    pesquisar_campanhas_estruturadas(obj,tipo){
        try{
            fnjs.logi(this.constructor.name,"pesquisar_campanhas_estruturadas");
            let div_opcoes_pesquisa = {},
                div_periodos = {},
                inputs_datas = {},
                datas = {},
                comhttp = null;
            obj = fnjs.obterJquery(obj);
            div_opcoes_pesquisa = obj.closest("div.div_opcoes_pesquisa");
            div_periodos = div_opcoes_pesquisa.find("div.div_periodos");
            inputs_datas = div_periodos.find("input.componente_data");
            datas = this.pegar_valores_elementos(inputs_datas);
            datas[0] = fndt.como_data_oracle(datas[0]);
            datas[1] = fndt.como_data_oracle(datas[1]);
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela_est";			
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            tipo = tipo.toString().toLowerCase().trim();
            if (tipo === "consultar" || tipo === "consulta") {
                comhttp.requisicao.requisitar.qual.objeto = "lista_campanhas_estruturadas_consultar";
                comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4000");
                comhttp.opcoes_retorno.seletor_local_retorno="div.div_arvore_opcoes_campanhas_estruturadas_consultar";
            } else if (tipo === "alterar" || tipo === "altera") {
                comhttp.requisicao.requisitar.qual.objeto = "lista_campanhas_estruturadas_alterar";
                comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4010");
                comhttp.opcoes_retorno.seletor_local_retorno="div.div_arvore_opcoes_campanhas_estruturadas_alterar";				
            } else {
                alert("tipo invalido: " + tipo);
                return;
            }
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdcampestr[(codcampestrsup is null or codcampestrsup=-1) and ((dtini between " + datas[0] + " and " + datas[1] + ") or (dtfim between " + datas[0] + " and " + datas[1] + ")) ]");
            comhttp.opcoes_retorno.usar_arr_tit=true;
            comhttp.opcoes_retorno.metodo_insersao = "html";						
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"pesquisar_campanhas_estruturadas");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }					
    }



    carregar_dados_campanha_consultar(obj){
        try{
            fnjs.logi(this.constructor.name,"carregar_dados_campanha_consultar");
            let comhttp ;
            let cel = fnjs.obterJquery(obj).closest("td");
            let linha = cel.closest("tr");
            let tabelaest = linha.closest("table.tabdados");
            let tabeladb = "sjdcampestr";
            let tabelasub = "sjdobjetcampestr";
            let codcampestr=0;
            let indcolcodcampestr = -1;
            let idrand = fnjs.id_random();			

        if ((linha.attr("status") || "normal") === "normal" && !cel.hasClass("cel_cmd")) {			
            fnreq.abortar_requisicoes_em_andamento();
            indcolcodcampestr = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"codcampestr");
            codcampestr = linha.children("td").eq(indcolcodcampestr).text();				
            //requisita dados da campanha (linha)
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divtab").html("");
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divgraficocamp").html("");
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divgraficossubcamp").html("");
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "linha";
            comhttp.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4200");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabeladb+"["+ tabeladb +".codcampestr="+codcampestr+"]");				
            comhttp.opcoes_retorno.usar_arr_tit=true;            
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_dados_campanhas_consultar_container_corpo0_divtab";					
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});			

            //requisita tabela de objetivos
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo1").html('<button class="botao_padrao" onclick="window.fnsisjd.imprimir_conteudo_elemento(this.parentNode)">Imprimir Relatorio</button><br /><div class="div_consultar_objet_gerais_camp"></div>');
            let comhttpobj = JSON.parse(vars.str_tcomhttp);
            comhttpobj.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
            comhttpobj.opcoes_requisicao.objeto_carregando = "div.div_consultar_objet_gerais_camp,div.div_dados_campanhas_consultar_container_corpo0_divgraficocamp";
            comhttpobj.opcoes_requisicao.tipo_carregando = "simples";
            comhttpobj.requisicao.requisitar.oque="dados_sql";
            comhttpobj.requisicao.requisitar.qual.comando = "consultar";
            comhttpobj.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttpobj.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttpobj.requisicao.requisitar.qual.condicionantes = [];				
            comhttpobj.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabela_est");
            comhttpobj.requisicao.requisitar.qual.condicionantes.push("relatorio=campanhas_estruturadas_objetivos_gerais");
            comhttpobj.requisicao.requisitar.qual.condicionantes.push("codcampestr="+codcampestr);
            comhttpobj.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabelasub+"["+ tabelasub +".codcampestr="+codcampestr+"]");				
            comhttpobj.opcoes_retorno.usar_arr_tit=true;
            comhttpobj.opcoes_retorno.seletor_local_retorno="div.div_consultar_objet_gerais_camp";					
            comhttpobj.opcoes_retorno.metodo_insersao = "html";			
            comhttpobj.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            },{
                arquivo:null,
                funcao:"window.fnsisjd.grafico_campanhas_estruturadas"
            }];
            fnjs.obterJquery("div.div_consultar_objet_gerais_camp").attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttpobj});

            //requisita tabela de objetivos especificos
            let comhttpepec = JSON.parse(vars.str_tcomhttp);
            comhttpepec.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
            comhttpepec.opcoes_requisicao.objeto_carregando = "div.div_dados_campanhas_consultar_container_corpo2";
            comhttpepec.opcoes_requisicao.tipo_carregando = "simples";
            comhttpepec.requisicao.requisitar.oque="dados_sql";
            comhttpepec.requisicao.requisitar.qual.comando = "consultar";
            comhttpepec.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttpepec.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttpepec.requisicao.requisitar.qual.condicionantes = [];				
            comhttpepec.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabela_est");
            comhttpepec.requisicao.requisitar.qual.condicionantes.push("relatorio=campanhas_estruturadas_objetivos_especificos");
            comhttpepec.requisicao.requisitar.qual.condicionantes.push("codcampestr="+codcampestr);
            comhttpepec.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabelasub+"["+ tabelasub +".codcampestr="+codcampestr+"]");				
            comhttpepec.opcoes_retorno.usar_arr_tit=true;
            comhttpepec.opcoes_retorno.seletor_local_retorno="div.div_dados_campanhas_consultar_container_corpo2";
            comhttpepec.opcoes_retorno.metodo_insersao = "html";			
            comhttpepec.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo2").attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttpepec});							

            //requisita condicionantes da campanha
            let comhttpcond = JSON.parse(vars.str_tcomhttp);
            comhttpcond.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
            comhttpcond.opcoes_requisicao.objeto_carregando = "div." + idrand;
            comhttpcond.opcoes_requisicao.tipo_carregando = "simples";				
            comhttpcond.requisicao.requisitar.oque="dados_sql";
            comhttpcond.opcoes_retorno.ignorar_tabela_est = true;
            comhttpcond.requisicao.requisitar.qual.comando = "consultar";
            comhttpcond.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttpcond.requisicao.requisitar.qual.objeto = tabeladb;
            comhttpcond.requisicao.requisitar.qual.condicionantes = [];
            comhttpcond.requisicao.requisitar.qual.condicionantes.push("codprocesso=4310");
            comhttpcond.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabeladb+"["+ tabeladb +".codcampestr="+codcampestr+"]");				
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo3").addClass(idrand);
            comhttpcond.opcoes_retorno.usar_arr_tit=true;
            comhttpcond.opcoes_retorno.seletor_local_retorno="div." + idrand;
            comhttpcond.opcoes_retorno.metodo_insersao = "html";			
            comhttpcond.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div."+idrand).attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttpcond});
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo1").append('<br /><br /><div class="div_consultar_objet_gerais_subcampanhas"><h3>Sub Campanhas:</h3><br /></div>');

            let comhttpsub = JSON.parse(vars.str_tcomhttp);
            comhttpsub.opcoes_requisicao.tipo_alvo_carregando = "objeto";				
            comhttpsub.opcoes_requisicao.objeto_carregando = "div.div_consultar_objet_gerais_subcampanhas>h3,div.div_dados_campanhas_consultar_container_corpo0_divgraficossubcamp";
            comhttpsub.opcoes_requisicao.tipo_carregando = "simples";
            comhttpsub.requisicao.requisitar.oque="dados_sql";
            comhttpsub.requisicao.requisitar.qual.comando = "consultar";
            comhttpsub.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttpsub.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttpsub.requisicao.requisitar.qual.condicionantes = [];
            comhttpsub.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabela_est");
            comhttpsub.requisicao.requisitar.qual.condicionantes.push("relatorio=campanhas_estruturadas_objetivos_gerais_subcampanhas");
            comhttpsub.requisicao.requisitar.qual.condicionantes.push("codcampestr="+codcampestr);
            comhttpsub.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabelasub+"["+ tabelasub +".codcampestr="+codcampestr+"]");				
            comhttpsub.opcoes_retorno.usar_arr_tit=true;
            comhttpsub.opcoes_retorno.seletor_local_retorno="div.div_consultar_objet_gerais_subcampanhas";
            comhttpsub.opcoes_retorno.metodo_insersao = "append";			
            comhttpsub.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            },{
                arquivo:null,
                funcao:"window.fnsisjd.criar_graficos_camp_sub_estruturada"
            },{
                arquivo:null,
                funcao:"window.fnsisjd.atualizar_vlatingimento_campanha"
            }];
            fnjs.obterJquery("div.div_consultar_objet_gerais_subcampanhas").attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttpsub});
        }
        console.log("Fim carregar_dados_campanha_consultar");			
            fnjs.logf(this.constructor.name,"carregar_dados_campanha_consultar");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }


    pesquisar_itens_campanha_giro(obj) {
        try {
            fnjs.logi(this.constructor.name,"pesquisar_itens_campanha_giro");
            let 
                comhttp_itens_camp_giro = JSON.parse(vars.str_tcomhttp),
                condicionantes = [],
                div_itens_camp_giro = fnjs.obterJquery("div.div_consultar_itens_campanha_giro"),
                div_filtros_entidades = {},
                div_filtros_periodos = {},
                inputs_entidades = {},
                input_filial = {},
                input_superv = {},
                input_rca = {},
                filial = null,
                superv = null,
                rca = null,
                combo_boxes = {},
                inputs_anos = {},
                combobox_periodo1 = {},
                combobox_periodo2 = {},
                input_ano_periodo1 = {},
                input_ano_periodo2 = {},
                mes_periodo1 = null,
                mes_periodo2 = null,
                ano_periodo1 = null,
                ano_periodo2 = null,
                criterios_itens_camp_giro = {};
            div_filtros_periodos = div_itens_camp_giro.find("div.div_consultar_sinergia_filtros_periodos");				
            combo_boxes = div_filtros_periodos.find("div.div_combobox") ;
            inputs_anos = div_filtros_periodos.find("input.input_ano") ;	
            combobox_periodo1 = combo_boxes.eq(0);
            combobox_periodo2 = combo_boxes.eq(0);
            input_ano_periodo1 = inputs_anos.eq(0);
            input_ano_periodo2 = inputs_anos.eq(0);
            mes_periodo1 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo1);
            mes_periodo2 = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_periodo2);
            ano_periodo1 = input_ano_periodo1.val();
            ano_periodo2 = input_ano_periodo2.val();		
            criterios_itens_camp_giro.filial = "";//filial;
            criterios_itens_camp_giro.superv = "";//superv;
            criterios_itens_camp_giro.rca = "";//rca;
            criterios_itens_camp_giro.mes_periodo1 = mes_periodo1;
            criterios_itens_camp_giro.mes_periodo2 = mes_periodo2;
            criterios_itens_camp_giro.ano_periodo1 = ano_periodo1;
            criterios_itens_camp_giro.ano_periodo2 = ano_periodo2;
            comhttp_itens_camp_giro.requisicao.requisitar.oque="dados_sql";
            comhttp_itens_camp_giro.requisicao.requisitar.qual.comando = "consultar";
            comhttp_itens_camp_giro.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp_itens_camp_giro.requisicao.requisitar.qual.objeto = "consultar_itens_campanha_giro";
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes=[];
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("relatorio=consultar_itens_campanha_giro");		
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+ criterios_itens_camp_giro.mes_periodo1);
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+ criterios_itens_camp_giro.mes_periodo2);
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+ criterios_itens_camp_giro.ano_periodo1);
            comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+ criterios_itens_camp_giro.ano_periodo2);
            if (criterios_itens_camp_giro.filial.trim().length > 0) {
                condicionantes.push("filial=" + criterios_itens_camp_giro.filial);
                comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("filial=" + criterios_itens_camp_giro.filial);
            } 
            if (criterios_itens_camp_giro.superv.trim().length > 0) {
                condicionantes.push("supervisor=" + criterios_itens_camp_giro.superv);
                comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("supervisor=" + criterios_itens_camp_giro.superv);
            } 
            if (criterios_itens_camp_giro.rca.trim().length > 0) {
                condicionantes.push("rca=" + criterios_itens_camp_giro.rca);
                comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push("rca=" + criterios_itens_camp_giro.rca);
            } 
            if (condicionantes.length > 0) {
                condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                comhttp_itens_camp_giro.requisicao.requisitar.qual.condicionantes.push(condicionantes);
            }	
            comhttp_itens_camp_giro.opcoes_retorno.seletor_local_retorno="div.div_consultar_itens_campanha_giro div.div_resultado";
            comhttp_itens_camp_giro.opcoes_retorno.metodo_insersao = "html";			
            comhttp_itens_camp_giro.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp_itens_camp_giro});		
            fnjs.logf(this.constructor.name,"pesquisar_itens_campanha_giro");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_dados_grupos_equivalentes(){
        try {
            fnjs.logi(this.constructor.name,"carregar_dados_grupos_equivalentes");
            let comhttp_campanha_sinergia = JSON.parse(vars.str_tcomhttp),
                condicionantes = [];
            comhttp_campanha_sinergia.requisicao.requisitar.oque="dados_sql";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.comando = "consultar";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.objeto = "gruposprodutosequivalentes";
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes=[];
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp_campanha_sinergia.requisicao.requisitar.qual.condicionantes.push("relatorio=gruposprodutosequivalentes");		
            comhttp_campanha_sinergia.opcoes_retorno.seletor_local_retorno="div.div_manutencao_grupos_prodequiv_arvore_opcoes";
            comhttp_campanha_sinergia.opcoes_retorno.metodo_insersao = "html";					
            comhttp_campanha_sinergia.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp_campanha_sinergia});		
            fnjs.logf(this.constructor.name,"carregar_dados_grupos_equivalentes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }


    carregar_dados_grupo_prod_equiv(obj){
        try{            
            fnjs.logi(this.constructor.name,"carregar_dados_grupo_prod_equiv");
            let comhttp,
            comhttp_info,
            cel = fnjs.obterJquery(obj),
            tabelaest = cel.closest("table.tabdados"),
            codusur = "",
            codgrupoprodequiv = "",
            tabeladb = "sjdgruposprodequiv";
        
        if (cel.prop("tagName").toLowerCase() !== "td") {
            if (cel.closest("tr").find("td").length) {
                cel = cel.find("td").eq(0);
            }
        }
        if ((cel.closest("tr").attr("status") || "normal") === "normal" && !cel.hasClass("cel_cmd")) {
            codgrupoprodequiv = cel.closest("tr").children("td").eq(0).text();	               			
            comhttp_info = JSON.parse(vars.str_tcomhttp);
            comhttp_info.requisicao.requisitar.oque="dados_sql";
            comhttp_info.requisicao.requisitar.qual.comando = "consultar";
            comhttp_info.requisicao.requisitar.qual.tipo_objeto = "linha";
            comhttp_info.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttp_info.requisicao.requisitar.qual.condicionantes = [];
            comhttp_info.requisicao.requisitar.qual.condicionantes.push("codprocesso=10251");
            comhttp_info.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdgruposprodequiv["+ tabeladb +".codgrupoprod="+codgrupoprodequiv+"]");				
            comhttp_info.opcoes_retorno.usar_arr_tit=true;
            comhttp_info.opcoes_retorno.seletor_local_retorno="div.div_dados_grupos_alterar_container_orelha0";					
            comhttp_info.opcoes_retorno.metodo_insersao = "html";			
            comhttp_info.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div.div_dados_grupos_alterar_container_orelha0").attr("codgrupoprodequiv",codgrupoprodequiv);				
            fnreq.requisitar_servidor({comhttp:comhttp_info});
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = "sjdinteggrupoprod"
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=lista");
            comhttp.requisicao.requisitar.qual.condicionantes.push("especificacao_dados=integgrupoprod");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdinteggrupoprod[sjdinteggrupoprod.codgrupoprod=" + codgrupoprodequiv+"]");
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_dados_grupos_alterar_container_orelha1";
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div.div_dados_grupos_alterar_container_orelha1").attr("codgrupoprodequiv",codgrupoprodequiv);
            fnreq.requisitar_servidor({comhttp:comhttp});
        }
            fnjs.logf(this.constructor.name,"carregar_dados_grupo_prod_equiv");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }


    /**
        * Funcao responsavel por preparar a requisicao para atualizar os realizados dos objetivos das campanhas estruturadas e requisitar o 
        * envio ao servidor. Esta funcao eh recursiva indefinidamente enquanto a pagina que a acionou estiver averta e nao
        * ouverem erros. Ela se auto chama de hora em hora.
        * @param obj Object - O elemento html clicado
        * @created 01/01/2019
    */	
    atualizar_realizado_objetivos_campanhas_estruturadas(obj){
        try {
            fnjs.logi(this.constructor.name,"atualizar_realizado_objetivos_campanhas_estruturadas");
            let comhttp = JSON.parse(vars.str_tcomhttp),
                datas = {},
                inputs_datas = {};
            obj = fnjs.obterJquery(obj);
            inputs_datas = obj.closest("div");
            inputs_datas = inputs_datas.find("input.componente_data");
            datas=this.pegar_valores_elementos(inputs_datas);
            if (inputs_datas.length) {
                for (let i = 0; i < inputs_datas.length; i++) {
                    if (inputs_datas.eq(i).attr("type") === "date") {
                        datas[i] = fndt.dataBR(datas[i]);
                    } 
                }
                if (inputs_datas.eq(0).attr("type") === "date") {
                    inputs_datas.eq(0).val(fndt.dataUSA(fndt.data_primeirodiames()));
                    inputs_datas.eq(1).val(fndt.dataUSA());
                } else {
                    inputs_datas.eq(0).val(fndt.data_primeirodiames());
                    inputs_datas.eq(1).val(fndt.dataBR());
                }
            }							
            comhttp.requisicao.requisitar.oque="funcoes_erp";
            comhttp.requisicao.requisitar.qual.comando = "atualizar_realizado_objetivos_campanhas_estruturadas";
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("datas=" + datas.join(","));
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.processar_retorno_em_silencio'
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});			
            fnjs.logf(this.constructor.name,"atualizar_realizado_objetivos_campanhas_estruturadas");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }			
    }

    /**
        * Funcao responsavel por preparar a requisicao para atualizar os realizados dos objetivos sinergia e requisitar o 
        * envio ao servidor. Esta funcao eh recursiva indefinidamente enquanto a pagina que a acionou estiver averta e nao
        * ouverem erros. Ela se auto chama de hora em hora.
        * @param obj Object - O elemento html clicado
        * @created 01/01/2019
    */	
    atualizar_realizado_objetivos_sinergia(obj){
        try {
            fnjs.logi(this.constructor.name,"atualizar_realizado_objetivos_sinergia");
            let comhttp = JSON.parse(vars.str_tcomhttp),
                datas = {},
                inputs_datas = {};
            obj = fnjs.obterJquery(obj);
            inputs_datas = obj.closest("div");
            inputs_datas = inputs_datas.find("input.componente_data");
            datas=this.pegar_valores_elementos(inputs_datas);
            if (inputs_datas.length) {
                for (let i = 0; i < inputs_datas.length; i++) {
                    if (inputs_datas.eq(i).attr("type") === "date") {
                        datas[i] = fndt.dataBR(datas[i]);
                    }
                }
                if (inputs_datas.eq(0).attr("type") === "date") {
                    inputs_datas.eq(0).val(fndt.dataUSA(fndt.data_primeirodiames()));
                    inputs_datas.eq(1).val(fndt.dataUSA());
                } else {
                    inputs_datas.eq(0).val(fndt.data_primeirodiames());
                    inputs_datas.eq(1).val(fndt.dataBR());
                }
            }			
            comhttp.requisicao.requisitar.oque="funcoes_erp";
            comhttp.requisicao.requisitar.qual.comando = "atualizar_realizado_objetivos_sinergia";
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("datas=" + datas.join(","));
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.processar_retorno_em_silencio'
            }];			
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"atualizar_realizado_objetivos_sinergia");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }			
    }


    funcoes_eventuais(obj){
        try{
            fnjs.logi(this.constructor.name,"funcoes_eventuais");
            let nomeatualizacao = null,
                comhttp={},
                selecionados = [];
            obj = fnjs.obterJquery(obj);
            nomeatualizacao = obj.attr("data-nomeatualizacao").trim();
            comhttp = JSON.parse(vars.str_tcomhttp);		
            comhttp.requisicao.requisitar.oque="funcoes_eventuais";
            comhttp.requisicao.requisitar.qual.nomeatualizacao = nomeatualizacao;
            comhttp.requisicao.requisitar.qual.condicionantes=[];
            comhttp.requisicao.requisitar.qual.condicionantes.push("nomeatualizacao"+'='+nomeatualizacao);	
            if (obj.closest('td').prev('td').find(vars.seletores.div_combobox).length) {
                selecionados = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(obj.closest('td').prev('td').find(vars.seletores.div_combobox));
                comhttp.requisicao.requisitar.qual.condicionantes.push('selecionados=' + selecionados.join(','));	
            }
            if (obj.closest('td').prev('td').find("input.componente_data").length) {
                let datas = [];
                $.each(obj.closest('td').prev('td').find("input.componente_data"),function(index,element){
                    datas.push(element.value);
                });                
                comhttp.requisicao.requisitar.qual.condicionantes.push("datas=" +  datas.join(","));	
            }
            comhttp.opcoes_retorno.parar_por_erros_sql=false;
            if(nomeatualizacao==='executar'&&tipo_objeto==='selecionados'&&objeto==='todos'){				
                comhttp = JSON.parse(vars.str_tcomhttp);		
                comhttp.requisicao.requisitar.oque='funcoes_iniciais';
                comhttp.requisicao.requisitar.qual.condicionantes=[];				
                let btns=fnjs.obterJquery(obj).closest('fieldset').find('img').not(obj),
                nomesatualizacoes=[];
                btns.each(function(){
                    if(fnjs.obterJquery(this).closest('tr').find('input').prop('checked')===true){
                        nomesatualizacoes.push(fnjs.obterJquery(this).attr("data-nomeatualizacao"));
                    }
                });
            comhttp.requisicao.requisitar.qual.nomeatualizacao = nomesatualizacoes;
            comhttp.requisicao.requisitar.qual.condicionantes.push("nomeatualizacao"+'='+nomesatualizacoes);	
                comhttp.opcoes_retorno.parar_por_erros_sql=false;				
                comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:'window.fnreq.processar_retorno_como_log'
                },{
                        arquivo:null,
                        funcao:'window.fnsisjd.recarregar_opcao_sistema',
                        parametros:{opcao_sistema:'manutencao'}
                }];			
            } else if(nomeatualizacao==='CARREGAR_COMANDOS'){
                comhttp.opcoes_retorno.seletor_local_retorno=vars.seletores.div_atualizar;
                comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:vars.nfj.processar_retorno_como_texto_html
                }];							
            } else {
                comhttp.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:'window.fnreq.processar_retorno_como_log'
                }];
                if(nomeatualizacao==='executar_limpar'||(nomeatualizacao==='inserir_dados'&&tipo_objeto==='tabela'&&objeto==='comandos')){
                        comhttp.eventos.aposretornar=[{
                            arquivo:null,
                            funcao:'window.fnreq.processar_retorno_como_msg'
                        },{
                            arquivo:null,
                            funcao:'window.fnsisjd.recarregar_opcao_sistema',
                            parametros:{opcao_sistema:'manutencao'}
                        }];
                }
            }
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"funcoes_eventuais");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }							
    }


    pesquisar_sub_registro_clientes_ativosxposit(obj){
        try{
            fnjs.logi(this.constructor.name,"pesquisar_sub_registro_clientes_ativosxposit");
            let comhttp,
            div_filtros,div_filtros_entidades,div_filtros_periodos,
            divs_sel,
            filial_filtro_existente,
            rca_filtro_existente,
            superv_filtro_existente,
            mes,
            visao,
            combo_boxes={},
            combobox_visao={},
            combobox_rca={},
            combobox_mes={},
            combobox_ano={},
            i=0,
            j=0,
            qt=0,
            qt2=0,
            inputs_entidades,
            input_filial,
            input_superv,
            input_rca,
            condicionantes,
            tabelaest={},
            visao_sub="",
            cel_sub_registro={},
            idrand=fnjs.id_random(),
            campanha="",
            codfilial = "",
            codsupervisor="",
            codrca="",
            codgrupogiro = "",
            opcoes_combobox={},
            div_resultado = "",
            condicionantestab=[],
            linha = {},
            mesperiodo1,
            mesperiodo2,
            anoperiodo1,
            anoperiodo2,
            codusur;
        obj = fnjs.obterJquery(obj);
        linha = obj.closest("tr");
        tabelaest=linha.closest("table.tabdados");
        visao = tabelaest.attr("visao").trim().toLowerCase();
        condicionantestab = (tabelaest.attr("condicionantestab"));
        if (typeof condicionantestab === "undefined") {
            condicionantestab = [];
        } else {
            condicionantestab = condicionantestab.substr(condicionantestab.indexOf("[")).replace("[","").replace("]","").split(" and ");
        }
        condicionantes = [];
        filial_filtro_existente = tabelaest.attr("filtro_filial").trim();
        superv_filtro_existente = tabelaest.attr("filtro_supervisor").trim();
        rca_filtro_existente = tabelaest.attr("filtro_rca").trim();
        mesperiodo1 = tabelaest.attr("filtro_mes_periodo1").trim();
        mesperiodo2 = tabelaest.attr("filtro_mes_periodo2").trim();
        anoperiodo1 = tabelaest.attr("filtro_ano_periodo1").trim();
        anoperiodo2 = tabelaest.attr("filtro_ano_periodo2").trim();
        
        
        if (visao.trim().toLowerCase() === "rca") {
            visao_sub = "cliente";
        } else {
            visao_sub = "rca";
        }
        cel_sub_registro = linha.next().children("td.cel_sub_registro");
        
        cel_sub_registro.addClass(idrand);
        codusur = tabelaest.attr("codusur") || linha.children("td").eq(1).text();

        /*se esta numa linha hierarquicamente subordinada a outra, aloca a condicionante referente a essa linha*/
        if (visao === "filial") {
            codfilial = linha.children("td").eq(1).text();				
        } else if (visao === "supervisor") {
            codsupervisor = linha.children("td").eq(1).text();
        } else if (visao === "rca") {
            codrca = linha.children("td").eq(1).text();				
        } else if (visao === "grupo giro") {
            codgrupogiro = linha.children("td").eq(1).text();								
        }


            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='dados_sql';
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = "clientes_ativosxposit_subregistros";
            comhttp.requisicao.requisitar.qual.condicionantes=[];
            comhttp.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp.requisicao.requisitar.qual.condicionantes.push("relatorio=clientes_ativosxposit_subregistros");
            comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+mesperiodo1);
            comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+anoperiodo1);
            comhttp.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+mesperiodo2);
            comhttp.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+anoperiodo2);
            comhttp.requisicao.requisitar.qual.condicionantes.push("visao="+visao_sub);
            comhttp.requisicao.requisitar.qual.condicionantes.push("codusur="+codusur);
        
        //condicionantes da linha superior
        if (codfilial.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("filial="+codfilial);
            if (codfilial.trim() === "1") {
                condicionantestab.push("sjdobjetivossinergia.codentidade<200");
            } else {
                condicionantestab.push("sjdobjetivossinergia.codentidade>200");
            }
        }

        if (codsupervisor.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("supervisor="+codsupervisor);
            condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor = " + codsupervisor + ")");
        }
        if (codrca.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("rca="+codrca);
            condicionantestab.push("sjdobjetivossinergia.codentidade=" + codrca);
        }
        if (codgrupogiro.trim().length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("grupogiro="+codgrupogiro);
            condicionantestab.push("sjdobjetivossinergia.codgrupogiro=" + codgrupogiro);
        }
        
        //condicionantes do filtro da pagina
        if (filial_filtro_existente.trim().length > 0) {
            condicionantes.push("filial="+filial_filtro_existente);
            comhttp.requisicao.requisitar.qual.condicionantes.push("filial="+filial_filtro_existente);
            if (filial_filtro_existente.trim() === "1") {
                condicionantestab.push("sjdobjetivossinergia.codentidade<200");
            } else {
                condicionantestab.push("sjdobjetivossinergia.codentidade>200");
            }
        } 
        if (superv_filtro_existente.trim().length > 0) {
            condicionantes.push("supervisor="+superv_filtro_existente);
            comhttp.requisicao.requisitar.qual.condicionantes.push("supervisor="+superv_filtro_existente);
            condicionantestab.push("sjdobjetivossinergia.codentidade in (select codusur from jumbo.pcusuari where codsupervisor = " + superv_filtro_existente + ")");
        } 
        if (rca_filtro_existente.trim().length > 0) {
            condicionantes.push("rca="+rca_filtro_existente);
            comhttp.requisicao.requisitar.qual.condicionantes.push("rca="+rca_filtro_existente);
            condicionantestab.push("sjdobjetivossinergia.codentidade=" + rca_filtro_existente);
        } 
        
        if (condicionantes.length > 0) {
            condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
            comhttp.requisicao.requisitar.qual.condicionantes.push(condicionantes);
        }
        if (condicionantestab.length > 0) {
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab=sjdobjetivossinergia["+condicionantestab.join(" and ")+"]");
        }
        comhttp.opcoes_retorno.seletor_local_retorno="td."+idrand;
        comhttp.opcoes_retorno.metodo_insersao = "html";			
        comhttp.eventos.aposretornar=[{
            arquivo:null,
            funcao:'window.fnreq.inserir_retorno'
        },{
            arquivo:null,
            funcao:"window.fnsisjd.atualizar_cores_clientes_positivados"
        }];
        comhttp.opcoes_retorno.padding_right = 10;
        comhttp.opcoes_retorno.padding_left = 10;
        fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"pesquisar_sub_registro_clientes_ativosxposit");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    atualizar_cores_clientes_positivados(params) {
        try {
            fnjs.logi(this.constructor.name,"atualizar_cores_clientes_positivados");
            let div_resultado = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
            let tabelaest = div_resultado.find("table.tabdados");
            let corpotabelaest = tabelaest.children("tbody");
            let linhas = corpotabelaest.children("tr");
            $.each(linhas,function(index,element) {
                if (window.fnjs.obterJquery(element).children("td:nth-child(7)").text() === "SIM") {
                    window.fnjs.obterJquery(element).addClass("cliente_positivado");
                } else {					
                    window.fnjs.obterJquery(element).addClass("cliente_negativado");
                }
            });
            fnjs.logf(this.constructor.name,"atualizar_cores_clientes_positivados");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    clicou_detalhar_evolucao(params){
        try {
            fnjs.logi(this.constructor.name,"clicou_detalhar_evolucao");
            params.elemento = params.elemento || params.obj || params.elem || params;
            params.filtros_painel = this.obter_filtros_painel();
            let nova_janela = window.open("/"+__CAMINHOBASESISREL__ + "/php/maximizada.php");		
            this.preencher_dados_janela_maximizada_defalhe_evolucao(nova_janela,params);
            fnjs.logf(this.constructor.name,"clicou_detalhar_evolucao");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    preencher_dados_janela_maximizada_defalhe_evolucao(janela,params) {
        try {
            fnjs.logi(this.constructor.name,"preencher_dados_janela_maximizada_defalhe_evolucao");
            if (fnjs.obterJquery(janela.document.body).find("div.div_conteudo_pagina").length) {			
                janela.document.var_params = params;
                fnjs.obterJquery(janela.document.body).find("div.div_conteudo_pagina").append('<div class="div_graficos_evolucao_sinergia_detalhados"></div>');
                fnjs.obterJquery(janela.document.body).find("div.div_conteudo_pagina").append('<script type="text/javascript">fnsisjd.requisitar_dados_graficos_detalhados_evolucao_sinergia(document.var_params);</script>');				
            } else {
                setTimeout(this.preencher_dados_janela_maximizada_defalhe_evolucao,1000,janela,params);
            }
            fnjs.logf(this.constructor.name,"preencher_dados_janela_maximizada_defalhe_evolucao");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    requisitar_dados_graficos_detalhados_evolucao_sinergia(params) {
        try {
            fnjs.logi(this.constructor.name,"requisitar_dados_graficos_detalhados_evolucao_sinergia");
            let comhttp_evolucao_sinergia = JSON.parse(vars.str_tcomhttp),
                    condicionantes = [];
            fnreq.mudar_titulo("Detalhamento Campanha por " + fnjs.obterJquery(params.elemento).text());
            comhttp_evolucao_sinergia.requisicao.requisitar.oque="dados_sql";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.comando = "consultar";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.objeto = "sinergia2evolucaoDetalhado";
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes=[];
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("tipo_dados=tabelaest");
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("relatorio=sinergia2evolucaoDetalhado");		
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo1="+ params.filtros_painel.mes_periodo1);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("mesperiodo2="+ params.filtros_painel.mes_periodo2);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo1="+ params.filtros_painel.ano_periodo1);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("anoperiodo2="+ params.filtros_painel.ano_periodo2);
            comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("detalhadopor="+ fnjs.obterJquery(params.elemento).text());
            
            if (params.filtros_painel.filial.trim().length > 0) {
                condicionantes.push("filial=" + params.filtros_painel.filial);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("filial=" + params.filtros_painel.filial);
            } 
            if (params.filtros_painel.superv.trim().length > 0) {
                condicionantes.push("supervisor=" + params.filtros_painel.superv);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("supervisor=" + params.filtros_painel.superv);
            } 
            if (params.filtros_painel.rca.trim().length > 0) {
                condicionantes.push("rca=" + params.filtros_painel.rca);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push("rca=" + params.filtros_painel.rca);
            } 
            if (condicionantes.length > 0) {
                condicionantes = "condicionantes="+condicionantes.join(vars.sepn1);
                comhttp_evolucao_sinergia.requisicao.requisitar.qual.condicionantes.push(condicionantes);
            }	
            comhttp_evolucao_sinergia.opcoes_retorno.seletor_local_retorno=fnjs.obterJquery("div.div_graficos_evolucao_sinergia_detalhados");
            comhttp_evolucao_sinergia.opcoes_retorno.ignorar_tabela_est=true;
            comhttp_evolucao_sinergia.opcoes_retorno.metodo_insersao = "html";
            comhttp_evolucao_sinergia.eventos.aposretornar=[{
                    arquivo:null,
                    funcao:"window.fnsisjd.atualizar_grafico_evolucao_sinergia_detalhado"
            }];		
            fnreq.requisitar_servidor({comhttp:comhttp_evolucao_sinergia});	
            fnjs.logf(this.constructor.name,"requisitar_dados_graficos_detalhados_evolucao_sinergia");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    atualizar_grafico_evolucao_sinergia_detalhado(params){
        try {
            fnjs.logi(this.constructor.name,"atualizar_grafico_evolucao_sinergia_detalhado");
            fnsisjd.criar_grafico_sinergia_evolucao_detalhado(params);
            fnjs.logf(this.constructor.name,"atualizar_grafico_evolucao_sinergia_detalhado");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }

    }

    criar_grafico_sinergia_evolucao_detalhado(params){
        try {
            fnjs.logi(this.constructor.name,"criar_grafico_sinergia_evolucao_detalhado");
            google.charts.load('current', {'packages':['corechart','line']});
            //alert(params.comhttp.requisicao.requisitar.qual.condicionantes.detalhadopor);
            google.charts.setOnLoadCallback(function (){
                window.fnsisjd.desenharGraficosEvolucaoDetalhe({
                    dados:params.comhttp.retorno.dados_retornados.dados[0],
                    detalhadopor:params.comhttp.requisicao.requisitar.qual.condicionantes.detalhadopor
                });
            });
            fnjs.logf(this.constructor.name,"criar_grafico_sinergia_evolucao_detalhado");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    desenharGraficosEvolucaoDetalhe(params) {
        try {
            fnjs.logi(this.constructor.name,"desenharGraficosEvolucaoDetalhe");
            let data;
            let div_graficos = fnjs.obterJquery('div.div_graficos_evolucao_sinergia_detalhados');
            for(let ind_matriz_entidade in params.dados) {
                let qtLinhas = params.dados[ind_matriz_entidade].length;
                for(let i = 0; i < qtLinhas; i++) {
                    params.dados[ind_matriz_entidade][i][0] = eval(params.dados[ind_matriz_entidade][i][0]);
                    params.dados[ind_matriz_entidade][i][1] = parseFloat(params.dados[ind_matriz_entidade][i][1]);
                    params.dados[ind_matriz_entidade][i][2] = parseFloat(params.dados[ind_matriz_entidade][i][2]);
                    /*if (i > 0) {
                        params.dados[ind_matriz_entidade][i][2] = params.dados[ind_matriz_entidade][i][2] + params.dados[ind_matriz_entidade][i-1][2];
                    }*/
                }
                data = new google.visualization.DataTable();
                data.addColumn('date', 'X');
                data.addColumn('number', 'Realizado');
                data.addColumn('number', 'Esperado');
                
                data.addRows(params.dados[ind_matriz_entidade]);

                let options = {
                    hAxis: {
                        title: 'Dias',
                        format:'dd/MM'
                    },
                    vAxis: {
                        title: 'Realizado',
                        minValue:0,
                        viewWindow:{
                            min:0
                        }
                    },
                    legend: { position: 'top' }
                };
                let opcoes_box = {
                    classe:"div_box_grafico_evolucao_detalhado",
                    titulo:{
                        texto:params.detalhadopor + " " + ind_matriz_entidade
                    },
                    corpo:{
                        classe:"div_graficos_"+ind_matriz_entidade
                    }
                };
                let nova_div_grafico = fnhtml.montar_box_padrao(opcoes_box);
                //div_graficos_evolucao_sinergia_detalhados //div_graficos.append('<div class="div_graficos_'+ind_matriz_entidade+' col-3"></div>');
                div_graficos.append(nova_div_grafico);
                let chart = new google.visualization.LineChart(fnjs.obterJquery('div.' + opcoes_box.corpo.classe)[0]);
                chart.draw(data, options);	
            }
            fnreq.carregando({
                acao:"excluir",
                id: "todos"
            });
            fnjs.logf(this.constructor.name,"desenharGraficosEvolucaoDetalhe");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);		
        }
    }

    fechar_card(obj){
        try {
            fnjs.logi(this.constructor.name,"fechar_card");
            obj = fnjs.obterJquery(obj);
            obj.closest("div.card").closest("div[class*=col]").remove();
            fnjs.logf(this.constructor.name,"fechar_card");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    carregar_lista_opcoes_sistema(obj){
        try{
            fnjs.logi(this.constructor.name,"carregar_lista_opcoes_sistema");
            let comhttp = JSON.parse(vars.str_tcomhttp);
            obj = fnjs.obterJquery(obj);
            let idrand = fnjs.id_random();
            let datalist = obj.next("datalist");
            if (datalist.children().length <= 1) {
                datalist[0].classList.add(idrand);   
                datalist.children("option").eq(0).append(fnhtml.criar_spinner());             
                comhttp.requisicao.requisitar.oque = obj.attr('oque');
                comhttp.requisicao.requisitar.qual.comando = obj.attr('comando');
                comhttp.requisicao.requisitar.qual.tipo_objeto = obj.attr('tipo_objeto');
                comhttp.requisicao.requisitar.qual.objeto = obj.attr('objeto');
                comhttp.requisicao.requisitar.qual.condicionantes = [];
                comhttp.requisicao.requisitar.qual.condicionantes.push('tipo_retorno=dados');
                comhttp.opcoes_requisicao.mostrar_carregando = false;
                comhttp.opcoes_retorno.seletor_local_retorno = "datalist." + idrand;
                comhttp.opcoes_retorno.metodo_insersao = vars.nfj.html;
                comhttp.opcoes_retorno.ignorar_tabela_est = true;
                comhttp.eventos.aposretornar = [];
                comhttp.eventos.aposretornar.push({
                    arquivo:null,
                    funcao:'window.fnreq.inserir_retorno'
                });
                fnreq.requisitar_servidor({comhttp:comhttp});
            }
            fnjs.logf(this.constructor.name,"carregar_lista_opcoes_sistema");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }							
    }

    acessar_opcao_pesquisada(obj){
        try {
            fnjs.logi(this.constructor.name,"acessar_opcao_pesquisada");
            let val = obj.value.trim();
            if (val.length > 0) {
                let opts = obj.nextElementSibling.childNodes;
                let qt = opts.length;                    
                for(let i = 0; i < qt; i++) {
                    if (opts[i].innerText === val) {
                        //alert('selecionado ' + opts[i].getAttribute("nomeops"));
                        this.abrir_opcao_sistema({nomeops:opts[i].getAttribute("nomeops")});
                    }
                }
            }
            fnjs.logf(this.constructor.name,"acessar_opcao_pesquisada");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }						
    }

    grafico_campanhas_estruturadas(params) {
        try {
            fnjs.logi(this.constructor.name,"grafico_campanhas_estruturadas");
            google.charts.load("current", {packages:['corechart']});
            google.charts.setOnLoadCallback(function (){
                window.fnsisjd._grafico_campanhas_estruturadas(params);
            });
            fnjs.logf(this.constructor.name,"grafico_campanhas_estruturadas");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    _grafico_campanhas_estruturadas(params) {
        try {
            fnjs.logi(this.constructor.name,"_grafico_campanhas_estruturadas");
            let grafico = "";
            let contexto = {};
            fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divgraficocamp").append('<div id="grafico_campanha"></div>');
            let celulas_valores = fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo1").find("table.tabdados").eq(0).children("tbody").children("tr:not(.linha_padrao)").children("td:nth-child(10)");
            let celulas_nomes = fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo1").find("table.tabdados").eq(0).children("tbody").children("tr:not(.linha_padrao)").children("td:nth-child(3)");
            let dados = [];
            if (!(typeof celulas_nomes !== "undefined" && celulas_nomes !== null && celulas_nomes.length)) {
                params.contador_recursao = params.contador_recursao || 0;
                if (params.contador_recursao > vars.num_limite_recursoes) {
                    console.error("processo interrompido por excesso de recurssoes");
                    return;
                }
                params.contador_recursao++;
                setTimeout(this._grafico_campanhas_estruturadas,300,params);
                return;
            }
            dados.push(['Objetivo','Realizado (%)', { role: "style" } ]);
            $.each(celulas_valores, function(index) {
                let linha = [celulas_nomes.eq(index).text(),fnmat.como_numero(celulas_valores.eq(index).text())];
                linha.push('color:' + window.fnsisjd.processar_regra_cor_barras_grafico_camp_est(linha[1]));
                dados.push(linha);
            });
            fngraf.criar_grafico_barras({
                dados:dados,
                titulo:"Objetivos Gerais",
                idconteiner:"grafico_campanha"
            });
            fnjs.logf(this.constructor.name,"_grafico_campanhas_estruturadas");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    criar_graficos_camp_sub_estruturada(params){
        try {
            fnjs.logi(this.constructor.name,"criar_graficos_camp_sub_estruturada");
            google.charts.load("current", {packages:['corechart']});
            google.charts.setOnLoadCallback(function (){
                window.fnsisjd.graficosub(params);
            });
            fnjs.logf(this.constructor.name,"criar_graficos_camp_sub_estruturada");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    processar_regra_cor_barras_grafico_camp_est(valor){
        try {
            fnjs.logi(this.constructor.name,"processar_regra_cor_barras_grafico_camp_est");
            if (valor <=30) {
                return 'red';
            } else if (valor <=50) { 
                return 'yellow';
            } else if (valor <=75) { 
                return 'blue';
            } else {
                return 'green';
            }
            fnjs.logf(this.constructor.name,"processar_regra_cor_barras_grafico_camp_est");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    graficosub(params) { 
        try {
            fnjs.logi(this.constructor.name,"graficosub");
            let grafico = "";
            let contexto = {};
            let div_alvo = fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divgraficossubcamp");
            let idcar = "";
            let titulo = fnjs.obterJquery("div.div_consultar_objet_gerais_subcampanhas").find("h3");
            let titulos = fnjs.obterJquery("div.div_consultar_objet_gerais_subcampanhas").find("h4");
            let tabelas = fnjs.obterJquery("div.div_consultar_objet_gerais_subcampanhas").find("table.tabdados");
            if (!(typeof tabelas !== "undefined" && tabelas !== null && tabelas.length)) {
                params.contador_recursao = params.contador_recursao || 0;
                if (params.contador_recursao > vars.num_limite_recursoes) {
                    console.error("processo interrompido por excesso de recurssoes");
                    return;
                }
                params.contador_recursao++;
                setTimeout(this.graficosub,300,params);
                return;
            }
            div_alvo.append("<br />");
            div_alvo.append("<br />");
            div_alvo.append(titulo.clone());

            if (tabelas.length) {
                let qt = tabelas.length;
                for (let i = 0 ; i < qt ; i++) {
                    div_alvo.append("<br />");
                    div_alvo.append("<br />");
                    div_alvo.append('<div id="grafico'+i+'"></div>');
                    let celulas_valores = tabelas.eq(i).children("tbody").children("tr:not(.linha_padrao)").children("td:nth-child(10)");
                    let celulas_nomes = tabelas.eq(i).children("tbody").children("tr:not(.linha_padrao)").children("td:nth-child(3)");
                    let dados = [];
                    dados.push(['Objetivo','Realizado (%)', { role: "style" } ]);
                    $.each(celulas_valores, function(index) {
                        let linha = [celulas_nomes.eq(index).text(),fnmat.como_numero(celulas_valores.eq(index).text())];							
                        linha.push('color:' + window.fnsisjd.processar_regra_cor_barras_grafico_camp_est(linha[1]));
                        dados.push(linha);
                    });
                    fngraf.criar_grafico_barras({
                        dados:dados,
                        titulo:titulos.eq(i).text() || tabelas.eq(i).children("thead").children("tr.linhatitulos").prev("tr").children("th").text(),
                        idconteiner:"grafico"+i
                    });
                }
            }
            fnjs.logf(this.constructor.name,"graficosub");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    atualizar_vlatingimento_campanha(params) { 
        try{
            fnjs.logi(this.constructor.name,"atualizar_vlatingimento_campanha");
            let div_objetivos_gerais_campanha = fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo1"),
                div_campanha = fnjs.obterJquery("div.div_dados_campanhas_consultar_container_corpo0_divtab"),
                tabelasobj = {},
                tabelacamp = {},
                qt = 0,
                vlratingimento = 0,
                vlratingimentototal = 0;
            tabelasobj = div_objetivos_gerais_campanha.find("table.tabdados");
            tabelacamp = div_campanha.find("table.tabdados").eq(0);
            if (!tabelasobj.length) {
                params.contador_recursao = params.contador_recursao || 0;
                params.contador_recursao++;
                if (params.contador_recursao > vars.num_limite_recursoes) {
                    alert('a função atualizar_vlatingimento_campanha está em loop aguardando resposta, atingiu o limite de recursividade, encerrando processo.');
                } else {
                    setTimeout(this.atualizar_vlatingimento_campanha,100,params);                    
                }                
                return;
            } else if (tabelasobj.length == 1) {
                params.contador_recursao = params.contador_recursao || 0;
                params.contador_recursao++;
                if (params.contador_recursao < vars.num_limite_recursoes) {
                    setTimeout(this.atualizar_vlatingimento_campanha,100,params);                    
                    return;
                }
            }
            qt = tabelasobj.length;
            for(let i = 0; i < qt ; i++) {                
                vlratingimento = fnmat.como_numero(tabelasobj.eq(i).children("tfoot").children("tr").eq(1).children("th:last").text());
                vlratingimentototal += vlratingimento;
            }
            tabelacamp.children("tbody").children("tr").children("td:last").text(vlratingimentototal.toFixed(2));
            fnjs.logf(this.constructor.name,"atualizar_vlatingimento_campanha");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    atualizar_info_campanhas(params) {
        try{
            fnjs.logi(this.constructor.name,"atualizar_info_campanhas");
            let div_info = fnjs.obterJquery("div.div_dados_campanhas_alterar_container_corpo0_info"),
                div_comandos = "";
            div_comandos = '<div><button class="botao_padrao" style="padding:5px;" onclick="window.fnsisjd.aplicar_percentual_geral({elemento:this})">Aplicar Percentual Geral</button></div>';
            div_info.html(div_comandos + "<br /");			
            fnjs.logf(this.constructor.name,"atualizar_info_campanhas");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    carregar_dados_campanha_alterar(params){
        try{
            fnjs.logi(this.constructor.name,"carregar_dados_campanha_alterar");
            params.elemento = fnjs.obterJquery(params.elemento||params.obj);
            let comhttp ;
        let cel = params.elemento;
        let linha = cel.closest("tr");
        let tabelaest = linha.closest("table.tabdados");
        let tabeladb = "sjdcampestr";
        let tabelasub = "sjdobjetcampestr";
        let codcampestr=0;
        let indcolcodcampestr = -1,
            idrand = fnjs.id_random();
        let col_detail = tabelaest.closest("div[class*=col]").next("div[class*=col]");
        
        
        linha.addClass(idrand);
        if (cel.prop("tagName") !== "td") {
            if (cel.closest("tr").find("td").length) {
                cel = cel.find("td").eq(0);
            }
        }
        if ((cel.closest("tr").attr("status") || "normal") === "normal" && !cel.hasClass("cel_cmd")) {			
            indcolcodcampestr = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"codcampestr");
            codcampestr = linha.children("td").eq(indcolcodcampestr).text();	
            //alert(codcampestr);
            //fnjs.obterJquery("div.div_manutencao_opcoes_sistema_dados_opcoes_container").attr("codcampestr",codcampestr);
            //fnjs.obterJquery("div.div_manutencao_opcoes_sistema_dados_opcoes_container").attr("idlinhacampestr",idrand);
            col_detail.attr("codcampestr",codcampestr);
            col_detail.attr("idlinhacampestr",idrand);
            //requisita dados da campanha (linha)
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "linha";
            comhttp.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4400");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabeladb+"["+ tabeladb +".codcampestr="+codcampestr+"]");				
            comhttp.opcoes_retorno.usar_arr_tit=true;
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_dados_campanhas_alterar_container_corpo0_divtab";					
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            },
            {
                arquivo:null,
                funcao:"window.fnsisjd.atualizar_info_campanhas"
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});				
            //requisita tabela de objetivos
            comhttp = JSON.parse(vars.str_tcomhttp);
            //comhttp.opcoes_retorno.ignorar_tabela_est = true;
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4020");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabelasub+"["+ tabelasub +".codcampestr="+codcampestr+"]");				
            comhttp.opcoes_retorno.usar_arr_tit=true;
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_dados_campanhas_alterar_container_corpo1";					
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div.div_dados_campanhas_alterar_container_corpo1").attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttp});
            //requisita tabela de objetivos especificos
            tabelasub = "sjdobjetespeccampestr";
            comhttp = JSON.parse(vars.str_tcomhttp);
            //comhttp.opcoes_retorno.ignorar_tabela_est = true;
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = tabelaest.attr("tabeladb");
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4420");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabelasub+"["+ tabelasub +".codcampestr="+codcampestr+"]");				
            comhttp.opcoes_retorno.usar_arr_tit=true;
            comhttp.opcoes_retorno.seletor_local_retorno="div.div_dados_campanhas_alterar_container_corpo2";					
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div.div_dados_campanhas_alterar_container_corpo2").attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttp});								
            //requisita condicionantes da campanha
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.opcoes_retorno.ignorar_tabela_est = true;
            comhttp.requisicao.requisitar.oque="dados_sql";
            comhttp.requisicao.requisitar.qual.comando = "consultar";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.objeto = tabeladb;
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso=4410");
            comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+tabeladb+"["+ tabeladb +".codcampestr="+codcampestr+"]");				
            fnjs.obterJquery("div.div_dados_campanhas_alterar_container_corpo3").find("div.div_opcoes_corpo").eq(0).addClass(idrand);
            comhttp.opcoes_retorno.usar_arr_tit=true;
            comhttp.opcoes_retorno.seletor_local_retorno="div." + idrand;					
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno'
            }];
            fnjs.obterJquery("div."+idrand).attr("codcampestr",codcampestr);
            fnreq.requisitar_servidor({comhttp:comhttp});		
        }
        console.log("Fim carregar_dados_campanha_alterar");
            fnjs.logf(this.constructor.name,"carregar_dados_campanha_alterar");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    copiar_campanha(params){
        try{
            fnjs.logi(this.constructor.name,"copiar_campanha");
            let linha = {};
            let tabelaest = {};			
            let ind_campo_codcampestr = -1;
            let codcampestr = -1;
            let comhttp = {};
            let idrand = fnjs.id_random();
        params.elemento = fnjs.obterJquery(params.elemento||params.obj);           
        linha = params.elemento.closest("tr");           
        linha.addClass(idrand);
        tabelaest = fnjs.obterJquery(document.body).find("table.tabdados").eq(0);
        ind_campo_codcampestr = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"codcampestr");
        codcampestr = linha.children("td").eq(ind_campo_codcampestr).text();
        comhttp = JSON.parse(vars.str_tcomhttp);
        comhttp.opcoes_retorno.ignorar_tabela_est = true;
        comhttp.requisicao.requisitar.oque="funcoes_sisjd";
        comhttp.requisicao.requisitar.qual.comando = "incluir";
        comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
        comhttp.requisicao.requisitar.qual.objeto = "copiar_campanha";
        comhttp.requisicao.requisitar.qual.condicionantes = [];
        comhttp.requisicao.requisitar.qual.condicionantes.push("codcampestr="+codcampestr);
        comhttp.opcoes_retorno.seletor_local_retorno = "tr." + idrand;
        comhttp.eventos.aposretornar=[{
            arquivo:null,
            funcao:'window.fnhtml.fntabdados.atualizar_dados_linha_copiada'
        }];
        fnreq.requisitar_servidor({comhttp:comhttp});			
            fnjs.logf(this.constructor.name,"copiar_campanha");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    preencher_dados_padrao_linha_campanha(params) {
        try {
            fnjs.logi(this.constructor.name,"preencher_dados_padrao_linha_campanha");
            if (!(typeof vars.visoes !== 'undefined' && vars.visoes !== null && vars.visoes.length)) {
                this.requisitar_visoes({elemento:params.elemento,funcao_retorno:"window.fnsisjd.preencher_dados_padrao_linha_campanha",parametros:params});
                return; 
            }
            params.elemento = fnjs.obterJquery(params.elemento||params.obj||params.comhttp.opcoes_retorno.seletor_local_retorno);
            let linha = params.elemento.closest("tr");
            let tabelaest = linha.closest("table.tabdados");
            let linhatitulos = tabelaest.children("thead").find("tr.linhatitulos");
            let celstit = linhatitulos.children("th");
            let celslin = linha.children("td");
            let opcoes_combobox = {};
            let indcampo = -1;			
            let valor = "";
            indcampo = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtini");
            celslin.eq(indcampo).children("input").attr("aoselecionardia","");
            fnhtml.fncal.transformar_calendario_se_data({elemento:celslin.eq(indcampo).children("input")});
            indcampo = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtfim");
            celslin.eq(indcampo).children("input").attr("aoselecionardia","");
            fnhtml.fncal.transformar_calendario_se_data({elemento:celslin.eq(indcampo).children("input")});
            indcampo = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"visao");			
            if (celslin.eq(indcampo).children("div.div_combobox").length) {
                celslin.eq(indcampo).children("div.div_combobox").find("table.tabdados").eq(0).attr("aoselecionaropcao","");
            } else {
                valor = (celslin.eq(indcampo).children("input[type=text]").eq(0).val()||celslin.eq(indcampo).text()||"").trim().toLowerCase();				
                alert(valor);
                celslin.eq(indcampo).html(this.criar_combobox_visao({selecionados:valor}));
            }
            fnjs.logf(this.constructor.name,"preencher_dados_padrao_linha_campanha");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }					
    }


    salvar_edicao_linha_campanha(params) {
        try{
            fnjs.logi(this.constructor.name,"salvar_edicao_linha_campanha");
            let linha = {},
                idrand = fnjs.id_random();
            params.elemento = fnjs.obterJquery(params.elemento||params.obj);
            linha = params.elemento;
            linha.addClass(idrand);
            params.processar_retorno_como = {
                arquivo:null,
                funcao:"window.fnsisjd.salvar_edicao_linha_campanha_retorno",
                parametros:{idlin:idrand}
            }
            fnhtml.fntabdados.atualizar_dados_sql_padrao(params);				
            fnjs.logf(this.constructor.name,"salvar_edicao_linha_campanha");
        }catch(e){	
            console.log(e);
            alert(e.message || e);
        }					
    }

    salvar_edicao_linha_campanha_retorno(params) {
        try{
            fnjs.logi(this.constructor.name,"salvar_edicao_linha_campanha_retorno");
            let linha = {},
                tabelaest = {},
                indcampodtini = 0,
                indcampodtfim = 0,
                celdtini = {},
                celdtfim = {},
                opcoes_modal = {},
                codcampestr = 0,
                campos = "",
                datas = "";
            linha = fnjs.obterJquery("tr." + params.idlin);
            tabelaest = linha.closest("table.tabdados");
            codcampestr = (linha.children("td").eq(0).children("input").val()||linha.children("td").eq(0).attr("data-valor")||linha.children("td").eq(0).text());
            indcampodtini = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtini");
            indcampodtfim = fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtfim");
            celdtini = linha.children("td").eq(indcampodtini);
            celdtfim = linha.children("td").eq(indcampodtfim);
            fnreq.carregando({
                    texto:'',
                    acao:"esconder",
                    id:(params.comhttp.id_carregando || params.id_carregando || "todos")
            });
            let dtini_valor = celdtini.attr("data-valor");
            let dtfim_valor = celdtfim.attr("data-valor");
            let dtini_novo = (celdtini.children("input").val() || celdtini.text());
            let dtfim_novo = (celdtfim.children("input").val() || celdtfim.text());

            if ((dtini_valor != dtini_novo) || (dtfim_valor != dtfim_novo)) {
                campos = "['dtini','dtfim']";
                datas = "['"+dtini_novo+"','"+dtfim_novo+"']";
                let params_modal = {
                    header:{
                        content:"Replicar Datas?",
                        hasBtnClose:true
                    },
                    body:{
                        content:"Deseja replicar estas datas para os objetivos gerais, objetivos específicos e subcampanhas, desta campanha?"
                    },
                    foot:{
                        hasBtnClose:true,
                        sub:[{
                            tag:"button",
                            class:"btn btn-primary",
                            content:"Aplicar",
                            onclick:"window.fnsisjd.salvar_edicao_linha_campanha_sim("+codcampestr+","+campos+","+datas+")",
                            props:[
                                {
                                    prop:"data-bs-dismiss",
                                    value:"modal"
                                }
                            ]
                        }]
                        
                    }
                }
                fnjs.obterJquery(document.body).append(fnhtml.criar_modal(params_modal));
                let div_modal = fnjs.obterJquery(document.body).children("div.div_modal:last");
                let obj_modal = new bootstrap.Modal(div_modal);
                obj_modal.show();
            }						
            fnjs.logf(this.constructor.name,"salvar_edicao_linha_campanha_retorno");
        }catch(e){	
            console.log(e);
            alert(e.message || e);
        }					
    }

    salvar_edicao_linha_campanha_sim(codcampestr,campos,datas){
        try{
            fnjs.logi(this.constructor.name,"salvar_edicao_linha_campanha_sim");
            let tabelaest = {},
                titulotabelaest = {},
                comhttp = {};
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.opcoes_retorno.ignorar_tabela_est = true;
            comhttp.requisicao.requisitar.oque="funcoes_erp";
            comhttp.requisicao.requisitar.qual.comando = "atualizar_dt_campanha";
            comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela";
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push("codcampestr=" + codcampestr);
            comhttp.requisicao.requisitar.qual.condicionantes.push("campo=" + campos.join(","));
            comhttp.requisicao.requisitar.qual.condicionantes.push("data=" + datas.join(","));
            comhttp.opcoes_retorno.metodo_insersao = "html";			
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:"window.fnsisjd.atualizou_campanha",
                parametros:{codcampestr:codcampestr}
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});							
            fnjs.logf(this.constructor.name,"salvar_edicao_linha_campanha_sim");
        }catch(e){	
            console.log(e);
            alert(e.message || e);
        }					
    }

    atualizou_campanha(params) {
        try {
            fnjs.logi(this.constructor.name,"atualizou_campanha");
            let div_container = fnjs.obterJquery("div.div_dados_campanha_alterar"),
                idlinhacampanha = "";
            fnreq.carregando({
                    texto:'',
                    acao:"esconder",
                    id:"todos"
            });		
            alert(params.comhttp.retorno.dados_retornados.conteudo_html.mensagem);
            fnreq.carregando({
                    texto:'',
                    acao:"esconder",
                    id:"todos"
            });				
            idlinhacampanha = div_container.attr("idlinhacampanha");
            fnjs.obterJquery("tr." + idlinhacampanha).click();
            fnjs.logf(this.constructor.name,"atualizou_campanha");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    preencher_dados_padrao_linha_objetivos_campanha(params) {
		try {
			console.log("Inicio preencher_dados_padrao_linha_objetivos_campanha");
			if (typeof window.vars.sjd.visoes === 'undefined' || window.vars.sjd.visoes.length === 0) {
				requisitar_visoes({
                    elemento:params.elemento,
                    funcao_retorno:"window.fnsisjd.preencher_dados_padrao_linha_objetivos_campanha",
                    parametros:params
                });
				return; 
			}
			params.elemento = $(params.elemento||params.obj||params.comhttp.opcoes_retorno.seletor_local_retorno);
			
			let linha = params.elemento.closest("tr");
			let tabelaest = linha.closest("table.tabdados");
			let linhatitulos = tabelaest.children("thead").find("tr.linhatitulos");
			let celstit = linhatitulos.children("th");
			let celslin = linha.children("td");
			let opcoes_combobox = {};
			let indcampo = -1;			
			let valor = "";

			indcampo = window.fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtini");
			celslin.eq(indcampo).children("input").attr("aoselecionardia","");
			window.fnhtml.fncal.transformar_calendario_se_data({elemento:celslin.eq(indcampo).children("input")});
			indcampo = window.fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"dtfim");
			celslin.eq(indcampo).children("input").attr("aoselecionardia","");
			window.fnhtml.fncal.transformar_calendario_se_data({elemento:celslin.eq(indcampo).children("input")});
			indcampo = window.fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"visao");			
			if (celslin.eq(indcampo).children("div.div_combobox").length) {
				celslin.eq(indcampo).children("div.div_combobox").find("table.tabdados").eq(0).attr("aoselecionaropcao","");
			} else {
				opcoes_combobox = {};			
				opcoes_combobox.opcoes_texto_opcao = window.vars.sjd.visoes;
				opcoes_combobox.selecionados = [];			
				opcoes_combobox.tipo = "radio";
				opcoes_combobox.multiplo = "nao";
				opcoes_combobox.selecionar_todos = "nao";
				opcoes_combobox.filtro = "nao";
				valor = (celslin.eq(indcampo).children("input[type=text]").eq(0).val()||celslin.eq(indcampo).text()||"").trim().toLowerCase();
				if (valor.length > 0) {
					opcoes_combobox.selecionados.push(window.vars.sjd.visoes.join(",").trim().toLowerCase().split(",").indexOf(valor));
				}
 			celslin.eq(indcampo).html(window.fnhtml.fncomboboxs.montar_combobox(opcoes_combobox));
			}
			indcampo = window.fnhtml.fntabdados.obter_indice_campo_db(tabelaest,"unidade");			
			if (celslin.eq(indcampo).children("div.div_combobox").length) {
				celslin.eq(indcampo).children("div.div_combobox").find("table.tabdados").eq(0).attr("aoselecionaropcao","");
			} else {
				opcoes_combobox = {};			
				opcoes_combobox.opcoes_texto_opcao = ["r$","kg","mix"];
				opcoes_combobox.selecionados = [];
				opcoes_combobox.tipo = "radio";
				opcoes_combobox.multiplo = "nao";
				opcoes_combobox.selecionar_todos = "nao";
				opcoes_combobox.filtro = "nao";
				valor = (celslin.eq(indcampo).children("input[type=text]").eq(0).val()||celslin.eq(indcampo).text()||"").trim().toLowerCase();
				if (valor.length > 0) {
					opcoes_combobox.selecionados.push(opcoes_combobox.opcoes_texto_opcao.indexOf(valor));
				}
				celslin.eq(indcampo).html(window.fnhtml.fncomboboxs.montar_combobox(opcoes_combobox));
			}
 		}catch(e){
 			console.log(e);
 			alert(e.message || e);
		}					
	}

    salvar_condicionantes(obj){
        try{
            console.log("Inicio salvar_condicionantes");
           let div_condicionantes = {};
           let divs_condicionantes = {};
           let divs_operacoes = {};
           let comhttp = {};
           let cont_erros = 0;
           let condicionantes = [];
           let operacoes = [];
           let opcoes = [];
           let erros_preenchimento = [];
           let codcampestr = -1;
           obj = $(obj);
           div_condicionantes = obj.closest("div.div_condicionantes");
            divs_condicionantes = div_condicionantes.find('div.div_combobox');	
           divs_operacoes = divs_condicionantes.filter('div.operacao');
            divs_condicionantes = divs_condicionantes.filter('div.condicionante');			
            if(div_condicionantes.find('.condicionante[value="' + ''+'"]').length){
                erros_preenchimento[ cont_erros ] = "Ha condicionantes sem valores escolhidos (=(Selecione)). \n"+
                       "Verifique e escolha ao menos um valor para a condicionante ou exclua-a." ;
                cont_erros ++ ;
            }
            $.each(divs_condicionantes,function(index,element){
                condicionantes.push(window.fnsisjd.pegar_valores_elementos(divs_condicionantes.eq(index)).toString().replace(/,/g,window.vars.sepn2));
                if(condicionantes[condicionantes.length-1].trim().length===0){
                    erros_preenchimento[ cont_erros ] = "Ha condicionantes sem valores escolhidos. \n"+
                           "Verifique e escolha ao menos um valor para a condicionante ou exclua-a." ;
                    cont_erros ++ ;
                    return false;
                }
            });
            if(cont_erros > 0){
                alert( "Por favor, verifique os seguintes erros de preenchimento:\n\n"+
                      erros_preenchimento.join( "\n \n " ) ) ;
                return false;
            }			
            operacoes=window.fnsisjd.pegar_valores_elementos(divs_operacoes);			
            $(condicionantes).each(function(index){
                if(operacoes[index]==="Diferente de"){
                    condicionantes[index]=condicionantes[index].toString().replace(/=/g,"!=");
                }
            });
            condicionantes = condicionantes.join(window.vars.sepn1).replace(/,/g,window.vars.subst_virg);
           codcampestr = div_condicionantes.find("div.div_opcoes_corpo").attr("codcampestr");
           opcoes = {};
           opcoes.tabela = "sjdcampestr";
           opcoes.campos = "condicionantes";
           opcoes.valores = condicionantes;
           opcoes.condicionantes = "codcampestr=" + codcampestr;
           window.fnreq.atualizar_dados_sql({opcoes:opcoes});
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    carregar_dados_processo(params) {
        try {
            fnjs.logi(this.constructor.name,"carregar_dados_processo");
            let comhttp = null;            
            if (typeof params !== "undefined" && params !== null) {
                if (["string","number","numeric","integer"].indexOf(typeof params) > -1) {
                    params = {
                        codprocesso:params
                    };
                } 
                if (typeof params.codprocesso !== "undefined" && params.codprocesso !== null) {
                    params.seletor_local_retorno = fnjs.first_valid([params.seletor_local_retorno,"body"]);
                    params.metodo_insersao = fnjs.first_valid([params.metodo_insersao,"html"]);
                    params.usar_arr_tit = fnjs.first_valid([params.usar_arr_tit,true]);
                    comhttp = JSON.parse(vars.str_tcomhttp);
                    comhttp.requisicao.requisitar.oque="dados_sql";
                    comhttp.requisicao.requisitar.qual.comando = "consultar";
                    comhttp.requisicao.requisitar.qual.tipo_objeto = "tabela_est";			
                    comhttp.requisicao.requisitar.qual.condicionantes = [];
                    comhttp.requisicao.requisitar.qual.condicionantes.push("codprocesso="+params.codprocesso);
                    if (typeof params.condicionantestab !== "undefined" && params.condicionantestab !== null && params.condicionantestab.length) {
                        comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantestab="+params.condicionantestab);
                    }
                    comhttp.opcoes_retorno.seletor_local_retorno=params.seletor_local_retorno;            
                    comhttp.opcoes_retorno.usar_arr_tit=params.usar_arr_tit;
                    comhttp.opcoes_retorno.metodo_insersao = params.metodo_insersao;	
                    comhttp.eventos.aposretornar=[{
                        arquivo:null,
                        funcao:'window.fnreq.inserir_retorno'
                    }];
                    fnreq.requisitar_servidor({comhttp:comhttp});
                } else {
                    console.log('params.codprocesso nulo ou em branco')
                }
            } else {
                console.log('params nulo');
            }
            fnjs.logf(this.constructor.name,"carregar_dados_processo");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }

    selecionou_mes_inicio(params){
        params = params || {};
        params.elemento = params.elemento || params.obj || params;
        let mes = fnhtml.fncomboboxs.obter_valores_selecionados_combobox(params.elemento);
        fnsisjd.requisitar_valores_inicio({
            mes:mes
        });
    }

    imprimir_conteudo_elemento(el) {
		try {
			var imprimir = "",
				rca = "",
				totalpremiavel = 0,
				totalatingido = 0,
				popupImprimir = window.open('/sjd/html/imprimir.html','_blank');
			rca = window.fnhtml.fncomboboxs.obter_valores_selecionados_combobox($("div.div_dados_campanhas_consultar_container_corpo3").find("div.div_combobox.condicionante"),"linha");
			let rca_rel = [];
			for ( var i = 0 ; i < rca.length; i++) {
				if (rca[i].attr("data-valor_opcao").indexOf("215") > -1) {
					rca_rel = rca[i];
				}
			}
			if (rca_rel.length === 0) {
				rca_rel = rca[0];
			}
			totalpremiavel = $("div.div_dados_campanhas_consultar_container_corpo0_divtab")
                .find("table.tabdados").eq(0).children("tbody")
                .children("tr:not(.linha_padrao)").eq(0).children("td").eq(6).text();
			totalatingido = $("div.div_dados_campanhas_consultar_container_corpo0_divtab")
                .find("table.tabdados").eq(0).children("tbody").
                children("tr:not(.linha_padrao)").eq(0).children("td").eq(7).text();
			imprimir = el.innerHTML;
			imprimir = '<h2>Campanha referente ao período de ' 
                + $(el).find('td').eq(3).text() + ' a ' + $(el).find('td').eq(4).text() 
                + '</h2><h4>Rca: ' + rca_rel.children("label").text() + '</h4><h3>Capanha Principal: </h3>'+imprimir;
			imprimir += '<table class="tab_totais_relatorio_campanha"><caption>Totais</caption><body><tr><td>Total Premiável:</td><td class="cel_valor">'
                +totalpremiavel+'</td><td>Total Atingido:</td><td class="cel_valor">'
                +totalatingido+'</td><td>Total a Pagar:</td><td class="cel_valor">'
                +totalatingido+'</td></tr></tdoby></table>';			
			if (window.vars.navegador === "iexplorer") {
				popupImprimir.document.write('<html><head><meta charset="utf-8"><title>SisJD-Jumbo Distribuidor-Imprimir</title><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/estilos.css?12.21"/><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/estilos_basicos.css?12.23"/><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/login.css?12.1"/><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/barra_sup.css?12" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/menu_esquerdo.css?12" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/combobox.css?12.1" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/calendario.css?12.1" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/tabela_est.css?12.4" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/input_combobox.css?12" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSISBU__+'/css/abas.css?12" /><link rel="stylesheet" type="text/css" href="/'+__NOMEDIRSIS__+'/css/sisjd.css?12.7" /><script type="text/javascript" src="/'+__NOMEDIRSISBU__+'/javascript/arquivos_de_terceiros/jquery-3.3.1.min.js?12.33" charset="UTF-8"></script></head><body>');
				popupImprimir.document.write(imprimir);
				popupImprimir.document.write('</body></html>');
				$(popupImprimir.document.body).find("button").remove();
                $(popupImprimir.document.body).find("img").remove();
                $(popupImprimir.document.body).find(".naomostrar").remove();
				$(popupImprimir.document.body).find("thead").find("tr.linhacomandos").remove();
                $(popupImprimir.document.body).find("thead").find("tr.linhafiltros").remove();
				$(popupImprimir.document.body).find("h3").nextAll("br").eq(0).remove();
				$(popupImprimir.document.body).find("br").next("br").remove();
				$(popupImprimir.document.body).append('<br /><text style="font-size:1.2em;font-weight: bold;">_________________________________________,______ de ___________________ de __________ .</text><br /></br /><br /></br /><br /><text style="font-size:15px;font-weight: bold;">________________________________________________</text><br /><text style="font-size:1.2em;font-weight: bold;">'+rca[0].children("td").eq(1).text()+'</text>');			
				$(popupImprimir.document.body).append('<script type="text/javascript">document.execCommand("print", false, null); window.close();</script>');
			} else {
				popupImprimir.onload = function(){			
					popupImprimir.document.body.innerHTML = imprimir;
					$(popupImprimir.document.body).find("button").remove();
                    $(popupImprimir.document.body).find("img").remove();
                    $(popupImprimir.document.body).find(".naomostrar").remove();
                    $(popupImprimir.document.body).find(".cel_quant,.celperc").css("text-align","right");
					$(popupImprimir.document.body).find("thead").find("tr.linhacomandos").remove();
                    $(popupImprimir.document.body).find("thead").find("tr.linhafiltros").remove();
					$(popupImprimir.document.body).find("h3").nextAll("br").eq(0).remove();
					$(popupImprimir.document.body).find("br").next("br").remove();
					$(popupImprimir.document.body).append('<br /><text style="font-size:1.2em;font-weight: bold;">_________________________________________,______ de ___________________ de __________ .</text><br /></br /><br /></br /><br /><text style="font-size:15px;font-weight: bold;">________________________________________________</text><br /><text style="font-size:1.2em;font-weight: bold;">'+rca[0].children("td").eq(1).text()+'</text>');								
                    $(popupImprimir.document.body).append('<link rel="stylesheet" type="text/css" href="/sjd/css/estilos.css?12.7" />');
                    $(popupImprimir.document.body).append('<script type="text/javascript" src="/js/jquery/3.6.0/jquery-3.6.0.min.js?12.33" charset="UTF-8"></script>');
                    $(popupImprimir.document.body).append('<style>table.tabdados>tfoot{color:black !important;}</style>');
                    popupImprimir.print();
					popupImprimir.close();
 			};
 		}
 		}catch(e){
 			console.log(e);
 			alert(e.message || e);
 		}			
 	}


    /**
	 * obtem ou cria uma div class=row contida em parent conforme o indice passado (index)
	 * @param {object} parent - o elemento html que contem ou vai conter a row
	 * @param {integer} ind - o indice (index) do elemento html row procurada ou a ser criada se nao existir
	 * @returns {object} - a div row encontrada ou criada
	 */
     get_row_form_ind(parent,ind){
        let class_rand = "_" + Math.random().toString().replace(".","_");
        try {			
            parent.classList.add(class_rand);
            let row = parent.parentNode.querySelectorAll(parent.tagName.toLowerCase() + "." + class_rand+">div.row");
            if (fnjs.typeof(row) === "undefined" || row === null 
                || (fnjs.typeof(row) === "array" && (!row.length || !(ind in row)))) {
                row = window.fnhtml.criar_elemento({tag:"div",class:"row"});
                parent.insertAdjacentHTML("beforeend",row);
                row = parent.lastElementChild;
            } else {
                row = row[ind];					
            }
            parent.classList.remove(class_rand);
            return row;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }

     /**
	 * cria um fieldset colapsavel (tipo gavega abre-fecha) para comprimir informações
	 * @param {object} params - o objeto contendo os parametros para criacao
	 * @created 04/05/2021
	 */
	criar_filtro_collapsavel(params) {
		try {
			let retorno = '';
			let idrand = '_' + window.fnjs.id_random();			
			retorno += '<fieldset class="fieldset_collapse border w-100 m-2">';				
				retorno += '<legend>';
					retorno += '<a data-bs-toggle="collapse" href="#'+idrand+'">';
						retorno += params.title;	
					retorno += '</a>';
				retorno += '</legend>';
				retorno += '<div id="'+idrand+'" class="panel-collapse collapse m-2">';					
				retorno += '</div>';
			retorno += '</fieldset>';
			params.parent.insertAdjacentHTML("beforeend",retorno);
			params.parent = params.parent.querySelector("#" + idrand);
			retorno += fnsisjd.criar_filtros(params);
		} catch(e) {
			console.log(e);
			alert(e.message||e);
	 	}
	}

     /**
	 * cria os elementos html dos filtros, conforme parametros
	 * @param {object} params - objeto contendo os parametros 
	 * @created 04/05/2021 
	 */
	criar_filtros(params) {
		try {
			params.source_object = params.source_object || {};
			params.filters = params.filters || params.source_object.filters || [];
			let q = params.filters.length;
			let ind_row = -1;            
			for(let i =0; i < q; i++) {
				let filtro = params.filters[i];
				ind_row = window.fnjs.first_valid([filtro.row,(ind_row + 1)]);
				let row = fnsisjd.get_row_form_ind(params.parent,ind_row);				
				if ((filtro.collapsable || false) === true) {
					filtro.parent = row;
					filtro = fnsisjd.criar_filtro_collapsavel(filtro);
				} else {
					filtro = window.fnhtml.btstrp.forms.criar_form_group_input(filtro);	
					row.insertAdjacentHTML("beforeend",filtro);
				}				
			}

			params.buttons = params.buttons || params.source_object.buttons ||  [];
			q = params.buttons.length;
			let button = null;
			for(let i =0; i < q; i++) {
				button = params.buttons[i];
				ind_row = window.fnjs.first_valid([button.row,(ind_row + 1)]);
				let row = fnsisjd.get_row_form_ind(params.parent,ind_row);				
				window.fnhtml.atribuir_classe(button,"btn-primary");
				button = window.fnhtml.btstrp.forms.create_button(button);
				row.insertAdjacentHTML("beforeend",button);
			}

		} catch(e) {
			console.log(e);
			alert(e.message||e);
	 	}
	}

     /**
	 * cria o html dos filtros que compoem a pesquisa baseado nos parametros passados
	 * @param {object} params - o objeto de parametros esperados para a funcao
	 * @created 04/05/2021
	 */
	criar_filtro_pesquisa_padrao(params){
		try {
			let barra_nav = null,
				div_conteudo = null,
				fieldset_filtros = null,
				row = null,
				col = null,
				filtro = null,
				form = null;
                

			/*obtem o objeto de origem que foi armazenado o seletor no cache e é o objeto que originou a abertura da janela*/
			if (typeof window.objeto_origem === "undefined" || window.objeto_origem === null)  {
				let seletor_objeto_origem = localStorage.getItem("seletor_objeto_origem");
				if (typeof seletor_objeto_origem !== "undefined" && seletor_objeto_origem !== null 
					&& seletor_objeto_origem.length && typeof window.opener !== "undefined" && window.opener !== null){
					window.objeto_origem = window.opener.window.document.querySelector(seletor_objeto_origem);				
				}
			}

			/*carrega o arquivo que contem o objeto com os dados padrao de filtros */
			/*if (typeof vars.dados_filtros === "undefined") {
				window.fnarq.carregar_arquivo_js(sjd.nomes_caminhos_arquivos.dados_para_filtros);
			}*/

			/*caso nao venha os filtros ja setados, pode vir somente o nivel e a entidade, que sao membros do objeto vars.dados_filtros.filtros */
			params = params || {};
			params.nivel = params.nivel || "basico";
			params.entity = params.entity || null;
			params.source_object = params.source_object || ((vars.dados_filtros.filtros||{})[params.nivel]||{})[params.entity] || {};

			/*seta o titulo da pagina e da nav superior*/
			params.title = params.title || params.source_object.title || "Pesquisar (Titulo)";
			window.document.title = params.title;
			barra_nav = $("nav.barra_sup");
			if (barra_nav.length) {
				barra_nav.text(params.title);
			}

			div_conteudo = document.querySelector("div.div_conteudo_pagina>div:first-child");
			if (typeof div_conteudo === "undefined" || div_conteudo === null) {
				div_conteudo = document.querySelector("div.div_conteudo_pagina");
			}

			/*cria o form, submit false para nao recarregar a pagina ao submeter*/
			form = window.fnhtml.criar_elemento({
				tag:"form",
                class:"form m-2",
				props:[
					{
						prop:"onsubmit",
						value:"return false;"
					}
				]
			});
			div_conteudo.insertAdjacentHTML("beforeend",form);
			form = div_conteudo.lastElementChild;	

			/*cria o fieldset filtros*/			
			fieldset_filtros = window.fnhtml.criar_elemento({tag:"fieldset",class:"fieldset_filtros border p-2"});	
			form.insertAdjacentHTML("beforeend",fieldset_filtros);
			fieldset_filtros = form.lastElementChild;			
			fieldset_filtros.setAttribute("nivel",params.nivel);
			fieldset_filtros.setAttribute("entity",params.entity);
			fieldset_filtros.insertAdjacentHTML("beforeend",window.fnhtml.criar_elemento({tag:"legend",content:"Filtros"}));

			/*cria os filtros*/			
			params.parent = fieldset_filtros;
			fnsisjd.criar_filtros(params);
		} catch(e) {
			console.log(e);
			alert(e.message || e);
	 	}					
	}



    /**
	 * abre uma nova janela de pesquisa conforme dados do objeto clicado
	 * @param {object} obj - o objeto que foi clicado para abrir a pesquisa
	 * @created 04/05/2021
	 */
	abrir_pesquisa_padrao(obj) {
		try {			
			/*salva no cache o seletor para o objeto dom que originou a abertura da pesquisa, a fim de encontrar o input de retorno*/
			let idrand = '_' + window.fnjs.id_random();			
			obj.classList.add(idrand);
			let seletor_objeto_origem = obj.tagName.trim().toLowerCase() + "." + idrand;
			localStorage.setItem("seletor_objeto_origem",seletor_objeto_origem);		
			/*abre a janela da pesquisa*/
			window.fnsisjd.abrir_opcao_sistema({nomeops:obj.getAttribute("nomeops")});
		} catch(e) {
			console.log(e);
			alert(e.message||e);
	 	}					
	}

	/**
	 * efetua pesquisa baseado nos filtros informados
	 * @param {object} params - o objeto clicado para pesquisar
	 * @created 04/05/2021
	 */
	pesquisar_filtro_padrao(params){
		try {
            params = params || {};
            params.elemento = params.elemento || params.element || params.elem || params;
            params.relatorio = params.relatorio || "";
            params.entidade = params.entidade || "";
            params.nivel = params.nivel || "basico";

			let div_conteudo = document.querySelector("div.div_conteudo_pagina>div:first-child");
			if (typeof div_conteudo === "undefined" || div_conteudo === null) {
				div_conteudo = document.querySelector("div.div_conteudo_pagina");
			}
			let inputs = div_conteudo.querySelectorAll("input[type=text],input[type=number]");
			let fieldset_filtros = document.querySelector("fieldset.fieldset_filtros");
			let div_resultado = $(fieldset_filtros).closest("form")[0].nextSibling;
			let condicionantes = [];

			let nivel = params.nivel;
			let entity = params.entidade;
            

			/*cria a div_resultado, se ainda nao existir na pagina, assim como a barra inferior, com o botao OK*/
			if (typeof div_resultado === "unedefined" || div_resultado === null) {
				$(obj).closest("form")[0].insertAdjacentHTML('afterend','<div class="div_resultado m-3" style="margin-bottom:100px !important;"></div>');
				div_resultado = $(obj).closest("form")[0].nextSibling;
				div_resultado.insertAdjacentHTML('afterend','<div class="row d-block bg-dark w-100 p-2 m-2 div_barra_inf_filtro"><div class="col"><button class="btn btn-primary w-25" onclick="window.fnsisjd.finalizar_pesquisa(this)">OK</button></div></div>');
			}

			/*percorre os inputs montando as condicionantes de pesquisa*/
			if (typeof inputs !== "undefined" && inputs !== null) {
				let qt_inputs = inputs.length;
				let form_group = null;
				let campo = null;
				let select_criterio = null;
				let criterio_selecionado = null;
				let valores = null;
				let condicionantes_multiplas = null;
				let operacao = null;
				let juncao = null;
				let prefixo = '';
				let posfixo = '';
				if (qt_inputs > 0) {					
					for(let i = 0 ; i < qt_inputs; i++) {
						if (inputs[i].value.trim().length) {
							form_group = $(inputs[i]).closest("div.form-group");
							campo = form_group.attr("campo");
							if (typeof campo !== "undefined" && campo !== null && campo.length) {
								vars.dados_filtros.filtros[nivel][entity].expressoes = vars.dados_filtros.filtros[nivel][entity].expressoes || {};
                                console.log(nivel,entity,campo,vars.dados_filtros.filtros);
                                console.log(vars.dados_filtros.filtros[nivel]);
                                console.log(vars.dados_filtros.filtros[nivel][entity]);
                                console.log(vars.dados_filtros.filtros[nivel][entity].expressoes);
                                console.log(vars.dados_filtros.filtros[nivel][entity].expressoes[campo]);
								let expressao = vars.dados_filtros.filtros[nivel][entity].expressoes[campo] || 'lower(' + campo + ')' + " __OP__ __VALUE__";
								if (typeof expressao !== "undefined" && expressao !== null && expressao.length) {
									select_criterio = form_group.find("select");
									if (typeof select_criterio !== "undefined" && select_criterio !== null && select_criterio.length) {
										criterio_selecionado = select_criterio.children("option:selected");
										if (typeof criterio_selecionado !== "undefined" && criterio_selecionado !== null && criterio_selecionado.length) {
											criterio_selecionado = criterio_selecionado.text().trim().toLowerCase();
											juncao = " or ";
											operacao = " in ";
											prefixo = "";
													posfixo = "";
											switch(criterio_selecionado) {
												case "contém": case "contem":
													operacao = " like ";
													prefixo = "%";
													posfixo = "%";
													break;
												case "não contém": case "nao contem":
													operacao = " not like ";
													juncao = " and "
													prefixo = "%";
													posfixo = "%";
													break;
												case "exato": case "igual":
													prefixo = "";
													posfixo = "";
													break;
												case "diferente de": case "diferente":
													operacao = " not in "
													prefixo = "";
													posfixo = "";
													break;
												case "começa com": case "comeca com":
													operacao = " like "
													prefixo = "";
													posfixo = "%";
													break;
												case "termina com": 
													operacao = " like "
													prefixo = "%";
													posfixo = "";
													break;
												default:
													throw "criterio filtro nao esperado: " + criterio_selecionado;
													break;
											}
											valores = inputs[i].value.trim().toLowerCase().split(",");
											condicionantes_multiplas = [];											
											for(let j = 0; j < valores.length; j++) {
												condicionantes_multiplas.push(
													expressao
														.replace(/__OP__/g,operacao)
														.replace(/__JUNCAO__/g,juncao)
														.replace(/__VALUE__/g,"'"+prefixo + valores[j] + posfixo + "'"));
											}
											if (condicionantes_multiplas.length) {
												condicionantes.push("(" + condicionantes_multiplas.join(juncao) + ")");
											}
										}
									} else {
										if (["text","date"].indexOf(inputs[i].getAttribute("type")) > -1) {
											prefixo = "'";
											posfixo = "'";
										}
										valores = inputs[i].value.trim().toLowerCase().split(",");
										condicionantes.push(expressao.replace(/__OP__/g,' in ').replace(/__VALUE__/g,"(" + prefixo + valores.join(prefixo + "," + posfixo) + posfixo + ")"));
									}									
								}
							}
						}
					}
				}
			}

			/*gera o json da requisicao http e envia*/
			let comhttp = JSON.parse(window.vars.str_tcomhttp);
			comhttp.opcoes_retorno.ignorar_tabela_est = true;
			comhttp.requisicao.requisitar.oque="dados_sql";
			comhttp.requisicao.requisitar.qual.comando = "consultar";
			comhttp.requisicao.requisitar.qual.tipo_objeto = "pesquisa";
			comhttp.requisicao.requisitar.qual.objeto = params.relatorio;
			comhttp.requisicao.requisitar.qual.condicionantes = [];
			if (condicionantes.length) {
				comhttp.requisicao.requisitar.qual.condicionantes.push("condicionantes=" + condicionantes.join(window.vars.sepn1));
			}
			comhttp.opcoes_retorno.seletor_local_retorno=div_resultado;					
			comhttp.opcoes_retorno.metodo_insersao = "html";			
			comhttp.eventos.aposretornar=[{
				arquivo:null,
				funcao:'window.fnreq.inserir_dados_retorno_como_tabela'
			}];
			window.fnreq.requisitar_servidor({comhttp:comhttp});
		} catch(e) {
			console.log(e);
			alert(e.message||e);
	 	}
	}	


	fechar_subpesquisa(obj) {
		obj.close();
		window.focus();
	}

	/**
	 * fecha a janela de pesquisa e retorna os valores selecionados da tabela resultante para o input de origem
	 * que abriu a pesquisa
	 * @param {object} obj - o botao de encerrar a janela de pesquisa (geralmente 'OK')
	 * @created 03/05/2021
	 * @todo implementar opcao de configuracao na criacao do filtro de forma que a pesquisa seja retornada para
	 * 		 a sua janela anterior (ja está assim) ou que execute uma funcao (eval(funcao)) com os dados selecionados,
	 * 		 por exemplo: mostrar dados detalhados de um cliente numa nova janela
	 */
	finalizar_pesquisa(obj){
		try {
			obj = $(obj);			
			let div_barra_inf = obj.closest("div.div_barra_inf_filtro");
			let div_resultado = div_barra_inf.prev("div.div_resultado");
			let tabela_resultado = div_resultado.children("table");
			let corpo_resultado = tabela_resultado.children("tbody");
			let linhas_resultado = corpo_resultado.children("tr");
			let qt = linhas_resultado.length;
			let arr_selecionados = [];
			for(let i = 0; i < qt; i++) {
				if (linhas_resultado.eq(i).children("td:nth-child(1)").children("input:checked").length) {
					arr_selecionados.push(linhas_resultado.eq(i).children("td:nth-child(2)").text());
				}
			}
			let input_target = window.objeto_origem.previousSibling;
			input_target.value = arr_selecionados.join(",");
			setTimeout(window.opener.window.fnsisjd.fechar_subpesquisa,50,window);			
		} catch(e) {
			console.log(e);
			alert(e.message||e);
	 	}
	}


};

var fnsisjd = new FuncoesSisJD();

window.fnsisjd = fnsisjd;

export { fnsisjd };