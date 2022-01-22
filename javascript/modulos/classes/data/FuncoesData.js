import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';
import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

/**Classe FuncoesData - utilidades de data */
class FuncoesData{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.nomes_variaveis = {
                FuncoesData : "FuncoesData"
            };
            this.nomes_variaveis.fndt_pt = this.nomes_variaveis.FuncoesData + ".";
            this.nomes_funcoes = {			
                data_como_cnj_date : "data_como_cnj_date",
                data_primeirodiames : "data_primeirodiames",
                data_primeirodiames_anterior : "data_primeirodiames_anterior",
                dataBR : "dataBR",
                dataBR_getAno : "dataBR_getAno",
                dataBR_getDia : "dataBR_getDia",
                dataBR_getMes : "dataBR_getMes",
                dataUSA : "dataUSA",			
                diferenca_datas : "diferenca_datas",
                getAno : "getAno",
                getDia : "getDia",
                getHora : "getHora",
                getMes : "getMes",
                getMinuto : "getMinuto",
                getSegundo : "getSegundo",
                hoje : "hoje",
                incrementar_datas : "incrementar_datas",
                setar_ultimo_dia_mes : "setar_ultimo_dia_mes",
                SomarData : "SomarData"
                
            };
            this.nomes_completos_funcoes = {			
                data_como_cnj_date : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.data_como_cnj_date,
                data_primeirodiames : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.data_primeirodiames,
                data_primeirodiames_anterior : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.data_primeirodiames_anterior,	
                dataBR : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.dataBR,	
                dataBR_getAno : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.dataBR_getAno,
                dataBR_getDia : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.dataBR_getDia,
                dataBR_getMes : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.dataBR_getMes,
                dataUSA : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.dataUSA,
                diferenca_datas : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.diferenca_datas,
                getAno : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getAno,	
                getDia : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getDia,	
                getHora : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getHora,	
                getMes : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getMes,	
                getMinuto : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getMinuto,	
                getSegundo : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.getSegundo,	
                hoje : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.hoje,	
                incrementar_datas : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.incrementar_datas,
                setar_ultimo_dia_mes : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.setar_ultimo_dia_mes,
                SomarData : this.nomes_variaveis.fndt_pt + this.nomes_funcoes.SomarData
            };
            this.mensagens = {
                formato_invalido : "tipo do objeto data invalido: "
            };
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    };

    data_como_cnj_date(data) {
        try {
            fnjs.logi(this.constructor.name,"data_como_cnj_date");
            let cnj = [],
                separador_datas = '';
            if (typeof data === 'object' && typeof data.getMonth === 'function') {
                cnj.push(data.getFullYear());
                cnj.push(data.getMonth());
                cnj.push(data.getDate());
                cnj.push(data.getHours());
                cnj.push(data.getMinutes());
                cnj.push(data.getSeconds());
            } else if (typeof data === 'string') {
                data = data.trim();
                if (data.indexOf(vars.sepdata) > -1) {
                    separador_datas = vars.sepdata;
                } else if (data.indexOf('-') > -1) {
                    separador_datas = '-';
                } else {
                    throw "separador de datas nao encontrado: " + data;
                }
                if (data.indexOf(separador_datas) === 4) {
                    //data no formato americano yyyy/mm/dd
                    cnj.push(data.substring(0,4) * 1);
                    cnj.push((data.substring(5,7) * 1) - 1 );
                    cnj.push(data.substring(8,10) * 1);
                    cnj.push(data.substring(11,13)||0);
                    cnj.push(data.substring(14,16)||0);
                    cnj.push(data.substring(17,19)||0);
                } else if (data.indexOf(separador_datas) === 2) {
                    //data no formato brasileiro dd/mm/yyyy
                    cnj.push(data.substring(6,10) * 1);
                    cnj.push((data.substring(3,5) * 1) - 1);
                    cnj.push(data.substring(0,2) * 1);
                    cnj.push(data.substring(11,13)||0);
                    cnj.push(data.substring(14,16)||0);
                    cnj.push(data.substring(17,19)||0);
                } else {
                    throw this.mensagens.formato_invalido + data;
                }				
            } else {
                throw this.mensagens.formato_invalido + typeof data + typeof data.getMonth;
            }
            fnjs.logf(this.constructor.name,"data_como_cnj_date");
            return cnj;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }								
    }

    dataUSA(data,separador){
        try {
            fnjs.logi(this.constructor.name,"dataUSA");
            if(data==null){
                data= new Date();
            };
            let dia='',
                mes='',
                ano='';
            if (typeof(data)=='string') {
                dia=data.slice(0,2);
                mes=data.slice(3,5);
                ano=data.slice(6,10);
            } else {
                ano=data.getFullYear();
                mes=data.getMonth();
                dia=data.getDate();
            };
            mes = mes.toString().padStart(2,'0');
            dia = dia.toString().padStart(2,'0');
            if (separador == null) {
                separador='-';
            };
            let retorno=ano+separador+mes+separador+dia;
            if (data.length > 10) {
                //tem horarios
                let horarios = data.substr(10,data.length - 10);
                retorno += horarios;
            }
            fnjs.logf(this.constructor.name,"dataUSA");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
            return null;
        }	
    }
    dataBR(data){
        try {
            fnjs.logi(this.constructor.name,"dataBR");
            data = fnjs.first_valid([data,new Date()]);
            if (data === null) {
                data = new Date();
            }        
            let dia='';
            let mes='';
            let ano='';
            if(typeof data === 'string'){
                dia=data.slice(8,10);
                mes=data.slice(5,7);
                ano=data.slice(0,4);
            } else if (typeof data === 'object') {
                ano=data.getFullYear();
                mes=data.getMonth()+1;
                dia=data.getDate();
            } else {
                return false;
            }
            mes = mes.toString().padStart(2,'0');
            dia = dia.toString().padStart(2,'0');
            let retorno=dia+vars.sepdata+mes+vars.sepdata+ano;
            fnjs.logf(this.constructor.name,"dataBR");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
    hoje(){
        try {
            fnjs.logi(this.constructor.name,"hoje");
            let data=this.dataBR(null);
            fnjs.logf(this.constructor.name,"hoje");
            return data;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }
    data_primeirodiames(data){
        try {
            fnjs.logi(this.constructor.name,"data_primeirodiames");
            if (typeof data === 'undefined') {
                data  = new Date();
            } else {
                if(typeof data === 'string') {
                    data = this.data_como_cnj_date(data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            let ano = data.getFullYear();
            let mes = data.getMonth() + 1;
            mes = mes.toString().padStart(2,'0');
            let dia='01';
            let retorno=dia+vars.sepdata+mes+vars.sepdata+ano;
            fnjs.logf(this.constructor.name,"data_primeirodiames");
            return retorno;	
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }							
    }
    dataBR_getDia(data){
        try {
            fnjs.logi(this.constructor.name,"dataBR_getDia");
            fnjs.logf(this.constructor.name,"dataBR_getDia");
            return data.slice(0,2);
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
    dataBR_getMes(data){
        try {
            fnjs.logi(this.constructor.name,"dataBR_getMes");
            fnjs.logf(this.constructor.name,"dataBR_getMes");
            return data.slice(3,5);
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }
    dataBR_getAno(data){
        try {
            fnjs.logi(this.constructor.name,"dataBR_getAno");
            fnjs.logf(this.constructor.name,"dataBR_getAno");
            return data.slice(6,10);
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    }
    diferenca_datas(data1,data2){
        try {
            fnjs.logi(this.constructor.name,"diferenca_datas");
            if (typeof data1 === 'object' && typeof data1.getMonth === 'function' && 
                typeof data2 === 'object' && typeof data2.getMonth === 'function') {
                //datas ja sao objeto, somente calcular
            } else {
                data1 = this.data_como_cnj_date(data1);
                data2 = this.data_como_cnj_date(data2);
                data1 = new Date(data1[0],data1[1],data1[2],data1[3],data1[4],data1[5]);
                data2 = new Date(data2[0],data2[1],data2[2],data2[3],data2[4],data2[5]);
            }
            let diferenca = (data2 - data1); //diferenca em milEsimos e positivo
            let dia = 1000*60*60*24; // milEsimos de segundo correspondente a um dia
            let retorno = Math.round(diferenca/dia); //valor total de dias arredondado
            fnjs.logf(this.constructor.name,"diferenca_datas");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }	
    };
    SomarData(txtData,DiasAdd,mesesiguais) {
        try {
            fnjs.logi(this.constructor.name,"SomarData");
            let d = new Date();
            if((DiasAdd==29||DiasAdd==30||DiasAdd==31)&&mesesiguais){
                d.setTime(Date.parse(txtData.split(vars.sepdata).reverse().join(vars.sepdata)));
                dt=new Date(d);
                d.setMonth(d.getMonth()+1);	
                if(!(d.getMonth()==dt.getMonth())){
                    d.setDate(d.getDate()-1);
                }else{
                    dt=new Date(d);
                    d.setDate(d.getDate()+1);
                    if(!(d.getMonth()==dt.getMonth())){
                        d.setDate(d.getDate()-1);
                    }
                };
            }else{
                d.setTime(Date.parse(txtData.split(vars.sepdata).reverse().join(vars.sepdata))+(86400000*(DiasAdd)))
            }
            let DataFinal = d.getDate().toString().padStart(2,'0');
            DataFinal += vars.sepdata+((d.getMonth()+1).toString().padStart(2,'0'))+vars.sepdata+d.getFullYear().toString();
            fnjs.logf(this.constructor.name,"SomarData");
            return DataFinal;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
    setar_ultimo_dia_mes(data,incrmeses){
        try {
            fnjs.logi(this.constructor.name,"setar_ultimo_dia_mes");
            if (typeof data !== 'object') {
                data = this.data_como_cnj_date(data);
                data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
            }
            data.setDate(27);
            if(!(incrmeses==null)){
                data.setMonth(data.getMonth()+incrmeses);
            };
            let data_temp=new Date(data);	
            while (data.getMonth()==data_temp.getMonth()){
                data.setDate(data.getDate()+1);
            };
            data.setDate(data.getDate()-1);
            fnjs.logf(this.constructor.name,"setar_ultimo_dia_mes");
            return data;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    };
    incrementar_datas(data_ini,data_fim){		
        try {
            fnjs.logi(this.constructor.name,"incrementar_datas");
            let diferenca_dias=this.diferenca_datas(data_ini,data_fim);	
            data_ini = this.data_como_cnj_date(data_ini);
            data_ini = new Date(data_ini[0],data_ini[1],data_ini[2],data_ini[3],data_ini[4],data_ini[5]);
            data_fim = this.data_como_cnj_date(data_fim);
            data_fim = new Date(data_fim[0],data_fim[1],data_fim[2],data_fim[3],data_fim[4],data_fim[5]);
            if(data_ini.getDate()==1){
                if(((diferenca_dias==27||diferenca_dias==28||diferenca_dias==29)&&(data_ini.getMonth()==1))||
                ((diferenca_dias==29||diferenca_dias==30||diferenca_dias==31)&&!(data_ini.getMonth()==1))){
                    /*
                    *	tratar como diferenca de 01 mes
                    */
                    data_ini.setMonth(data_ini.getMonth()+1);
                    data_fim=this.setar_ultimo_dia_mes(data_fim,1);
                }else{
                    data_ini = this.data_como_cnj_date(data_fim);
                    data_ini=new Date(data_ini[0],data_ini[1],data_ini[2],data_ini[3],data_ini[4],data_ini[5]);
                    data_ini.setDate(data_fim.getDate()+1);
                    data_fim.setDate(data_fim.getDate()+diferenca_dias);
                };
            }else{
                /*
                *Nao tratar como diferenca de 01 mes
                */
                data_ini = this.data_como_cnj_date(data_fim);
                data_ini = new Date(data_ini[0],data_ini[1],data_ini[2],data_ini[3],data_ini[4],data_ini[5]);
                data_ini.setDate(data_fim.getDate()+1);
                data_fim.setDate(data_fim.getDate()+diferenca_dias);
            };
            data_ini = this.dataBR(data_ini);
            data_fim = this.dataBR(data_fim);
            fnjs.logf(this.constructor.name,"incrementar_datas");
            return [data_ini,data_fim];
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }					
    }
    data_primeirodiames_anterior(data){		
        try {
            fnjs.logi(this.constructor.name,"data_primeirodiames_anterior");
            if (typeof data !== 'object') {
                data = new Date();
            }
            data = data.setMonth(data.getMonth() - 1);
            fnjs.logf(this.constructor.name,"data_primeirodiames_anterior");
            return this.dataBR(this.data_primeirodiames(data));			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }		
    getDia(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getDia");
            let data = null,
                dia = '';
            opcoes = opcoes || {};
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(opcoes.data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            dia = data.getDate().toString();
            if (opcoes.digitos >= 2) {
                dia = dia.padStart(2,'0');
            }
            fnjs.logf(this.constructor.name,"getDia");
            return dia;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    getMes(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getMes");
            let data = null,
                mes = '';
            opcoes = opcoes || {};
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(opcoes.data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            mes = (data.getMonth() + 1).toString(); //getMonth eh base 0
            if (opcoes.digitos >= 2) {
                mes = mes.padStart(2,'0');
            }
            fnjs.logf(this.constructor.name,"getMes");
            return mes;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    getAno(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getAno");
            let data = null,
                ano = '';
            opcoes = opcoes || {};
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(opcoes.data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            ano = data.getFullYear(); 			
            ano = ano.toString();
            fnjs.logf(this.constructor.name,"getAno");
            return ano;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }					
    }
    getHora(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getHora");
            let data = null,
                hora = '';
            opcoes = opcoes || {};
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(opcoes.data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            hora = data.getHours().toString();
            if (opcoes.digitos >= 2) {
                hora = hora.padStart(2,'0');
            }                    
            fnjs.logf(this.constructor.name,"getHora");
            return hora;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    getMinuto(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getMinuto");
            let data = null,
                minuto = '';
            opcoes = opcoes || {};			
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }			
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(opcoes.data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            minuto = data.getMinutes().toString();
            if (opcoes.digitos >= 2) {
                minuto = minuto.padStart(2,'0');
            }
            fnjs.logf(this.constructor.name,"getMinuto");
            return minuto;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    getSegundo(opcoes){
        try {
            fnjs.logi(this.constructor.name,"getSegundo");
            let data = null,
                segundo = '';
            opcoes = opcoes || {};			
            if (typeof opcoes === 'string') {
                opcoes = {data:opcoes};
            } else if (typeof opcoes === 'object') {
                if (typeof opcoes.getMonth === 'function') {
                    opcoes = {data:opcoes};
                }
            }			
            if (typeof opcoes.digitos === 'undefined') {
                opcoes.digitos = 1;
            }
            if (typeof opcoes.data === 'undefined') {
                data = new Date();
            } else {
                if (typeof opcoes.data === 'object') {
                    data = opcoes.data;
                } else {
                    data = this.data_como_cnj_date(data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                }
            }
            segundo = data.getSeconds().toString();
            if (opcoes.digitos >= 2) {
                setundo = segundo.padStart(2,'0');
            }
            fnjs.logf(this.constructor.name,"getSegundo");
            return segundo;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }					
    }

    detectar_formato(data) {
        try {
            let sep = null;
            let retorno = "";
            data = data || "";
            if (data.replace(/\//g,'').length === data.length - 2) {
                sep = '/';
            } else if (data.replace(/-/g,'').length === data.length - 2) {
                sep = '-';
            } else if (data.replace(/./g,'').length === data.length - 2) {
                sep = '.';
            }
            let arr_data = data.split(sep);
            let qtcaract = arr_data[0].length;
            let valor0 = arr_data[0] - 0;
            let valor1 = arr_data[1] - 1;
            let dia_incluido = false;
            let mes_incluido = false;
            let ano_incluido = false;
            if (qtcaract === 4) {
                retorno += "yyyy";
                ano_incluido = true;
            } else {
                if (valor1 > 12) {
                    retorno += "mm";
                    mes_incluido = true;
                } else {
                    retorno += "dd";
                    dia_incluido = true;
                }
            }
            retorno += sep;
            if (arr_data.length > 1) {
                qtcaract = arr_data[1].length;
                if (qtcaract === 4) {
                    retorno += "yyyy";
                    ano_incluido = true;
                } else {
                    if (valor1 <= 12 && !mes_incluido) {
                        retorno += "mm";
                        mes_incluido = true;
                    } else {
                        retorno += "dd";
                        dia_incluido = true;
                    }
                }
                retorno += sep;

                qtcaract = arr_data[2].length;
                if (qtcaract === 4) {
                    retorno += "yyyy";
                    ano_incluido = true;
                } else {
                    if (valor1 > 12 && !mes_incluido) {
                        retorno += "mm";
                        mes_incluido = true;
                    } else {
                        retorno += "dd";
                        dia_incluido = true;
                    }
                }
            }
            fnjs.logf(this.constructor.name,"detectar_formato");
            return retorno;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    }
    como_data_oracle(data) {
        try {
            let retorno = "";
            let formato = this.detectar_formato(data);
            retorno += "to_date('" + data + "','" + formato + "')";
            fnjs.logf(this.constructor.name,"como_data_oracle");
            return retorno;
        } catch {
            console.log(e);
            alert(e.message || e);
        }
    }
};

var fndt = new FuncoesData();

export { fndt };