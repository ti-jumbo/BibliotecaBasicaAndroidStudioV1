import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';
import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';
import { fnreq } from '/sjd/javascript/modulos/classes/requisicao/FuncoesRequisicao.js';

/**Classe FuncoesString - utilidades para string */
class FuncoesString {
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.nomes_variaveis = {
                FuncoesString : "FuncoesString"
            };
            this.nomes_variaveis.fnjs_pt = this.nomes_variaveis.FuncoesString + '.';
            this.nomes_funcoes = {
                string_para_json : "string_para_json"
            };
            this.nomes_completos_funcoes = {			
                string_para_json : this.nomes_variaveis.fnjs_pt + this.nomes_funcoes.string_para_json
            },
            this.mensagens = {
                erro_conversao_json : "erro de conversao de string para json",
                erro_conversao_numerica : "erro na conversao numerica"
            };  
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };

    string_para_json(valor) {
        try {
            //fnjs.logi(this.constructor.name,"string_para_json");
            let tipo_valor = null,
                retorno = null;
            tipo_valor = typeof valor;
            if (tipo_valor === 'string') {
                valor = valor.trim();
                let pinijson = -1;
                pinijson = valor.indexOf('{');
                if (pinijson === 0) {
                    retorno = JSON.parse(valor);
                    if (typeof retorno === 'undefined' || retorno === null) {
                        throw this.mensagens.erro_conversao_json;				
                    }
                } else {
                    alert(this.mensagens.erro_conversao_json + vars.quebra_linha + valor);
                    fnreq.carregando({
                        acao:"excluir",
                        id:"todos"
                    });
                }
            } else {
                throw this.mensagens.erro_conversao_json;
            }
            //fnjs.logf(this.constructor.name,"string_para_json");
            return retorno;		
        } catch(e) {                    
            console.log(e);
            console.log(valor);
            alert(e.message || e);
        } 	
    }	
    aspas_duplas(texto){
        try{
            return '"'+texto+'"';
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }
    
    primeira_maiuscula(texto){
        try{
            return texto.charAt(0).toUpperCase()+texto.slice(1);
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }	
    rtrim(str){
        try{
            return str.replace(/\s+$/,'');
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }	
    str_contem(str,procurar){
        try{
            fnjs.logi(this.constructor.name,"str_contem");
            let tipo_procurar='',
                tipo_str='',
                encontrado=false;
            tipo_str=typeof str;
            tipo_procurar=typeof procurar;
            if(tipo_str==='string'){
                if(tipo_procurar==='string'){
                }else if(tipo_procurar==='object'){	
                    $.each(procurar,function(index,element){
                        if(str.indexOf(element)!==-1){
                            encontrado=true;
                            return false;
                        }
                    });
                }else{
                    alert(tipo_procurar);
                }
            }
            fnjs.logf(this.constructor.name,"str_contem");
            return encontrado;
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }
    str_posicoes(str,procurar){
        try{
            fnjs.logi(this.constructor.name,"str_posicoes");
            let tipo_procurar='',
                tipo_str='',
                pos=0,
                arr_ret=[];
            tipo_str=typeof str;
            tipo_procurar=typeof procurar;
            if(tipo_str==='string'){
                if(tipo_procurar==='string'){
                }else if(tipo_procurar==='object'){	
                    $.each(procurar,function(index,element){
                        pos=str.indexOf(element);
                        if(pos!==-1){
                            arr_ret[arr_ret.length]=[];
                            arr_ret[arr_ret.length-1][0]=element;
                            arr_ret[arr_ret.length-1][1]=pos;
                        }
                    });
                }else{
                    alert(tipo_procurar);
                }
            }
            fnjs.logf(this.constructor.name,"str_posicoes");
            return arr_ret;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }	
    trim( valor){
        try{
            let tipo = typeof valor ;
            if(tipo !== 'string'){ 
                return false ;
            }
            return valor.replace(/\s/g,'');
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }	

    
};

var fnstr = new FuncoesString();

export { fnstr };