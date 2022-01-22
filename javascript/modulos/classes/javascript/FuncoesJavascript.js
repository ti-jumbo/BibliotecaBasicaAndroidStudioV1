import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';

class FuncoesJavascript{    
    constructor(){        
        try {
            this.logi(this.constructor.name);
            this.mostrar_log_ini = true;
            this.mostrar_log_fim = true;
            this.nomes_variaveis = {
                FuncoesJavascript : "FuncoesJavascript"
            };
            this.nomes_variaveis.fnjs_pt = this.nomes_variaveis.FuncoesJavascript + '.';
            this.mensagens = {
                erro_conteudo_branco : "Erro ao carregar o conteudo js, conteudo em branco"
            };
            this.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    getMomento(){
        let momento=new Date();
        momento=momento.getDay().toString().padStart(2,'0')+'/'+((momento.getMonth()+1).toString().padStart(2,'0'))+'/'+momento.getFullYear()+' '+momento.getHours()+':'+momento.getMinutes()+':'+momento.getSeconds()+'.'+momento.getMilliseconds();
        return momento;
    };

    log(v1,v2,v3){
        try{
            if (typeof v1 !== "undefined") {
                if (typeof v2 !== "undefined") {
                    if (typeof v3 !== "undefined") {
                        console.info(this.getMomento(),'-',v1,v2,v3);            
                    } else {
                        console.info(this.getMomento(),'-',v1,v2);
                    }
                } else {
                    console.info(this.getMomento(),'-',v1);
                }
            }
        }catch(e){
            console.log(e);					  
            alert(e.message || e);
        }		            
    };

    logi(p_nome_classe,p_nome_funcao){
        try {
            if (this.mostrar_log_ini) {                
                if (typeof p_nome_funcao !== "undefined") {
                    this.log('Inicio ',p_nome_classe + "." + p_nome_funcao);
                } else {
                    this.log('Inicio ',p_nome_classe);
                }
            }
        }catch(e){
            console.log(e);					  
            alert(e.message || e);									
        }
    };

    logf(p_nome_classe,p_nome_funcao){		
        try {
            if (this.mostrar_log_fim) {
                if (typeof p_nome_funcao !== "undefined") {
                    this.log('Fim ',p_nome_classe + "." + p_nome_funcao);
                } else {
                    this.log('Fim ',p_nome_classe);
                }
            }
        }catch(e){
            console.log(e);					  
            alert(e.message || e);								
        }
    }; 


    /**
     * Retorna o tipo do elemento passado como parametro. Adicionalmente e diferentemente do typeof normal,
     * verifica se eh do tipo array.
     * @param {variant} value - o elemento
     * @returns {string} - o tipo encontrado
     */
     typeof(value){
        let r = typeof value;
        if (Array.isArray(value) || value instanceof NodeList || value instanceof Array) {
            r = "array";
        }
        return r;
    }

    /*checa de um array de falores, o primeiro que nao seja undefined e retorna-o. 
      adicionalmente, checa se o elemento é nulo .Esta funcao é um hotfix para o operador unario || do 
      javascript a fim de corrigir o bug quando ao invez de o valor for undefined, for false ou 0, pois
      esse operador unario ignoraria isso. Nas utilizacoes do operador unario || que não envolvem booleanos 
      ou que não se queira checar se nulo sera considerado é desnecessário utilizar essa funcao .
      @param arr_valores : array - o array de valores a serem checados, a ordem sera do primeiro para o ultimo
      @check_null : boolean = true - checa se o valor é nulo, se for, continua procurando (
          para ignorar esta checage, chamar a funcao com esse parametro como false (padrao = true)
      )
    */
    first_valid(arr_valores,check_null) {
        try {
            //this.logi(this.constructor.name,"first_valid");
            if (typeof arr_valores !== "undefined") {
                check_null = check_null === false ? false : true;
                if (arr_valores !== null) {            
                    if (this.typeof(arr_valores) === "array") {
                        let q = arr_valores.length;                
                        if (check_null) {
                            for (let i = 0; i < q; i++) {
                                if (typeof arr_valores[i] !== "undefined" && arr_valores[i] !== null) {
                                    return arr_valores[i];
                                };
                            }
                        } else {
                            for (let i = 0; i < q; i++) {
                                if (typeof arr_valores[i] !== "undefined") {
                                    return arr_valores[i];
                                }
                            }
                        }
                    } 
                } 
            }            
            //this.logf(this.constructor.name,"first_valid");
            return null;
        }catch(e){
            console.log(e);            
            alert(e.message || e);            
            return null;
        } 
    };


    /**
     * Gera um id randomico, substituindo o . por _ para tornalo elegivel a class e id de elementos html
     * @returns {string} - a id gerada
     */
     id_random(){
        return '_' + Math.random().toString().replace('.','_');
    }

    obterJquery(obj) {
        try {
            //this.logi(this.constructor.name,"obterJquery");
            if (typeof obj !== "undefined" && obj !== null && 
                (
                    !(obj instanceof ($ || null))
                    ||(typeof obj === "string" && obj.length)
                )
            ) {
                return $(obj);
            } else {
                return obj;
            }
            //this.logf(this.constructor.name,"obterJquery");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
     * Injeta no inicio do head html um bloco <script> com o conteudojs passado no parametro
     * @param {string} conteudojs - o conteudo javascript a injetar
     * @param {string} chamador - quem chamou a funcao, para aparecer no log em caso de falha
     */
    carregar_conteudo_js(conteudojs) {
         try {
            this.logi(this.constructor.name,"carregar_conteudo_js");
             let script = document.createElement('script'),
                prior = document.currentScript || ( function () { 
                    let scripts = document .getElementsByTagName('script'); 
                    return scripts[scripts.length - 1]; 
                })(),
                
                msg_erro_branco = 'conteudo em branco';
                //prefixo = 'try{',
                //sufixo = vars.bloco_catch;
            if(typeof prior !== 'undefined') {
            } else {
                prior = document.querySelector('script');
                if (typeof prior !== "undefined" && prior !== null) {
                } else {
                    prior = document.querySelector('body');
                }
            }
             let erro_no_carregamento=true;
             if(conteudojs.trim()===''){
                 throw msg_erro_branco;
             }
             script.type='module';
             //script.textContent=prefixo;
             script.textContent+=conteudojs;
             //script.textContent+=sufixo;
             console.log(script);
             prior.parentNode.insertBefore(script,prior);
            this.logf(this.constructor.name,"carregar_conteudo_js");
         }catch(e){
            console.log(e);
            alert(e.message || e);
         }
     }
    
     /**
      * Converte um valor em booleano conforme parametros
      * @param {variant} valor - o valor a ser convertido
      * @param {string} retornar_como - como ira retornar, padrao = booleano, mas pode ser string
      * @returns 
      */
     como_booleano(valor,retornar_como){		
         try{
            //this.logi(this.constructor.name,"como_booleano");
            retornar_como = this.first_valid([retornar_como,'booleano']);			
            //this.logf(this.constructor.name,"como_booleano");
             if(typeof valor !== 'undefined') {
                if (retornar_como === 'booleano') {
                    return (['true','1','sim'].indexOf(String(valor).trim().toLowerCase()) > -1);
                } else {
                    if ((['true','1','sim'].indexOf(String(valor).trim().toLowerCase()) > -1)) {
                        return 'true';
                    } else {
                        return 'false';
                    }
                }
             }else{				
                if (retornar_como === 'booleano') {
                    return false;
                } else {
                    return 'false';
                }
             }
         }catch(e){
            console.log(e);
            alert(e.message || e);
            return false;
         } 		
     }
     
    
     /**
      * Retorna o scroll (posicao em funcao da barra de rolagem) de um elemento na pagina
      * @param {object} obj - o elemento html
      * @returns {object} - o objeto scroll (x,y)
      */
     getScroll(obj) {
        try {
            this.logi(this.constructor.name,"getScroll");
            let retorno = {x:0,y:0};
            if (obj.length > 0) {
                objtemp = obj;
                objtemp2 = null;
                while (objtemp.length) {
                    objtemp2 = objtemp[0];
                    retorno.x = retorno.x + (objtemp2.scrollLeft || 0);
                    retorno.y = retorno.y + (objtemp2.scrollTop  || 0);
                    objtemp = objtemp.parent();
                }				
            }
            this.logf(this.constructor.name,"getScroll");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }						
    }            
    
    /**
     * Retorna a posicao de um elemento html na tela, considerando o scroll
     * @param {object} obj 
     * @returns {object} - o objeto position (x,y) do elemento
     */
    getPosition(obj) {
        try {
            this.logi(this.constructor.name,"getPosition");
            let retorno = {x:0,y:0};
            if (obj.length > 0) {
                let rect = obj[0].getBoundingClientRect();						
                scroll = this.getScroll(obj);						
                retorno.x = rect.left + scroll.x;
                retorno.y = rect.bottom + scroll.y;
            }
            this.logf(this.constructor.name,"getPosition");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }						
    }
    
    /**
     * Seta a posicao do cursor num elemento html conforme o caretPos parametro
     * @param {object} elem - o elemento html
     * @param {int} caretPos - a posicao desejada do cursor
     */
    setCaretPosition(elem, caretPos){
        try {
            this.logi(this.constructor.name,"setCaretPosition");
            if (elem) {
                if (typeof elem.createTextRange != 'undefined') {
                    let range = elem.createTextRange();
                    range.move('character', caretPos);
                    range.select();
                } else {
                    if (typeof elem.selectionStart != 'undefined') {
                        elem.selectionStart = caretPos;
                        elem.selectionEnd = caretPos;
                    }
                    elem.focus();
                }
            }
            this.logf(this.constructor.name,"setCaretPosition");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }	

    /**
     * Gera uma cor aleatoria no estilo hexadecimal de 6 caracteres
     * @returns {string} - a cor gerada 
     */            
    gerar_cor(){
        try {
            this.logi(this.constructor.name,"gerar_cor");
            let cor = '';
            for (let i = 0; i < 6; i++ ) {
                cor += vars.hexadecimais[Math.floor(Math.random() * 16)];
            }
            this.logf(this.constructor.name,"gerar_cor");
            return "#" + cor;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
     * Converte uma cor no estilo rgb para hexadecimal
     * @param {int} r 
     * @param {int} g 
     * @param {int} b 
     * @returns {string} - a cor convertida
     */
    corRgbParaCorHex(r, g, b) {
        try {
            this.logi(this.constructor.name,"corRgbParaCorHex");
            if (r > 255 || g > 255 || b > 255)
                throw "Invalid color component";
            this.logf(this.constructor.name,"corRgbParaCorHex");
            return ((r << 16) | (g << 8) | b).toString(16);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
     * Transforma, num elemento de entrada de texto, a tecla tab, fazendo com que seja incluido 4 espacos
     * ao invez de pular campo.
     * @param {object} params 
     */
    como_tab(params) {
        try {
            this.logi(this.constructor.name,"como_tab");
           let posAnterior = params.elemento.selectionStart;
           let posPosterior = params.elemento.selectionEnd;

           params.elemento.value = params.elemento.value.substring(0, posAnterior)
                            + '    '
                            + params.elemento.value.substring(posPosterior);    
           params.elemento.selectionStart = posAnterior + 1;
           params.elemento.selectionEnd = posAnterior + 1;
           // não move pro próximo elemento
           params.event.preventDefault();			
            this.logf(this.constructor.name,"como_tab");
       }catch(e){
           console.log(e);
           alert(e.message || e);
        }				
    }			
   
   /**
       * Funcao que verifica a tecla digitada num objeto e se parametrizado, executa algo em funcao dessa tecla
       * @obs Nao mudado para 'params' porque a geracao de um objeto empacotado com os params a cada tecla digitada prejudicaria a performance da digitacao
       * @param obj Object - O objeto onde a tecla foi apertada
       * @param event Event - O evento da tecla
       * @param tecla_acao Array{} - O conjunto de teclas relacionado a acoes que devem ser executadas
       * @param teclas_permitidas Array[] - O conjunto de teclas permitidas
       * @author Antonio Alencar Velozo
       * @create 01/01/2019
   */
    verificar_tecla(obj,event,tecla_acao,teclas_permitidas) {
        try {
            this.logi(this.constructor.name,"verificar_tecla");
            teclas_permitidas = teclas_permitidas || [];			
            if (typeof tecla_acao !== 'undefined') {
                if (typeof tecla_acao === 'object') {
                   if (typeof tecla_acao['todas'] !== 'undefined') {						
                       if (typeof tecla_acao[event.key] !== 'undefined') {
                           eval(tecla_acao['todas'].replace('this','obj'));
                       }
                       if (teclas_permitidas.length > 0 && teclas_permitidas.indexOf(event.key) === -1) {
                           if (vars.consts.teclas_especiais.indexOf(event.key) === -1) {
                               this.obterJquery(obj).after('<div class="' + fnsisjd.classes.div_aviso_temporario + '">' +vars.mensagens.tecla_nao_permitida + event.key + '</div>');
                           }
                       }
                   } else {
                       if (typeof tecla_acao[event.key] !== 'undefined') {
                           eval(tecla_acao[event.key].replace('this','obj'));
                       }
                       if (teclas_permitidas.length > 0 && teclas_permitidas.indexOf(event.key) === -1) {
                           if (vars.consts.teclas_especiais.indexOf(event.key) === -1) {
                               if (this.obterJquery(obj).next(fnsisjd.seletores.div_aviso_temporario).length) {
                                   this.obterJquery(obj).next(fnsisjd.seletores.div_aviso_temporario).remove();
                               }
                               this.obterJquery(obj).after('<div class="' + fnsisjd.classes.div_aviso_temporario + '">' +vars.mensagens.tecla_nao_permitida + event.key + '</div>');
                               setTimeout(fnhtml.esmaecer,1000,this.obterJquery(obj).next('div'),3000);
                           }
                       }

                   }
                }
            }
            this.logf(this.constructor.name,"verificar_tecla");
        }catch(e){
           console.log(e);
           alert(e.message || e);
        }				
    }   

    copiar_texto_input_area_transferencia(input) {
        try {
            this.logi(this.constructor.name,"copiar_texto_input_area_transferencia");
            console.log(input);
            let disabled = input.disabled;
            if (disabled) {
                input.disabled = false;
                this.obterJquery(input).removeAttr("disabled");
            }
            input.focus();
            input.select();
            let success = document.execCommand('copy');
            if (disabled) {
                input.disabled = disabled;
                this.obterJquery(input).attr("disabled",disabled);
            }
            if (success === 'successful' || success === true) {
                this.obterJquery(input).after('<div class="alert alert-primary alert-dismissible fade show" role="alert" style="position:absolute;top:40px;left:100px;">Copiado</div>');                
                let el_text_alert = this.obterJquery(input).next("div")[0];
                let obj_text_alert = new bootstrap.Alert(el_text_alert);                
                setTimeout(fnhtml.esmaecer,3000,el_text_alert,2000);
            } else {
                this.obterJquery(input).after('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="position:absolute;top:40px;left:100px;">Erro ao copiar: '+success+'</div>');
                let el_text_alert = this.obterJquery(input).next("div")[0];
                let obj_text_alert = new bootstrap.Alert(el_text_alert);                
                setTimeout(fnhtml.esmaecer,3000,el_text_alert,2000);
            }
            this.logf(this.constructor.name,"copiar_texto_input_area_transferencia");
        }catch(e){
           console.log(e);
           alert(e.message || e);
        }				
    
    }

    detectar_dispositivo(sjd){
        try {            
            console.log('Inicio ' + this.constructor.name + '.detectar_dispositivo');
            vars.dispositivo = 'pc';
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                vars.dispositivo = 'celular';
            }
            return vars.dispositivo;
            console.log('Fim ' + this.constructor.name + '.detectar_dispositivo');
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }	

    detectar_navegador(){
        try{
            console.log('Inicio ' + this.constructor.name + '.detectar_navegador');
            let navegador = "padrao";
            if (/Firefox/i.test(navigator.userAgent)) {
                navegador = "firefox";
            } else if (/Chrome/i.test(navigator.userAgent)) {
                navegador = "chrome";
            } else if (/Microsoft|IE|MSIE|Trident/i.test(navigator.userAgent)) {
                navegador = "iexplorer";
            } else if (/Opera|OPR/i.test(navigator.userAgent)) {
                navegador = "opera";
            } else {
                navegador = "padrao";
            }
            return navegador;	
            console.log('Fim ' + this.constructor.name + '.detectar_navegador');
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }	
    alturajanela(){
        try {
            console.log('Inicio ' + this.constructor.name + '.alturajanela');
            return Number(window.innerHeight);
            console.log('Fim ' + this.constructor.name + '.alturajanela');
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }
    LarguraJanela(){
        try{
            console.log('Inicio ' + this.constructor.name + '.LarguraJanela');
            return Number(window.innerWidth);
            console.log('Fim ' + this.constructor.name + '.LarguraJanela');
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    
};

var fnjs = new FuncoesJavascript();

window.fnjs = fnjs;

export { fnjs };