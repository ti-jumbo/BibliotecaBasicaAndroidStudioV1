import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

/**Classe FuncoesArray - utilidades para array */
class FuncoesArray{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    procurar_array(params) { 
        try{
            fnjs.logi(this.constructor.name,"procurar_array");
            params.parcial=params.parcial||false;
            let retorno=-1;
            if(params.parcial===true){
                for(let i=0; i<params.array.length; i++){
                    if(params.array[i].indexOf(params.valor)>-1){
                        return i;
                    }
                }
            } else {
                for(let i=0; i<params.array.length; i++){
                    if (typeof params.array[i] === 'string' || typeof params.valor === 'string') {
                        if(params.array[i].toString().replace(/'/g,'') === params.valor.toString().replace(/'/g,'')){
                            return i;
                        }
                    } else {
                        if(params.array[i] === params.valor){
                            return i;
                        }
                    }
                }			
            }
            fnjs.logf(this.constructor.name,"procurar_array");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
            return null;
        } 			
    }                         
};

var fnarr = new FuncoesArray();

export { fnarr };