/**
 * Classe FuncoesObjeto
 */
 class FuncoesObjeto{

    static #instance = null;

    static getInstance(){
        if (FuncoesObjeto.#instance == null) {
            FuncoesObjeto.#instance = new FuncoesObjeto();
        }
        return FuncoesObjeto.#instance;
    }

     constructor() {
        try {
            fnjs.logi(this.constructor.name);
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };

    /**
     * Obtem o valor de uma propriedade de um objeto com base em seu caminho. Adicionalmente também pode 
     * setar esse valor conforme params.
     * @param {object} obj - o objeto de referencia
     * @param {array || string} caminho_prop - o caminho da propriedade dentro do objeto
     * @param {object} params - parametros adicionais
     * @returns {variant} o valor da propriedade encontrado (undefined se nao existe)
     * @created 01/01/2021
     * @update 17/05/2021 - acrescentado o params com opcao de setar valor, para reutilizacao de codigo
     */
    obter_propriedade_interna(obj, caminho_prop, params) {		
        try {
            fnjs.logi(this.constructor.name,"obter_propriedade_interna");
            let retorno = null;
            params = params || {};
            params.setar_valor = fnjs.first_valid([params.setar_valor,false]);
            if (typeof obj === 'object') {                    
                let tipo_caminho = fnjs.typeof(caminho_prop);
                if (tipo_caminho === 'string') {
                    caminho_prop = caminho_prop.split(',');
                    tipo_caminho = 'array';
                }
                if (tipo_caminho === 'array') {
                    let profund_caminho = caminho_prop.length;
                    let obj_interno = obj;
                    for(let i = 0; i < profund_caminho; i++) {
                        if (typeof obj_interno !== 'undefined') {
                            if (params.setar_valor === true && typeof obj_interno[caminho_prop[i]] === 'undefined') {
                                if (i === (profund_caminho - 1)) {
                                    obj_interno[caminho_prop[i]] = params.valor;
                                } else {
                                    obj_interno[caminho_prop[i]] = [];
                                }
                            }
                            obj_interno = obj_interno[caminho_prop[i]];
                            if (params.setar_valor === true && i === (profund_caminho - 1)) {
                                obj_interno[caminho_prop[i]] = params.valor;
                            }
                        } else {                                
                            break;
                        }
                    }
                    retorno = obj_interno;
                } else {
                    throw 'tipo caminho_prop nao esperado: ' + tipo_caminho;
                }
            }
            fnjs.logf(this.constructor.name,"obter_propriedade_interna");
            return retorno;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
     * Verifica se uma propriedade existe, baseada no caminho dela dentro do objeto
     * @param {object} obj - o objeto de referencia
     * @param {array | string} caminho_prop - o caminho da propriedade dentro do objeto
     * @param {booelan} verif_tamanho_maior_0 - se deve verificar se o valor da propriedade tem tamanho > 0
     * @returns {boolean} se a propriedade existe ou nao conforme parametros
     */
    verif_existe(obj, caminho_prop , verif_tamanho_maior_0) {
        try {
            fnjs.logi(this.constructor.name,"verif_existe");
            let retorno = false;
            let propriedade = null;
            obj = obj || {};
            verif_tamanho_maior_0 = fnjs.first_valid([verif_tamanho_maior_0,true]);		
            propriedade = this.obter_propriedade_interna(obj,caminho_prop);
            if (typeof propriedade !== 'undefined') {
                if (verif_tamanho_maior_0 === true) {
                    if (propriedade !== null) {
                        if (propriedade || Object.keys(propriedade).length || propriedade.length) {
                            retorno = true;
                        } 
                    }
                } else {
                    retorno = true;
                }
            }
            fnjs.logf(this.constructor.name,"verif_existe");
            return retorno;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    /**
     * Transforma um params.elemento (Node) em uma string de seletor para esse elemento, util 
     * em requisicoes http
     * @param {object} params - os parametros para a funcao 
     * @returns {string} a classe gerada
     */
    transformar_elemento_classe_seletor(params) {                
        try {
            fnjs.logi(this.constructor.name,"transformar_elemento_classe_seletor");
            let idrand = fnjs.id_random();
            if (this.verif_existe(params,['elemento'])) {
                fnjs.obterJquery(params.elemento).addClass(idrand);
                params.elemento = '.' + idrand;
            } else if (this.verif_existe(params,['parametros','elemento'])) {
                fnjs.obterJquery(params.parametros.elemento).addClass(idrand);
                params.parametros.elemento = '.' + idrand;
            } else {
                console.log(params);
                throw 'params espera propriedade elemento, nao encontrada';
            }
            fnjs.logf(this.constructor.name,"transformar_elemento_classe_seletor");
            return idrand;
        } catch (e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    /**
     * Compara um valor de uma propriedade de um objeto conforme parametros de tipo e comparacao.
     * @param {object} obj - o objeto do qual se quer comparar uma propriedade com um valor
     * @param {array || string} caminho_prop - o caminho da propriedade
     * @param {variant} valor - o valor de comparacao
     * @param {string[valor,tipo]} oque_verif - o que sera comparado
     * @param {string[igual,diferente]} tipo_comp - o tipo de comparacao
     * @returns {boolean} - se a comparacao resultou verdadeiro ou falso
     */
    verif_prop( obj , caminho_prop , valor , oque_verif, tipo_comp){
        try{
            fnjs.logi(this.constructor.name,"verif_prop");
            let ret=false,
                objint=obj,
                profund_caminho=0,
                prop = null;
            oque_verif=fnjs.first_valid([oque_verif,'valor']);
            tipo_comp=fnjs.first_valid([tipo_comp,'igual']);
            prop = this.obter_propriedade_interna(obj,caminho_prop);
            if(oque_verif==='valor'){
                if(tipo_comp==='igual'){
                    if(prop===valor||prop===valor.toString()){
                        ret=true;
                    }
                }else if(tipo_comp==='diferente'){
                    if(prop!==valor&&prop!==valor.toString()){
                        ret=true;
                    }										
                }else if(tipo_comp==='maior'){
                    if(prop>valor){
                        ret=true;
                    }																					
                }
            }else if(oque_verif==='tipo'){
                if(tipo_comp==='igual'){
                    if(fnjs.typeof(prop)===valor||fnjs.typeof(prop)===valor.toString()){
                        ret=true;
                    }
                }else if(tipo_comp==='diferente'){
                    if(fnjs.typeof(prop)!==valor&&fnjs.typeof(prop)!==valor.toString()){
                        ret=true;
                    }										
                }										
            }
            fnjs.logf(this.constructor.name,"verif_prop");
            return ret;
        }catch(e){
            console.log(e);
            alert(e.message || e);
            return false;
        } 	
    } 

    /**
     * Seta o valor de uma propriedade de um objeto, com base no caminho passado
     * @param {object} obj - o objeto alvo
     * @param {array || string} caminho_prop - o caminho da propriedade alvo
     * @param {variant} valor - o valor a ser setado
     */
    set_prop( obj , caminho_prop , valor){
        try{
            fnjs.logi(this.constructor.name,"set_prop");
            obter_propriedade_interna(obj,caminho_prop,{setar_valor:true,valor:valor});
            fnjs.logf(this.constructor.name,"set_prop");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    } 
};

export default FuncoesObjeto.getInstance(); 