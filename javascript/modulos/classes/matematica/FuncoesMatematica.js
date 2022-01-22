import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

class FuncoesMatematica{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };
    isNumber(valor){
        try {
            //fnjs.logi(this.constructor.name,"isNumber");
            valor = valor - 0;
            if (valor >= 0 || valor <= 0 ) {
                return true;
            } else {
                return false;
            }
            //fnjs.logf(this.constructor.name,"isNumber");
        } catch (e) {
            console.log(e);
            return false;
        }
    }
    como_numero(valor){
        try{
            //fnjs.logi(this.constructor.name,"como_numero");
            let tipo = typeof valor;
            let vl_spt = ''; //valor sem ponto
            let vl_svg = ''; //valor sem virgula
            let posvirg = -1;
            let pospt   = -1;
            let vlini = '';
            vlini=valor;			
            if(tipo === 'undefined'){
                return 0;
            }
            if(tipo === 'number'){
                return valor;
            }
            //fnjs.logf(this.constructor.name,"como_numero");
            if(tipo === 'string'){
                valor = valor.toLowerCase();
                valor = valor.replace('r$','');
                valor = valor.replace('kg','');
                valor = valor.replace('%','');
                valor = valor.replace('px','');
                valor = valor.replace(/\s/g,'');
                valor = valor.trim();
                if(valor === 'item' || valor === 'item,'){
                    valor = '0';
                }
                posvirg = valor.indexOf(',');
                pospt = valor.indexOf('.');
                if(posvirg !== -1){
                    vl_svg = valor.replace(/\,/g,'');
                if(vl_svg.length < valor.length -1){
                        /*tinha mais de uma virgula, logo virgula nao E o separador de decimal*/
                        valor = valor.replace(/\,/g,'');
                    } 
                }
                if(pospt !== -1){
                    vl_spt = valor.replace(/\./g,'');
                    if(vl_spt.length < valor.length -1){
                        /*tem mais de um ponto, logo ponto nao E o separador de decimal*/
                        valor = valor.replace(/\./g,'');
                    }
                }
                if(posvirg !== -1 || pospt !== -1){
                    if(vl_svg.length === valor.length -1 && vl_spt.length === valor.length -1 ){
                        /*tem uma virgula e um ponto, um pode ser o decimal e outro o milhar*/
                        if(valor.indexOf(',')===valor.indexOf('.')+4){
                            /*ponto estA na frente da virgula e E o separador de milhar, exclui-lo*/
                            valor = valor.replace('.','');
                            valor = valor.replace(',','.');
                        }else if(valor.indexOf('.')===valor.indexOf(',')+4){
                            /*virgula estA na frente do ponto e E a separadora de milhar, apenas excluila*/
                            valor = valor.replace(',','');
                        }else{
                            return vlini;
                        }
                    }else if(vl_svg.length === valor.length -1){
                        /*tem uma virgula somente, trocala por ponto, pois significa a separacao de decimal*/
                        valor = valor.replace(',','.');
                    }
                }
                try{
                    valor = valor.replace(',','.'); //se sobrou uma virgula ate aqui significa que ela E o decimal
                    valor = Number(valor);
                    if(isNaN(valor)){
                        return vlini;						
                    }else{					
                        return valor ;
                    }
                }catch(e){
                    return vlini;
                }
            }else{
                return vlini;
            }
            return vlini;
        }catch(e){
            console.log(e);
            alert(e.message || e);
            return vlini;
        }				
    }
};

var fnmat = new FuncoesMatematica();

export { fnmat };