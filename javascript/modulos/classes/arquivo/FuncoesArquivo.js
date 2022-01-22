import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

/*Classe FuncoesArquivo */
class FuncoesArquivo{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.arqs_carregados = [];
            this.arqs_em_carregamento = [];
            this.nomes_variaveis = {
                FuncoesArquivo : "FuncoesArquivo"
            };
            this.nomes_variaveis.fnarq_pt = this.nomes_variaveis.FuncoesArquivo + '.';
            this.nomes_funcoes = {
                carregar_arquivo_js : "carregar_arquivo_js"
            };
            this.nomes_completos_funcoes = {
                carregar_arquivo_js : this.nomes_variaveis.fnarq_pt + this.nomes_funcoes.carregar_arquivo_js
            };
            this.mensagens = {
                arq_ja_carregado : "arquivo ja carregado: ",
                arq_na_fila : "arquivo ja esta na fila de carregamento: ",
                arq_nao_encontrado: "Arquivo nao encontrado: ",
                arq_undef : "arquivo undefined",
                carregando_arq : "carregando arquivo: ",
                chamador : " chamador: ",
                erro_arq_branco : "Erro ao carregar o arquivo, nome em branco",
                erro_no_carregamento:"Erro no carregamento do arquivo",
                requisitante : " requisitante: "
            }; 
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);           
        }
    };
            
    carregar_arquivo_js(arquivojs,chamador) {
        try {            
            fnjs.logi(this.constructor.name,"carregar_arquivo_js");
            let script = document.createElement('script');
            let prior = document.getElementsByTagName('script')[0];
            let rq = new  XMLHttpRequest();
            if (arquivojs !== undefined) {
                arquivojs = arquivojs.trim().toLowerCase();
                if (arquivojs !== '') {
                    chamador = chamador || (typeof arguments !== 'undefined'?(typeof arguments.callee !== 'undefined'?(typeof arguments.callee.caller !== 'undefined' && arguments.callee.caller !== null?arguments.callee.caller.name:''):''):'');
                    if (fnarq.arqs_carregados.indexOf(arquivojs) > -1) {
                        return;
                    }else if (fnarq.arqs_em_carregamento.indexOf(arquivojs) > -1) {
                        return;
                    }
                    script.type = 'type/javascript';
                    rq.onload = function(e) {
                        if (this.status !== 200) {
                            throw fnarq.mensagens.erro_no_carregamento +' ' +  rq.responseURL + ' ' +  this.status + ' ' + this.statusText + ' ' + fnarq.mensagens.requisitante + ' ' +  chamador;
                        }
                        script.textContent = rq.responseText;
                        prior.parentNode.insertBefore(script,prior);
                        fnarq.arqs_carregados.push(arquivojs);
                        fnarq.arqs_em_carregamento.slice(fnarq.arqs_em_carregamento.indexOf(arquivojs),fnarq.arqs_em_carregamento.indexOf(arquivojs));
                    };
                    rq.onerror = function(e) {
                        console.log(e);
                        alert(fnarq.mensagens.erro_no_carregamento + rq.responseURL + e.message + fnarq.mensagens.requisitante + chamador);
                    };
                    console.log('arquivo: ' + arquivojs);
                    rq.open('get',arquivojs + '?' + new Date().toString(),false);
                    rq.send();
                }
            } 
            fnjs.logi(this.constructor.name,"carregar_arquivo_js");
        } catch(e) {			
            console.log(e);
            alert(e.message || e);			
        } 			
    }
}
var fnarq = new FuncoesArquivo();

export { fnarq };
