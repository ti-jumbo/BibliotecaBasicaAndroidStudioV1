import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';

/*Classe FuncoesEventos*/
class FuncoesEventos{
    constructor(){
            try {
            /*Evento que previne fechamento indevido de menu dropdow ao abrir subitem */
            
            fnjs.logi(this.constructor.name);
            fnjs.obterJquery(document).on('click','*',function(e){
                try {			
                    //fnjs.logi(this.constructor.name,"click");
                    let elemento = fnjs.obterJquery(e.target);
                    let estaemtabdados = elemento.closest("table.tabdados").length || false;
                    let ehimgbtnesquerdo = elemento.hasClass('img_btn_menu_esquerdo');
                    let elementodesabilitado = elemento.hasClass('desabilitado') || false;
                    let ehInput = (elemento.prop('tagName').toLowerCase() === "input");
                    let ehbtncomandos = elemento.hasClass('btncomandos') || false;
                    if (elementodesabilitado || ehimgbtnesquerdo) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        return;
                    }
                    if (estaemtabdados) {			
                        if (!(ehInput || ehbtncomandos)) {
                            e.preventDefault();
                            e.stopImmediatePropagation();
                            fnhtml.fntabdados.clicou_tabela(e);
                            return;
                        }
                    }
                    //fnjs.logf(this.constructor.name,"click");
                } catch(er) {
                    console.log(er);
                    alert(er.message || er);
                }			
            });

            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro); 
        }
    }

        

    clicou_link_abrir_itemmenu(elem, event) {		
        try {
            fnjs.logi(this.constructor.name,"clicou_link_abrir_itemmenu");
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            let $el,$li,codops;
            $el = fnjs.obterJquery(elem);
            if ($el !== null && typeof $el !== "undefined" && $el.length) {
                $li = $el.closest("li");
                if ($li !== null && typeof $li !== "undefined" && $li.length) {
                    codops = $li.attr("codops");
                    fnsisjd.acessar_item_menu({elemento:$li});
                } 
            }	
            fnjs.logf(this.constructor.name,"clicou_link_abrir_itemmenu");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
}
var fnevt = new FuncoesEventos();

window.fnevt = fnevt;

export { fnevt };