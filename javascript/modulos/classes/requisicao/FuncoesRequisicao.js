import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';
import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';
import { fnstr } from '/sjd/javascript/modulos/classes/string/FuncoesString.js';
import { fnarq } from '/sjd/javascript/modulos/classes/arquivo/FuncoesArquivo.js';
import { fnhtml } from '/sjd/javascript/modulos/classes/html/FuncoesHtml.js';


/**Classe FuncoesRequisicao - utilizadas de requisicao */
class FuncoesRequisicao{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.nomes_variaveis = {
                FuncoesRequisicao : "FuncoesRequisicao"
            };
            this.nomes_variaveis.fnreq_pt = this.nomes_variaveis.FuncoesRequisicao + '.';
            this.nomes_funcoes = {
                abortar_requisicoes_em_andamento : "abortar_requisicoes_em_andamento",
                atualizar_dados_sql : "atualizar_dados_sql",
                carregando : "carregando",
                excluir_dados_inexistentes : "excluir_dados_inexistentes",
                excluir_dados_sql : "excluir_dados_sql",
                incluir_inicio : "incluir_inicio",
                incluir_sjdreq : "incluir_sjdreq",
                ins_lin : "ins_lin",
                ins_lin_concat : "ins_lin_concat",
                incluir_dados_sql : "incluir_dados_sql",
                inserir_linha : "inserir_linha",
                inserir_linha_concatenadas : "inserir_linha_concatenadas",
                inserir_linhas : "inserir_linhas",
                inserir_dados_retorno_como_tabela : "inserir_dados_retorno_como_tabela",
                inserir_retorno : "inserir_retorno",
                inserir_retorno_como_menu_suspenso : "inserir_retorno_como_menu_suspenso",
                inserir_retorno_com_tabelaest : "inserir_retorno_com_tabelaest",
                mostrar_erros_servidor : "mostrar_erros_servidor",
                mostrar_log_servidor : "mostrar_log_servidor",
                processar_retorno_como_msg : "processar_retorno_como_msg",
                processar_retorno_como_mensagem : "processar_retorno_como_mensagem",
                processar_retorno_em_silencio : "processar_retorno_em_silencio",
                procurar_sjdreq: "procurar_sjdreq",
                receber_dados : "receber_dados",
                requisitar_inicio : "requisitar_inicio",
                requisitar_servidor : "requisitar_servidor"
            };
            this.nomes_completos_funcoes = {                    
                abortar_requisicoes_em_andamento : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.abortar_requisicoes_em_andamento,
                atualizar_dados_sql : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.atualizar_dados_sql,
                carregando : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.carregando,
                excluir_dados_inexistentes : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.excluir_dados_inexistentes,
                excluir_dados_sql : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.excluir_dados_sql,
                incluir_inicio : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.incluir_inicio,
                incluir_sjdreq : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.incluir_sjdreq,
                ins_lin : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.ins_lin,
                ins_lin_concat : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.ins_lin_concat,
                incluir_dados_sql : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.incluir_dados_sql,
                inserir_linha : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_linha,
                inserir_linha_concatenadas : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_linha_concatenadas,
                inserir_linhas : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_linhas,
                inserir_dados_retorno_como_tabela : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_dados_retorno_como_tabela,
                inserir_retorno : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_retorno,                
                inserir_dados_retorno_como_tabela : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_dados_retorno_como_tabela,
                inserir_retorno_como_menu_suspenso : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_retorno_como_menu_suspenso,
                inserir_retorno_com_tabelaest : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.inserir_retorno_com_tabelaest,
                mostrar_erros_servidor : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.mostrar_erros_servidor,
                mostrar_log_servidor : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.mostrar_log_servidor,
                processar_retorno_em_silencio : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.processar_retorno_em_silencio,
                processar_retorno_como_msg : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.processar_retorno_como_msg,
                processar_retorno_como_mensagem : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.processar_retorno_como_mensagem,
                procurar_sjdreq : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.procurar_sjdreq,
                receber_dados : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.receber_dados,
                requisitar_inicio : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.requisitar_inicio,
                requisitar_servidor : this.nomes_variaveis.fnreq_pt + this.nomes_funcoes.requisitar_servidor
            };
            this.seletores = {
                img_btn_home : "img.img_btn_home",
                img_btn_menu_esquerdo : "img.img_btn_menu_esquerdo",
                img_btn_home_rodape_barra : "img.img_btn_home_rodape_barra",
                img_btn_home_rodape : "img.img_btn_home_rodape"
            };
            this.propriedades_html = {
                id_dados : "id_dados"
            };
            this.mensagens = {
                erro_abortando : "abortando recebimento, requisicao cancelada: ",
                erro_inclusao_tab : "Houve um erro com a inlusao da tabela, verifique no log a marcacao html de tags",
                erros_servidor : "Houveram erros no servidor",
                erro_tipo_dados_ret : "tipo de dados de processar_retorno_como nao esperado: ",
                erro_tipo_func_ret : "tipo do parametro 'funcoes_apos_retonar' incorreto, esperado array de objetos [{arquivo:,funcao:},..]",
                erro_tipo_req : "tipo de requisicao nao e objeto: ",
                inserindo_linha_num : "inserindo linha nr. ",
                processamento_continua : "Processamento vai continuar.",
                proc_finalizado_erros : ", o processo foi finalizado, mas ouveram erros.",
                requisitando_a : "requisitando a : " ,
                requisitando_dados_aguarde : ", estou requisitando dados, aguarde",
                resultado_nao_definido : "resultado nao definido no retorno: ",
                sem_arquivos_adicionais : "Nao ha arquivos adicionais a carregar para tratar o retorno",
                sem_erros_servidor : "Nao houveram erros no servidor",
                tipo_req_nao_implementado : "tipo de requisicao nao implementado: "
            };
            this.titles = {
                voltar_inicio : "Voltar ao Inicio"
            };                
            if (typeof vars.reqs !== 'object') {
                vars.reqs = {};
                vars.reqs.requisicoes = [];
            }
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };            

    procurar_sjdreq(params) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"procurar_sjdreq");
            let retorno = [];			
            if (typeof params.id !== "undefined") {
                for (let i = 0; i < vars.reqs.requisicoes.length; i++) {
                    if (vars.reqs.requisicoes[i].id.trim().toLowerCase() === params.id.trim().toLowerCase()) {
                        retorno.push(vars.reqs.requisicoes[i]);
                    }
                }				
            }
            if (typeof params.status !== "undefined") {
                for (let i = 0; i < vars.reqs.requisicoes.length; i++) {
                    if (vars.reqs.requisicoes[i].status.trim().toLowerCase() === params.status.trim().toLowerCase()) {
                        retorno.push(vars.reqs.requisicoes[i]);
                    }
                }
            }
            fnjs.logf(window.fnreq.constructor.name,"procurar_sjdreq");
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 
    }		

    abortar_requisicoes_em_andamento(params) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"abortar_requisicoes_em_andamento");
            let requisicoes_ativas = window.fnreq.procurar_sjdreq({status:'requisitando'});
            let abortar = null;
            for (let i = 0; i < requisicoes_ativas.length; i++) {
                requisicoes_ativas[i].status = 'cancelado';
                requisicoes_ativas[i].post.abort();
                abortar = {
                    abortar:'abortar',
                    id : requisicoes_ativas[i].id
                }
                $.post(vars.nomes_caminhos_arquivos.requisicao_php_sjd,{abortar:abortar},function(retorno){});
            }
            fnjs.logf(window.fnreq.constructor.name,"abortar_requisicoes_em_andamento");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }
    }	

    incluir_sjdreq(params) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"incluir_sjdreq");
            if (typeof vars.reqs === 'undefined') {
                vars.reqs = {
                    requisicoes:[]
                }
            }
            vars.reqs.requisicoes.push({
                id : params.comhttp.id,
                status : 'requisitando',
                aoretornar : 'normal'
            });
            fnjs.logf(window.fnreq.constructor.name,"incluir_sjdreq");
            return vars.reqs.requisicoes[vars.reqs.requisicoes.length-1];
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 
    }	

    mostrar_erros_servidor(params) {
        try{
            //fnjs.logi(window.fnreq.constructor.name,"mostrar_erros_servidor");
            params.mostrar_como = params.mostrar_como || 'log';
            if (typeof params.comhttp === 'object') {
                if (typeof params.comhttp.retorno.erros === 'string' && params.comhttp.retorno.erros.length) {					
                    params.comhttp.retorno.erros = fnstr.string_para_json(params.comhttp.retorno.erros);
                }
                if (typeof params.comhttp.retorno.erros === 'object' && params.comhttp.retorno.erros !== null) {
                    if (params.comhttp.retorno.erros.length) {
                        for(let i = 0; i<params.comhttp.retorno.erros.length; i++) {
                            if (typeof params.comhttp.retorno.erros[i] === 'object') {
                                for (let key in params.comhttp.retorno.erros[i]) {
                                    if (params.comhttp.retorno.erros[i].hasOwnProperty(key)) {
                                        console.log((key === 'codigo'?key:'  ' + key) + ':' + params.comhttp.retorno.erros[i][key]);
                                    }
                                }						
                            }
                        }
                    } else {

                    }
                }
            } else {
                alert(window.fnreq.mensagens.erro_tipo_req + typeof params.comhttp);
            }
            //fnjs.logf(window.fnreq.constructor.name,"mostrar_erros_servidor");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 
    }

    mostrar_log_servidor(params) { 
        try{
            //fnjs.logi(window.fnreq.constructor.name,"mostrar_log_servidor");
            //fnjs.logf(window.fnreq.constructor.name,"mostrar_log_servidor");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 		
    }

    excluir_dados_inexistentes(){	
        try {
            //fnjs.logi(window.fnreq.constructor.name,"excluir_dados_inexistentes");
            let tabela_inexistente = null;
            $.each(vars.dados,function(index,element){
                tabela_inexistente = fnjs.obterJquery('table[' + window.fnreq.propriedades_html.id_dados + '=' + index+']')
                if (tabela_inexistente.length) {					
                } else {
                    delete vars.dados[index];
                }
            });
            //fnjs.logf(window.fnreq.constructor.name,"excluir_dados_inexistentes");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:"todos"
            });
        }			
    }

    executar_eval_retorno(params,eval_retorno){
        try {
            fnjs.logi(window.fnreq.constructor.name,"executar_eval_retorno");
            eval_retorno.parametros = eval_retorno.parametros || {};
            eval_retorno.parametros.comhttp = params.comhttp;                    

            /*corrige o nome da funcao se ela vier com o nome da classe (Classe.funcao para fnxxx.funcao) */
            /*let arr_func = eval_retorno.funcao.split('.');
            if (arr_func.length > 1) {
                let objs_this = Object.keys(window.fbj);
                let i = 0; 
                let qt = objs_this.length;
                let nome_obj = null;
                for(i = 0; i < qt; i++) {
                    if (typeof window.fbj[objs_this[i]] === "object" && window.fbj[objs_this[i]] !== null && ["object","function"].indexOf(typeof window.fbj[objs_this[i]].constructor) > -1 && window.fbj[objs_this[i]].constructor !== null) {
                        nome_obj = window.fbj[objs_this[i]].constructor.name || '';
                        if (nome_obj.trim().toLowerCase() === arr_func[0].trim().toLowerCase()) {
                            arr_func[0] = '' + objs_this[i];
                            eval_retorno.funcao = arr_func.join('.');
                            break;                                      
                        }
                    }
                }
            */
           console.log(eval_retorno);
            if (typeof eval_retorno.tempo_iniciar_execucao !== "undefined") {
                setTimeout(eval(eval_retorno.funcao),eval_retorno.tempo_iniciar_execucao,eval_retorno.parametros);
            } else {
                eval(eval_retorno.funcao+'(eval_retorno.parametros)');
            }
            fnjs.logf(window.fnreq.constructor.name,"executar_eval_retorno");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    processar_recebimento_dados(params) {
        try {
            fnjs.logi(window.fnreq.constructor.name,"processar_recebimento_dados");
            if (params.comhttp.eventos.aposretornar.length>0) {
                for(let i = 0; i<params.comhttp.eventos.aposretornar.length;i++) {
                    if (params.comhttp.eventos.aposretornar[i].funcao.trim().length > 0) {
                        if (typeof params.comhttp.eventos.aposretornar[i].tempo_iniciar_execucao !== "undefined") {
                            window.fnreq.executar_eval_retorno(params,params.comhttp.eventos.aposretornar[i]);
                        } else {
                            if (params.comhttp.requisicao.requisitar.oque === 'conteudo_html') {
                                if (params.comhttp.requisicao.requisitar.qual.objeto !== 'pagina' && params.comhttp.requisicao.requisitar.qual.objeto !== 'inicio') {
                                    if (fnjs.como_booleano(params.comhttp.requisicao.requisitar.qual.condicionantes.inicial) === true) {
                                        window.fnreq.executar_eval_retorno(params,params.comhttp.eventos.aposretornar[i]);
                                    } else {
                                        window.fnreq.carregando({
                                            texto:'',
                                            acao:'esconder',
                                            id:(params.comhttp.id_carregando || params.id_carregando || 'todos')
                                        });

                                        params.comhttp.retorno.dados_retornados.caminho_recurso = params.comhttp.retorno.dados_retornados.caminho_recurso.replace(/\/\//g,'/');
                                        params.comhttp.retorno.dados_retornados.caminho_recurso = params.comhttp.retorno.dados_retornados.caminho_recurso.replace(/\\\\/g,'\\');

                                        if (typeof params.comhttp.requisicao.requisitar.qual.condicionantes.efetuar_pesquisa !== "undefined") {
                                            window.open(params.comhttp.retorno.dados_retornados.caminho_recurso+'?efetuar_pesquisa=' +params.comhttp.requisicao.requisitar.qual.condicionantes.efetuar_pesquisa,'_blank', 'width=' + screen.width + ',height=' + screen.height + ',location=1,status=1,scrollbars=1,resizable=1,directories=1,tollbar=1,titlebar=1' );
                                        } else {
                                            window.open(params.comhttp.retorno.dados_retornados.caminho_recurso,'_blank','width=' + screen.width + ',height=' + screen.height + ',location=1,status=1,scrollbars=1,resizable=1,directories=1,tollbar=1,titlebar=1' );
                                        }
                                        break;
                                    }
                                } else {
                                    window.fnreq.executar_eval_retorno(params,params.comhttp.eventos.aposretornar[i]);
                                }
                            } else {
                                window.fnreq.executar_eval_retorno(params,params.comhttp.eventos.aposretornar[i]);
                            }
                        }
                    }
                }
            } 
            fnjs.logf(window.fnreq.constructor.name,"processar_recebimento_dados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }			
    }

    receber_dados(params) { 
        try{
            fnjs.logi(window.fnreq.constructor.name,"receber_dados");
            let tipo_dados = '';
            params.teste = params.teste || false;
            tipo_dados = typeof params.comhttp_retorno;
            if (tipo_dados === 'string') {
                params.comhttp.retorno = null;
                params.comhttp.retorno = fnstr.string_para_json(params.comhttp_retorno);
                if (typeof params.comhttp.retorno !== "undefined" && params.comhttp.retorno !== null) {
                    params.comhttp = params.comhttp.retorno;
                    let sjdreq = window.fnreq.procurar_sjdreq({id:params.comhttp.id});
                    if (sjdreq.length > 0) {
                        if (sjdreq[0].status === 'cancelado') {
                            alert(window.fnreq.mensagens.erro_abortando+sjdreq[0].id);
                            return;
                        }
                        sjdreq[0].status = 'concluido';
                    }
                    window.fnreq.excluir_dados_inexistentes();
                    if (typeof params.comhttp.retorno.dados_retornados.conteudo_html === "undefined") {
                        let strtemp = params.comhttp.retorno.dados_retornados;
                        params.comhttp.retorno.dados_retornados = {};
                        params.comhttp.retorno.dados_retornados.conteudo_html = strtemp;
                    }
                    if (typeof params.comhttp.retorno.resultado !== "undefined"){
                        window.fnreq.mostrar_log_servidor({comhttp:params.comhttp});
                        window.fnreq.mostrar_erros_servidor({comhttp:params.comhttp});
                        
                        switch(params.comhttp.retorno.resultado.toString().toLowerCase().trim()) {
                            case 'logar':
                                params.comhttp.opcoes_retorno.metodo_insersao = 'append';
                                if (params.teste) {
                                } else {									
                                    window.fnreq.inserir_retorno(params.comhttp);
                                }
                                return;
                                break;
                            case 'sucesso':
                                
                                /*if (typeof params.comhttp.eventos.aposretornar !== "undefined") {
                                    if (params.comhttp.eventos.aposretornar.length>0) {
                                        for(let i = 0; i<params.comhttp.eventos.aposretornar.length;i++) {											
                                            fnarq.carregar_arquivo_js(params.comhttp.eventos.aposretornar[i].arquivo,vars.nomes_caminhos_arquivos.funcoes_requisicao);
                                        }										
                                    } else {
                                        alert(window.fnreq.mensagens.sem_arquivos_adicionais);
                                        window.fnreq.carregando({
                                            texto:'',
                                            acao:'esconder',
                                            id:'todos'
                                        });
                                    }
                                }*/	

                                
                                if (typeof params.comhttp.retorno.erros === 'object' && params.comhttp.retorno.erros !== null ) {									                                    
                                    if (params.comhttp.retorno.erros.length) {
                                        alert(fnarq.mensagens.erros_servidor);
                                        window.fnreq.carregando({
                                            texto:'',
                                            acao:'esconder',
                                            id:(params.comhttp.id_carregando || params.id_carregando || 'todos')
                                        });
                                        if ((params.comhttp.opcoes_retorno.parar_por_erros_sql === false && params.comhttp.retorno.numerroscodigo === 0)||
                                            (params.comhttp.opcoes_retorno.parar_por_erros_codigo === false && params.comhttp.retorno.numerrossql === 0)) {
                                            alert(fnarq.mensagens.processamento_continua);
                                            window.fnreq.processar_recebimento_dados(params);								
                                        } 	
                                    } else {
                                        window.fnreq.processar_recebimento_dados(params);	
                                    }
                                } else {												
                                    window.fnreq.processar_recebimento_dados(params);									
                                }								
                                break;
                            case 'falha':
                                console.error('falha_requisicao',params.comhttp);
                                alert('falha_requisicao'+params.comhttp.retorno.dados_retornaods.conteudo_html);								
                                break;
                            default:
                                alert(window.fnreq.mensagens.resultado_nao_definido+params.comhttp.retorno.resultado);
                                break;
                        }
                    } else {
                        console.error('falha_requisicao',params.comhttp);
                        alert('falha_requisicao');
                    }
                } else {
                    console.error('falha_requisicao',params.comhttp_retorno);
                    alert('falha_requisicao');
                }
            } else {
                throw 'tipo nao esperado: ' + tipo_dados;
            }
            fnjs.logf(window.fnreq.constructor.name,"receber_dados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }				
    }



    incluir_elementos_html(params) {
        try {
            fnjs.logi(window.fnreq.constructor.name,"incluir_elementos_html");
            let elementos = null;
            elementos = params.comhttp.retorno.dados_retornados.conteudo_html || "";
            let parent = document.querySelector(params.comhttp.opcoes_retorno.seletor_local_retorno);// || document.body;
            if (typeof elementos === "string") {
                fnjs.obterJquery(parent).html(elementos);
            } else {
                elementos.parent = parent;
                console.log('incluindo elementos: ' , elementos);
                console.log('em : ' , elementos.parent);
                fnhtml.criar_elemento(elementos);            
            }
            fnjs.logf(window.fnreq.constructor.name,"incluir_elementos_html");
        } catch (e) {
            console.log(e);
            alert(e.message || e);
        }
    }


    incluir_inicio(params) { 
        try{
            fnjs.logi(window.fnreq.constructor.name,"incluir_inicio");
            fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).html(params.comhttp.retorno.dados_retornados.conteudo_html);
            if (typeof params.comhttp.retorno.dados_retornados.conteudo_javascript !== "undefined") {
                if (params.comhttp.retorno.dados_retornados.conteudo_javascript !== null) {
                    if (params.comhttp.retorno.dados_retornados.conteudo_javascript.length) {
                        fnjs.carregar_conteudo_js(params.comhttp.retorno.dados_retornados.conteudo_javascript);
                    }
                }
            }
            if (JSON.stringify(vars.ultima_requisicao.retorno.retorno.dados_retornados).indexOf('main_login') > -1) {
                window.fnreq.incluir_elementos_html(params);
            } else {               
                window.fnreq.incluir_elementos_html(params);
                let parametros = null;
                parametros = {
                    nomeops: params.recurso,					
                    inicial:true,					
                    efetuar_pesquisa : params.efetuar_pesquisa
                };
                fnsisjd.acessar_item_menu(parametros);
            }
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(window.fnreq.constructor.name,"incluir_inicio");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }	
    }
    processar_retorno_como_log(params){
        try{
            fnjs.logi(window.fnreq.constructor.name,"processar_retorno_como_log");
            fnjs.obterJquery(vars.seletores.textologprocesso).val(fnjs.obterJquery(vars.seletores.textologprocesso).val() + params.comhttp.retorno.dados_retornados.conteudo_html);
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(window.fnreq.constructor.name,"processar_retorno_como_log");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }									
    }	
    processar_retorno_como_msg(params){
        try{
            fnjs.logi(window.fnreq.constructor.name,"processar_retorno_como_msg");
            alert(params.comhttp.retorno.dados_retornados.conteudo_html);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
            fnjs.logf(window.fnreq.constructor.name,"processar_retorno_como_msg");
        }catch(e){
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 						
    }	
    processar_retorno_em_silencio(params){
        try{
            fnjs.logi(window.fnreq.constructor.name,"processar_retorno_em_silencio");
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
            fnjs.logf(window.fnreq.constructor.name,"processar_retorno_em_silencio");
        }catch(e){
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 							
    }		
    processar_retorno_como_mensagem(params) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"processar_retorno_como_mensagem");
            if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.mensagem !== "undefined") {
            params.comhttp.retorno.dados_retornados.conteudo_html.mensagem = fnhtml.htmlDecode(params.comhttp.retorno.dados_retornados.conteudo_html.mensagem);
                alert(params.comhttp.retorno.dados_retornados.conteudo_html.mensagem);
            } else if (typeof params.comhttp.retorno.dados_retornados.conteudo_html !== "undefined") {
                alert(params.comhttp.retorno.dados_retornados.conteudo_html);
            } else {
                alert(params.comhttp.retorno.dados_retornados.toString());
            }
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
            fnjs.logf(window.fnreq.constructor.name,"processar_retorno_como_mensagem");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 									
    }
    processar_retorno_como_incluir_link(params) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"processar_retorno_como_incluir_link");
            let local_retorno = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
            let link = null;
            console.log(local_retorno);
            if (typeof params.comhttp.retorno.dados_retornados.dados.link !== "undefined") {
                console.log(params.comhttp.retorno.dados_retornados);
                link = params.comhttp.retorno.dados_retornados.dados.link;
            } else if (typeof params.comhttp.retorno.dados_retornados.link !== "undefined") {
                link = params.comhttp.retorno.dados_retornados.conteudo_html;
            } else {
                link = params.comhttp.retorno.dados_retornados.toString();
            }
            console.log(link);
            if (local_retorno.prop("tagName") === "INPUT") {
                local_retorno.val(link);
            } else {
                local_retorno.html(link)
            }
            fnjs.logf(window.fnreq.constructor.name,"processar_retorno_como_incluir_link");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 									
    }

    ins_lin(corpo,tabtemp,lin,cont){
        try {
            fnjs.logi(window.fnreq.constructor.name,"ins_lin");
            tabtemp.innerHTML = lin;
            corpo.appendChild(tabtemp.children[0]);
            fnjs.logf(window.fnreq.constructor.name,"ins_lin");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:"todos"
            });
        } 
    }

    ins_lin_concat(corpo,tabtemp,lin,cont,cont4){
        try {
            fnjs.logi(window.fnreq.constructor.name,"ins_lin_concat");
            let tabtemp2 = document.createElement('tbody');
            tabtemp2.innerHTML = lin[cont4].join('');
            let qt3 = 0;
            let cont3 = 0;
            let children = [];
            qt3 = tabtemp2.children.length;
            children = tabtemp2.children;
            qt3 = children.length;
            for(cont3=0;cont3<children.length;cont3++){
                corpo.appendChild(children[cont3]);
            }
            fnjs.logf(window.fnreq.constructor.name,"ins_lin_concat");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:"todos"
            });
        } 
    }

    inserir_linha(comhttp,corpo,tabtemp,linha,cont,qt) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"inserir_linha");
            setTimeout(window.fnreq.carregando,0,{
                texto:window.fnreq.mensagens.inserindo_linha_num + cont.toString() + '(de ' + qt.toString()+')', 
                acao:'alterar' , 
                id:comhttp.id_carregando
            });
            setTimeout(window.fnreq.ins_lin,0,corpo,tabtemp,linha,cont-1);
            if (cont === (qt - 1) ) {                
                vars.iniciou_inclusao_tabela_est = false;
                vars.terminou_inclusao_tabela_est = true;
                fnjs.obterJquery(corpo).closest('table.' + vars.classes.tabela_est).attr('carregamento','carregado');
            }
            fnjs.logf(window.fnreq.constructor.name,"inserir_linha");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:comhttp.id_carregando || "todos"
            });
        }									
    }

    inserir_linha_concatenadas(comhttp,corpo,linhas,qttotal,contador, numlinhasporvez,iteracao) {
        try{			
            fnjs.logi(window.fnreq.constructor.name,"inserir_linha_concatenadas");
            let tabtemp = document.createElement('tbody');
            let str_linhas = '';
            let cont2 = 0;
            window.fnreq.carregando({
                texto:window.fnreq.mensagens.inserindo_linha_num + (contador).toString() + ' a ' + (contador+numlinhasporvez).toString() + ' (de ' + qttotal.toString()+')',
                acao:'alterar' , 
                id:comhttp.id_carregando
            });			
            for(let i = contador ; i<qttotal&&cont2<numlinhasporvez ; i++) {
                str_linhas += linhas[i];
                cont2++;
            }
            contador += cont2;
            tabtemp.innerHTML = str_linhas;
            for(let i = tabtemp.children.length-1 ; i>-1 ; i--) {
                corpo.appendChild(tabtemp.children[i]);
            }
            if (contador<qttotal) {
                setTimeout(window.fnreq.inserir_linha_concatenadas,10,comhttp,corpo,linhas,qttotal,contador,numlinhasporvez,iteracao);
            } else {
                vars.iniciou_inclusao_tabela_est = false;
                vars.terminou_inclusao_tabela_est = true;
                fnjs.obterJquery(corpo).closest('table.' + vars.classes.tabela_est).attr('carregamento','carregado');
            }
            fnjs.logf(window.fnreq.constructor.name,"inserir_linha_concatenadas");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:comhttp.id_carregando || "todos"
            });
        } 									
    }	

    inserir_linhas(comhttp,linhas,contador_recursao) {
        try{
            fnjs.logi(window.fnreq.constructor.name,"inserir_linhas");
            let corpo = fnjs.obterJquery(comhttp.opcoes_retorno.seletor_tabela_est);
            let qt = 0;
            let idrand = '';
            let tabtemp = {};
            let numlinhasporvez = 0;
            contador_recursao = fnjs.first_valid([contador_recursao,0]);
            if (contador_recursao > vars.num_limite_recursoes) {
                alert(vars.atingido_limite_recursoes +vars.num_limite_recursoes);
                setTimeout(window.fnreq.carregando,50,vars.mensagens.sem_resultados,'excluir',comhttp.id_carregando);
                vars.iniciou_inclusao_tabela_est = false;
                vars.terminou_inclusao_tabela_est = true;
                return;
            }
            if (!corpo.length) {
                contador_recursao = contador_recursao + 1;
                setTimeout(window.fnreq.inserir_linhas,500,comhttp,linhas, contador_recursao);
                return;
            } else {
                if (corpo.hasClass(vars.classes.tb2)) {
                    corpo = corpo.children('tbody');
                } else {
                    corpo = corpo.find('table.' + vars.classes.tabcorpo).children('tbody');
                }				
                idrand = fnjs.id_random();
                corpo.addClass(idrand);
                corpo = document.getElementsByClassName(idrand)[0];
                if (typeof corpo === "undefined") {		
                    contador_recursao = contador_recursao + 1;				
                    setTimeout(window.fnreq.inserir_linhas,500,comhttp,linhas,contador_recursao);
                    return;
                }					
                linhas = linhas.split('<tr');
                qt = linhas.length;
                tabtemp = document.createElement('table');
                tabtemp.innerHTML = '<tbody id="corpotemp"></tbody>';
                tabtemp = tabtemp.children[0];
                if (qt <= 1 ) {                    
                    setTimeout(window.fnreq.carregando,50,vars.mensagens.sem_resultados,'excluir',comhttp.id_carregando);
                    vars.iniciou_inclusao_tabela_est = false;
                    vars.terminou_inclusao_tabela_est = true;
                    fnjs.obterJquery(corpo).closest('table.' + vars.classes.tabela_est).attr('carregamento','carregado');
                } else if (qt > 1 && qt < 5001) {
                    for (let i = 1 ; i < qt ; i++) {
                        setTimeout(window.fnreq.inserir_linha,0,comhttp,corpo,tabtemp,'<tr ' + linhas[i], i , qt);
                    }
                } else if (qt>5000 && qt < 10001) {
                    numlinhasporvez = 100;
                    setTimeout(window.fnreq.inserir_linha_concatenadas,0,comhttp,corpo,linhas, linhas.length, 0, numlinhasporvez,0);	
                } else if (qt>10000 && qt < 20001) {
                    numlinhasporvez = 500;
                    setTimeout(window.fnreq.inserir_linha_concatenadas,0,comhttp,corpo,linhas, linhas.length, 0, numlinhasporvez,0);	
                } else if (qt>20000 && qt < 40001) {
                    numlinhasporvez = 1000;
                    setTimeout(window.fnreq.inserir_linha_concatenadas,0,comhttp,corpo,linhas, linhas.length, 0, numlinhasporvez,0);			
                } else if (qt>40000) {
                    numlinhasporvez = 10000;
                    setTimeout(window.fnreq.inserir_linha_concatenadas,0,comhttp,corpo,linhas, linhas.length, 0, numlinhasporvez,0);				
                }				
            }
            fnjs.logf(window.fnreq.constructor.name,"inserir_linhas");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:comhttp.id_carregando || "todos"
            });
        }									
    }	

    inserir_retorno_com_array_tabelaest(params){
        try{
            fnjs.logi(window.fnreq.constructor.name,"inserir_retorno_com_array_tabelaest");
            if (typeof params.comhttp.opcoes_retorno.metodo_insersao === "undefined") {
                params.comhttp.opcoes_retorno.metodo_insersao = 'append';
            }
            let local_retorno = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
            if (params.comhttp.opcoes_retorno.metodo_insersao !== 'append' && params.comhttp.opcoes_retorno.metodo_insersao !== vars.nfj.after) { 
                local_retorno.html('');
            }
            let branco_se_zero = fnjs.first_valid([params.comhttp.requisicao.requisitar.qual.condicionantes.branco_se_zero,false]);                        
            params.comhttp.retorno.dados_retornados.conteudo_html.rodape = params.comhttp.retorno.dados_retornados.conteudo_html.rodape || [];
            for (let ind in params.comhttp.retorno.dados_retornados.conteudo_html.cabecalho) {
                //alert(ind);
                local_retorno[params.comhttp.opcoes_retorno.metodo_insersao]('<table>' + params.comhttp.retorno.dados_retornados.conteudo_html.cabecalho[ind] + '</table>');
                let tab = local_retorno.children("table:last");
                if (typeof tab !== "undefined" && tab !== null && tab.length) {
                    if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.props[ind] !== "undefined" 
                        && params.comhttp.retorno.dados_retornados.conteudo_html.props[ind] !== null 
                        && Object.keys(params.comhttp.retorno.dados_retornados.conteudo_html.props[ind]).length
                    ) {
                        for( let i = 0; i < Object.keys(params.comhttp.retorno.dados_retornados.conteudo_html.props[ind]).length; i++) {
                            if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.props[ind][i] !== "undefined" && params.comhttp.retorno.dados_retornados.conteudo_html.props[ind][i] !== null) {
                                tab.attr(params.comhttp.retorno.dados_retornados.conteudo_html.props[ind][i].prop,params.comhttp.retorno.dados_retornados.conteudo_html.props[ind][i].value);
                            }   
                        }
                    }
                    tab.addClass("tabdados");                    
                    let cels_tit = tab.children("thead").find("th.celula_final_tit");
                    tab.append("<tbody></tbody>");                    
                    if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.rodape[ind] !== "undefined" 
                        && params.comhttp.retorno.dados_retornados.conteudo_html.rodape[ind] !== null &&
                        params.comhttp.retorno.dados_retornados.conteudo_html.rodape[ind].trim().length > 0) {
                        tab.append(params.comhttp.retorno.dados_retornados.conteudo_html.rodape[ind]);
                    }
                    let tem_sub = false;

                    /*obtem as classes das celulas dos titulos*/
                    let classes = [];

                    if (fnjs.como_booleano(fnjs.first_valid([tab.attr("subregistros"),tab.html().indexOf("SUB") > -1]))) {
                        tem_sub = true;
                        classes.push("cel_sub");
                    }            
                    let qt_tit = cels_tit.length;
                    let classes_temp = [];
                    let classe = null;
                    for(let i = 0; i < qt_tit; i++) {
                        classes_temp = cels_tit.eq(i).attr("class").split(" ");
                        classe = classes_temp[classes_temp.length-1];//ultima classe esperada eh a que indica o tipo (cel_numint, cel_texto..)
                        if (cels_tit.eq(i).hasClass("naomostrar")) {
                            classe += " naomostrar";
                        }
                        if (cels_tit.eq(i).hasClass("bloqueado")) {
                            classe += " bloqueado";
                        }
                        classes.push(classe);
                    }
                    let corpo = tab.children("tbody");
                    let dados = params.comhttp.retorno.dados_retornados.dados[ind] || [];
                    let qt = dados.length;
                    let cels = [];
                    let j = 0;
                    let val = null;

                    /*insere as linhas */
                    for(let i = 0; i < qt; i ++) {
                        cels = [];
                        j = 0;
                        if (tem_sub) {
                            cels.push('<td class="'+classes[j]+'"><img class="img_sub" src="/sjd/images/mais.png" /></td>');
                            j++;
                        }
                        for(let key in dados[i]) {
                            if (["cel_qt","cel_peso","cel_valor","cel_perc","cel_perc_med"].indexOf(classes[j]) > -1) {                        
                                val = ((dados[i][key] || '').toString().replace(/\./g,'').replace(',','.')-0);
                                cels.push('<td class="'+(classes[j]||'')+'">' + 
                                    (   val == 0 && branco_se_zero?''
                                        :val.toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2})
                                    ) + '</td>'
                                );
                            } else {
                                cels.push('<td class="'+(classes[j]||'')+'">' + (dados[i][key] || '') + '</td>');
                            }
                            j++;
                        }
                        corpo.append('<tr>' + cels.join('') + '</tr>');
                    }
                    local_retorno.append('<br />');
                    fnhtml.fntabdados.calcular_tabdados(tab);
                } else {
                    console.log("tabela nao encontrada");
                }
                if (params.comhttp.opcoes_retorno.metodo_insersao == "html") {
                    /*multiplas tabelas no mesmo local de retorno, nao trocar por append, sao sempre substituidas pela proxima*/
                    params.comhttp.opcoes_retorno.metodo_insersao = "append";
                }
            }

            if (typeof params.comhttp.retorno.dados_retornados.conteudo_javascript !== "undefined") {
                if (params.comhttp.retorno.dados_retornados.conteudo_javascript !== null) {
                    if (params.comhttp.retorno.dados_retornados.conteudo_javascript.length) {
                        fnjs.carregar_conteudo_js(params.comhttp.retorno.dados_retornados.conteudo_javascript);
                    }
                }
            } 
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(window.fnreq.constructor.name,"inserir_retorno_com_array_tabelaest");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }      
    }


    inserir_retorno_com_tabelaest(params){
        try{
            fnjs.logi(window.fnreq.constructor.name,"inserir_retorno_com_tabelaest");

            if (typeof params.comhttp.opcoes_retorno.metodo_insersao === "undefined") {
                params.comhttp.opcoes_retorno.metodo_insersao = 'append';
            }
            let local_retorno = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno);
            if (params.comhttp.opcoes_retorno.metodo_insersao !== 'append' && params.comhttp.opcoes_retorno.metodo_insersao !== vars.nfj.after) { 
                local_retorno.html('');
            }
            let branco_se_zero = fnjs.first_valid([params.comhttp.requisicao.requisitar.qual.condicionantes.branco_se_zero,false]);
            if (["array","object"].indexOf(fnjs.typeof(params.comhttp.retorno.dados_retornados.conteudo_html.cabecalho)) > -1) {
                window.fnreq.inserir_retorno_com_array_tabelaest(params);
                return;
            }
            local_retorno[params.comhttp.opcoes_retorno.metodo_insersao]('<table>' + params.comhttp.retorno.dados_retornados.conteudo_html.cabecalho + '</table>');
            let tab = local_retorno.children("table:last");
            if (typeof tab !== "undefined" && tab !== null && tab.length) {
                if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.props !== "undefined" && params.comhttp.retorno.dados_retornados.conteudo_html.props !== null && Object.keys(params.comhttp.retorno.dados_retornados.conteudo_html.props).length) {
                    for( let i = 0; i < Object.keys(params.comhttp.retorno.dados_retornados.conteudo_html.props).length; i++) {
                        if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.props[i] !== "undefined" && params.comhttp.retorno.dados_retornados.conteudo_html.props[i] !== null) {
                            tab.attr(params.comhttp.retorno.dados_retornados.conteudo_html.props[i].prop,params.comhttp.retorno.dados_retornados.conteudo_html.props[i].value);
                        }   
                    }
                }
                tab.addClass("tabdados");
                let cels_tit = tab.children("thead").find("th.celula_final_tit");
                tab.append("<tbody></tbody>");
                if (typeof params.comhttp.retorno.dados_retornados.conteudo_html.rodape !== "undefined" 
                    && params.comhttp.retorno.dados_retornados.conteudo_html.rodape !== null &&
                    params.comhttp.retorno.dados_retornados.conteudo_html.rodape.trim().length > 0) {
                    tab.append(params.comhttp.retorno.dados_retornados.conteudo_html.rodape);
                }
                let tem_sub = false;
                let edicao_ativa = false;
                let exclusao_ativa = false;
                let copiar_ativa = false;

                /*obtem as classes das celulas dos titulos*/
                let classes = [];

                if (fnjs.como_booleano(fnjs.first_valid([tab.attr("subregistros"),tab.html().indexOf("SUB") > -1]))) {
                    tem_sub = true;
                    classes.push("cel_sub");
                }
                if (fnjs.como_booleano(fnjs.first_valid([tab.attr("edicao_ativa"),false]))) {
                    edicao_ativa = true;
                }
                if (fnjs.como_booleano(fnjs.first_valid([tab.attr("exclusao_ativa"),false]))) {
                    exclusao_ativa = true;
                }
                if (fnjs.como_booleano(fnjs.first_valid([tab.attr("copiar_ativa"),false]))) {
                    copiar_ativa = true;
                }
                let qt_tit = cels_tit.length;
                let classes_temp = [];
                let classe = null;
                for(let i = 0; i < qt_tit; i++) {
                    classes_temp = cels_tit.eq(i).attr("class").split(" ");
                    classe = classes_temp[classes_temp.length-1];//ultima classe esperada eh a que indica o tipo (cel_numint, cel_texto..)
                    if (cels_tit.eq(i).hasClass("naomostrar")) {
                        classe += " naomostrar";
                    }
                    if (cels_tit.eq(i).hasClass("bloqueado")) {
                        classe += " bloqueado";
                    }
                    classes.push(classe);
                }
                let corpo = tab.children("tbody");
                let dados = params.comhttp.retorno.dados_retornados.dados || [];
                //console.log(dados);                
                let qt = dados.length || Object.keys(dados).length;
                //alert(qt);
                let cels = [];
                let j = 0;
                let val = null;
                /*insere as linhas */
                for(let i in dados) {
                    cels = [];
                    j = 0;
                    if (tem_sub) {
                        cels.push('<td class="'+classes[j]+'"><img class="img_sub" src="/sjd/images/mais.png" /></td>');
                        j++;
                    }
                    for(let key in dados[i]) {
                        if (["cel_qt","cel_peso","cel_valor","cel_perc","cel_perc_med"].indexOf(classes[j]) > -1) {                        
                            val = ((dados[i][key] || '').toString().replace(/\./g,'').replace(',','.')-0);
                            cels.push('<td class="'+(classes[j]||'')+'">' + 
                                (   val == 0 && branco_se_zero?''
                                    :val.toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2})
                                ) + '</td>'
                            );
                        } else {
                            cels.push('<td class="'+(classes[j]||'')+'">' + (dados[i][key] || '') + '</td>');
                        }
                        j++;
                    }
                    corpo.append('<tr>' + cels.join('') + '</tr>');
                }

                if (edicao_ativa || exclusao_ativa || copiar_ativa) {
                    let linhas = corpo.children("tr");
                    let celcmd = '<td class="cel_cmd">';
                    if (edicao_ativa) {
                        celcmd += '<img class="img_editar clicavel" src="/sjd/images/editar1_32.png" title="Editar esta linha" />';
                    }
                    if (exclusao_ativa) {
                        celcmd += '<img class="img_excluir clicavel" src="/sjd/images/deletar1_32.png" title="Excluir esta linha" />';
                    }
                    if (copiar_ativa) {
                        celcmd += '<img class="img_copiar clicavel" src="/sjd/images/copiar1_32.png" title="Copiar esta linha" />';
                    }
                    celcmd += '</td>';
                    for(let i = 0; i < qt; i ++) {
                        linhas.eq(i).append(celcmd);
                    }
                }

                fnhtml.fntabdados.calcular_tabdados(tab);

                if (typeof params.comhttp.retorno.dados_retornados.conteudo_javascript !== "undefined") {
                    if (params.comhttp.retorno.dados_retornados.conteudo_javascript !== null) {
                        if (params.comhttp.retorno.dados_retornados.conteudo_javascript.length) {
                        fnjs.carregar_conteudo_js(params.comhttp.retorno.dados_retornados.conteudo_javascript);
                        }
                    }
                } 
            } else {
                console.log("tabela nao encontrada");
            }
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(window.fnreq.constructor.name,"inserir_retorno_com_tabelaest");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 	       
    }	

    mudar_titulo(params) {
        try {
            fnjs.logi(this.constructor.name,"mudar_titulo");
            let nav = fnjs.obterJquery("nav.barra_sup");
            let style = nav.attr("style");
            let titulo = params.titulo || params || '';
            nav.html(titulo);
            nav.attr("style",style + ";text-align:center !important; display:block; font-weight:bolder;");
            document.title = "SisJD - " + titulo; 
            fnjs.logf(this.constructor.name,"mudar_titulo");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }    

    /**
     * insere os dados no html montando a tabela html (table)
     * @param {object} params - comhtt retornado da requisicao
     * @created 03/05/2021
     * @update 03/05/2021 - opcao para distinguir no array de dados se eh realmente array ou object
     */
    inserir_dados_retorno_como_tabela(params) { 
        try{
            fnjs.logi(this.constructor.name,"inserir_dados_retorno_como_tabela");
            if (typeof params.comhttp.opcoes_retorno.metodo_insersao === "undefined") {
                params.comhttp.opcoes_retorno.metodo_insersao = 'append';
            }
            let tabela = document.createElement("table");
            tabela.classList.add("table","table-sm","table-bordered","table-hover");
            fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).html(tabela);
            let arr_tit = null;
            let dados = null;
            let qt = 0;
            let i = 0;
            let linha = null;
            let celula = null;
            let linha_filtros = null;
            let titulo = document.createElement("thead");
            let checkbox = null;
            let input_filtro = null;

            if (
                typeof params.comhttp.retorno.dados_retornados !== "undefined" 
                && params.comhttp.retorno.dados_retornados !== null
            ) {
                if (
                    typeof params.comhttp.retorno.dados_retornados.dados !== "undefined" 
                    && params.comhttp.retorno.dados_retornados.dados !== null
                ) {
                    arr_tit = params.comhttp.retorno.dados_retornados.dados.tabela.titulo.arr_tit;
                    dados = params.comhttp.retorno.dados_retornados.dados.tabela.dados;
                } else if (
                    typeof params.comhttp.retorno.dados_retornados.conteudo_html !== "undefined" 
                    && params.comhttp.retorno.dados_retornados.conteudo_html !== null
                ) {
                    if (
                        typeof params.comhttp.retorno.dados_retornados.conteudo_html.dados !== "undefined" 
                        && params.comhttp.retorno.dados_retornados.conteudo_html.dados !== null
                    ) {
                        if (
                            typeof params.comhttp.retorno.dados_retornados.conteudo_html.dados.tabela !== "undefined" 
                            && params.comhttp.retorno.dados_retornados.conteudo_html.dados.tabela !== null
                        ) {
                            arr_tit = params.comhttp.retorno.dados_retornados.conteudo_html.dados.tabela.titulo.arr_tit || null;
                            dados = params.comhttp.retorno.dados_retornados.conteudo_html.dados.tabela.dados || null;
                        }
                    }
                }
            }
            titulo.classList.add("table-dark");
            tabela.appendChild(titulo);			
            linha = document.createElement("tr");			
            titulo.appendChild(linha);
            linha_filtros = document.createElement("tr");
            titulo.appendChild(linha_filtros);
            celula = document.createElement("th");
            celula.classList.add("center");
            linha.appendChild(celula);
            checkbox = document.createElement("input");
            celula.appendChild(checkbox);
            checkbox.setAttribute("type","checkbox");
            checkbox.setAttribute("onclick","window.fnhtml.fntabdados.selecionar_todos(this)");
            celula = document.createElement("th");
            linha_filtros.appendChild(celula);

            if (typeof arr_tit !== "undefined" && arr_tit !== null && arr_tit.length) {				
                qt = arr_tit.length;
                if (qt > 0) {					
                    for(i = 0; i < qt; i++) {
                        celula = document.createElement("th");
                        linha.appendChild(celula);
                        celula.innerText = (arr_tit[i].valor || arr_tit[i]);
                        celula = document.createElement("th");
                        linha_filtros.appendChild(celula);
                        input_filtro = document.createElement("input");
                        input_filtro.classList.add("input_filtro","form-control");
                        input_filtro.setAttribute("onkeyup","window.fnhtml.fntabdados.filtrar_tabdados(event,this)");
                        input_filtro.placeholder = "(Filtro)";
                        celula.appendChild(input_filtro);
                    }
                }
            }
            let corpo = document.createElement("tbody");
            tabela.appendChild(corpo);
            if (typeof dados !== "undefined" && dados !== null && dados.length) {				
                qt = dados.length;
                let qtcol = 0;
                let j = 0;
                if (qt > 0) {
                    if (fnjs.typeof(dados[0]) === "array") {
                        qtcol = dados[0].length;
                        for(i = 0; i < qt; i++) {
                            linha = document.createElement("tr");
                            corpo.appendChild(linha);
                            celula = document.createElement("td");
                            celula.classList.add("center");
                            linha.appendChild(celula);
                            checkbox = document.createElement("input");
                            celula.appendChild(checkbox);
                            checkbox.setAttribute("type","checkbox");
                            for(j = 0; j < qtcol; j++) {
                                celula = document.createElement("td");
                                linha.appendChild(celula);
                                celula.innerText = dados[i][j];
                            }
                        }
                    } else if (fnjs.typeof(dados[0]) === "object") {
                        let cols = Object.keys(dados[0]);
                        qtcol = cols.length;
                        for(i = 0; i < qt; i++) {
                            linha = document.createElement("tr");
                            corpo.appendChild(linha);
                            celula = document.createElement("td");
                            celula.classList.add("center");
                            linha.appendChild(celula);
                            checkbox = document.createElement("input");
                            celula.appendChild(checkbox);
                            checkbox.setAttribute("type","checkbox");
                            for(j = 0; j < qtcol; j++) {
                                celula = document.createElement("td");
                                linha.appendChild(celula);
                                celula.innerText = dados[i][cols[j]];
                            }
                        }
                    }
                }
            }
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'excluir',
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
            fnjs.logf(this.constructor.name,"inserir_dados_retorno_como_tabela");
         } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }       
    }

    inserir_retorno(params) { 
        try{
            fnjs.logi(this.constructor.name,"inserir_retorno");
            if (typeof params.comhttp.opcoes_retorno.metodo_insersao === "undefined") {
                params.comhttp.opcoes_retorno.metodo_insersao = 'append';
            }
            if (typeof params.comhttp.retorno.dados_retornados.conteudo_html !== "undefined") {								
                if (typeof params.comhttp.opcoes_retorno.ignorar_tabela_est === "undefined") {
                    params.comhttp.opcoes_retorno.ignorar_tabela_est = false;
                }
                if (
                    (
                        params.comhttp.requisicao.requisitar.oque.trim().toLowerCase() === 'dados_sql' 
                        || params.comhttp.requisicao.requisitar.oque.trim().toLowerCase() === 'dados_literais'                                 
                    )                               
                    && fnjs.como_booleano(params.comhttp.opcoes_retorno.ignorar_tabela_est)===false
                ) {
                    vars.iniciou_inclusao_tabela_est = true;
                    vars.terminou_inclusao_tabela_est = false;
                    setTimeout(
                        this.carregando,10,{
                            acao:"alterar_titulo",
                            id:params.comhttp.id_carregando || params.id_carregando,
                            titulo:"Dados recebidos, montando tabela..."
                        }
                    );
                    setTimeout(this.inserir_retorno_com_tabelaest,50,{comhttp:params.comhttp});
                } else {
                    params.comhttp.opcoes_retorno.metodo_insersao = params.comhttp.opcoes_retorno.metodo_insersao || 'append';	
                    this.incluir_elementos_html(params);
                    if ((params.comhttp.requisicao.requisitar.qual.objeto || "").trim().toLowerCase() !== "inicio" &&
                        params.comhttp.requisicao.requisitar.oque.trim().toLowerCase()!== 'dados_literais') {
                        this.mudar_titulo({titulo:(params.comhttp.requisicao.requisitar.qual.objeto||"").replace(/_/g," ").toUpperCase()});
                    }
                    window.fnreq.carregando({
                        texto:'processo_concluido',
                        acao:'esconder',
                        id:params.comhttp.id_carregando
                    });
                    if (typeof params.comhttp.retorno.dados_retornados.conteudo_javascript !== "undefined") {
                        if (params.comhttp.retorno.dados_retornados.conteudo_javascript !== null) {
                            if (params.comhttp.retorno.dados_retornados.conteudo_javascript.length) {
                            fnjs.carregar_conteudo_js(params.comhttp.retorno.dados_retornados.conteudo_javascript);
                            }
                        }
                    } 
                }
            }			
            fnjs.logf(this.constructor.name,"inserir_retorno");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 		
    }	

    inserir_retorno_como_menu_suspenso(params) {
        try{
            fnjs.logi(this.constructor.name,"inserir_retorno_como_menu_suspenso");
            let idrand = fnjs.id_random();
            fnmenususp.criar_menu_suspenso(fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno),{texto:'<div class="' + idrand + '">log:</div>',btn_fechar:true});
            if (typeof params.comhttp.retorno.dados_retornados.conteudo_html !== "undefined") {
                fnjs.obterJquery('div.' + idrand).append(params.comhttp.retorno.dados_retornados.conteudo_html);
            }
            if (typeof params.comhttp.retorno.dados_retornados.conteudo_javascript !== "undefined") {
                if (params.comhttp.retorno.dados_retornados.conteudo_javascript !== null) {
                    if (params.comhttp.retorno.dados_retornados.conteudo_javascript.length) {
                    fnjs.carregar_conteudo_js(params.comhttp.retorno.dados_retornados.conteudo_javascript);
                    }
                }
            } 
            window.fnreq.carregando({
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando
            });
            fnjs.logf(this.constructor.name,"inserir_retorno_como_menu_suspenso");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 	
    }		

    incluir_dados_sql(params) { 
        try{
            fnjs.logi(this.constructor.name,"incluir_dados_sql");
            if (typeof params.comhttp === "undefined") {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (params.comhttp === null) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (!params.comhttp.length) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            }
            $.each(params.opcoes.valores,function(index,element) {
                params.opcoes.valores[index] = params.opcoes.valores[index].replace(/,/g,vars.subst_virg);
            });
            params.ignorar_condicionantes_tab = params.ignorar_condicionantes_tab || false;
            params.comhttp.requisicao.requisitar.oque = 'incluir_dados_sql';
            params.comhttp.requisicao.requisitar.qual.condicionantes = [];
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('tabela=' + params.opcoes.tabela);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('campos=' + params.opcoes.campos);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('valores=' + params.opcoes.valores);
            if (typeof params.opcoes.condicionantestab !== "undefined") {
                params.comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantestab=' + params.opcoes.condicionantestab);
            }
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('ignorar_condicionantes_tab=' + params.ignorar_condicionantes_tab);
            params.comhttp.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao:'this.processar_retorno_como_mensagem'
                }
            ];
            if (typeof params.funcoes_apos_retornar === 'object') {
                if (params.funcoes_apos_retornar.length) {
                    $.each(params.funcoes_apos_retornar,function(index,element){
                        if (typeof element !== 'object') {
                            throw window.fnreq.mensagens.erro_tipo_func_ret;
                        }
                        params.comhttp.eventos.aposretornar.push(element);
                    });
                }
            }
            this.requisitar_servidor({comhttp:params.comhttp});
            fnjs.logf(this.constructor.name,"incluir_dados_sql");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 									
    }

    atualizar_dados_sql(params) {
        try{
            fnjs.logi(this.constructor.name,"atualizar_dados_sql");
            if (typeof params.comhttp === "undefined") {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (params.comhttp === null) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (!params.comhttp.length) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            }
            params.opcoes.processar_retorno_como = fnjs.first_valid([params.opcoes.processar_retorno_como,'this.processar_retorno_como_mensagem']);
            params.comhttp.requisicao.requisitar.oque = 'atualizar_dados_sql';
            params.comhttp.requisicao.requisitar.qual.condicionantes = [];
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('tabela=' + params.opcoes.tabela);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('campos=' + params.opcoes.campos);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('valores=' + params.opcoes.valores);
            /*
                a condicionante deve vir da forma que sera processada diretamente pelo sql, exemplo: tabela.campo = valor
            */
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantes=' + params.opcoes.condicionantes);
            if (typeof params.opcoes.seletor_retorno !== "undefined") {
                params.comhttp.opcoes_retorno.seletor_local_retorno = params.opcoes.seletor_retorno;
                if (typeof params.opcoes.processar_retorno_como === 'string') {
                    params.comhttp.eventos.aposretornar = [
                        {
                            arquivo:null,
                            funcao:params.opcoes.processar_retorno_como
                        }
                    ];
                } else if (typeof params.opcoes.processar_retorno_como === 'object') {
                    params.comhttp.eventos.aposretornar = params.opcoes.processar_retorno_como;
                } else {
                    alert(this.mensagens.erro_tipo_dados_ret + typeof params.opcoes.processar_retorno_como);
                }
            } else {			
                if (typeof params.opcoes.processar_retorno_como === 'string') {
                    params.comhttp.eventos.aposretornar = [
                        {
                            arquivo:null,
                            funcao:params.opcoes.processar_retorno_como
                        }
                    ];
                } else if (typeof params.opcoes.processar_retorno_como === 'object') {
                    params.comhttp.eventos.aposretornar = params.opcoes.processar_retorno_como;
                } else {
                    alert(this.mensagens.erro_tipo_dados_ret + typeof params.opcoes.processar_retorno_como);
                }
            }
            params.async = fnjs.first_valid([params.async,false]);
            this.requisitar_servidor(params);
            fnjs.logf(this.constructor.name,"atualizar_dados_sql");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        } 									
    }		

    excluir_dados_sql(params) { 
        try{
            fnjs.logi(this.constructor.name,"excluir_dados_sql");
            if (typeof params.comhttp === "undefined") {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (params.comhttp === null) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            } else if (!params.comhttp.length) {
                params.comhttp = JSON.parse(vars.str_tcomhttp);
            }
            params.comhttp.requisicao.requisitar.oque = 'excluir_dados_sql';
            params.comhttp.requisicao.requisitar.qual.condicionantes = [];
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('tabela=' + params.opcoes.tabela);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('campos=' + params.opcoes.campos);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('valores=' + params.opcoes.valores);
            params.comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantes=' + params.opcoes.condicionantes);
            params.comhttp.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao:'this.processar_retorno_como_mensagem'
                }
            ];
            this.requisitar_servidor(params);
            fnjs.logf(this.constructor.name,"excluir_dados_sql");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }								
    }

    #excluir_carregando(params) {
        try {
            params = params || {};
            if (params.id === '' || params.id === 'todos') {
                let divs = fnjs.obterJquery('div.div_modal');
                let qt = divs.length;
                for(let i = 0 ; i < qt; i++) {
                    let div_modal = bootstrap.Modal.getInstance(divs.eq(i)[0]);
                    if (typeof div_modal !== "undefined" && div_modal !== null && div_modal.length) {
                        div_modal.hide();
                    } else {
                        divs.eq(i).fadeOut(800, function(){ 
                            divs.eq(i).remove();
                        });						
                    }
                };
                divs = fnjs.obterJquery('div.modal-backdrop.show');
                qt = divs.length;
                for(let i = 0 ; i < qt; i++) {
                    divs.eq(i).remove();
                }
                
                params.objeto_carregando.attr("style",fnjs.first_valid([params.objeto_carregando.attr("style_bkp"),params.objeto_carregando.attr("style")]));
                if (params.objeto_carregando.prop("tagName") === "BODY" && (params.objeto_carregando.attr("style") ||"").indexOf("overflow: hidden") > -1) {
                    /*correção de erro desconhecido que retira o overflow do body*/
                    params.objeto_carregando.attr("style","");
                }
            } else {
                let el_modal = fnjs.obterJquery("#"+params.id);
                if (typeof el_modal !== "undefined" && el_modal !== null && el_modal.length) {                           
                    el_modal.fadeOut(800, function(){ 
                        el_modal.remove();
                        let div_backdrop = params.objeto_carregando.children("div.modal-backdrop.fade.show");
                        if (typeof div_backdrop !== "undefined" && div_backdrop !== null && div_backdrop.length) {
                            div_backdrop.remove();
                        }
                    });						
                }
                let div_backdrop = params.objeto_carregando.children("div.modal-backdrop.fade.show");
                if (typeof div_backdrop !== "undefined" && div_backdrop !== null && div_backdrop.length) {
                    div_backdrop.remove();
                }
                params.objeto_carregando.removeClass("modal-open");
                
                params.objeto_carregando.attr("style",fnjs.first_valid([params.objeto_carregando.attr("style_bkp"),params.objeto_carregando.attr("style")]));
                if (params.objeto_carregando.prop("tagName") === "BODY" && (params.objeto_carregando.attr("style")||"").indexOf("overflow: hidden") > -1) {
                    /*correção de erro desconhecido que retira o overflow do body*/
                    params.objeto_carregando.attr("style","");
                }
            }
        } catch(e){
            console.log(e);            
        }
    }

    carregando(params) {
        try{
            fnjs.logi(this.constructor.name,"carregando");
            let div = '',
                alvo = {},
                el_modal,
                div_modal;
            params = params || {};
            params.id = params.id || fnjs.id_random();
            params.acao = params.acao || 'mostrar';
            params.tipo = params.tipo || 'completo';
            params.titulo = params.titulo || "Carregando...";
            params.objeto_carregando = document.body;
            params.objeto_carregando = fnjs.obterJquery(params.objeto_carregando);
            if (params.acao === 'mostrar') { 
                
                el_modal = params.objeto_carregando.children("div.div_modal");
                if (typeof el_modal !== "undefined" && el_modal !== null && el_modal.length) {
                    params.id = el_modal.attr("id") || params.id;
                    params.objeto_carregando.attr("style_bkp",params.objeto_carregando.attr("style")||"");
                    el_modal.attr("id",params.id);
                    div_modal = bootstrap.Modal.getOrCreateInstance(el_modal[0],{
                        backdrop:'static'
                    });
                    if (params.objeto_carregando.prop("tagName") === "BODY") {
                        div_modal = div_modal;
                    }                    
                    params.objeto_carregando.attr("id_carregando",params.id);
                    div_modal.show();
                } else {

                    /*cria a div modal se nao existir*/
                    let params_criar_modal = {
                        tag:"div",
                        class:"div_modal modal fade",
                        id:params.id,
                        props:[
                            {
                                prop:"aria-labelledby",
                                value:"staticBackdropLabel"
                            },
                            {
                                prop:"data-bs-backdrop",
                                value:"static"
                            },
                            {
                                prop:"data-bs-keyboard",
                                value:"false"
                            },
                            {
                                prop:"aria-hidden",
                                value:"true"
                            }
                        ],
                        sub:[
                            {
                                tag:"div",
                                class:"modal-dialog modal-dialog-centered",
                                sub:[
                                    {
                                        tag:"div",
                                        class:"modal-content"
                                    }
                                ]
                            }
                        ]

                    };

                        params_criar_modal.sub[0].sub[0].sub = [
                            {
                                tag:"div",
                                class:"modal-header",
                                sub:[
                                    {
                                        tag:"h5",
                                        class:"modal-title",
                                        content:params.titulo
                                    }
                                ]
                            },
                            {
                                tag:"div",
                                class:"modal-body",
                                sub:[
                                    {
                                        tag:"div",
                                        class:"d-flex justify-content-center",
                                        sub:[
                                            {
                                                tag:"div",
                                                class:"spinner-border",
                                                sub:[
                                                    {
                                                        tag:"span",
                                                        class:"visually-hidden",
                                                        content:"Loading..."
                                                    }
                                                ]
                                            }
                                        ]
                                    }
                                ]
                            },
                            {
                                tag:"div",
                                class:"modal-footer"
                            }
                        ];
                    
                    let el_criado = fnhtml.criar_elemento(params_criar_modal);
                    params.objeto_carregando.append(el_criado);
                    el_modal = document.getElementById(params.id);
                    if (typeof el_modal !== "undefined" && el_modal !== null) {
                        params.objeto_carregando.attr("style_bkp",params.objeto_carregando.attr("style")||"");
                        params.objeto_carregando.attr("id_carregando",params.id);
                        div_modal = new bootstrap.Modal(el_modal,{
                            backdrop:'static'
                        });
                        div_modal.show();
                    }
                }
            } else if (params.acao === 'alterar') {
                fnjs.obterJquery('#'+params.id).find('strong').text(params.texto);
            } else if (params.acao === 'alterar_titulo') {
                fnjs.obterJquery('#' + params.id).find('div.modal-header h5.modal-title').replaceWith('<h5 class="modal-title">' + params.titulo + '</h5>');
                console.log(fnjs.obterJquery('#' + params.id).find('div.modal-header h5.modal-title'));
                console.log(fnjs.obterJquery('#' + params.id).find('div.modal-header h5.modal-title').text());
            } else { //esconder			
                setTimeout(window.fnreq.#excluir_carregando,300,params);
            }
            fnjs.logf(this.constructor.name,"carregando");
            return params.id;
        } catch(e) {
            console.log(e);
            alert(e.message || e);            
        }
    }

    requisitar_servidor_nova_thread(params) { 
        try{
            fnjs.logi(this.constructor.name,"requisitar_servidor_nova_thread");
            let tipo_requisicao = '';
            let nome_usuario_logado = vars.nome_usuario_logado || 'usuario';
            let destino = vars.nomes_caminhos_arquivos.requisicao_php;
            let id_requisicao = fnjs.id_random();
            params.teste = params.teste || false;
            params.requisitar_a_sjd = params.requisitar_a_sjd || false;
            tipo_requisicao = typeof params.comhttp.requisicao;
            if (tipo_requisicao === 'object') {
                if (fnjs.como_booleano(fnjs.first_valid([params.comhttp.opcoes_requisicao.mostrar_carregando || params.comhttp.mostrar_carregando])) === true) {
                    params.comhttp.id_carregando = window.fnreq.carregando({
                        titulo:"Consultando dados Servidor...",
                        acao:'mostrar',
                        id:params.comhttp.id_carregando,
                        tipo: params.comhttp.opcoes_requisicao.tipo_carregando,
                        tipo_alvo_carregando : params.comhttp.opcoes_requisicao.tipo_alvo_carregando,
                        objeto_carregando:params.comhttp.opcoes_requisicao.objeto_carregando						
                    });
                }
                params.comhttp.id = fnjs.id_random();
                params.comhttp.requisicao.id = params.comhttp.id;
                //alert(params.comhttp.opcoes_retorno.seletor_local_retorno);
                (fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno)||$(null)).addClass(params.comhttp.requisicao.id);
                params.comhttp.opcoes_retorno.seletor_local_retorno = '.' + params.comhttp.requisicao.id;
                if (params.comhttp.requisicao.requisitar.oque !== 'logar' && params.comhttp.requisicao.requisitar.oque !== 'login' ) {
                    vars.ultima_requisicao = params.comhttp;
                    vars.ultimo_destino_requisicao = vars.nomes_caminhos_arquivos.requisicao_php;
                }
                if (params.requisitar_a_sjd === true) {
                    destino = vars.nomes_caminhos_arquivos.requisicao_php_sjd;
                }
                
                /*
                    transforma os objetos contidos nos eventos de retorno em seletores
                */	
                if (typeof params.comhttp.opcoes_retorno.seletor_local_retorno !== "undefined" && params.comhttp.opcoes_retorno.seletor_local_retorno !== null && params.comhttp.opcoes_retorno.seletor_local_retorno.length) {
                    if (fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).length) {						
                        fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno).addClass(id_requisicao);
                    }
                }
                if (typeof params.comhttp.eventos.aposretornar !== "undefined") {
                    if (params.comhttp.eventos.aposretornar !== null) {
                        let qt = 0;
                        qt = params.comhttp.eventos.aposretornar.length;
                        for (let i = 0; i < qt; i++) {
                            if (typeof params.comhttp.eventos.aposretornar[i].parametros !== "undefined") {
                                if (params.comhttp.eventos.aposretornar[i].parametros !== null) {
                                    if (typeof params.comhttp.eventos.aposretornar[i].parametros.elemento !== "undefined") {
                                        if (params.comhttp.eventos.aposretornar[i].parametros.elemento !== null) {
                                            if (typeof params.comhttp.eventos.aposretornar[i].parametros.elemento !== 'string') {
                                                
                                                fnjs.obterJquery(params.comhttp.eventos.aposretornar[i].parametros.elemento).addClass(id_requisicao);
                                                params.comhttp.eventos.aposretornar[i].parametros.elemento = '.' + id_requisicao;
                                            }											 
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                
                params.async = fnjs.first_valid([params.async,true]);
                $.ajaxSetup({
                    async:params.async,
                    type:"POST",
                    cache:false
                });
                console.log("requisitando a " + destino);
                console.log("parametros:" , params.comhttp);
                params.comhttp.retorno = {};
                if (typeof params.comhttp.requisicao.requisitar.qual.objeto === "object") {
                    params.comhttp.requisicao.requisitar.qual.objeto = "";
                }
                $.ajax({
                    async:params.async,
                    type:"POST",
                    url:destino,
                    data:params.comhttp,
                    cache:false,
                    success:function(comhttp_retorno){
                        console.log("Inicio ajax.success");
                        try {
                            comhttp_retorno = comhttp_retorno.trim();
                            window.fnreq.receber_dados({comhttp:params.comhttp,comhttp_retorno:comhttp_retorno});    
                            console.log("fim ajax.success");
                        } catch (e_processamento) {
                            console.log(e_processamento);
                            alert(e_processamento.message || e_processamento);
                        }
                    },
                    error:function(request,textStatus,error){
                        console.log("Inicio ajax.error");
                        console.log('falha:');
                        console.log(request);
                        console.log(textStatus);
                        console.log(error);
                        window.fnreq.carregando({
                            acao:'esconder',
                            id:params.comhttp.id_carregando
                        });
                        throw error; 
                        console.log("Fim ajax.error");
                    }
                });
                
            } else {
                throw this.mensagens.tipo_req_nao_implementado + tipo_requisicao;
            }
            fnjs.logf(this.constructor.name,"requisitar_servidor_nova_thread");
        } catch(e) {
            console.log(e);
            alert(e.message || e);            
            window.fnreq.carregando({
                acao:"excluir",
                id:"todos"
            });
        }
    }

    requisitar_servidor(params) { 
        try {
            params.async = fnjs.first_valid([params.async,true]);
            if (params.async) {
                setTimeout(this.requisitar_servidor_nova_thread,100,params);
            } else {
                this.requisitar_servidor_nova_thread(params);
            }
            fnjs.logf(this.constructor.name,"requisitar_servidor");
        } catch (e) {
            console.log(e);
            alert(e.message || e);
        }
    }


    /*
        É chamada quando a pagina é carregada no navegador. Obtem os elementos html basicos da pagina. 
        no seu retorno (incluir_inicio) é feita uma nova requisicao para preencher o corpo da pagina com 
        os elementos da opção a qual a pagina faz referencia
    */
    requisitar_inicio(params) {
        try {
            fnjs.logi(this.constructor.name,"requisitar_inicio");
            let params_req = {
                async: false,
                comhttp: JSON.parse(vars.str_tcomhttp)
            };
            params = params || {};
            params.recurso = params.recurso || params.elemento || params.obj;
            params.efetuar_pesquisa = params.efetuar_pesquisa || false;
            params_req.comhttp.requisicao.requisitar.oque = 'conteudo_html';
            params_req.comhttp.requisicao.requisitar.qual.condicionantes = [];
            params_req.comhttp.requisicao.requisitar.qual.comando = "consultar";
            params_req.comhttp.requisicao.requisitar.qual.tipo_objeto = 'opcao_sistema';
            params_req.comhttp.requisicao.requisitar.qual.objeto = "pagina";			
            params_req.comhttp.opcoes_retorno.seletor_local_retorno = "body";
            params_req.comhttp.opcoes_retorno.metodo_insersao = 'html';
            params_req.comhttp.opcoes_requisicao.mostrar_carregando = false;
            params_req.comhttp.eventos.aposretornar = [
                {
                    arquivo:null,
                    funcao :'window.fnreq.incluir_inicio',
                    parametros:{recurso:params.recurso,efetuar_pesquisa:params.efetuar_pesquisa}
                }
            ];			
            params_req.async = fnjs.first_valid([params_req.async,false]);
            this.requisitar_servidor(params_req);
            fnjs.logf(this.constructor.name,"requisitar_inicio");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            window.fnreq.carregando({
                acao:"excluir",
                id:params.comhttp.id_carregando || params.id_carregando || "todos"
            });
        }
    }
};
var fnreq = new FuncoesRequisicao();

window.fnreq = fnreq;

export { fnreq };

