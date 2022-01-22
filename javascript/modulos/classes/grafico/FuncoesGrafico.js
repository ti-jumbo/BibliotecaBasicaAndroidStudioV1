import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

/**Classe FuncoesGrafico */
class FuncoesGrafico{
    constructor() {
        try {
            fnjs.logi(this.constructor.name);
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    }

    criarEixos(params) {
        try {
            fnjs.logi(this.constructor.name,"criarEixos");
            let c=document.getElementById(params.canvas);
            let ctx=c.getContext("2d");
            let rightX = c.width - params.margem;
            let altura = c.height - params.margem;
            let incremento = 0;
            let qtescala = 0;
            let tamanhoescala = 0;
            let indescala = 0;
            params.escala =fnjs.first_valid([params.escala,["0%","10%","20%","30%","40%","50%","60%","70%","80%","90%","100%"]]);
            params.direcao =fnjs.first_valid([params.direcao,"vertical"]);
            ctx.strokeStyle = "#000";
            ctx.moveTo(params.margem, 0);
            ctx.lineTo(params.margem, altura);
            // setas do y
            ctx.moveTo(params.margem, 0);
            ctx.lineTo(params.margem + 5, 5);
            ctx.moveTo(params.margem, 0);
            ctx.lineTo(params.margem - 5, 5);
            // x
            ctx.moveTo(params.margem, altura);
            ctx.lineTo(rightX + params.margem, altura);
            // setas x
            ctx.moveTo(rightX+params.margem, altura);
            ctx.lineTo(rightX+params.margem - 5, altura + 5);
            ctx.moveTo(rightX+params.margem, altura);
            ctx.lineTo(rightX+params.margem - 5, altura - 5);
            ctx.stroke();
            indescala = 0;
            let tem_grade = false,
                passo_mostrar_texto_escalay = 1,
                mostrar_grade_y_se_existe_texto = false;
            if (typeof params.grade !== "undefined") {
                if (params.grade === true) {
                    tem_grade = true;
                }
            }
            if (typeof params.passo_mostrar_texto_escalay !== "undefined") {
                passo_mostrar_texto_escalay = params.passo_mostrar_texto_escalay;
            }
            if (typeof params.mostrar_grade_y_se_existe_texto !== "undefined") {
                mostrar_grade_y_se_existe_texto = params.mostrar_grade_y_se_existe_texto;
            }

            if (params.direcao === "vertical") {
                if (typeof params.escalax !== "undefined") {
                    incremento = (altura - params.margem) / (params.escalax.length-1);
                    indescala = 0;
                    qtescala = params.escalax.length -1;
                    let 
                        pyini = 0,
                        pyfim = 0;
                        
                    pyini = params.margem-5;
                    pyfim = params.margem+5;
                    if (tem_grade === true) {
                        pyfim = rightX;
                    }
                    
                    for (let i = qtescala ; i > -1 ; i--) {
                        ctx.fillText(params.escalax[i],0,(params.margem + (incremento * indescala)));										
                        ctx.moveTo(pyini, (params.margem + (incremento * indescala)));
                        ctx.lineTo(pyfim, (params.margem + (incremento * indescala)));					
                        indescala++;
                    }			
                } else {
                    incremento = (altura - params.margem) / (params.escala.length-1);
                    indescala = 0;
                    qtescala = params.escala.length - 1;
                    let 
                        pyini = 0,
                        pyfim = 0;
                        
                    pyini = params.margem-5;
                    pyfim = params.margem+5;
                    if (tem_grade === true) {
                        pyfim = params.margem + rightX;
                    }				
                    for (let i = qtescala ; i > -1 ; i--) {
                        ctx.fillText(params.escala[i],0,(params.margem + (incremento * indescala)));
                        ctx.moveTo(pyini, (params.margem + (incremento * indescala)));
                        
                        ctx.lineTo(pyfim, (params.margem + (incremento * indescala)));					
                        indescala++;
                    }
                }			
                if (typeof params.escalay !== "undefined") {
                    incremento = (rightX - params.margem) / (params.escalay.length-1);
                    indescala = 0;
                    qtescala = params.escalay.length;
                    let 
                        pxini = 0,
                        pxinioriginal = 0;
                        pxfim = 0;
                        
                    pxini = (altura - 5);
                    pxinioriginal = (altura - 5);
                    pxinifinal = pxini;
                    pxfim = (altura + 5);
                    if (tem_grade === true) {
                        pxini = params.margem;
                    }
                    
                    for (let i = 0 ; i < qtescala ; i++) {
                        if (i % passo_mostrar_texto_escalay === 0) {
                            ctx.fillText(params.escalay[i],(params.margem -5 + (incremento * indescala)),(altura + params.margem-(params.margem/2)));
                        }					
                        pxinifinal = pxini;
                        if (mostrar_grade_y_se_existe_texto === true) {
                            if (typeof params.escalay[i] !== "undefined") {
                                if (params.escalay[i] === null) {
                                    pxinifinal = pxinioriginal;
                                } else {
                                    if (params.escalay[i].toString().trim().length === 0) {
                                        pxinifinal = pxinioriginal;
                                    }
                                }
                            } else {
                                pxinifinal = pxinioriginal;
                            }
                        }
                        ctx.moveTo((params.margem + (incremento * indescala)), pxinifinal);
                        ctx.lineTo((params.margem + (incremento * indescala)), pxfim);								
                        indescala++;
                    }
                }
            } else { //horizontal
                if (typeof params.escalay !== "undefined") {
                    incremento = (rightX - params.margem) / (params.escalay.length-1);
                    indescala = 0;
                    qtescala = params.escalay.length;
                    let 
                        pxini = 0,
                        pxfim = 0;
                        
                    pxini = (altura - 5);
                    pxfim = (altura + 5);
                    if (tem_grade === true) {
                        pxini = params.margem;
                    }
                    for (let i = 0 ; i < qtescala ; i++) {
                        ctx.fillText(params.escalay[i],(params.margem -5 + (incremento * indescala)),(altura + params.margem-(params.margem/2)));
                        ctx.moveTo((params.margem + (incremento * indescala)), pxini);
                        ctx.lineTo((params.margem + (incremento * indescala)), pxfim);								
                        indescala++;
                    }			
                } else {
                    incremento = (rightX - params.margem) / (params.escala.length-1);
                    indescala = 0;
                    qtescala = params.escala.length;
                    let 
                        pxini = 0,
                        pxfim = 0;
                        
                    pxini = (altura - 5);
                    pxfim = (altura + 5);
                    if (tem_grade === true) {
                        pxini = params.margem;
                    }
                    for (let i = 0 ; i < qtescala ; i++) {
                        ctx.fillText(params.escala[i],(params.margem -5 + (incremento * indescala)),(altura + params.margem-(params.margem/2)));
                        ctx.moveTo((params.margem + (incremento * indescala)), pxini);
                        ctx.lineTo((params.margem + (incremento * indescala)), pxfim);								
                        indescala++;
                    }
                }
                if (typeof params.escalax !== "undefined") {
                    incremento = (altura - params.margem) / (params.escalax.length-1);
                    indescala = 0;
                    qtescala = params.escalax.length -1;
                    let 
                        pyini = 0,
                        pyfim = 0;
                        
                    pyini = params.margem-5;
                    pyfim = params.margem+5;
                    if (tem_grade === true) {
                        pyfim = params.margem + rightX;
                    }		
                    for (let i = qtescala ; i > -1 ; i--) {
                        ctx.fillText(params.escalax[i],0,(params.margem + (incremento * indescala)));
                        ctx.moveTo(pyini, (params.margem + (incremento * indescala)));
                        ctx.lineTo(pyfim, (params.margem + (incremento * indescala)));					
                        indescala++;
                    }			
                }
            }
        ctx.stroke();	
            fnjs.logf(this.constructor.name,"criarEixos");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    criarBarra(canvas,xPos, yPos, largura, altura, cor,margem,direcao){
        try {
            fnjs.logi(this.constructor.name,"criarBarra");
            let c=document.getElementById(canvas);
            let ctx=c.getContext("2d");
            ctx.fillStyle = cor;  
            direcao = fnjs.first_valid([direcao,"vertical"]);
            if (direcao === "vertical") {
                ctx.fillRect(xPos, yPos, largura, altura);
            } else {
                ctx.fillRect((0+margem), xPos, altura,largura);
            }
            fnjs.logf(this.constructor.name,"criarBarra");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    }

    criarGrafico(canvas, margem, barras, cor,tipo,legenda,nomes,escala){
        try {
            fnjs.logi(this.constructor.name,"criarGrafico");
            let comptotalelementos=0;
            let comptotalescala = 0;
            let c = document.getElementById(canvas);
            let ctx = c.getContext("2d");
            let qtd = barras.length;
            let largbarra = 20;
            let entre = 5;
            let escalatotal = 100;
            tipo = fnjs.first_valid([tipo,"vertical"]);
            legenda = fnjs.first_valid([legenda,true]);
            if (qtd<=1) {
                comptotalelementos = (1 * largbarra) + (1 * entre) + (margem * 2);
            } else {
                comptotalelementos = (qtd * largbarra) + (qtd * entre) + (margem * 2);
            }

            if (tipo === "vertical") {
                comptotalescala = document.getElementById(canvas).height;
                c2 = '<canvas id="'+canvas+'" width="'+comptotalelementos+'" height="'+comptotalescala+'"></canvas>';						
            } else if (tipo === "horizontal") {
                comptotalescala = document.getElementById(canvas).width;
                c2 = '<canvas id="'+canvas+'" width="'+comptotalescala+'" height="'+comptotalelementos+'"></canvas>';			
            } else if (tipo === "quebra_cabeca") {
                c2 = '<canvas id="'+canvas+'" width="400" height="400"></canvas>';			
            } else {
                alert("tipo "+ tipo + " nao programado");
                return;
            }
            fnjs.obterJquery(c).replaceWith(c2);
            c = document.getElementById(canvas);
            ctx = c.getContext("2d");
            for (i = 0; i < qtd; i++) {		
                if (barras[i] >= 100) {
                    cor = "green";
                    if (barras[i] > 110) {
                        barras[i] = 110;
                    }
                } else if (barras[i] > 50) {
                    cor = "royalblue";
                } else if (barras[i] > 25) {
                    cor = "orange";
                } else {
                    cor = "red";
                }
                if (tipo === "vertical") {
                    fngraf.criarBarra(
                        canvas,
                        ((largbarra+entre)*i)+(margem+entre),
                        comptotalescala - margem - ((barras[i] * (comptotalescala-(margem*2))) / escalatotal),
                        largbarra,
                        ((barras[i] * (comptotalescala-(margem*2))) / escalatotal),
                        cor,margem,tipo
                    );
                    ctx.fillText(i+1,(margem + entre + (largbarra / 2)) + ((largbarra+entre) * i),c.height);
                } else {
                    fngraf.criarBarra(
                        canvas,
                        ((largbarra+entre)*i)+(margem+entre),
                        comptotalescala - margem - ((barras[i] * (comptotalescala-(margem*2))) / escalatotal),
                        largbarra,
                        ((barras[i] * (comptotalescala-(margem*2))) / escalatotal),
                        cor,margem,tipo
                    );			
                    if (typeof nomes !== "undefined") {					
                        ctx.fillText(nomes[i],0,((margem*1 + entre*1 + (largbarra/2))*1 + ((largbarra*1+entre*1) * i) * 1));
                    } else {
                        ctx.fillText(i+1,0,((margem*1 + entre*1 + (largbarra/2))*1 + ((largbarra*1+entre*1) * i) * 1));
                    }
                }
            }
            ctx.fillStyle="black";
            fngraf.criarEixos({canvas:canvas, margem:margem,direcao:tipo,escala:escala});
            fnjs.logf(this.constructor.name,"criarGrafico");
            return c;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    criar_grafico_barras(params){
        try {
            fnjs.logi(this.constructor.name,"criar_grafico_barras");
            let data = google.visualization.arrayToDataTable(params.dados);
            let view = new google.visualization.DataView(data);
            view.setColumns([0, 1,{calc: "stringify",sourceColumn: 1,type: "string",role: "annotation" },2]);
            let options = {
                title: params.titulo,
                width: 600,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: { position: "none" },
                vAxis:{
                    minValue:0,
                    maxValue:120
                }
            };
            let chart = new google.visualization.ColumnChart(document.getElementById(params.idconteiner));
            chart.draw(view, options);
            fnjs.logf(this.constructor.name,"criar_grafico_barras");
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    }
};

var fngraf = new FuncoesGrafico();

export { fngraf };