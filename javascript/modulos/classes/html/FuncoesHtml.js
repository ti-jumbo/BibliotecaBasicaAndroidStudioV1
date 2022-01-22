import { vars } from '/sjd/javascript/modulos/classes/variaveis/Variaveis.js';
import { fnjs } from '/sjd/javascript/modulos/classes/javascript/FuncoesJavascript.js';
import { fnmat } from '/sjd/javascript/modulos/classes/matematica/FuncoesMatematica.js';
import { fnarr } from '/sjd/javascript/modulos/classes/array/FuncoesArray.js';
import { fndt } from '/sjd/javascript/modulos/classes/data/FuncoesData.js';


class FuncoesDropdown{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            fnjs.obterJquery(document).on('click','button.dropdown-toggle',function(e){
                try {
                    fnjs.logi('button.dropdown-toggle',"click");
                    let button = fnjs.obterJquery(this);
                    if (button.hasClass("show")) {
                        let div_combobox = button.closest("div.div_combobox");
                        let aoabrir = div_combobox.attr("aoabrir");
                        if (typeof aoabrir !== "undefined" && aoabrir !== null && aoabrir.length > 0) {
                            eval(aoabrir);
                        }
                    }
                }catch(er){
                    console.log(er);
                    alert(er.message || er);
                }	
            });
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        } 
    };

    /**
     * Criar um dropdow bootstrap (button + ul) conforme parametros
     * @param {json object} params - os parametros para criacao
     * @returns {string | NodeHtml} - o elemento criado
     */
    criar_dropdown(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_dropdown");
            params = params || {};
            params.itens = params.itens || [];
            params.retornar_como = params.retornar_como || 'string';
            params.tag = params.tag || 'div';            
            params.class = params.class || '';
            params.class = (params.class + ' div_combobox').trim();
            params.class_botao = params.class_botao || params.classe_botao || '';
            params.classe_botao = params.class_botao;
            params.class_dropdown = params.class_dropdown || '';
            params.sub = params.sub || [];
            params.selecionado = (params.selecionado || params.selecionados || params.selecionada || params.selecionadas);
            params.sub.push({
                tag:"button",
                class:"btn dropdown-toggle " + params.class_botao,
                type:"button",
                content: params.selecionado || "(Selecione)",
                props:[
                    {
                        prop:"data-bs-toggle",
                        value:"dropdown"
                    },
                    {
                        prop:"aria-expanded",
                        value:"false"
                    }
                ]
            });
            let li_itens = [];
            let v_name = fnjs.id_random();
            let v_input = null;
            for(let ind in params.itens) {
                v_input = {
                    tag:"input",
                    type:"radio",
                    name:v_name
                };
                if (params.itens[ind] === params.selecionado) {
                    v_input.checked = true;
                }
                li_itens.push({
                    tag:"li",
                    class:"dropdown-item",
                    props:[
                        {
                            prop:"data-valor_opcao",
                            value:params.itens[ind]
                        },
                        {
                            prop:"data-texto_botao",
                            value:params.itens[ind]
                        },
                        {
                            prop:"selecao_status",
                            value:"nao selecionado"
                        }
                    ],
                    sub:[
                        {
                            tag:"label",
                            content:params.itens[ind],
                            content_apos:true,
                            sub:[v_input]
                        }
                    ]
                });
            }
            params.sub.push({
                tag:"ul",
                class:"dropdown-menu " + params.class_dropdown,
                onclick:"window.fnhtml.fndrop.clicou_dropdown(event,this)",
                sub:[]
            });
            if ((params.filter || params.filtro || params.filtrar) === true) {
                params.filtrar_ao_digitar = fnjs.first_valid([params.filtrar_ao_digitar,true]);
                let obj_filtro = {
                    tag:"input",
                    class:"input_filtro_dropdown rounded",
                    type:"text",                    
                    placeholder:"(filtro)"                    
                }
                if(params.filtrar_ao_digitar === true) {
                    obj_filtro.onkeyup = "window.fnhtml.fndrop.filtrar_dropdown(this)";
                } else {
                    //obj_filtro.onkeyup = "window.fnhtml.fndrop.filtrar_dropdown(this)";
                }
                params.sub[params.sub.length-1].sub.push(obj_filtro);
            }
            params.sub[params.sub.length-1].sub = params.sub[params.sub.length-1].sub.concat(li_itens);
            fnjs.logf(this.constructor.name,"criar_dropdown");
            return fnhtml.criar_elemento(params);
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        } 											
    }

    verificar_marcou_todos(div_combobox) {
        try {
            fnjs.logi(this.constructor.name,"verificar_marcou_todos");
            div_combobox = fnjs.obterJquery(div_combobox);
            let input_selecionar_todos = div_combobox.find("input.input_selecionar_todos");
            let tem_input_selecionar_todos = false;
            if (typeof input_selecionar_todos !== "undefined" && input_selecionar_todos !== null && input_selecionar_todos.length) {
                tem_input_selecionar_todos = true;
            }
            if (tem_input_selecionar_todos) {
                let inputs_visiveis = div_combobox.find("li.dropdown-item>label>input:visible");
                if (inputs_visiveis.length > 0 && inputs_visiveis.not(":checked").length === 0) {
                    input_selecionar_todos[0].checked = true;
                } else {
                    input_selecionar_todos[0].checked = false;
                }
            }
            fnjs.logf(this.constructor.name,"verificar_marcou_todos");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        } 	
    }

    atualizar_texto(obj,verificar_marcou_todos) {
        try {
            fnjs.logi(this.constructor.name,"atualizar_texto");
            obj = fnjs.obterJquery(obj);
            let div_combobox = obj;
            if (!obj.hasClass("div_combobox")) {
                div_combobox = obj.closest("div.div_combobox")
            }
            let inputs_selecionados = div_combobox.find("li.dropdown-item>label>input:checked");
            let qt = inputs_selecionados.length;
            let btn = div_combobox.find("button.dropdown-toggle");
            btn.text(div_combobox.attr("placeholder") || btn.attr("placeholder") || "(Selecione)");             
            if (qt) {                
                let qt_max = div_combobox.attr("num_max_texto_botao") || 5;
                if (qt > qt_max) {
                    if (qt === div_combobox.find("li.dropdown-item>label>input").length) {
                        btn.text('Todos (' + inputs_selecionados.length + ') Selecionado(s)');
                    } else {                                                
                        btn.text(inputs_selecionados.length + ' Selecionados');
                    }
                } else {
                    let selecionados = [];
                    for(let i = 0; i < qt; i++ ) {
                        selecionados.push(inputs_selecionados.eq(i).closest("li").attr("data-texto_botao") || inputs_selecionados.eq(i).closest("label").text());
                    }                    
                    btn.text(selecionados.join(","));                
                }                
            }
            verificar_marcou_todos = fnjs.first_valid([verificar_marcou_todos,true]);
            if (verificar_marcou_todos) {
                this.verificar_marcou_todos(div_combobox);
            }
            fnjs.logf(this.constructor.name,"atualizar_texto");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        } 				
    }


    selecionou_todos_dropdown(event,obj) {
        try {
            fnjs.logi(this.constructor.name,"selecionou_todos_dropdown");
            let ul = fnjs.obterJquery(obj).closest("ul");
            if (typeof ul !== "undefined" && ul !== null && ul.length) {
                let permite_selecao = fnjs.como_booleano(fnjs.first_valid([ul.attr("permite_selecao"),true]));
                if (permite_selecao) {
                    let list = ul.find("li.dropdown-item:visible");
                    let qt = list.length;            
                    for (let i = 0; i < qt; i++) {
                        list.eq(i).find("input")[0].checked = obj.checked;
                    }
                    this.atualizar_texto(fnjs.obterJquery(obj).closest("div.div_combobox"),false);
                } else {                    
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                }
            }
            fnjs.logf(this.constructor.name,"selecionou_todos_dropdown");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }

    filtrar_dropdown(input) {
        try {
            fnjs.logi(this.constructor.name,"filtrar_dropdown");
            input = fnjs.obterJquery(input);
            let ul = input.closest("ul");
            let lis = ul.children("li");
            let qt = lis.length;            
            let texto = input.val().toLowerCase();
            let i = 0;
            for (i = 0; i < qt; i++) {
                if (lis.eq(i).text().toLowerCase().indexOf(texto) > -1) {
                    lis.eq(i).show();
                } else {
                    lis.eq(i).hide();
                }
            }
            this.verificar_marcou_todos(ul.closest("div.div_combobox"));
            fnjs.logf(this.constructor.name,"filtrar_dropdown");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }

    /**
     * Seleciona checkbox ou radio se forem clicados em dropdown
     * @param {object} event 
     * @param {object} obj 
     */
    clicou_dropdown(event,obj) {
        try {            
            fnjs.logi(this.constructor.name + ".clicou_dropdown");            
            obj = fnjs.obterJquery(obj);
            let target = fnjs.obterJquery(event.target);
            if (["input","label","li"].indexOf(target.prop("tagName").toLowerCase()) > -1) {
                let input = target.find("input");
                if ((typeof input === "undefined" || input === null || !input.length) && target.prop("tagName") === "INPUT") {
                    input = target;
                }
                if (typeof input !== "undefined" && input !== null && input.length) {
                    let li = input.closest("li");
                    let ul = li.closest("ul");
                    let btn = ul.prev("button");
                    let div_combobox = btn.closest("div.div_combobox");
                    let permite_selecao = fnjs.como_booleano(fnjs.first_valid([ul.attr("permite_selecao"),true]));
                    if (permite_selecao) {
                        if (input.attr("type") === "radio") {
                            btn.text(li.attr("data-texto_botao") || input.closest("label").text());
                            bootstrap.Dropdown.getOrCreateInstance(btn[0]).hide();
                            input.prop("checked",true);
                        } else {
                            this.atualizar_texto(div_combobox);
                        }
                        if (div_combobox.length) {
                            let aoselecionaropcao = div_combobox.attr("aoselecionaropcao");
                            if (typeof aoselecionaropcao !== "undefined" && aoselecionaropcao !== null && aoselecionaropcao.trim().length > 0) {
                                eval(aoselecionaropcao.replace("this","input"));
                            }
                        }
                    } else {
                        event.preventDefault();
                        event.stopPropagation();
                        event.stopImmediatePropagation();
                    }
                }
            }
            fnjs.logf(this.constructor.name,"clicou_dropdown");
        } catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
};



/**Classe FuncoesComboboxs */
class FuncoesComboboxs{
    constructor() {
        try {
            fnjs.logi(this.constructor.name);
            this.strings = {
                placeholder_padrao : "(Selecione)",
                texto_multiplos_selecionados : " Selecionado(s)",
                Todos : "Todos"
            };
            this.nomes_variaveis = {
                FuncoesComboboxs : "FuncoesComboboxs"
            };
            this.nomes_variaveis.fncomboboxs_pt = this.nomes_variaveis.FuncoesComboboxs + '.';
            this.nomes_funcoes = {
                obter_texto_combobox: "obter_texto_combobox",
                atualizar_texto_combobox: "atualizar_texto_combobox",
                fechar_combobox: "fechar_combobox",
                fechar_comboboxes_abertos: "fechar_comboboxes_abertos",
                mostrar_dropdown: "mostrar_dropdown",
                mostrar_esconder_dropdown: "mostrar_esconder_dropdown",
                limpar_combobox: "limpar_combobox",
                obter_valores_selecionados_combobox: "obter_valores_selecionados_combobox",
                montar_combobox: "montar_combobox",
                selecionar_valor : "selecionar_valor"
            };
            this.nomes_completos_funcoes = {                    
                obter_texto_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.obter_texto_combobox,
                atualizar_texto_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.atualizar_texto_combobox,
                fechar_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.fechar_combobox,
                fechar_comboboxes_abertos : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.fechar_comboboxes_abertos,
                mostrar_dropdown : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.mostrar_dropdown,
                mostrar_esconder_dropdown : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.mostrar_esconder_dropdown,
                limpar_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.limpar_combobox,
                obter_valores_selecionados_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.obter_valores_selecionados_combobox,
                montar_combobox : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.montar_combobox,
                selecionar_valor : this.nomes_variaveis.fncomboboxs_pt + this.nomes_funcoes.selecionar_valor

            };
            this.classes = {
                div_combobox : "div_combobox",
                div_combobox_botaobox_img : "div_combobox_botaobox_img",
                div_combobox_dropdown_aberto : "div_combobox_dropdown_aberto",
                div_combobox_botaobox_fechado : "div_combobox_botaobox_fechado",
                div_combobox_dropdown_fechado : "div_combobox_dropdown_fechado",
                div_combobox_botaobox : "div_combobox_botaobox",
                div_combobox_dropdown : "div_combobox_dropdown",
                div_combobox_botaobox_texto : "div_combobox_botaobox_texto",
                tabela_combobox : "tabela_combobox"
            };
            this.seletores = {
                div_combobox : "div.div_combobox",
                div_combobox_botaobox : "div.div_combobox_botaobox",
                div_combobox_botaobox_texto : "div.div_combobox_botaobox_texto",			
                div_combobox_dropdown : "div.div_combobox_dropdown",
                input_combobox : "input.input_combobox",
                tabela_est : "table.tabdados"
            };
            this.propriedades_html = {
                multiplo : "multiplo",
                num_max_texto_botao : "num_max_texto_botao"
            };   
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };



    obter_texto_combobox(combobox){
        try {
            fnjs.logi(this.constructor.name,"obter_texto_combobox");
            combobox = fnjs.obterJquery(combobox);			
            fnjs.logf(this.constructor.name,"obter_texto_combobox");
            return combobox.find(this.seletores.div_combobox_botaobox_texto).text();
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }												
    }
    atualizar_texto_combobox(combobox) {
        try {
            fnjs.logi(this.constructor.name,"atualizar_texto_combobox");
            combobox = fnjs.obterJquery(combobox);
            let	textos_selecionados = fnhtml.fntabdados.obter_textos_selecao(combobox.find(this.seletores.tabela_est));
            let num_max_texto_botao = combobox.children(this.seletores.div_combobox_botaobox).children(this.seletores.div_combobox_botaobox_texto).attr(this.propriedades_html.num_max_texto_botao) * 1;
            let texto = '';							
            let placeholder_padrao='(Selecione)';
            let multiplo = combobox.attr(this.propriedades_html.multiplo) || 'sim';
            multiplo = multiplo.trim().toLowerCase();
            if (textos_selecionados.length === fnhtml.fntabdados.obter_dados_tabela(combobox.find(this.seletores.tabela_est)).length && multiplo !== 'nao') {
                texto =  'Todos (' + textos_selecionados.length.toString() + ')';
            } else {
                if (textos_selecionados.length > num_max_texto_botao) {
                    texto = textos_selecionados.length.toString() + ' Selecionado(s)';
                } else {
                    if (!textos_selecionados.length || textos_selecionados.length === 0 ) {
                        texto = combobox.attr('placeholder') || placeholder_padrao;					
                    } else {
                        texto = textos_selecionados.join(',');
                    }
                }
            }
            combobox.find(this.seletores.div_combobox_botaobox_texto).text(texto);
            fnjs.logf(this.constructor.name,"atualizar_texto_combobox");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }											
    }
    fechar_combobox(combobox) {
        try {
            fnjs.logi(this.constructor.name,"fechar_combobox");
            let dropdown_aberto = fnjs.obterJquery(combobox).children(this.seletores.div_combobox_dropdown);
            dropdown_aberto.removeClass(this.classes.div_combobox_dropdown_aberto);
            dropdown_aberto.addClass(this.classes.div_combobox_dropdown_fechado);
            fnjs.logf(this.constructor.name,"fechar_combobox");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }											
    }		
    fechar_comboboxes_abertos() {
        try {
            fnjs.logi(this.constructor.name,"fechar_comboboxes_abertos");
            let dropdowns_abertos = fnjs.obterJquery('div.' + this.classes.div_combobox_dropdown + '.' + this.classes.div_combobox_dropdown_aberto);
            $.each(dropdowns_abertos,function(index) {
                dropdowns_abertos.removeClass(window.fnhtml.fncomboboxs.classes.div_combobox_dropdown_aberto);
                dropdowns_abertos.addClass(window.fnhtml.fncomboboxs.classes.div_combobox_dropdown_fechado);
            });
            fnjs.logf(this.constructor.name,"fechar_comboboxes_abertos");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }										
    }	
    mostrar_dropdown(obj,verificar_aoabrir) {
        try{
            fnjs.logi(this.constructor.name,"mostrar_dropdown");
            verificar_aoabrir = verificar_aoabrir || false;
            if (fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).hasClass(this.classes.div_combobox_dropdown_fechado)) {
                fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).removeClass(this.classes.div_combobox_dropdown_fechado).addClass(this.classes.div_combobox_dropdown_aberto);
                if (typeof vars.zindexcombobox === 'undefined') {
                    vars.zindexcombobox = 10;
                } 
                vars.zindexcombobox++;
                fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('z-index',vars.zindexcombobox);
                if (vars.navegador === 'iexplorer') {
                    fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('top',(
                        fnjs.obterJquery(obj).closest(this.seletores.div_combobox)[0].getBoundingClientRect().top - 
                        fnjs.obterJquery(obj).closest(this.seletores.div_combobox).closest(vars.seletores.div_opcoes)[0].getBoundingClientRect().top + fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_botaobox).height())+'px');
                    if (fnjs.obterJquery(obj).closest(vars.seletores.div_opcoes_pesquisa_avancada).length){
                        fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('left',(fnjs.obterJquery(obj).closest(this.seletores.div_combobox)[0].getBoundingClientRect().left-60) + 'px');
                    } else if (fnjs.obterJquery(obj).closest(vars.seletores.div_clientesnaopositivados).length) {
                        fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('left',(fnjs.obterJquery(obj).closest(this.seletores.div_combobox)[0].getBoundingClientRect().left-33) + 'px');
                    } else {
                        fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('left',(fnjs.obterJquery(obj).closest(this.seletores.div_combobox)[0].getBoundingClientRect().left-45) + 'px');
                    }
                }
                if (verificar_aoabrir) {
                    if (typeof fnjs.obterJquery(obj).closest(this.seletores.div_combobox).attr('aoabrir') !== 'undefined') {
                        if (fnjs.obterJquery(obj).closest(this.seletores.div_combobox).attr('aoabrir').trim().length > 0) {
                            eval(fnjs.obterJquery(obj).closest(this.seletores.div_combobox).attr('aoabrir').trim().replace('this','window.fnjs.obterJquery(obj).' + vars.nfj.closest + '("' + this.seletores.div_combobox + '")' ));
                        }
                    }
                }				
            } else {
                fnjs.obterJquery(obj).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).removeClass(this.classes.div_combobox_dropdown_aberto).addClass(this.classes.div_combobox_dropdown_fechado);
            }
            fnjs.logf(this.constructor.name,"mostrar_dropdown");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }		
    mostrar_esconder_dropdown(e) {
        try{
            fnjs.logi(this.constructor.name,"mostrar_esconder_dropdown");
            if (fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).hasClass(this.classes.div_combobox_dropdown_fechado)) {
                fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).removeClass(this.classes.div_combobox_dropdown_fechado).addClass(this.classes.div_combobox_dropdown_aberto);
                if (typeof vars.zindexcombobox === 'undefined') {
                    vars.zindexcombobox = 10;
                } 
                vars.zindexcombobox++;
                fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).css('z-index',vars.zindexcombobox);
                if (typeof fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).attr('aoabrir') !== 'undefined') {
                    if (fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).attr('aoabrir').trim().length > 0) {
                        eval(fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).attr('aoabrir').trim().replace('this','window.fnjs.obterJquery(' + vars.seletores.e_target+').' + vars.nfj.closest + '("' + this.seletores.div_combobox + '")'));
                    }
                }
                
                if (fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).find("input.inputfiltro").length) {
                    fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).find("input.inputfiltro").focus();
                } 
            } else {
                fnjs.obterJquery(e.target).closest(this.seletores.div_combobox).children(this.seletores.div_combobox_dropdown).removeClass(this.classes.div_combobox_dropdown_aberto).addClass(this.classes.div_combobox_dropdown_fechado);
            }
            fnjs.logf(this.constructor.name,"mostrar_esconder_dropdown");
        }catch(er){
            console.log(er);
            alert(e.message || er);
        }		
    }	


    limpar_combobox(obj) {
        try{
            fnjs.logi(this.constructor.name,"limpar_combobox");
            obj = fnjs.obterJquery(obj).closest(this.seletores.div_combobox);
            obj.children(this.seletores.div_combobox_botaobox).children(this.seletores.div_combobox_botaobox_texto).text('(Selecione)');
            obj.children(this.seletores.div_combobox_dropdown).children(this.seletores.tabela_est).remove();
            fnjs.logf(this.constructor.name,"limpar_combobox");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	
    obter_valores_selecionados_combobox(obj,tipo_retorno) {
        try{
            fnjs.logi(this.constructor.name,"obter_valores_selecionados_combobox");
            if (typeof obj.hasClass !== "function") {
                obj = fnjs.obterJquery(obj);
            }
            if (!obj.hasClass('div_combobox')) {
                obj = obj.closest('div.div_combobox');
            }
            let itens_checados = obj.find("input:checked:not(.input_selecionar_todos)");
            let retorno = [],
                li = null,
                label = null,
                valor = null,
                input = null,
                qt = 0;
            tipo_retorno = (tipo_retorno || "valor").toLowerCase().trim();
            qt = itens_checados.length;
            for(let i = 0; i < qt; i++) {
                input = itens_checados.eq(i);
                label = input.closest("label");
                li = input.closest("li");
                valor = li.attr("data-valor_opcao") || input.val() || label.text();
                if (typeof valor !== "undefined") {
                    if (tipo_retorno == "linha") {
                        retorno.push(li);
                    } else {
                        retorno.push(valor);
                    }
                }
            }
            fnjs.logf(this.constructor.name,"obter_valores_selecionados_combobox");
            return retorno;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }		
    /**
        * Metodo para selecionar um valor do combobox automaticamente.
        * @author Antonio Alencar Velozo
        * @created 13/02/2019
        * @param combobox Object - O elemento html que representa o combobox (div.div_combobox)
        * @param valor_selecionar String - O valor a procurar e selecionar no combobox
        * @return boolean - Se encontrou o valor e o selecionou (true) ou nao (false)
        * @status desenvolvimento
    */
    selecionar_valor(combobox,valor_selecionar) {
        try{
            fnjs.logi(this.constructor.name,"selecionar_valor");
            let tabelaest = fnjs.obterJquery(combobox).find(this.seletores.tabela_est),
                corpotab = {},
                linhastab = {},
                qtlin = 0,
                encontrou = false;
            corpotab = fnhtml.fntabdados.corpo_tabela_est(tabelaest);	
            linhastab = corpotab.children('tr');
            qtlin = linhastab.length;
            valor_selecionar = valor_selecionar.toString().trim().toLowerCase();
            for (let i = 0; i < qtlin; i++) {
                if (linhastab.eq(i).children('td:' + vars.seletores.nth_child+'(2)').text().trim().toLowerCase() === valor_selecionar) {
                    fnhtml.fntabdados.selecionar_linha_tabela_est(linhastab.eq(i));
                    encontrou = true;
                    break;
                }
            }
            fnjs.logf(this.constructor.name,"selecionar_valor");
            return encontrou;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	

    /*
    substituir referencias a esta funcao por fndrop.criar_dropdown
    */
    montar_combobox(opcoes) {
        try{
            fnjs.logi(this.constructor.name,"montar_combobox");
            let opcoes_texto_opcao = [];
            let qt = 0;
            let cont1 = 0;
            let imagem_selecao = '';
            let imagem_selecionado = '';
            let selecionar_todos = false;
            let html_combobox = '';
            let html_div_botao = '';
            let html_div_drop = '';
            let html_tab_drop = '';
            let html_linha_titulos = '';
            let html_linhas = [];
            let html_linha = '';
            let html_celula_sel = '';
            let html_img_sel = '';
            let html_celula_opcao = '';
            let status_selecao = '';
            let texto_botao = [];
            let placeholder = '(Selecione)';
            let classe_combobox = '';
            if (typeof opcoes.opcoes_texto_opcao === 'undefined') {
                qt = opcoes.length;
                for(cont1 = 0; cont1 < qt; cont1 ++) {
                    opcoes_texto_opcao.push(opcoes[cont1]);
                }
                opcoes = {};
                opcoes.opcoes_texto_opcao = opcoes_texto_opcao;
            }
            if (typeof opcoes.opcoes_valor_opcao === 'undefined') {				
                qt = opcoes.opcoes_texto_opcao.length;
                opcoes.opcoes_valor_opcao = [];
                for(cont1=0; cont1 < qt; cont1++) {
                    opcoes.opcoes_valor_opcao.push(opcoes.opcoes_texto_opcao[cont1]);
                }
            }
            if (typeof opcoes.opcoes_texto_botao === 'undefined') {
                qt = opcoes.opcoes_texto_opcao.length;
                opcoes.opcoes_texto_botao = [];
                for(cont1=0; cont1 < qt; cont1++) {
                    opcoes.opcoes_texto_botao.push(opcoes.opcoes_texto_opcao[cont1]);
                }
            }
            if (typeof opcoes.tipo === 'undefined') {
                opcoes.tipo = 'checkbox';
            }
            if (typeof opcoes.multiplo === 'undefined') {
                opcoes.multiplo = 'sim';
            }
            if (typeof opcoes.selecionar_todos === 'undefined') {
                opcoes.selecionar_todos = 'sim';
            }
            if (opcoes.tipo === 'radio') {
                imagem_selecao = vars.nomes_caminhos_arquivos.radio;
                imagem_selecionado = vars.nomes_caminhos_arquivos.radio_checked;
            } else {
                imagem_selecao = vars.nomes_caminhos_arquivos.checkbox;
                imagem_selecionado = vars.nomes_caminhos_arquivos.checkbox_checked;
                }
            if (typeof opcoes.selecionados !== 'undefined') {
                if (typeof opcoes.selecionados !== 'object') {
                    opcoes.selecionados = opcoes.selecionados.split(',');
                }
            } else {
                opcoes.selecionados = [];
            }
            if (typeof opcoes.selecionados[0] !== 'undefined') {
                if (opcoes.selecionados[0].toString().trim().toLowerCase() === 'todos') {
                    selecionar_todos = true;
                } else {
                    selecionar_todos = false;
                }
            }

            if (typeof opcoes.num_max_texto_botao === 'undefined') {
                opcoes.num_max_texto_botao = 5;
            }		
            classe_combobox = '';
            html_combobox += '<div tipo="' + opcoes.tipo + '" multiplo="' + opcoes.multiplo + '" ' ;
            if (typeof opcoes.aoselecionaropcao !== 'undefined') {
                html_combobox += ' aoselecionaropcao="' + opcoes.aoselecionaropcao + '" ';
            }
            if (typeof opcoes.aoabrir !== 'undefined') {
                html_combobox += ' aoabrir="' + opcoes.aoabrir + '" ';
            }
            if (typeof opcoes.propriedades_html !== 'undefined') {
                qt = opcoes.propriedades_html.length;
                for(cont1=0; cont1 < qt; cont1++){
                    if (opcoes.propriedades_html[cont1].propriedade === 'class') {
                        classe_combobox = ' ' + opcoes.propriedades_html[cont1].valor;
                    } else {
                        html_combobox += ' ' + opcoes.propriedades_html[cont1].propriedade + '="' + opcoes.propriedades_html[cont1].valor + '" '; 
                    }
                }
            }
            html_combobox += ' class="' + this.classes.div_combobox + classe_combobox+'" ';			
            html_combobox +=  '>';
            html_div_botao = '<div class="' + this.classes.div_combobox_botaobox + ' ' + this.classes.div_combobox_botaobox_fechado + '" >';
            html_div_drop = '<div class="' + this.classes.div_combobox_dropdown + ' ' + this.classes.div_combobox_dropdown_fechado + '">';
            html_div_botao += '<div class="' + this.classes.div_combobox_botaobox_texto + '" ' + this.propriedades_html.num_max_texto_botao + '="' + opcoes.num_max_texto_botao + '">';
            texto_botao = [];
            if (selecionar_todos) {
                texto_botao.push( 'Todos (' + opcoes.opcoes_texto_opcao.length + ')');			
            } else {
                qt = opcoes.selecionados.length;
                for(cont1=0 ; cont1 < qt ; cont1++) {
                    texto_botao.push(opcoes.opcoes_texto_botao[opcoes.selecionados[cont1]]);
                }
            }
            if (texto_botao.length <= 0 ) {
                texto_botao.push(placeholder);
            } else if (texto_botao.length > opcoes.num_max_texto_botao) {
                qt = texto_botao.length;
                texto_botao = [];				
                texto_botao.push(qt.toString() + ' Selecionado(s)');
            }
            texto_botao = texto_botao.join(',');
            html_div_botao += texto_botao;
            html_div_botao += '</div>';
            html_div_botao += '<div class="' + this.classes.div_combobox_botaobox_img + '"><img src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown + '"></div>';
            html_div_botao += '</div>';
            opcoes.classetab = this.classes.tabela_combobox;
            opcoes.selecionar_pela_linha = true;
            html_tab_drop = fnhtml.fntabdados.montar_tabela_est(opcoes,selecionar_todos);
            html_div_drop += html_tab_drop;
            html_div_drop += '</div>';		
            html_combobox += html_div_botao + html_div_drop + '</div>';
            fnjs.logf(this.constructor.name,"montar_combobox");
            return html_combobox;			
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }
};			





/*Classe FuncoesCalendario*/
class FuncoesCalendario{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.strings= {
                _01 : "01"
            };
            this.nomes_variaveis = {
                FuncoesCalendario : "FuncoesCalendario"
            };
            this.nomes_variaveis.fncal_pt = this.nomes_variaveis.FuncoesCalendario + '.';
            this.nomes_funcoes = {
                aplicar_mascara_calendario : "aplicar_mascara_calendario",
                atualizar_dias : "atualizar_dias",
                clicou_dia_calendario : "clicou_dia_calendario",
                clicou_mes_calendario : "clicou_mes_calendario",
                decrementar_ano : "decrementar_ano",
                decrementar_dia : "decrementar_dia",
                decrementar_hora : "decrementar_hora",
                decrementar_mes : "decrementar_mes",
                decrementar_minuto : "decrementar_minuto",
                decrementar_segundo : "decrementar_segundo",
                esconder_calendario : "esconder_calendario",
                fechar_calendario : "fechar_calendario",
                incrementar_ano : "incrementar_ano",
                incrementar_dia : "incrementar_dia",
                incrementar_hora : "incrementar_hora",
                incrementar_mes : "incrementar_mes",
                incrementar_minuto : "incrementar_minuto",
                incrementar_segundo : "incrementar_segundo",
                montar_cabecalho_calendario : "montar_cabecalho_calendario",
                montar_combobox_mes_calendario : "montar_combobox_mes_calendario",
                montar_corpo_calendario : "montar_corpo_calendario",
                montar_dias : "montar_dias",
                montar_horarios : "montar_horarios",
                montar_mes : "montar_mes",
                mostrar_calendario : "mostrar_calendario",
                obter_data : "obter_data",
                obter_hora : "obter_hora",
                obter_minuto : "obter_minuto",
                obter_segundo : "obter_segundo",
                selecionado_mes : "selecionado_mes",
                selecionar_dia : "selecionar_dia",
                selecionou_hora : "selecionou_hora",
                selecionou_minuto : "selecionou_minuto",
                selecionou_segundo : "selecionou_segundo",
                setar_dia : "setar_dia",
                setar_mes : "setar_mes",
                transf_calendario : "transf_calendario",
                transformar_calendario_se_data : "transformar_calendario_se_data"

            };
            this.nomes_completos_funcoes = {                    
                aplicar_mascara_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.aplicar_mascara_calendario,
                atualizar_dias : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.atualizar_dias,
                clicou_dia_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.clicou_dia_calendario,
                clicou_mes_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.clicou_mes_calendario,
                decrementar_ano : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_ano,
                decrementar_dia : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_dia,
                decrementar_hora : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_hora,
                decrementar_mes : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_mes,
                decrementar_minuto : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_minuto,
                decrementar_segundo : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.decrementar_segundo,
                esconder_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.esconder_calendario,
                fechar_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.fechar_calendario,
                incrementar_ano : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_ano,
                incrementar_dia : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_dia,
                incrementar_hora : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_hora,
                incrementar_mes : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_mes,
                incrementar_minuto : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_minuto,
                incrementar_segundo : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.incrementar_segundo,
                montar_cabecalho_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_cabecalho_calendario,
                montar_combobox_mes_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_combobox_mes_calendario,
                montar_corpo_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_corpo_calendario,
                montar_dias : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_dias,
                montar_horarios : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_horarios,
                montar_mes : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.montar_mes,
                mostrar_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.mostrar_calendario,
                obter_data : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.obter_data,
                obter_hora : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.obter_hora,
                obter_minuto : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.obter_minuto,
                obter_segundo : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.obter_segundo,
                selecionado_mes : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.selecionado_mes,
                selecionar_dia : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.selecionar_dia,
                selecionou_hora : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.selecionou_hora,
                selecionou_minuto : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.selecionou_minuto,
                selecionou_segundo : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.selecionou_segundo,
                setar_dia : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.setar_dia,
                setar_mes : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.setar_mes,
                transf_calendario : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.transf_calendario,
                transformar_calendario_se_data : this.nomes_variaveis.fncal_pt + this.nomes_funcoes.transformar_calendario_se_data
            };
            this.propriedades_html = {			
                aoselecionardia : "aoselecionardia",
                aoselecionarhora : "aoselecionarhora",
                aoselecionarminuto : "aoselecionarminuto",
                aoselecionarsegundo : "aoselecionarsegundo"
            };
            this.classes = {
                componente_data : "componente_data",
                dia_selecionado : "dia_selecionado",
                div_ano_controles : "div_ano_controles",
                div_ano_input : "div_ano_input",
                div_dia : "div_dia",
                div_mes_controles : "div_mes_controles",
                div_calendario_ano : "div_calendario_ano",
                div_calendario_btn_ok : "div_calendario_btn_ok",
                div_calendario_cabecalho : "div_calendario_cabecalho",
                div_calendario_combobox_mes : "div_calendario_combobox_mes",
                div_calendario_corpo : "div_calendario_corpo",
                div_calendario_dias : "div_calendario_dias",			
                div_calendario_dias_corpo : "div_calendario_dias_corpo",
                div_calendario_mes : "div_calendario_mes",
                div_calendario_horarios : "div_calendario_horarios",
                div_calendario_rodape : "div_calendario_rodape",
                div_coluna_dia : "div_coluna_dia",
                div_colunas_dias : "div_colunas_dias",
                div_dias_controles : "div_dias_controles",
                div_horas : "div_horas",
                div_horas_controles : "div_horas_controles",
                div_lista_horas : "div_lista_horas",
                div_lista_minutos : "div_lista_minutos",
                div_lista_segundos : "div_lista_segundos",
                div_minutos : "div_minutos",
                div_minutos_controles : "div_minutos_controles",
                div_segundos : "div_segundos",
                div_segundos_controles : "div_segundos_controles",
                dia_selecionado : "dia_selecionado",			
                div_semana : "div_semana",
                div_titulo_horas : "div_titulo_horas",
                div_titulo_minutos : "div_titulo_minutos",
                div_titulo_segundos : "div_titulo_segundos",
                imagem_mes_calendario : "imagem_mes_calendario",
                input_calendario : "input_calendario",
                input_div_ano : "input_div_ano"
            };
            this.seletores = {
                componente_data : "input.componente_data",
                div_calendario : "div.div_calendario",
                div_calendario_dias : "div.div_calendario_dias",
                div_calendario_dias_corpo : "div.div_calendario_dias_corpo",
                div_calendario_mes : "div.div_calendario_mes",
                div_combobox : "div.div_combobox",
                div_dia : "div.div_dia",
                dia_selecionado : "div.dia_selecionado",
                div_horas : "div.div_horas",
                div_lista_horas : "div.div_lista_horas",
                div_lista_minutos : "div.div_lista_minutos",
                div_lista_segundos : "div.div_lista_segundos",
                div_listbox : "div.div_listbox",
                div_minutos : "div.div_minutos",
                div_segundos : "div.div_segundos",
                input_calendario : "input.input_calendario",
                input_div_ano : "input.input_div_ano",
                inputano : "input.inputano"
            };
            this.mensagens = {
                erro_incrementar_anterior_inexistente : "falha ao incrementar valor, anterior nao encontrado"
            }
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        } 
    };
    esconder_calendario(params){
        try {
            fnjs.logi(this.constructor.name,"esconder_calendario");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                if (params.elemento.hasClass(vars.classes.div_calendario)) {
                    params.elemento.prev('input').attr('status_calendario','invisivel');
                    params.elemento.remove();
                } else {
                    let status = params.elemento.attr('status_calendario');
                    if (status !== 'invisivel') {
                        params.elemento.next(this.seletores.div_calendario).fadeOut(150).remove();
                        params.elemento.attr('status_calendario','invisivel');
                    }
                }
            }
            fnjs.logf(this.constructor.name,"esconder_calendario");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }
    obter_hora(params){
        try {
            fnjs.logi(this.constructor.name,"obter_hora");
            let div_hora = {},
                lista_horas = {},
                hora = 0;
            params.elemento = fnjs.obterJquery(params.elemento);
            div_hora = params.elemento.find(this.seletores.div_horas);
            lista_horas = div_hora.find(this.seletores.div_lista_horas);
            hora = fnlistboxs.obter_valores_selecionados_listbox(lista_horas.find(this.seletores.div_listbox));
            hora = hora.toString();
            fnjs.logf(this.constructor.name,"obter_hora");
            return hora;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }
    obter_minuto(params){
        try {
            fnjs.logi(this.constructor.name,"obter_minuto");
            let div_minutos = {},
                lista_minutos = {},
                minuto = 0;
            params.elemento = fnjs.obterJquery(params.elemento);
            div_minutos = params.elemento.find(this.seletores.div_minutos);
            lista_minutos = div_minutos.find(this.seletores.div_lista_minutos);
            minuto = fnlistboxs.obter_valores_selecionados_listbox(lista_minutos.find(this.seletores.div_listbox));
            minuto = minuto.toString();
            fnjs.logf(this.constructor.name,"obter_minuto");
            return minuto;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }
    obter_segundo(params){
        try {
            fnjs.logi(this.constructor.name,"obter_segundo");
            let div_segundos = {},
                lista_segundos = {},
                segundo = 0;
            params.elemento = fnjs.obterJquery(params.elemento);
            div_segundos = params.elemento.find(this.seletores.div_segundos);
            lista_segundos = div_segundos.find(this.seletores.div_lista_segundos);
            segundo = fnlistboxs.obter_valores_selecionados_listbox(lista_segundos.find(this.seletores.div_listbox));
            segundo = segundo.toString();
            fnjs.logf(this.constructor.name,"obter_segundo");
            return segundo;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }				
    }	
    obter_data(params) {
        try {
            fnjs.logi(this.constructor.name,"obter_data");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                let calendario = params.elemento.closest(this.seletores.div_calendario),
                    ano = 0;
                    mes = {},
                    dia = 0,
                    opcoes_calendario = {},
                    hora = 0,
                    minuto = 0,
                    segundo = 0,
                    data = '',
                    dataverif = {},
                    cont = 0,
                    tem_horarios = false;
                opcoes_calendario = JSON.parse(calendario.attr('opcoes').replace(/\\"/g,'"'))||{};
                ano = calendario.find(this.seletores.input_div_ano).val();					
                mes = fnsisjd.pegar_valores_elementos(calendario.find(this.seletores.div_combobox));			
                dia = calendario.find(this.seletores.dia_selecionado).text();
                if (typeof mes !== 'string') {
                    mes = mes.toString();
                }
                mes = vars.constantes.meses.indexOf(mes);
                if (fnjs.como_booleano(opcoes_calendario.mostrar_horas) === true) {
                    tem_horarios = true;
                    hora = this.obter_hora({elemento:calendario})||0;
                }			
                if (fnjs.como_booleano(opcoes_calendario.mostrar_minutos) === true) {
                    tem_horarios = true;
                    minuto = this.obter_minuto({elemento:calendario})||0;
                }
                if (fnjs.como_booleano(opcoes_calendario.mostrar_segundos) === true) {
                    tem_horarios = true;
                    segundo = this.obter_segundo({elemento:calendario})||0;
                }
                dataverif = new Date(ano * 1,mes * 1,dia * 1,hora * 1,minuto * 1,segundo * 1);	
                if (tem_horarios === true) {
                    data = fndt.dataBR(dataverif) + ' ' + fndt.getHora({data:dataverif,digitos:2}) + ':' + fndt.getMinuto({data:dataverif,digitos:2}) + ':' + fndt.getSegundo({data:dataverif,digitos:2});
                } else {
                    data = fndt.dataBR(dataverif);
                }				
            }
            fnjs.logf(this.constructor.name,"obter_data");
            return data;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	

    selecionar_dia(params) {
        try {
            fnjs.logi(this.constructor.name,"selecionar_dia");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                let calendario = params.elemento.closest(this.seletores.div_calendario);
                let input = calendario.prev(this.seletores.input_calendario);
                calendario.find(this.seletores.div_dia).removeClass(this.classes.dia_selecionado);
                params.elemento.addClass(this.classes.dia_selecionado);
                this.atualizar_data_input({elemento:calendario});
                if (typeof calendario.attr(this.propriedades_html.aoselecionardia) !== 'undefined') {
                    eval(calendario.attr(this.propriedades_html.aoselecionardia).replace(/this/g,'params.elemento'));
                }
                this.esconder_calendario({elemento:calendario});
            }
            fnjs.logf(this.constructor.name,"selecionar_dia");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }
    selecionou_hora(params) {
        try {
            fnjs.logi(this.constructor.name,"selecionou_hora");
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            if (params.elemento.length) {
                let calendario = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
                this.atualizar_data_input({elemento:calendario});
                if (typeof calendario.attr(this.propriedades_html.aoselecionarhora) !== 'undefined') {
                    eval(calendario.attr(this.propriedades_html.aoselecionarhora).replace(/this/g,params.elemento));
                }
            }
            fnjs.logf(this.constructor.name,"selecionou_hora");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	

    selecionou_minuto(params) {
        try {
            fnjs.logi(this.constructor.name,"selecionou_minuto");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                let calendario = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
                this.atualizar_data_input({elemento:calendario});
                if (typeof calendario.attr(this.propriedades_html.aoselecionarminuto) !== 'undefined') {
                    eval(calendario.attr(this.propriedades_html.aoselecionarminuto).replace(/this/g,params.elemento));
                }
            }
            fnjs.logf(this.constructor.name,"selecionou_minuto");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }
    selecionou_segundo(params) {
        try {
            fnjs.logi(this.constructor.name,"selecionou_segundo");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                let calendario = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
                this.atualizar_data_input({elemento:calendario});
                if (typeof calendario.attr(this.propriedades_html.aoselecionarsegundo) !== 'undefined') {
                    eval(calendario.attr(this.propriedades_html.aoselecionarsegundo).replace(/this/g,params.elemento));
                }
            }
            fnjs.logf(this.constructor.name,"selecionou_segundo");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }	

    /**
        * Funcao que monta os dias do calendario
        * @author Antonio Alencar Velozo
        * @created 01/001/2019
        * @param data String - A data atual dos dias
        * @param opcoes Object - opcoes
        * @status finalizada
    */	
    montar_dias(params) { 
        try {
            
            fnjs.logi(this.constructor.name,"montar_dias");
            let div_dias = '<div class="' + this.classes.div_calendario_dias + '"><div class="' + this.classes.div_calendario_dias_corpo + '">';
            let div_colunas_dias = '<div class="' + this.classes.div_colunas_dias + '">';
            let linhas_dias = [];
            let qtlinhas = 6;
            let cont = 0;
            let cont2 = 0;
            let linha_dias = [];
            let dia = 0;
            let primeirodiames = null;
            let primeirodiasemana = 0;
            let ultimodiadomes=null;
            let datatemp = '';
            if (typeof params.data === 'object') {
                datatemp = fndt.getDia({data:params.data,digitos:2}) + vars.sepdata + fndt.getMes({data:params.data,digitos:2}) + vars.sepdata + fndt.getAno({data:params.data,digitos:4});
            } else {
                datatemp = params.data;
            }
            datatemp = fndt.data_como_cnj_date(datatemp);
            let obj_data = new Date(datatemp[0],datatemp[1],datatemp[2],datatemp[3],datatemp[4],datatemp[5]);
            let dia_do_mes = datatemp[2];
            let ind_mes = datatemp[1];
            let classe_dia_selecao = '';
            $.each(vars.constantes.dias_da_semana_abrev,function(index){
                div_colunas_dias += '<div class="' + window.fnhtml.fncal.classes.div_coluna_dia + '">' + vars.constantes.dias_da_semana_abrev[index] + '</div>';
            });
            div_colunas_dias += '</div>';
            primeirodiames = fndt.data_primeirodiames(obj_data);
            primeirodiames = fndt.data_como_cnj_date(primeirodiames);
            primeirodiames = new Date(primeirodiames[0],primeirodiames[1],primeirodiames[2],primeirodiames[3],primeirodiames[4],primeirodiames[5]);
            primeirodiasemana = primeirodiames.getDay();
            ultimodiadomes = fndt.setar_ultimo_dia_mes(primeirodiames);
            diadasemana = primeirodiasemana ;
            dia = 1;
            for(cont = 0 ; cont<qtlinhas; cont++){
                linha_dias = [];						
                for(cont2 = 0; cont2 < vars.constantes.dias_da_semana_abrev.length; cont2++) {
                    if (diadasemana === cont2 && dia <= ultimodiadomes.getDate()) {
                        if (dia === dia_do_mes) {
                            classe_dia_selecao = this.classes.dia_selecionado;
                        } else {
                            classe_dia_selecao = '';
                        }
                        linha_dias.push('<div class="' + this.classes.div_dia + ' ' + classe_dia_selecao + '" onclick="window.fnhtml.fncal.selecionar_dia({elemento:this})">' + dia.toString() + '</div>');
                        diadasemana = cont2+1;
                        dia++;
                    } else {
                        linha_dias.push('<div class="' + this.classes.div_dia + '">&nbsp;</div>' );
                    }
                }
                diadasemana = 0;
                linha_dias = linha_dias.join('');
                linhas_dias.push('<div class="'+ this.classes.div_semana + '">'+linha_dias+'</div>');
            }					
            linhas_dias = linhas_dias.join('');			
            div_dias_controles = '<div class="'+ this.classes.div_dias_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_dia({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_dia({event:event,elemento:this})"></div>' ;			
            div_dias += div_colunas_dias + linhas_dias + '</div>' + div_dias_controles + '</div>';			
            fnjs.logf(this.constructor.name,"montar_dias");
            return div_dias;			
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }
    /**
        * Funcao que monta os horarios do calendario
        * @author Antonio Alencar Velozo
        * @created 01/01/2019
        * @param data String - A data atual dos dias
        * @param opcoes Object - opcoes
        * @status desenvolvimento
    */	
    montar_horarios(params) {
        try {
            fnjs.logi(this.constructor.name,"montar_horarios");
            let div_horarios = '',
                div_horas = '',
                div_minutos = '',
                div_segundos = '',
                opcoes_listbox = {},
                horas = [],
                div_lista_horas = {},
                minutos = [],
                div_lista_minutos = {},
                segundos = [],
                div_lista_segundos = {},
                data = {},
                div_horas_controles,
                div_minutos_controles,
                div_segundos_controles;
            params.opcoes = params.opcoes || {};
            params.opcoes.data = params.opcoes.data || params.data;
            if (typeof params.opcoes.data === 'undefined' || params.opcoes.data === null) {
                data = new Date();
            } else {
                if (typeof params.opcoes.data === 'string') {
                    data = fndt.data_como_cnj_date(data);
                    data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);
                } else if (typeof params.opcoes.data === 'object') {
                    data = params.opcoes.data;
                }
            }			
            time = data.toLocaleTimeString();
            time = time.split(':');
            if (typeof params.opcoes.hora === 'undefined') {				
                params.opcoes.hora = time[0].toString().substr(0,2).replace(' ','').replace('am','').replace('pm','').trim();
            }
            if (typeof params.opcoes.minuto === 'undefined') {
                params.opcoes.minuto = time[1].toString().substr(0,2).replace(' ','').replace('am','').replace('pm','').trim();
            }
            if (typeof params.opcoes.segundo === 'undefined') {
                params.opcoes.segundo = time[2].toString().substr(0,2).replace(' ','').replace('am','').replace('pm','').trim();
            }

            div_horarios = '<div class="'+ this.classes.div_calendario_horarios + '">';
            if (params.opcoes.mostrar_horas === true) {			
                div_horas = '<div class="' + this.classes.div_horas + '"><div class="' + this.classes.div_titulo_horas + '">hs</div>' ;
                div_lista_horas = '<div class="' + this.classes.div_lista_horas + '">';
                horas = [];
                for (let i = 0; i < 24; i++) {                            
                    horas.push(i.toString().padStart(2,'0'));
                }
                opcoes_listbox = {};
                opcoes_listbox.opcoes_texto_opcao = horas;
                opcoes_listbox.selecionados = horas.indexOf(params.opcoes.hora);
                opcoes_listbox.tipo = 'radio';
                opcoes_listbox.multiplo = false;
                opcoes_listbox.selecionar_todos = 'nao';
                opcoes_listbox.propriedades_html = [];
                opcoes_listbox.propriedades_html.push({propriedade:'style',valor: 'max-height:100px;overflow:auto;'});				
                opcoes_listbox.aoselecionaropcao='window.fnhtml.fncal.selecionou_hora(this)';
                div_lista_horas += fnlistboxs.montar_listbox(opcoes_listbox);
                div_horas_controles = '<div class="' + this.classes.div_horas_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_hora({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_hora({event:event,elemento:this})"></div>' ;			
                div_horas += div_lista_horas + '</div>' + div_horas_controles + '</div>';
                div_horarios += div_horas;
            }
            if (params.opcoes.mostrar_minutos === true) {			
                div_minutos = '<div class="' + this.classes.div_minutos + '"><div class="' + this.classes.div_titulo_minutos + '">min</div>' ;
                div_lista_minutos = '<div class="' + this.classes.div_lista_minutos + '">';
                minutos = [];
                for (let i = 0; i < 60; i++) {
                    minutos.push(i.toString().padStart(2,'0'));
                }
                opcoes_listbox = {};
                opcoes_listbox.opcoes_texto_opcao = minutos;
                opcoes_listbox.selecionados = minutos.indexOf(params.opcoes.minuto);
                opcoes_listbox.tipo = 'radio';
                opcoes_listbox.multiplo = false;
                opcoes_listbox.selecionar_todos = 'nao';
                opcoes_listbox.propriedades_html = [];
                opcoes_listbox.propriedades_html.push({propriedade:'style',valor: 'max-height:100px;overflow:auto;'});				
                opcoes_listbox.aoselecionaropcao='window.fnhtml.fncal.selecionou_minuto({elemento:this})';
                div_lista_minutos += fnlistboxs.montar_listbox(opcoes_listbox);
                div_minutos_controles = '<div class="' + this.classes.div_minutos_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_minuto({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_minuto({event:event,elemento:this})"></div>' ;			
                div_minutos += div_lista_minutos + '</div>' + div_minutos_controles + '</div>';
                div_horarios += div_minutos;
            }
            if (params.opcoes.mostrar_segundos === true) {			
                div_segundos = '<div class="' + this.classes.div_segundos + '"><div class="' + this.classes.div_titulo_segundos + '">s</div>' ;
                div_lista_segundos = '<div class="' + this.classes.div_lista_segundos + '">';
                segundos = [];
                for (let i = 0; i < 60; i++) {
                    segundos.push(i.toString().padStart(2,'0'));
                }
                opcoes_listbox = {};
                opcoes_listbox.opcoes_texto_opcao = segundos;
                opcoes_listbox.selecionados = segundos.indexOf(params.opcoes.segundo);
                opcoes_listbox.tipo = 'radio';
                opcoes_listbox.multiplo = false;
                opcoes_listbox.selecionar_todos = 'nao';
                opcoes_listbox.propriedades_html = [];
                opcoes_listbox.propriedades_html.push({propriedade:'style',valor: 'max-height:100px;overflow:auto;'});				
                opcoes_listbox.aoselecionaropcao='window.fnhtml.fncal.selecionou_segundo({elemento:this})';
                div_lista_segundos += fnlistboxs.montar_listbox(opcoes_listbox);
                div_minutos_controles = '<div class="' + this.classes.div_segundos_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_segundo({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_segundo({event:event,elemento:this})"></div>' ;			
                div_segundos += div_lista_segundos + '</div>' + div_minutos_controles + '</div>';
                div_horarios += div_segundos;
            }
            div_horarios += '</div>';			
            fnjs.logf(this.constructor.name,"montar_horarios");
            return div_horarios;			
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	
    montar_combobox_mes_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"montar_combobox_mes_calendario");
            if (typeof params.data === 'object') {
                datatemp = fndt.getDia({data:params.data,digitos:2}) + vars.sepdata + fndt.getMes({data:params.data,digitos:2}) + vars.sepdata + fndt.getAno({data:params.data,digitos:4});
                params.data = datatemp;
            } else {
                datatemp = params.data;
            }
            datatemp = fndt.data_como_cnj_date(datatemp);
            let obj_data = new Date(datatemp[0],datatemp[1],datatemp[2],datatemp[3],datatemp[4],datatemp[5]);
            let ind_mes = datatemp[1]; //mes ja retorna base 0
            let opcoes_combobox = {};			
            let combobox_mes_calendario = '';
            opcoes_combobox = {};
            opcoes_combobox.opcoes_texto_opcao = vars.constantes.meses;
            opcoes_combobox.selecionados = [];
            opcoes_combobox.selecionados.push(ind_mes);
            opcoes_combobox.tipo = 'radio';
            opcoes_combobox.multiplo = 'nao';
            opcoes_combobox.selecionar_todos = 'nao';
            opcoes_combobox.filtro = 'sim';
            opcoes_combobox.aoselecionaropcao = 'window.fnhtml.fncal.selecionado_mes({elemento:this})';
            opcoes_combobox.propriedades_html = [];
            opcoes_combobox.propriedades_html.push({
                propriedade:'style',
                valor:'width:150px;max-width:150px;height:30px;max-height:30px;'
            });
            combobox_mes_calendario = window.fnhtml.fncomboboxs.montar_combobox(opcoes_combobox);
            fnjs.logf(this.constructor.name,"montar_combobox_mes_calendario");
            return combobox_mes_calendario;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		
    }
    montar_mes(params) {
        try {
            fnjs.logi(this.constructor.name,"montar_mes");
            let div_mes = '<div class="' + this.classes.div_calendario_mes + '">';
            let datatemp = '';
            let div_dias = '';
            if (typeof params.data === 'object') {
                datatemp = fndt.getDia({data:params.data,digitos:2}) + vars.sepdata + fndt.getMes({data:params.data,digitos:2}) + vars.sepdata + fndt.getAno({data:params.data,digitos:4});
                params.data = datatemp;
            } else {
                datatemp = params.data;
            }
            datatemp = fndt.data_como_cnj_date(datatemp);
            let obj_data = new Date(datatemp[0],datatemp[1],datatemp[2],datatemp[3],datatemp[4],datatemp[5]);
            let ind_mes = datatemp[1];
            let opcoes_combobox = {};			
            opcoes_combobox = {};
            opcoes_combobox.opcoes_texto_opcao = vars.constantes.meses;
            opcoes_combobox.selecionados = [];
            opcoes_combobox.selecionados.push(ind_mes);
            opcoes_combobox.tipo = 'radio';
            opcoes_combobox.multiplo = 'nao';
            opcoes_combobox.selecionar_todos = 'nao';
            opcoes_combobox.filtro = 'sim';
            opcoes_combobox.aoselecionaropcao = 'window.fnhtml.fncal.selecionado_mes({elemento:this})';
            opcoes_combobox.propriedades_html = [];
            opcoes_combobox.propriedades_html.push({
                propriedade:'style',
                valor:'width:150px;max-width:150px;height:30px;max-height:30px;'
            });
            div_mes += this.fncomboboxs.montar_combobox(opcoes_combobox) + '</div>';
            div_dias += fncal.montar_dias(params);			
            fnjs.logf(this.constructor.name,"montar_mes");
            return div_mes + div_dias;			
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }
    atualizar_dias(params){
        try {
            fnjs.logi(this.constructor.name,"atualizar_dias");
            params.elemento = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
            let div_dias = params.elemento.find(this.seletores.div_calendario_dias);
            let nova_div_dias = this.montar_dias({data:this.obter_data(params)});
            div_dias.html(nova_div_dias);
            fnjs.logf(this.constructor.name,"atualizar_dias");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	
    selecionado_mes(params){
        try {
            fnjs.logi(this.constructor.name,"selecionado_mes");
            if (typeof params.elemento.getElementohtml === 'function') {
                params.elemento = params.elemento.getElementohtml();
            }
            params.elemento = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
            this.atualizar_dias(params);
            this.atualizar_data_input(params);
            fnhtml.elemento_alterado_dinamicamente({elemento:params.elemento.find(this.seletores.div_combobox)});
            fnjs.logf(this.constructor.name,"selecionado_mes");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	
        
    atualizar_data_input(params) {
        try {
            fnjs.logi(this.constructor.name,"atualizar_data_input");
            let div_calendario = fnjs.obterJquery(params.elemento).closest(this.seletores.div_calendario);
            let data = this.obter_data({elemento:div_calendario});
            let input_data = div_calendario.prev(this.seletores.input_calendario);			
            input_data.val(data);		
            fnhtml.elemento_alterado_dinamicamente({elemento:input_data});
            fnjs.logf(this.constructor.name,"atualizar_data_input");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }		
    /**
        * Funcao que eh acionada ao clicar no botao incrementar ano do calendario. Efetiva o incremento do ano. 
        * @author Antonio Alencar Velozo
        * @created 01/02/2019
        * @param obj Object - O Objeto clicado		
        * @param processar_calendario Boolean [optional][default=true] - Se deve atualiar os demais campos do calendario (dias)
        * @status finalizada
    */	
    incrementar_ano(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_ano");
            let div_calendario = {},
                input_ano = {},
                ano = 0;
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            input_ano = div_calendario.find(this.seletores.input_div_ano);
            ano = Number(input_ano.val());			
            params.processar_calendario = params.processar_calendario || true;
            input_ano.val(ano+1);
            fnhtml.elemento_alterado_dinamicamente({elemento:input_ano});
            if (params.processar_calendario === true) {
                this.atualizar_dias({elemento:div_calendario});
                this.atualizar_data_input({elemento:div_calendario});
            }
            fnjs.logf(this.constructor.name,"incrementar_ano");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	
    /**
        * Funcao que eh acionada ao clicar no botao decrementar ano do calendario. Efetiva o decremento do ano. 
        * @author Antonio Alencar Velozo
        * @created 01/02/2019
        * @param obj Object - O Objeto clicado		
        * @param processar_calendario Boolean [optional][default=true] - Se deve atualiar os demais campos do calendario (dias)
        * @status finalizada
    */		
    decrementar_ano(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_ano");
            let div_calendario = {},
                input_ano = {},
                ano = 0;
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            input_ano = div_calendario.find(this.seletores.input_div_ano);
            ano = Number(input_ano.val());			
            params.processar_calendario = params.processar_calendario || true;
            input_ano.val(ano-1);	
            fnhtml.elemento_alterado_dinamicamente({elemento:input_ano});
            if (params.processar_calendario === true) {
                this.atualizar_dias({elemento:div_calendario});			
                this.atualizar_data_input({elemento:div_calendario});
            }
            fnjs.logf(this.constructor.name,"decrementar_ano");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	

    atualizou_ano(params) {
        try {
            fnjs.logi(this.constructor.name,"atualizou_ano");
            let div_calendario = {},
                input_ano = {},
                ano = 0;
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            input_ano = div_calendario.find(this.seletores.input_div_ano);
            ano = Number(input_ano.val());			
            params.processar_calendario = params.processar_calendario || true;
            fnhtml.elemento_alterado_dinamicamente({elemento:input_ano});
            if (params.processar_calendario === true) {
                this.atualizar_dias({elemento:div_calendario});			
                this.atualizar_data_input({elemento:div_calendario});
            }
            fnjs.logf(this.constructor.name,"atualizou_ano");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }

    /**
        * Funcao que eh acionada ao clicar no botao incrementar mes do calendario. Efetiva a selecao e atualizacao do combobox 
        * mes para o proximo.
        * @author Antonio Alencar Velozo
        * @created 13/02/2019
        * @param obj Object - O Objeto clicado		
        * @status finalizada
    */	
    incrementar_mes(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_mes");
            let div_calendario = {},
                combobox_mes = {},
                mes = '';
                proxmes = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            combobox_mes = div_calendario.find(this.seletores.div_calendario_mes).find(this.seletores.div_combobox);			
            mes = window.fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_mes);
            mes = mes.toString();
            proxmes = vars.constantes.meses.indexOf(mes) + 1
            if (proxmes > 11) {
                proxmes = 0;
                this.incrementar_ano({event:params.event,elemento:params.elemento,processar_calendario:false});
            }
            mes = vars.constantes.meses[proxmes];
            this.fncomboboxs.selecionar_valor(combobox_mes,mes);
            fnhtml.elemento_alterado_dinamicamente({elemento:combobox_mes});
            this.atualizar_dias({elemento:div_calendario});
            this.atualizar_data_input({elemento:div_calendario});
            fnjs.logf(this.constructor.name,"incrementar_mes");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	
    /**
        * Funcao que eh acionada ao clicar no botao decrementar mes do calendario. Efetiva a selecao e atualizacao do combobox 
        * mes para o proximo.
        * @author Antonio Alencar Velozo
        * @created 13/02/2019
        * @param obj Object - O Objeto clicado		
        * @status desenvolvimento
    */		
    decrementar_mes(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_mes");
            let div_calendario = {},
                combobox_mes = {},
                mes = '';
                proxmes = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            combobox_mes = div_calendario.find(this.seletores.div_calendario_mes).find(this.seletores.div_combobox);			
            mes = window.fnhtml.fncomboboxs.obter_valores_selecionados_combobox(combobox_mes);
            mes = mes.toString();
            proxmes = vars.constantes.meses.indexOf(mes) - 1
            if (proxmes < 0) {
                proxmes = 11;
                this.decrementar_ano({event:params.event,elemento:params.elemento,processar_calendario:false});
            }
            mes = vars.constantes.meses[proxmes];
            this.fncomboboxs.selecionar_valor(combobox_mes,mes);
            fnhtml.elemento_alterado_dinamicamente({elemento:combobox_mes});
            this.atualizar_dias({elemento:div_calendario});
            this.atualizar_data_input({elemento:div_calendario});
            fnjs.logf(this.constructor.name,"decrementar_mes");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    incrementar_dia(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_dia");
            let div_calendario = {},
                listbox_dia = {},
                div_dia_selecionado = {},
                div_prox_dia = {};
                dia = '';
                proxdia = '',
                proxdiaobj = {};
                proxdiaencontrado = false;
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            divs_dia = div_calendario.find(this.seletores.div_calendario_dias_corpo).find(this.seletores.div_dia);
            div_dia_selecionado = divs_dia.filter(this.seletores.dia_selecionado);
            dia = div_dia_selecionado.text();
            dia = dia.toString();
            proxdia = dia - 0 + 1;
            proxdiaencontrado = false;
            for (let i = 0; i < divs_dia.length; i ++) {
                if (divs_dia.eq(i).text().trim() - 0 === proxdia) {					
                    proxdiaencontrado = true;
                    proxdiaobj = divs_dia.eq(i);
                    break;
                }
            }
            if (proxdiaencontrado === true) {
                div_dia_selecionado.removeClass(this.classes.dia_selecionado);
                proxdiaobj.addClass(this.classes.dia_selecionado);
            } else {
                proxdia = 1;
                this.incrementar_mes({event:params.event,elemento:div_calendario});
                divs_dia = div_calendario.find(this.seletores.div_calendario_dias_corpo).find(this.seletores.div_dia);
                div_dia_selecionado = divs_dia.filter(this.seletores.dia_selecionado);
                proxdiaencontrado = false;
                for (let i = 0; i < divs_dia.length; i ++) {
                    if (divs_dia.eq(i).text().trim() - 0 === proxdia) {					
                        proxdiaencontrado = true;
                        proxdiaobj = divs_dia.eq(i);
                        break;
                    }
                }
                if (proxdiaencontrado === true) {
                    div_dia_selecionado.removeClass(this.classes.dia_selecionado);
                    proxdiaobj.addClass(this.classes.dia_selecionado);
                } else {
                    alert(this.mensagens.erro_incrementar_anterior_inexistente);
                    
                }
            }
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"incrementar_dia");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    decrementar_dia(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_dia");
            let div_calendario = {},
                listbox_dia = {},
                div_dia_selecionado = {},
                div_prox_dia = {};
                dia = '';
                proxdia = '',
                proxdiaobj = {};
                proxdiaencontrado = false;
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            divs_dia = div_calendario.find(this.seletores.div_calendario_dias_corpo).find(this.seletores.div_dia);
            div_dia_selecionado = divs_dia.filter(this.seletores.dia_selecionado);
            dia = div_dia_selecionado.text();
            dia = dia.toString();
            proxdia = fnmat.como_numero(dia) - 1;
            proxdiaencontrado = false;
            if (proxdia !== 0) {
                for (let i = 0; i < divs_dia.length; i ++) {
                    if (fnmat.como_numero(divs_dia.eq(i).text().trim()) === proxdia) {					
                        proxdiaencontrado = true;
                        proxdiaobj = divs_dia.eq(i);
                        break;
                    }
                }
            }
            if (proxdiaencontrado === true) {
                div_dia_selecionado.removeClass(this.classes.dia_selecionado);
                proxdiaobj.addClass(this.classes.dia_selecionado);
            } else {
                this.decrementar_mes({event:params.event,elemento:div_calendario});
                divs_dia = div_calendario.find(this.seletores.div_calendario_dias_corpo).find(this.seletores.div_dia);
                div_dia_selecionado = divs_dia.filter(this.seletores.dia_selecionado);
                proxdiaencontrado = false;
                for (let i = divs_dia.length; i > 0; i --) {
                    if (fnmat.como_numero(divs_dia.eq(i).text().trim()) > 0) {
                        proxdiaencontrado = true;
                        proxdiaobj = divs_dia.eq(i);
                        break;
                    }
                }
                if (proxdiaencontrado === true) {
                    div_dia_selecionado.removeClass(this.classes.dia_selecionado);
                    proxdiaobj.addClass(this.classes.dia_selecionado);
                } else {
                    alert(this.mensagens.erro_incrementar_anterior_inexistente);
                }
            }
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"decrementar_dia");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    incrementar_hora(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_hora");
            let div_calendario = {},
                listbox_hora = {},
                hora = '';
                proxhora = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_hora = div_calendario.find(this.seletores.div_horas).find(this.seletores.div_listbox);			
            hora = fnlistboxs.obter_valores_selecionados_listbox(listbox_hora);
            hora = hora.toString();
            proxhora = fnmat.como_numero(hora) + 1;			
            if (proxhora > 23) {
                proxhora = 0;
                this.incrementar_dia(params);
            }
            proxhora = proxhora.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_hora,proxhora);
            fnlistboxs.rolar_ate_selecionado(listbox_hora);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_hora});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"incrementar_hora");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    decrementar_hora(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_hora");
            let div_calendario = {},
                listbox_hora = {},
                hora = '';
                proxhora = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_hora = div_calendario.find(this.seletores.div_horas).find(this.seletores.div_listbox);			
            hora = fnlistboxs.obter_valores_selecionados_listbox(listbox_hora);
            hora = hora.toString();
            proxhora = fnmat.como_numero(hora) - 1;		
            if (proxhora < 0) {
                proxhora = 23;
                this.decrementar_dia(params);
            }
            proxhora = proxhora.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_hora,proxhora);
            fnlistboxs.rolar_ate_selecionado(listbox_hora);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_hora});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"decrementar_hora");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    incrementar_minuto(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_minuto");
            let div_calendario = {},
                listbox_minuto = {},
                minuto = '';
                proxminuto = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_minuto = div_calendario.find(this.seletores.div_minutos).find(this.seletores.div_listbox);			
            minuto = fnlistboxs.obter_valores_selecionados_listbox(listbox_minuto);
            minuto = minuto.toString();
            proxminuto = fnmat.como_numero(minuto) + 1;			
            if (proxminuto > 59) {
                proxminuto = 0;
                this.incrementar_hora(params);
            }
            proxminuto = proxminuto.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_minuto,proxminuto);
            fnlistboxs.rolar_ate_selecionado(listbox_minuto);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_minuto});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"incrementar_minuto");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    decrementar_minuto(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_minuto");
            let div_calendario = {},
                listbox_minuto = {},
                minuto = '';
                proxminuto = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_minuto = div_calendario.find(this.seletores.div_minutos).find(this.seletores.div_listbox);			
            minuto = fnlistboxs.obter_valores_selecionados_listbox(listbox_minuto);
            minuto = minuto.toString();
            proxminuto = fnmat.como_numero(minuto) -1;			
            if (proxminuto < 0) {
                proxminuto = 59;
                this.decrementar_hora(params);
            }
            proxminuto = proxminuto.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_minuto,proxminuto);
            fnlistboxs.rolar_ate_selecionado(listbox_minuto);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_minuto});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"decrementar_minuto");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    incrementar_segundo(params) {
        try {
            fnjs.logi(this.constructor.name,"incrementar_segundo");
            let div_calendario = {},
                listbox_segundo = {},
                segundo = '';
                proxsegundo = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_segundo = div_calendario.find(this.seletores.div_segundos).find(this.seletores.div_listbox);			
            segundo = fnlistboxs.obter_valores_selecionados_listbox(listbox_segundo);
            segundo = segundo.toString();
            proxsegundo = fnmat.como_numero(segundo) + 1;			
            if (proxsegundo > 59) {
                proxsegundo = 0;
                this.incrementar_minuto(params);
            }
            proxsegundo = proxsegundo.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_segundo,proxsegundo);
            fnlistboxs.rolar_ate_selecionado(listbox_segundo);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_segundo});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"incrementar_segundo");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    decrementar_segundo(params) {
        try {
            fnjs.logi(this.constructor.name,"decrementar_segundo");
            let div_calendario = {},
                listbox_segundo = {},
                segundo = '';
                proxsegundo = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params);
            div_calendario = params.elemento.closest(this.seletores.div_calendario);
            listbox_segundo = div_calendario.find(this.seletores.div_segundos).find(this.seletores.div_listbox);			
            segundo = fnlistboxs.obter_valores_selecionados_listbox(listbox_segundo);
            segundo = segundo.toString();
            proxsegundo = fnmat.como_numero(segundo) - 1;			
            if (proxsegundo < 0) {
                proxsegundo = 59;
                this.decrementar_minuto(params);
            }
            proxsegundo = proxsegundo.toString().padStart(2,'0');
            fnlistboxs.selecionar_valor(listbox_segundo,proxsegundo);
            fnlistboxs.rolar_ate_selecionado(listbox_segundo);
            fnhtml.elemento_alterado_dinamicamente({elemento:listbox_segundo});
            this.atualizar_data_input({elemento:div_calendario});			
            fnjs.logf(this.constructor.name,"decrementar_segundo");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    /**
        * Funcao que monta o corpo do calendario conforme opcoes (dias, hora, etc). 
        * @author Antonio Alencar Velozo
        * @created 01/02/2019
        * @param data String - A data atual do calendario
        * @param opcoes Object [optional][default={}] - opcoes 
        * @status desenvolvimento
    */	
    montar_corpo_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"montar_corpo_calendario");
            let div_corpo = '<div class="' + this.classes.div_calendario_corpo + '">',
                div_dias = {},
                div_horarios = {};
            div_dias = this.montar_dias(params);
            params.opcoes.data = params.datadata;
            div_horarios = this.montar_horarios(params);			
            div_corpo += div_dias + div_horarios + '</div>';
            fnjs.logf(this.constructor.name,"montar_corpo_calendario");
            return div_corpo;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }						
    }
    montar_cabecalho_calendario(params) {
        try {
            
            fnjs.logi(this.constructor.name,"montar_cabecalho_calendario");
            let div_cabecalho = '<div class="' + this.classes.div_calendario_cabecalho + '">';
            let div_ano = '<div class="' + this.classes.div_calendario_ano + '">';
            let div_input_ano = '<div class="' + this.classes.div_ano_input + '"><input class="' + this.classes.input_div_ano + ' ' + vars.classes.controle_input_texto + '" value="' + params.data.getFullYear() + '" onblur="window.fnhtml.fncal.atualizou_ano({elemento:this})" onkeyup="window.fnjs.verificar_tecla(this,event,{Enter:\'window.fnhtml.fncal.atualizou_ano({elemento:this})\'})"></div>' ;
            let div_ano_controles = '<div class="' + this.classes.div_ano_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_ano({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_ano({event:event,elemento:this})"></div>' ;			
            let div_mes = '<div class="' + this.classes.div_calendario_mes + '">';
            let div_combobox_mes = '<div class="' + this.classes.div_calendario_combobox_mes + '">';
            let div_mes_controles = '<div class="' + this.classes.div_mes_controles + '"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_acima + '" onclick="window.fnhtml.fncal.incrementar_mes({event:event,elemento:this})"><img class="' + vars.classes.clicavel + ' ' + vars.classes.img_controle + '" src="' + vars.nomes_caminhos_arquivos.img_seta_dropdown_abaixo + '" onclick="window.fnhtml.fncal.decrementar_mes({event:event,elemento:this})"></div>' ;
            div_ano += div_input_ano + div_ano_controles + '</div>';
            div_combobox_mes += this.montar_combobox_mes_calendario(params) + '</div>';
            div_mes += div_combobox_mes + div_mes_controles + '</div>';
            div_cabecalho += div_ano + div_mes + '</div>';
            fnjs.logf(this.constructor.name,"montar_cabecalho_calendario");
            return div_cabecalho;
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }						
    }	
    mostrar_calendario(params) { 
        try {
            fnjs.logi(this.constructor.name,"mostrar_calendario");
            if (vars.dispositivo === 'pc') {			
                params.elemento = fnjs.obterJquery(params.elemento);
                params.opcoes = params.opcoes || {};
                if (params.elemento.prop('tagName').toString().trim().toLowerCase() !== 'input') {
                    params.params.elemento = params.elemento.children(this.seletores.input_calendario);
                }
                if (params.elemento.length) {
                    let status = params.elemento.attr('status_calendario');					
                    let data = {};
                    if (params.elemento.val().trim().length === 0) {
                        data = new Date();
                    } else {
                        data = fndt.data_como_cnj_date(params.elemento.val());
                        data = new Date(data[0],data[1],data[2],data[3],data[4],data[5]);						
                    }
                    if (status === 'invisivel') {
                        let div_calendario = '';
                        let div_cabecalho = this.montar_cabecalho_calendario({data:data,opcoes:params.opcoes});
                        let div_corpo = this.montar_corpo_calendario({data:data,opcoes:params.opcoes});
                        let div_rodape = '<div class="' + this.classes.div_calendario_rodape + '"><button class="' + this.classes.div_calendario_btn_ok + '" onclick="window.fnhtml.fncal.fechar_calendario({elemento:this})">ok</button></div>' ;
                        let style = '';
                        let paddinglefttotal = 0,
                            marginlefttotal = 0;
                        let objtemp = {};
                        posicao = fnjs.getPosition(params.elemento);
                        
                        style= ' style="left:' + posicao.x + 'px;' +  '" ';						
                        div_calendario = '<div class="' + vars.classes.div_calendario + '" opcoes=\'' + JSON.stringify(params.opcoes) + '\' ' + style;
                        if (typeof params.opcoes.aoselecionardia !== 'undefined') {
                            div_calendario +=  ' ' + this.propriedades_html.aoselecionardia + '="' + params.opcoes.aoselecionardia+'" ';
                        } else if (typeof params.elemento.attr(this.propriedades_html.aoselecionardia) !== 'undefined') {
                            div_calendario +=  ' ' + this.propriedades_html.aoselecionardia + '="' + params.elemento.attr(this.propriedades_html.aoselecionardia)+'" ';
                        }
                        div_calendario += '>';
                        div_calendario += div_cabecalho + div_corpo + div_rodape +  '</div>';
                        params.elemento.after(div_calendario);
                        div_calendario = params.elemento.next(this.seletores.div_calendario);

                        /*correcao da posicao left quando tiver container relative */
                        let posicao_real = fnjs.getPosition(div_calendario);
                        if ((posicao_real.x * 1.05) > posicao.x ) {
                            div_calendario.css({left:(posicao.x - (posicao_real.x - posicao.x))});
                        }
                        params.elemento.attr('status_calendario','visivel');
                        if (div_calendario.find(this.seletores.div_horas).length) {
                            fnlistboxs.rolar_ate_selecionado(div_calendario.find(this.seletores.div_horas).find(this.seletores.div_listbox));
                        } 
                        if (div_calendario.find(this.seletores.div_minutos).length) {
                            fnlistboxs.rolar_ate_selecionado(div_calendario.find(this.seletores.div_minutos).find(this.seletores.div_listbox));
                        } 
                        if (div_calendario.find(this.seletores.div_segundos).length) {
                            fnlistboxs.rolar_ate_selecionado(div_calendario.find(this.seletores.div_segundos).find(this.seletores.div_listbox));
                        } 
                    } 
                }
            } 
            fnjs.logf(this.constructor.name,"mostrar_calendario");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }
    transf_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"transf_calendario");
            let qt = 0;
            params.elemento = fnjs.obterJquery(params.elemento);
            params.opcoes = params.opcoes || {};
            params.opcoes.mostrar = params.opcoes.mostrar || false;
            params.opcoes.setar_data = params.opcoes.setar_data || false;
            params.opcoes.data = params.opcoes.data || null;
            if (params.elemento.length) {
                qt = params.elemento.length;
                for(let i = 0 ; i < qt ; i++ ) {
                    if (vars.dispositivo === 'celular') {
                        let datatemp = params.elemento.eq(i).val();
                        datatemp = fndt.dataUSA(datatemp);
                        params.elemento.eq(i).attr('type','date');
                        params.elemento.eq(i).val(datatemp);
                    } else {
                        params.elemento.eq(i).attr('status_calendario','invisivel');
                        if (typeof params.opcoes.data !== 'undefined' && params.opcoes.data !== null) {
                            params.elemento.eq(i).val(params.opcoes.data);
                        }
                        params.elemento.eq(i).attr('onclick', 'window.fnhtml.fncal.mostrar_calendario({elemento:this,opcoes:' + JSON.stringify(params.opcoes)+ '})');
                        params.elemento.eq(i).addClass(this.classes.input_calendario);
                        params.elemento.eq(i).attr('opcoes',JSON.stringify(params.opcoes));
                        if (typeof params.opcoes.aoselecionardia !== 'undefined') {
                            params.elemento.eq(i).attr(this.propriedades_html.aoselecionardia,params.opcoes.aoselecionardia);
                        }
                        let val = params.elemento.eq(i).val();
                        if ( val.trim().length > 0) {
                    } else {
                            val = fndt.hoje();					
                        }
                        if (params.opcoes.setar_data === true) {
                            params.elemento.eq(i).val(val);
                        }
                        if (params.opcoes.mostrar === true) {
                            fncal.mostrar_calendario({elemento:params.elemento.eq(i),opcoes:params.opcoes});
                        }
                    }
                }
            } 	
            fnjs.logf(this.constructor.name,"transf_calendario");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    transformar_calendario_se_data(params) {
        try{
            fnjs.logi(this.constructor.name,"transformar_calendario_se_data");
            params.elemento = fnjs.obterJquery(params.elemento || params.obj || params.elem || params);
            if (params.elemento.hasClass("input_data") && params.elemento.attr("type") !== "date") {
                params.elemento.attr("type","date");
            }
            fnjs.logf(this.constructor.name,"transformar_calendario_se_data");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }						
    }

    setar_mes(params) {
        try {
            fnjs.logi(this.constructor.name,"setar_mes");
            let mes = 1;
            let dia = '01';
            let data = '';
            let inputano = {};
            let inputdt1 = {};
            let inputdt2 = {};
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {				
                mes = params.elemento.index() + 1;
                inputano = params.elemento.nextAll(this.seletores.inputano).eq(0);
                inputdt1 = params.elemento.closest("div.row").prev("div.row").find(this.seletores.componente_data).eq(0);
                
                inputdt2 = params.elemento.closest("div.row").prev("div.row").find(this.seletores.componente_data).eq(1);
                mes = mes.toString().padStart(2,'0');
                data = dia + vars.sepdata + mes + vars.sepdata + inputano.val();                
                inputdt1.val(fndt.dataUSA(data));
                data = fndt.dataBR(fndt.setar_ultimo_dia_mes(data));
                inputdt2.val(fndt.dataUSA(data));
                fnhtml.elemento_alterado_dinamicamente({elemento:inputdt1});
                fnhtml.elemento_alterado_dinamicamente({elemento:inputdt2});
            }
            fnjs.logf(this.constructor.name,"setar_mes");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }		
    clicou_mes_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"clicou_mes_calendario");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                this.setar_mes(params);
            }
            fnjs.logf(this.constructor.name,"clicou_mes_calendario");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	
    setar_dia(params) {
        try {
            fnjs.logi(this.constructor.name,"setar_dia");
            let mes = 1;
            let dia = this.strings._01;
            let data = '';
            let inputano = {};
            let inputdt1 = {};
            let inputdt2 = {};
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {				
                mes = params.elemento.index() + 1;
                inputano = params.elemento.nextAll(this.seletores.inputano);
                inputdt1 = params.elemento.closest(vars.seletores.div_opcao_controles).children(this.seletores.componente_data).eq(0);
                inputdt2 = params.elemento.closest(vars.seletores.div_opcao_controles).children(this.seletores.componente_data).eq(1);
                mes = mes.toString().padStart(2,'0');
                data = dia + vars.sepdata + mes + vars.sepdata + inputano.val();
                inputdt1.val(data);
                data = fndt.dataBR(fndt.setar_ultimo_dia_mes(data));
                inputdt2.val(data);
                fnhtml.elemento_alterado_dinamicamente({elemento:inputdt1});
                fnhtml.elemento_alterado_dinamicamente({elemento:inputdt2});
            } 	
            fnjs.logf(this.constructor.name,"setar_dia");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	
    clicou_dia_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"clicou_dia_calendario");
            params.elemento = fnjs.obterJquery(params.elemento);
            if (params.elemento.length) {
                this.setar_dia(params);
            } 
            fnjs.logf(this.constructor.name,"clicou_dia_calendario");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }
    fechar_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"fechar_calendario");
            params.elemento = fnjs.obterJquery(params.elemento);
            params.elemento.closest(this.seletores.div_calendario).prev().attr('status_calendario','invisivel');
            params.elemento.closest(this.seletores.div_calendario).find(this.seletores.div_dia + '.' + this.classes.dia_selecionado).click();
            fnjs.logf(this.constructor.name,"fechar_calendario");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }
        
    aplicar_mascara_calendario(params) {
        try {
            fnjs.logi(this.constructor.name,"aplicar_mascara_calendario");
            if (vars.dispositivo !== 'celular' || vars.navegador === 'firefox') {
                let val = params.elemento.value.split('');
                let pos = params.elemento.selectionStart;
                let compmax = 19;				
                if (vars.constantes.numstr.indexOf(params.event.key) > -1 || (pos === 10 && params.event.key === ' ')) {
                    if (pos === 2 || pos === 5 || pos === 10 || pos === 13 || pos === 16) {
                        pos++;
                    }				
                    let comp = val.length;
                    for (let i = 0 ; i < compmax; i++) {
                        if (pos === i) {
                            val[i] = params.event.key; 
                        }
                    }
                    params.elemento.value = val.join('');
                    params.event.stopImmediatePropagation();
                    params.event.preventDefault();				
                    fnjs.setCaretPosition(params.elemento,pos+1);
                    return;
                } else if (vars.constantes.teclas_especiais.indexOf(params.event.key) > -1) {
                    if (params.event.key==='Backspace') {
                        if (pos > 0) {
                            pos--;
                            if (val[pos] !== vars.sepdata && val[pos] !== ':' && val[pos] !== ' ') {
                                val[pos] = '_';
                            }
                            pos--;
                            params.elemento.value = val.join('');
                            params.event.stopImmediatePropagation();
                            params.event.preventDefault();
                            fnjs.setCaretPosition(params.elemento,pos+1);
                            return;						
                        }
                    } else if (params.event.key==='Delete') {
                        for (let i = pos; i<compmax; i++) {
                            if (vars.constantes.numstr.indexOf(val[i]) > -1) {
                                val[i] = '_';	
                                break;
                            }
                        }
                        params.elemento.value = val.join('');
                        params.event.stopImmediatePropagation();
                        params.event.preventDefault();
                        pos--;
                        fnjs.setCaretPosition(params.elemento,pos+1);
                        return;											
                    }
                } else {
                    params.event.stopImmediatePropagation();
                    params.event.preventDefault();			
                    if (vars.dispositivo === 'celular') {
                        alert('implementar');
                    }
                    return;				
                }
            }
            fnjs.logf(this.constructor.name,"aplicar_mascara_calendario");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    }	
};





class FuncoesTabDados{
    constructor() {
        try {
            fnjs.logi(this.constructor.name);        
            this.opcoes_tabelas = [];
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        } 
    }


    obter_dados_tabela(tabelaest){
        try{
            fnjs.logi(this.constructor.name,"obter_dados_tabela");
            tabelaest = fnjs.obterJquery(tabelaest); 
            let id_dados = tabelaest.attr('id_dados'),
                corpo = {},
                linhas = {},
                qt = 0;
            if (typeof tabelaest !== 'undefined' && tabelaest !== 'undefined' && tabelaest !== null && tabelaest.length) {
                if (typeof id_dados === 'undefined') {
                    id_dados = fnjs.id_random();
                    tabelaest.attr('id_dados',id_dados);
                }
                if (typeof vars.dados[id_dados] === 'undefined') {
                    vars.dados[id_dados] = [];
                    corpo = tabelaest.children("tbody")[0];
                    linhas = corpo.children;
                    qt = linhas.length;
                    for (let i = 0 ; i < qt ; i++) {
                        linhas[i].setAttribute('id_dados',i);
                        vars.dados[id_dados].push(linhas[i].cloneNode(true));
                    };
                } 
            }
            fnjs.logf(this.constructor.name,"obter_dados_tabela");
            return vars.dados[id_dados];			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    obter_data_opcoes(params) {
        try {
            fnjs.logi(this.constructor.name,"obter_data_opcoes");
            let id_opcoes = null,
                retorno = null;
            params.tabelaest = params.tabelaest || params.elemento || params.obj;
            id_opcoes = params.tabelaest.attr('data-id_opcoes');
            if (typeof this.opcoes_tabelas[id_opcoes] === 'undefined') {
                if (typeof params.tabelaest.attr('data-opcoes') !== 'undefined') {
                    try {
                        retorno = this.opcoes_tabelas[id_opcoes] = JSON.parse(params.tabelaest.attr('data-opcoes').replace(/__ASPD__/g,'"'));
                    } catch(e1) {
                        console.log(e1);
                        //nada faz, protege qd tabela nao tiver essa propriedade ou estiver com erro na formacao
                    }				
                }
            } else {
                retorno = this.opcoes_tabelas[id_opcoes];
            }
            fnjs.logf(this.constructor.name,"obter_data_opcoes");
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }		
    }

    obter_nomecampodb(celula) {
        try {
            fnjs.logi(this.constructor.name,"obter_nomecampodb");
            let retorno = null;
            if (typeof celula.attr("cnj_nomes_campos_db") !== 'undefined' && celula.attr("cnj_nomes_campos_db").length > 0) {
                retorno = celula.attr("cnj_nomes_campos_db").trim().toLowerCase();
            } else if (typeof celula.attr("data-campodb") !== 'undefined' && celula.attr("data-campodb").length > 0) {
                retorno = celula.attr("data-campodb").trim().toLowerCase();
            } else {
                retorno = celula.text().trim().toLowerCase();
            }
            fnjs.logf(this.constructor.name,"obter_nomecampodb");
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }	
    }

    ordenar_tabdados_thread(event,obj) {        
        try {            
            fnjs.logi(this.constructor.name,"ordenar_tabdados_thread");
            let cel_ord = fnjs.obterJquery(obj).closest('th');
            if (!fnjs.obterJquery(event.target).hasClass("img_ocultar_coluna")) {                
                let img_ord = {},
                    seq_ord = 0,
                    tabdados = {},			
                    titulotabdados = {},
                    corpotabdados = {},
                    idrandom = fnjs.id_random(),
                    temsubregistro = 0,
                    temselecao = 0,
                    cel_sub_tit = null;
                img_ord = cel_ord.find("img.imgord");
                let lin_ord = cel_ord.closest('tr');
                seq_ord = lin_ord.attr("sequencia_ordenacao")||0;
                tabdados = cel_ord.closest("table.tabdados");			
                titulotabdados = tabdados.children("thead");
                corpotabdados = tabdados.children("tbody");
                corpotabdados.addClass(idrandom);			
                corpotabdados = corpotabdados[0];//js nativo
                temsubregistro = Number(fnjs.como_booleano(tabdados.attr("subregistros")||tabdados.attr("subregistro")||false)||0)||0;
                temselecao = Number(fnjs.como_booleano(tabdados.attr("selecao_ativada")||false)||0)||0;
                cel_sub_tit = titulotabdados.find("th.cel_sub_tit");
                let linhas = [].slice.call(fnjs.obterJquery(corpotabdados).children('tr:not(.linha_padrao):not(.linha_sub)')),
                    linhas_sub = fnjs.obterJquery(corpotabdados).children('tr.linha_sub'),
                    linhapadrao = fnjs.obterJquery(corpotabdados).children('tr.linha_padrao'),
                    linhas_atuais = {},
                    ind_child = cel_ord.index(),
                    div_ordenando = {},
                    va = '',
                    vb = '',
                    comp = null,
                    ordem = cel_ord.attr('ordenacao')||'nao_ordenado',
                    cels_ord = {},
                    qt = 0,
                    cont1 = 0,
                    tipo_ordenacao = '',
                    linhas_ordenadas = [],
                    ordenacao_numerica = false,
                    ordenacao_data = false,
                    rowspan_cels_ini = 0;

                if (ordem === 'nao_ordenado' || ordem === '') {
                    seq_ord++;
                    cel_ord.attr('ordenacao','crescente');
                    img_ord.attr('src',vars.nomes_caminhos_arquivos.green_asc);
                    img_ord.addClass('imgordenado');
                    cel_ord.attr('sequencia_ordenacao',seq_ord);
                    lin_ord.attr('sequencia_ordenacao',seq_ord);
                } else {
                    if (ordem === 'crescente') {
                        seq_ord++;					
                        cel_ord.attr('ordenacao','decrescente');					
                        img_ord.attr('src',vars.nomes_caminhos_arquivos.green_desc);
                        img_ord.addClass('imgordenado');				
                        cel_ord.attr('sequencia_ordenacao',seq_ord);
                        lin_ord.attr('sequencia_ordenacao',seq_ord);					
                    } else {
                        cel_ord.attr('ordenacao','nao_ordenado');					
                        img_ord.attr('src',vars.nomes_caminhos_arquivos.green_unsorted);
                        img_ord.removeClass('imgordenado');
                        cel_ord.removeAttr('sequencia_ordenacao');
                        fnjs.obterJquery(corpotabdados).removeClass(idrandom);
                        return false;
                    }
                }
                if (event.ctrlKey) {
                    cels_ord = titulotabdados.find('th[ordenacao=crescente],th[ordenacao=decrescente]').add(cel_ord);
                    cels_ord.sort(function(a,b){
                        va = fnjs.obterJquery(a).attr('sequencia_ordenacao') * 1;
                        vb = fnjs.obterJquery(b).attr('sequencia_ordenacao') * 1;
                        if (va > vb) {
                            return 1;
                        } else if (va < vb) {
                            return -1;
                        } else {
                            return 0;
                        }
                    });
                } else {
                    cels_ord = titulotabdados.find('th[ordenacao=crescente],th[ordenacao=decrescente]').not(cel_ord);
                    cels_ord.attr('ordenacao','nao_ordenado');
                    cels_ord.removeAttr('sequencia_ordenacao');
                    cels_ord.find('img.imgord').attr('src',vars.nomes_caminhos_arquivos.green_unsorted)
                    cels_ord.find('img.imgord').removeClass('imgordenado');
                    cels_ord = fnjs.obterJquery(cel_ord);
                }
                qt = cels_ord.length;
                rowspan_cels_ini = (lin_ord.attr('rowspan_cels_ini') || 0 ) * 1;

                /*obtem dados dos cabecalhos a serem ordenados*/
                let inds_child = [];
                let ords_num = [];
                let tipos_ord = [];
                let ords_data = [];
                cont1 = 0;
                for (cont1 = 0 ; cont1 < qt; cont1++){
                    tipos_ord.push(cels_ord.eq(cont1).attr('ordenacao'));

                    /*se tiver subregistro e index real, verifica rowspam para ver se o indexreal já considera o sub ou nao*/
                    if (typeof cels_ord.eq(cont1).attr('indexreal') !== "undefined" && cels_ord.eq(cont1).attr('indexreal').trim().length > 0) {
                        if (temsubregistro) {
                            if ((cel_sub_tit.attr("rowspan") || 0) - 0 > (cels_ord.eq(cont1).attr("rowspan") || 0) - 0) {
                                inds_child.push(Number(cels_ord.eq(cont1).attr('indexreal')||cels_ord.eq(cont1).index()||0));        
                            } else {
                                inds_child.push(Number(cels_ord.eq(cont1).attr('indexreal')||cels_ord.eq(cont1).index()||0) /*+ temsubregistro*/ + temselecao);
                            }
                        } else {
                            inds_child.push(Number(cels_ord.eq(cont1).attr('indexreal')||cels_ord.eq(cont1).index()||0) + temselecao);
                        }
                    } else {
                        inds_child.push(Number(cels_ord.eq(cont1).index()||0) + temsubregistro + temselecao);
                    }

                    ords_num.push(cels_ord.eq(cont1).hasClass('cel_quantdec_med') || cels_ord.eq(cont1).hasClass('cel_quantdec') || cels_ord.eq(cont1).hasClass( 'cel_quant' ) || cels_ord.eq(cont1).hasClass( 'cel_peso' ) || cels_ord.eq(cont1).hasClass( 'cel_valor' ) || cels_ord.eq(cont1).hasClass('cel_perc') || cels_ord.eq(cont1).hasClass('cel_perc_med')|| cels_ord.eq(cont1).hasClass('cel_numint'));
                    ords_data.push(cels_ord.eq(cont1).hasClass('cel_data'));
                }


                linhas.sort(function(a,b){
                    cont1 = 0;
                    for (cont1 = 0 ; cont1 < qt; cont1++){
                        if (ords_num[cont1]) {
                            va = ((a.children[inds_child[cont1]]||{}).textContent||'0').trim().replace(/\./g,'').replace(',','.');
                            vb = ((b.children[inds_child[cont1]]||{}).textContent||'0').trim().replace(/\./g,'').replace(',','.');
                            va = va * 1;
                            vb = vb * 1;
                            if (tipos_ord[cont1] === 'decrescente') {
                                if (va>vb) {
                                    return -1;
                                } else if (va<vb) {
                                    return 1;
                                } else {
                                    continue;
                                }
                            } else {
                                if (va>vb) {
                                    return 1;
                                } else if (va<vb) {
                                    return -1;
                                } else {
                                    continue;
                                }							
                            }							
                        } else {
                            if (ords_data[cont1]) {
                                va = fndt.data_como_cnj_date(a.children[inds_child[cont1]].textContent.trim());
                                vb = fndt.data_como_cnj_date(b.children[inds_child[cont1]].textContent.trim());
                                va = new Date(va[0],va[1],va[2],va[3],va[4],va[5]);
                                vb = new Date(vb[0],vb[1],vb[2],vb[3],vb[4],vb[5]);
                                if (tipos_ord[cont1] === 'decrescente') {
                                    if (va>vb) {
                                        return -1;
                                    } else if (va<vb) {
                                        return 1;
                                    } else {
                                        continue;
                                    }
                                } else {
                                    if (va>vb) {
                                        return 1;
                                    } else if (va<vb) {
                                        return -1;
                                    } else {
                                        continue;
                                    }							
                                }								
                            } else {
                                va = a.children[inds_child[cont1]].textContent;
                                vb = b.children[inds_child[cont1]].textContent;
                                if (tipos_ord[cont1] === 'decrescente') {
                                    if (va<vb) {
                                        return 1;
                                    } else if (va>vb) {
                                        return -1;
                                    } else {
                                        continue;
                                    }
                                } else {
                                    if (va>vb) {
                                        return 1;
                                    } else if (va<vb) {
                                        return -1;
                                    } else {
                                        continue;
                                    }							
                                }
                            }
                        }
                    }
                    return 0;
                });
                qt = linhas.length;
                if (linhapadrao.length) {
                    linhas_ordenadas.push(linhapadrao[0].cloneNode(true));
                }
                for(let i = 0 ; i < qt; i++) {
                    linhas_ordenadas.push(linhas[i].cloneNode(true));
                    if (fnjs.obterJquery(linhas[i]).hasClass('aberta')) {
                        for(let j = 0; j < linhas_sub.length; j++) {
                            if ((linhas_sub[j].getAttribute('idlinhasub')||'a') === (linhas[i].getAttribute('idlinhasub')||'b'))  {
                                linhas_ordenadas.push(linhas_sub[j].cloneNode(true));
                                break;
                            }
                    }
                    }
                }
                corpotabdados.innerHTML = '';
                qt = linhas_ordenadas.length;
                for(let i = 0 ; i < qt; i++) {					
                    corpotabdados.appendChild(linhas_ordenadas[i]);
                }	
                fnjs.obterJquery(corpotabdados).removeClass(idrandom);
            } else {
                return;
            }
            fnjs.logf(this.constructor.name,"ordenar_tabdados_thread");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    ordenar_tabdados(event,obj) {
        try {
            fnjs.logi(this.constructor.name,"ordenar_tabdados");
            let cel_ord = fnjs.obterJquery(obj).closest('th');
            let id_carregando = 0;
            cel_ord.attr("id_carregando",id_carregando);
            setTimeout(this.ordenar_tabdados_thread,50,event,obj);
            fnjs.logf(this.constructor.name,"ordenar_tabdados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }	
    }


    obter_dados_tabdados(tabdados){
        try{
            fnjs.logi(this.constructor.name,"obter_dados_tabdados");
            let id_dados = null;
            if (typeof tabdados !== "undefined" && tabdados !== null) {
                if (typeof tabdados.hasClass !== "function") {
                    tabdados = fnjs.obterJquery(tabdados); 
                }                
                let corpo = {},
                linhas = {},
                qt = 0;
                if (typeof tabdados !== 'undefined' && tabdados !== 'undefined' && tabdados !== null && tabdados.length) {
                    id_dados = tabdados.attr('id_dados');
                    if (typeof id_dados === 'undefined') {
                        id_dados = fnjs.id_random();
                        tabdados.attr('id_dados',id_dados);
                    }
                    if (typeof vars.dados[id_dados] === 'undefined') {
                        vars.dados[id_dados] = [];
                        corpo = tabdados.children("tbody")[0];
                        linhas = corpo.children;
                        qt = linhas.length;
                        for (let i = 0 ; i < qt ; i++) {
                            linhas[i].setAttribute('id_dados',i);
                            vars.dados[id_dados].push(linhas[i].cloneNode(true));
                        };
                    } 
                }
            }
            fnjs.logf(this.constructor.name,"obter_dados_tabdados");
            return vars.dados[id_dados];
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    pegar_filtros_tabdados(obj){
        try{
            fnjs.logi(this.constructor.name,"pegar_filtros_tabdados");
            let tabdados = fnjs.obterJquery(obj).closest("table.tabdados"),            
            linhafiltros = null,
            cels_linhafiltros = null,
            cels_filtro = [];
            linhafiltros = tabdados.children("thead").children('tr.linhafiltros');
            cels_linhafiltros = linhafiltros.children('th');
            $.each(cels_linhafiltros,function(index,element){
                if (cels_linhafiltros.eq(index).find('input').length) {
                    if (cels_linhafiltros.eq(index).find('input').val().trim().length > 0) {
                        cels_filtro.push(cels_linhafiltros.eq(index));
                    }
                }
            });
            fnjs.logf(this.constructor.name,"pegar_filtros_tabdados");
            return cels_filtro;			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    calcular_tabdados(obj) {
        try{
            fnjs.logi(this.constructor.name,"calcular_tabdados");
                if (typeof obj !== "undefined" && obj !== null) {
                    let tabdados = null,
                        corpotabdados = {},
                        rodapetabdados = {},
                        linhacalculos = {},
                        celulas_com_calculo = {},
                        linhas = {},
                        selecao_ativada = 'nao',
                        colunas_iniciais = 0,
                        idrandom = fnjs.id_random(),
                        qt = 0,
                        qt2 = 0,
                        i = 0,
                        j = 0,
                        calculos = [],
                        ind_lin_ini = 0;
                    if (typeof obj.hasClass !== "function") {
                        obj = fnjs.obterJquery(obj);
                    }
                    tabdados = obj.closest("table.tabdados"),
                    corpotabdados = tabdados.children("tbody");
                    rodapetabdados = tabdados.children("tfoot");
                    linhacalculos = rodapetabdados.children('tr.linhacalculos');
                    celulas_com_calculo = linhacalculos.children('th.cel_contadora, th.cel_quant, th.cel_quantdec, th.cel_quantdec_med, th.cel_peso, th.cel_valor, th.cel_perc, th.cel_perc_med');
                    selecao_ativada = tabdados.attr('selecao_ativada') || 'nao';
                    corpotabdados.addClass(idrandom);
                    corpotabdados = corpotabdados[0]; //js nativo
                    linhas = fnjs.obterJquery(corpotabdados).children('tr:not(.linha_padrao):not(.linha_sub)');
                    if (selecao_ativada.trim().toLowerCase() === 'sim') {
                        colunas_iniciais++;
                    }
                    $.each(celulas_com_calculo,function(index,element){
                        calculos.push({
                            index:celulas_com_calculo.eq(index).index(),
                            valor:0,
                            tipo:(celulas_com_calculo.eq(index).hasClass('cel_contadora')?1:(celulas_com_calculo.eq(index).hasClass('cel_perc')||celulas_com_calculo.eq(index).hasClass('cel_perc_med')?3:2))
                        });
                    });
                    qt = linhas.length;
                    qt2 = calculos.length;
                    i = 0;                
                    for (i = ind_lin_ini; i < qt; i++) {
                        j = 0;				
                        for (j = 0 ; j < qt2; j++) {
                            if (calculos[j].tipo===1) {
                                calculos[j].valor++;
                            } else {
                                calculos[j].valor += ((linhas.eq(i)[0].children[calculos[j].index]||{}).textContent||'0').replace(/\./g,'').replace(',','.') - 0||0;
                            }
                        }
                    }
                    $.each(celulas_com_calculo,function(index,element){                        
                        if (celulas_com_calculo.eq(index).hasClass('cel_perc') || celulas_com_calculo.eq(index).hasClass('cel_perc_med') || celulas_com_calculo.eq(index).hasClass('cel_quantdec_med')) {                                                    
                            celulas_com_calculo.eq(index).text((calculos[index].valor / linhas.length).toLocaleString('pt-BR',{minimumFractionDigits:2,maximumFractionDigits:2}));
                        } else {
                            celulas_com_calculo.eq(index).text(calculos[index].valor.toLocaleString('pt-BR',{minimumFractionDigits:(celulas_com_calculo.eq(index).hasClass('cel_numint')||celulas_com_calculo.eq(index).hasClass('cel_contadora')?0:2),maximumFractionDigits:(celulas_com_calculo.eq(index).hasClass('cel_numint')||celulas_com_calculo.eq(index).hasClass('cel_contadora')?0:2)}));
                        }
                    });
                }
            fnjs.logf(this.constructor.name,"calcular_tabdados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    filtrar_tabdados_thread(event,obj) {
        try {
            fnjs.logi(window.fnhtml.fntabdados.constructor.name,"filtrar_tabdados_thread");
            let tabdados = null,
                corpotabdados = {},
                linhas = {},
                id_dados = null,
                celulas_com_filtro = [],
                linhas_filtradas = [],
                selecao_ativada = 'nao',
                colunas_iniciais = 0,
                filtrar_como_expressao = true,
                expressao_filtro = '',
                filtros = [],
                idrandom = fnjs.id_random(),
                qt = 0,
                qt2 = 0,
                qt3 = 0,
                i = 0,
                j = 0,
                dados = null,
                tem_filtro_geral = false,
                obj_filtro_geral = null,
                filtro_geral = '',
                linha_visivel = true,
                filtro = null;
            obj = fnjs.obterJquery(obj || event.target) ;
            tabdados = obj.closest("table.tabdados");
            corpotabdados = tabdados.children("tbody");
            selecao_ativada = tabdados.attr('selecao_ativada') || 'nao';	
            dados = window.fnhtml.fntabdados.obter_dados_tabdados(tabdados);
            id_dados = tabdados.attr('id_dados');
            corpotabdados.addClass(idrandom);
            corpotabdados = corpotabdados[0];//js nativo		
            if (typeof corpotabdados !== 'undefined' && corpotabdados !== 'undefined' && corpotabdados !== null && fnjs.obterJquery(corpotabdados).length) {
                linhas = corpotabdados.children;
                if (selecao_ativada.trim().toLowerCase() === 'sim') {
                    colunas_iniciais++;
                }
                tem_filtro_geral = fnjs.como_booleano(tabdados.attr('tem_filtro_geral')||false);

                if (tem_filtro_geral) {
                    obj_filtro_geral = fnjs.obterJquery('input[id=' +tabdados.attr('id_filtro_geral')+']').eq(0);
                    if (typeof obj_filtro_geral !== 'undefined' && obj_filtro_geral.length) {						
                        filtro_geral = obj_filtro_geral.val().trim();
                        if (filtro_geral.length <=0) {
                            tem_filtro_geral = false;
                        } else {
                            if (obj_filtro_geral.prop('class') === obj.prop('class')) {
                                filtrar_como_expressao = true;
                                if (filtro_geral.indexOf('>') === -1 && filtro_geral.indexOf('<') === -1 && filtro_geral.indexOf('=') === -1) {
                                    filtrar_como_expressao = false;
                                } else {
                                    filtro_geral = filtro_geral.replace(/(^[\>\=\<])/," $1").replace(/([^\s])([\>\=\<])/,"$1 $2").replace(/([\>\=\<])([^\s])/,"$1 $2").replace(/(^[\>\=\<])/g," $1").replace(/([^\s])([\>\=\<])/g,"$1 $2").replace(/([\>\=\<])([^\s])/g,"$1 $2").replace(/^\s([\<\>\=])/g,"campo $1").replace(/[^0-9]*[^\se\s][^\sou\s]\s([\<\>\=])/g,"campo $1").replace(/(\se\s)([\<\=\>])/g,"$1campo $2").replace(/\se\s/g,"&&").replace(/\sou\s/g,"||").replace(/\s\=\s/g," === ");					
                                }
                                filtro_geral={valor:filtro_geral,expressao:filtrar_como_expressao};
                            } else {
                                tem_filtro_geral = false;
                            }
                        }
                    }
                }
                celulas_com_filtro = window.fnhtml.fntabdados.pegar_filtros_tabdados(tabdados);	
                $.each(celulas_com_filtro,function(index,element){
                    filtro = celulas_com_filtro[index].find('input').val();
                    filtro = filtro.trim();
                    filtrar_como_expressao = true;
                    if (filtro.indexOf('>') === -1 && filtro.indexOf('<') === -1 && filtro.indexOf('=') === -1) {
                        filtrar_como_expressao = false;
                    } else {
                        filtro = filtro.replace(/(^[\>\=\<])/," $1").replace(/([^\s])([\>\=\<])/,"$1 $2").replace(/([\>\=\<])([^\s])/,"$1 $2").replace(/(^[\>\=\<])/g," $1").replace(/([^\s])([\>\=\<])/g,"$1 $2").replace(/([\>\=\<])([^\s])/g,"$1 $2").replace(/^\s([\<\>\=])/g,"campo $1").replace(/[^0-9]*[^\se\s][^\sou\s]\s([\<\>\=])/g,"campo $1").replace(/(\se\s)([\<\=\>])/g,"$1campo $2").replace(/\se\s/g,"&&").replace(/\sou\s/g,"||").replace(/\s\=\s/g," === ");					
                    }
                    filtros.push({valor:filtro,expressao:filtrar_como_expressao});
                });
                corpotabdados.innerHTML = '';
                qt = vars.dados[id_dados].length;
                i = 0;
                qt2 = filtros.length;
                if (tem_filtro_geral) {
                    qt3 = vars.dados[id_dados][0].children.length - colunas_iniciais;
                    for (i = 0 ; i < qt ; i++) {
                        linha_visivel = true;
                        j = 0;
                        if (vars.dados[id_dados][i].className.match(/\blinha_sub\b/) || vars.dados[id_dados][i].className.match(/\blinha_padrao\b/)) {
                            linha_visivel = false;
                            continue;
                        }
                    for ( j = 0 ; j < qt2 ; j++) {
                            filtro = '';
                            expressao_filtro = '';
                            if (filtros[j].expressao) {							
                                expressao_filtro = filtros[j].valor.replace(/campo/g,((vars.dados[id_dados][i].children[celulas_com_filtro[j].index()].textContent.trim().replace('.','').replace(',','.')||0)*1));
                                if (!(eval(expressao_filtro))) {							
                                    linha_visivel = false;
                                    break;
                                } 			
                            } else {
                                if ( !(vars.dados[id_dados][i].children[celulas_com_filtro[j].index()].textContent.toLowerCase().indexOf(filtros[j].valor.toLowerCase()) > -1)) {
                                    linha_visivel = false;
                                    break;
                                }
                            }
                        };
                        if (linha_visivel===true) {
                            j = 0;
                            linha_visivel = false;
                            for ( j = 0 ; j < qt3 ; j++) {
                                filtro = '';
                                expressao_filtro = '';
                                if (filtro_geral.expressao) {
                                    expressao_filtro = filtro_geral.valor.replace(/campo/g,((vars.dados[id_dados][i].children[j + colunas_iniciais].textContent.trim().replace('.','').replace(',','.')||0)*1));
                                    if ((eval(expressao_filtro))) {							
                                        linha_visivel = true;
                                        break;
                                    } 			
                                } else {
                                    if ( (vars.dados[id_dados][i].children[j + colunas_iniciais].textContent.toLowerCase().indexOf(filtro_geral.valor.toLowerCase()) > -1)) {
                                        linha_visivel = true;
                                        break;
                                    }
                                }
                            };						
                        }
                        if (linha_visivel) {
                            corpotabdados.appendChild(vars.dados[id_dados][i].cloneNode(true));
                            //reinclui a linha sub se esta estivesse visivel
                            if (vars.dados[id_dados][i].className.match(/\baberta\b/)) {
                                for (let key in vars.dados[id_dados]) {
                                    if (((vars.dados[id_dados][key].getAttribute('idlinhasub')||'a') === (vars.dados[id_dados][i].getAttribute('idlinhasub')||'b')) && (vars.dados[id_dados][key].className.match(/\blinha_sub\b/))) {
                                        corpotabdados.appendChild(vars.dados[id_dados][key].cloneNode(true));
                                        break;
                                    }
                                };
                            }							
                        }
                    };
                } else {
                    for (i = 0 ; i < qt ; i++) {
                        linha_visivel = true;
                        j = 0;
                        if (vars.dados[id_dados][i].className.match(/\blinha_padrao\b/)) {
                            corpotabdados.insertBefore(vars.dados[id_dados][i].cloneNode(true), corpotabdados.children[0]);
                            continue;
                        }
                        if (vars.dados[id_dados][i].className.match(/\blinha_sub\b/)) {
                            linha_visivel = false;
                            continue;
                        }						
                        for ( j = 0 ; j < qt2 ; j++) {
                            filtro = '';
                            expressao_filtro = '';
                            if (filtros[j].expressao) {							
                                expressao_filtro = filtros[j].valor.replace(/campo/g,((vars.dados[id_dados][i].children[celulas_com_filtro[j].index()].textContent.trim().replace('.','').replace(',','.')||0)*1));
                                if (!(eval(expressao_filtro))) {							
                                    linha_visivel = false;
                                    break;
                                }
                            } else {
                                if ( !(vars.dados[id_dados][i].children[celulas_com_filtro[j].index()].textContent.toLowerCase().indexOf(filtros[j].valor.toLowerCase()) > -1)) {
                                    linha_visivel = false;
                                    break;
                                }
                            }
                        };
                        if (linha_visivel === true) {
                            corpotabdados.appendChild(vars.dados[id_dados][i].cloneNode(true));
                            //reinclui a linha sub se esta estivesse visivel
                            if (vars.dados[id_dados][i].className.match(/\baberta\b/)) {
                                for (let key in vars.dados[id_dados]) {
                                    if (((vars.dados[id_dados][key].getAttribute('idlinhasub')||'a') === (vars.dados[id_dados][i].getAttribute('idlinhasub')||'b')) && (vars.dados[id_dados][key].className.match(/\blinha_sub\b/))) {
                                        corpotabdados.appendChild(vars.dados[id_dados][key].cloneNode(true));
                                        break;
                                    }
                                };
                            }							
                        }
                    };
                }
                fnjs.obterJquery(corpotabdados).removeClass(idrandom);
                window.fnhtml.fntabdados.calcular_tabdados(corpotabdados);
            }
            fnjs.logf(window.fnhtml.fntabdados.constructor.name,"filtrar_tabdados_thread");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    filtrar_tabdados(event,obj,somente_com_enter) {
        try {
            fnjs.logi(window.fnhtml.fntabdados.constructor.name,"filtrar_tabdados");

            if (typeof somente_com_enter === 'undefined') {
                somente_com_enter = true;
            } else {
                somente_com_enter = fnjs.como_booleano(somente_com_enter);
            }
            if (somente_com_enter === true) {
                if (event.key ===  'Enter' ) {                    
                    setTimeout(window.fnhtml.fntabdados.filtrar_tabdados_thread,50,event,obj);
                }
            } else {
                setTimeout(window.fnhtml.fntabdados.filtrar_tabdados_thread,50,event,obj);				
            }
            fnjs.logf(window.fnhtml.fntabdados.constructor.name,"filtrar_tabdados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }	
    }



    exportar_dados(obj){
        try{
            fnjs.logi(this.constructor.name,"exportar_dados");
            let tab        = fnjs.obterJquery(obj).closest("table.tabdados"),				
                tit= 'tabela.' + vars.nex.xls,
                tabhtml = {},
                abertura_excel = '',
                fechamento_excel = '',
                el_texts = {},
                qt = 0,
                texto_linhas = '',
                texto_tabela = '',
                tipo_aplicacao = '',
                blobdata = null,
                url_download = null,
                link_download = null;
            tabhtml = tab.clone();
            tabhtml.find('tr.linha_sub').remove();	
            tabhtml.find('tr.linhacomandos').remove();	
            tabhtml.find('tr.linha_padrao').remove();	
            tabhtml.find('tr.linha_filtrada').remove();	
            tabhtml.find('.naomostrar').remove();
            tabhtml.find('.invisivel').remove();
            tabhtml.find('.oculto').remove();
            tabhtml.find('.linhacomandos').remove();
            tabhtml.find('.linhafiltros').remove();			
            tabhtml.find( 'img' ).remove();
            tabhtml.find( 'button' ).remove();
            tabhtml.find( 'input' ).remove();
            tabhtml.find( 'label' ).remove();
            el_texts = tabhtml.find( 'text' );
            qt = el_texts.length;
            for(let i = 0; i< qt ; i++){
                el_texts.eq(i).replaceWith(el_texts.eq(i).text());					
            }
            texto_linhas = (tabhtml.children('thead').html()||'') + (tabhtml.children('tbody').html()||'') + (tabhtml.children('tfoot').html()||'');
            abertura_excel = vars.abertura_excel;
            fechamento_excel = vars.fechamento_excel;
            tipo_aplicacao = vars.tipo_aplicacao_excel;
            texto_tabela = abertura_excel + texto_linhas + fechamento_excel;			
            blobdata = new Blob([texto_tabela],{type:tipo_aplicacao});
            if (fnjs.detectar_navegador().indexOf('iexplorer') > -1) {
                navigator.msSaveBlob(blobdata, tit);
            } else {
                url_download = URL.createObjectURL(blobdata);
                link_download= document.createElement('a');
                link_download.download = tit;
                link_download.href = url_download;
                document.body.appendChild(link_download);
                link_download.click();
                document.body.removeChild(link_download);
                URL.revokeObjectURL(url_download);				
            }
            fnjs.logf(this.constructor.name,"exportar_dados");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    obter_link_tabdados_como_arq_html(btn_gerar,tabdados) {
        try{
            fnjs.logi(this.constructor.name,"obter_link_tabdados_como_arq_html");
            let tabdadoshtml = '',
                comhttp = {},
                compartilharcom = '',
                tabelanova = {};
            btn_gerar = fnjs.obterJquery(btn_gerar);           
            let input_dest = btn_gerar.next("input");
            let id_rand_dest = fnjs.id_random();
            input_dest.addClass(id_rand_dest);
            tabdados = fnjs.obterJquery(tabdados);
            tabelanova = tabdados.clone();
            tabelanova.children('thead').find('button').eq(2).remove();
            tabelanova.children('thead').find('button').eq(1).remove();
            tabdadoshtml = fnjs.obterJquery('<div>').append(tabelanova).html();
            comhttp = JSON.parse(vars.str_tcomhttp);
            comhttp.requisicao.requisitar.oque='compartilhar';
            comhttp.requisicao.requisitar.qual.condicionantes=[];
            comhttp.requisicao.requisitar.qual.comando = 'compartilhar';
            comhttp.requisicao.requisitar.qual.tipo_objeto = 'tabela';
            comhttp.requisicao.requisitar.qual.objeto = (typeof visoes==='undefined'?'':visoes);
            comhttp.requisicao.requisitar.qual.condicionantes.push( 'tipo_arquivo=html' );
            comhttp.requisicao.requisitar.qual.condicionantes.push( 'tipo_dados=tabelaest');
            comhttp.requisicao.requisitar.qual.condicionantes.push( 'compartilharcom=obter_link' );
            comhttp.requisicao.requisitar.qual.condicionantes.push( 'valor=' + tabdadoshtml);
            comhttp.opcoes_retorno.seletor_local_retorno='.' + id_rand_dest;
            comhttp.opcoes_requisicao.mostrar_carregando = false;
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.processar_retorno_como_incluir_link'
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});
            fnjs.logf(this.constructor.name,"obter_link_tabdados_como_arq_html");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    compartilhar_dados(e,obj){
        try{
            fnjs.logi(this.constructor.name,"compartilhar_dados");
            obj = fnjs.obterJquery(obj);
            let tabdados = obj.closest("table.tabdados");
            let id_rand = fnjs.id_random();
            tabdados.addClass(id_rand);
            let params_modal = {
                    header:{
                        content:"Gerar Link Compartilhavel",
                        hasBtnClose:true
                    },
                    body:{
                        sub:[
                            {
                                tag:"div",
                                class:"input-group mb-3",
                                sub:[
                                    {
                                        tag:"button",
                                        class:"btn btn-outline-primary",
                                        type:"button",
                                        content:"Gera Link",
                                        onclick:"window.fnhtml.fntabdados.obter_link_tabdados_como_arq_html(this,'."+id_rand+"')"
                                    },
                                    {
                                        tag:"input",
                                        class:"form-control",
                                        type:"text",
                                        placeholder:"(link)",
                                        props:[
                                            {
                                                prop:"disabled",
                                                value:true
                                            }
                                        ]
                                    },
                                    {
                                        tag:"button",
                                        class:"btn btn-outline-secondary",
                                        type:"button",
                                        content:"Copiar",
                                        onclick:"window.fnjs.copiar_texto_input_area_transferencia(this.previousSibling)"
                                    }
                                ]
                            }
                        ]
                    },
                    foot:{
                        hasBtnClose:true
                    }
            }
            fnjs.obterJquery(document.body).append(fnhtml.criar_modal(params_modal));
            let div_modal = fnjs.obterJquery(document.body).children("div.div_modal:last");
            let obj_modal = new bootstrap.Modal(div_modal);
            obj_modal.show();
            fnjs.logf(this.constructor.name,"compartilhar_dados");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }	


    clicou_titulo(e){
        try{
            fnjs.logi(this.constructor.name,"clicou_titulo");
            if (fnjs.obterJquery(e.target).closest('th.col_sel').length ||
                (fnjs.obterJquery(e.target).closest('tr').children('th.col_sel').length && 
                fnjs.obterJquery(e.target).closest('th').text().trim().toLowerCase() === 'Selecionar_todos')) {
                this.clicou_marcar_todos(e) ;
            }
            fnjs.logf(this.constructor.name,"clicou_titulo");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }	

    marcar_linha(e,obj){
        try{
            fnjs.logi(this.constructor.name,"marcar_linha");
            let linha = {},
                marcar = false,
                marcarmultiplo = false,
                classemarcacao = '',
                tabelaest = {};
            linha = fnjs.obterJquery(obj).closest('tr');
            if (linha.length&&!linha.hasClass('linha_sub')) {
                marcar = fnjs.como_booleano(linha.closest('table.tabdados').attr('marcar'));
                if (marcar===true) {
                    tabelaest = linha.closest('table.tabdados');
                    marcarmultiplo = fnjs.como_booleano(tabelaest.attr('marcarmultiplo'));
                    classemarcacao = tabelaest.attr('classemarcacao');
                    if (linha.hasClass(classemarcacao) && marcarmultiplo === true) {
                        linha.removeClass(classemarcacao);
                    } else {					
                        if (marcarmultiplo===false) {
                            tabelaest.children('tbody').children('tr').removeClass(classemarcacao);
                        } else if (marcarmultiplo===true) {
                            if (!e.ctrlKey) {
                                tabelaest.children('tbody').children('tr').removeClass(classemarcacao);
                            }						
                        }
                        linha.addClass(classemarcacao);
                    }
                }
            }
            fnjs.logf(this.constructor.name,"marcar_linha");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }

    selecionar_linha(e){
        try{
            fnjs.logi(this.constructor.name,"selecionar_linha");
            let cel = fnjs.obterJquery(e.target||e).closest("td");
                cel_sel = cel.closest('tr').children('td.cel_selecao'),
                linha = cel.closest('tr'),
                corpo = linha.closest('tbody'),
                tabelaest = corpo.closest('table.tabdados'),			
                tipo_sel = tabelaest.attr('selecao_tipo'),
                img_sel = cel_sel.find('img'),			
                status = linha.attr('selecao_status') || 'nao_selecionado',
                multiplo = fnjs.como_booleano(tabelaest.attr('multiplo') || tabelaest.attr('selecao_multiplo') || true),
                linhas = {},
                imgs_sel = {},
                dados = null,
                permite_selecao = true;
            permite_selecao = fnjs.como_booleano(tabelaest.attr('permite_selecao')||true);            
            if (!permite_selecao) return false;           
            dados = this.obter_dados_tabela(tabelaest);
            tipo_sel = tipo_sel.trim().toLowerCase();
            status = status.trim().toLowerCase();
            switch(multiplo) {
                case true:
                    if (status === 'selecionado') {
                        if (tipo_sel === 'checkbox') {
                            img_sel.attr('src',vars.nomes_caminhos_arquivos.checkbox);							
                            linha.attr('selecao_status','nao_selecionado');
                            if (tabelaest.attr('id_dados') !== 'undefined') {
                                vars.dados[tabelaest.attr('id_dados')][linha.attr('id_dados')] = linha[0].cloneNode(true);
                            }
                        this.desmarcar_selecionar_todos(tabelaest);
                        } 												
                    } else {
                        if (tipo_sel === 'checkbox') {
                            
                            img_sel.attr('src',vars.nomes_caminhos_arquivos.checkbox_checked);
                            linha.attr('selecao_status','selecionado');
                            if (tabelaest.attr('id_dados') !== 'undefined') {
                                vars.dados[tabelaest.attr('id_dados')][linha.attr('id_dados')] = linha[0].cloneNode(true);
                            }
                        this.checkar_marcou_todos(tabelaest);
                        } 						
                    }
                    break;
                case false:
                default:
                    img_sel = fnjs.obterJquery(cel_sel).find('img');
                    if (status !== 'selecionado') {
                        linhas = corpo[0].children;
                        let qt = 0,
                            ind_col_sel = 0;
                        qt = dados.length;
                        for(let i = 0 ; i<qt; i++) {
                            dados[i].setAttribute('selecao_status','nao_selecionado');
                            dados[i].children[ind_col_sel].children[0].setAttribute('src',vars.nomes_caminhos_arquivos.radio);
                        };
                        qt = linhas.length;
                        for(let i = 0; i<qt; i++) {
                            linhas[i].setAttribute('selecao_status','nao_selecionado');
                            linhas[i].children[ind_col_sel].children[0].setAttribute('src',vars.nomes_caminhos_arquivos.radio);
                        };
                        img_sel.attr('src',vars.nomes_caminhos_arquivos.radio_checked);
                        linha.attr('selecao_status','selecionado');
                        dados[linha.attr('id_dados')] = linha[0].cloneNode(true);
                        if (typeof linha.attr('selecao_aoselecionar') !== 'undefined') {
                            if (linha.attr('selecao_aoselecionar').trim().length) {
                                eval(linha.attr('selecao_aoselecionar').replace('this','linha'));
                            }
                        }
                    }
                    break;
            }
            if (tabelaest.closest('div.div_combobox').length) {
                this.fncomboboxs.atualizar_texto_combobox(tabelaest.closest('div.div_combobox'));
            }
            if (typeof tabelaest.attr('aoselecionaropcao') !== 'undefined') {
                if (tabelaest.attr('aoselecionaropcao').trim().length > 0) {                   
                    eval(tabelaest.attr('aoselecionaropcao').trim().replace('this','linha'));
                }
            }
            fnjs.logf(this.constructor.name,"selecionar_linha");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }

    clicou_corpo(e){
        try{
            fnjs.logi(this.constructor.name,"clicou_corpo");
            let el = fnjs.obterJquery(e.target);
            let cel = el.closest("td");
            let linha = cel.closest("tr");
            let tabdados = linha.closest("table.tabdados");
            this.marcar_linha(e,linha);
            if (cel.hasClass('cel_cmd')) {
                this.clicou_cel_cmd(e);
            } else {
                if (el.closest('td.cel_selecao').length || (linha.children('td.cel_selecao').length && (fnjs.como_booleano(tabdados.attr('selecionar_pela_linha')||false)) === true)) {
                    this.selecionar_linha(e);
                } else {
                    if (el.hasClass('img_sub')) {
                        this.mostrar_sub_registro(e.target);
                    } else {
                        let data_opcoes = this.obter_data_opcoes({elemento:tabdados});
                        if (tabdados.attr('aoclicarlinha') || 
                            (typeof data_opcoes !== 'undefined' && data_opcoes !== null && data_opcoes.length && typeof data_opcoes.aoclicarlinha !== 'undefined') ) {
                            if (tabdados.attr('aoclicarlinha').trim().length) {
                                if ((typeof linha.attr('status') !== 'undefined' && linha.attr('status') === 'normal') || typeof linha.attr('status') === 'undefined') {										
                                    eval(tabdados.attr('aoclicarlinha').trim().replace('this', 'el'));
                                }
                            }
                        }
                    }
                }
            }
            fnjs.logf(this.constructor.name,"clicou_corpo");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }

    clicou_tabela(e){
        try{
            fnjs.logi(this.constructor.name,"clicou_tabela");
            if (fnjs.obterJquery(e.target).closest('tr').parent('thead').length) {
                    this.clicou_titulo(e);
            } else if (fnjs.obterJquery(e.target).closest('tr').parent('tbody').length) {				
                this.clicou_corpo(e);
            } 
            fnjs.logf(this.constructor.name,"clicou_tabela");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }

    obter_campos_db(tabelaest){
        try {
            fnjs.logi(this.constructor.name,"obter_campos_db");
            let linhatitulos = fnjs.obterJquery(tabelaest).children('thead').find('tr.linha_campos'),
                cels_campos = linhatitulos.children('th:not(.cel_sub_tit):not(.cel_cmd_tit)'),
                camposdb = [],
                strtemp = '',
                camposdbsemtabela = [];
            if (!linhatitulos.length) {
                linhatitulos = $(tabelaest).children('thead').find('tr.linhatitulos');
            }
            cels_campos = linhatitulos.children('th:not(.cel_sub_tit):not(.cel_cmd_tit)');
            $.each(cels_campos,function(index){			
                strtemp = window.fnhtml.fntabdados.obter_nomecampodb(cels_campos.eq(index));
                camposdb.push(strtemp);
                if (strtemp.indexOf('.') !== -1) {
                    camposdbsemtabela.push(strtemp.substr(strtemp.indexOf('.')+1));
                } else {
                    camposdbsemtabela.push(strtemp);
                }				
            });
            fnjs.logf(this.constructor.name,"obter_campos_db");
            return {camposdb:camposdb,camposdbsemtabela:camposdbsemtabela};			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    obter_indice_campo_db(tabelaest, campodb,tentativa) {
        try {
            fnjs.logi(this.constructor.name,"obter_indice_campo_db");
            let cels_campos = {},
                temsubregistro = 0,
                temselecao = 0,
                ind = null,
                strtemp = null;
            tentativa = tentativa||0;
            tabelaest = fnjs.obterJquery(tabelaest);
            temsubregistro = Number(fnjs.como_booleano(tabelaest.attr('subregistros')||tabelaest.attr('subregistro')||false)||0);
            temselecao = Number(fnjs.como_booleano(tabelaest.attr('selecao_ativada')||false)||0);
            cels_campos = tabelaest.children('thead').find('tr.linha_campos').children('th:not(.cel_sub_tit):not(.col_sel)');
            if (!cels_campos.length||cels_campos.length<=0) {
                cels_campos = tabelaest.children('thead').find('tr.linhatitulos').children('th:not(.cel_sub_tit):not(.col_sel)');
            }			
            ind = -1;
            $.each(cels_campos,function(index){
                let campodbinterno = campodb;
                if (typeof cels_campos.eq(index).attr('cnj_nomes_campos_db') !== 'undefined' 
                    && cels_campos.eq(index).attr('cnj_nomes_campos_db').length > 0) {
                    strtemp = cels_campos.eq(index).attr('cnj_nomes_campos_db').trim().toLowerCase();
                } else if (typeof cels_campos.eq(index).attr('data-campodb') !== 'undefined' 
                    && cels_campos.eq(index).attr('data-campodb').length > 0) {
                    strtemp = cels_campos.eq(index).attr('data-campodb').trim().toLowerCase();
                } else {
                    strtemp = cels_campos.eq(index).text().trim().toLowerCase();
                }
                if (tentativa === 1) {
                    if (typeof cels_campos.eq(index).attr('data-campodb') !== 'undefined' && cels_campos.eq(index).attr('data-campodb').length > 0) {
                        strtemp = cels_campos.eq(index).attr('data-campodb').trim().toLowerCase();
                    } else {
                        strtemp = cels_campos.eq(index).text().trim().toLowerCase();
                    }					
                } else if (tentativa === 2) {
                    strtemp = cels_campos.eq(index).text().trim().toLowerCase();
                }
                if (strtemp === campodbinterno.trim().toLowerCase()) {
                    ind = index + temsubregistro + temselecao;					
                    return false;
                }				
                if (strtemp.indexOf('.') >-1 && campodbinterno.indexOf('.') === -1) {
                    strtemp = strtemp.substr(strtemp.indexOf('.') + 1);
                } else if (strtemp.indexOf('.') === -1 && campodbinterno.indexOf('.') > -1) {
                    campodbinterno = campodbinterno.substr(campodbinterno.indexOf('.') + 1);
                }
                if (strtemp === campodbinterno.trim().toLowerCase()) {
                    ind = index + temsubregistro + temselecao; 					
                    return false;
                }
            });
            if (ind < 0) {
                if (tentativa < 3) {
                    tentativa++;
                    return 	this.obter_indice_campo_db(tabelaest, campodb,tentativa);
                } else {
                    return ind;
                }
            } else {
                return ind;
            }
            fnjs.logf(this.constructor.name,"obter_indice_campo_db");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }	

    mostrar_sub_registro(obj){
        try{
            fnjs.logi(this.constructor.name,"mostrar_sub_registro");
            let tag = fnjs.obterJquery(obj).prop('tagName'),
                linha = {},
                linha_sub = {},
                img_abrir = {},
                tabdados = {},
                fn_aoabrir = '',
                idrand = null,
                id_dados_tab = null,
                id_dados_linha = null,
                id_dados_linha_sub = null,
                ehtb2 = false;
            if (tag !== 'TR') {
                linha = fnjs.obterJquery(obj).closest('tr');
            } else {
                linha = fnjs.obterJquery(obj);
            }
            tabdados = linha.closest("table.tabdados");            
            img_abrir = linha.find('img').eq(0);
            if (img_abrir.attr('src').indexOf("mais") > -1) {
                fn_aoabrir = tabdados.attr("aoabrir");
                idrand = fnjs.id_random();
                linha_sub = '<tr class="linha_sub" idlinhasub="'+idrand+'"><td class="cel_sub_espacadora"></td><td class="cel_sub_registro" colspan="999"></td></tr>';
                linha.after(linha_sub);					
                linha_sub = linha.next('tr');					
                img_abrir.attr('src',img_abrir.attr('src').replace('mais','menos'));
                if (fn_aoabrir.length > 0) {
                    eval(fn_aoabrir.replace('this','linha'));
                }
            } else {
                linha.next('tr').remove();
                img_abrir.attr('src',img_abrir.attr('src').replace('menos','mais'));
            }
            fnjs.logf(this.constructor.name,"mostrar_sub_registro");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }


    pesquisar_sub_registro(obj){
        try{
            fnjs.logi(this.constructor.name,"pesquisar_sub_registro");
            let linha = fnjs.obterJquery(obj).closest('tr'),
                linha_sub = linha.next(),
                cel_sub = linha_sub.children('td.cel_sub_registro'),
                tabelaest = linha.closest('table.tabdados'),
                campo_subregistro = tabelaest.attr('campo_subregistro'),
                campo_sub_registro_pai = tabelaest.attr('campo_subregistro_pai'),
                valor_subregistro = linha.attr(campo_subregistro),
                comhttp = JSON.parse(vars.str_tcomhttp),
                idrand = fnjs.id_random(),
                codprocesso = -1,
                tabeladb = '',
                ind_col = null;
            cel_sub.addClass(idrand);
            if (!(typeof valor_subregistro !== "undefined" && valor_subregistro !== null && valor_subregistro.length)) {
                ind_col = this.obter_indice_campo_db(tabelaest,campo_subregistro);
                valor_subregistro = linha.children("td").eq(ind_col).text();
            }
            codprocesso = tabelaest.attr('codprocesso');
            comhttp.requisicao.requisitar.oque='dados_sql';
            comhttp.requisicao.requisitar.qual.comando = 'consultar';
            comhttp.requisicao.requisitar.qual.tipo_objeto = 'tabelaest';
            tabeladb = tabelaest.attr('tabeladb');
            comhttp.requisicao.requisitar.qual.objeto = tabeladb;
            comhttp.requisicao.requisitar.qual.condicionantes = [];
            comhttp.requisicao.requisitar.qual.condicionantes.push('codprocesso=' + codprocesso);
            comhttp.requisicao.requisitar.qual.condicionantes.push('condicionantestab='+tabeladb+'['+campo_sub_registro_pai+'='+valor_subregistro+']');
            comhttp.opcoes_retorno.seletor_local_retorno='td.'+idrand;
            comhttp.opcoes_retorno.metodo_insersao = 'html';			
            //comhttp.opcoes_retorno.ignorar_tabela_est = true;
            comhttp.opcoes_retorno.usar_arr_tit = true;
            comhttp.eventos.aposretornar=[{
                arquivo:null,
                funcao:'window.fnreq.inserir_retorno',
            }];
            fnreq.requisitar_servidor({comhttp:comhttp});			
            fnjs.logf(this.constructor.name,"pesquisar_sub_registro");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }


    clicou_cel_cmd(e){
        try{
            fnjs.logi(this.constructor.name,"clicou_cel_cmd");
            let status = '';
            //alert(this.classes.img_excluir);
            if (fnjs.obterJquery(e.target).hasClass('img_editar')) {
                this.abrir_edicao_linha(e,fnjs.obterJquery(e.target).closest('tr'));
            } else if (fnjs.obterJquery(e.target).hasClass('img_excluir')) {
                this.excluir_linha_registro(e,fnjs.obterJquery(e.target).closest('tr'));
            } else if (fnjs.obterJquery(e.target).hasClass('img_copiar')) {
                this.copiar_linha_registro(e,fnjs.obterJquery(e.target).closest('tr'));
            } else if (fnjs.obterJquery(e.target).hasClass('img_salvar')) {
                status = (fnjs.obterJquery(e.target).closest('tr').attr('status') || 'normal').trim().toLowerCase();				
                if (status.indexOf('inclu') > -1) {
                    this.salvar_nova_linha_registro(e,fnjs.obterJquery(e.target).closest('tr'));
                } else if (status.indexOf('edic') > -1) {
                    this.salvar_edicao_linha({event:e,elemento:fnjs.obterJquery(e.target).closest('tr')});
                }
            } else {
                if (fnjs.obterJquery(e.target).prop('tagName') !== 'td') {
                    if (typeof fnjs.obterJquery(e.target).attr('onclick') !== 'undefined') {						
                    } else {						
                        throw "Classe botao nao definido";
                    }
                }
            }
            fnjs.logf(this.constructor.name,"clicou_cel_cmd");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }


    copiar_linha_registro(e,obj){
        try{
            fnjs.logi(this.constructor.name,"copiar_linha_registro");
            let linharef = fnjs.obterJquery(obj).closest('tr'),
                tabelaest = linharef.closest("table.tabdados"),
                corpotab = tabelaest.children("body"),
                novalinha = {},
                aocopiar = '';
            novalinha = linharef.clone();
            corpotab.append(novalinha);
            aocopiar = tabelaest.attr('aocopiar')||'';
            if (aocopiar.trim().length) {
                eval(aocopiar.replace('this','novalinha'));
            }           
            fnjs.logf(this.constructor.name,"copiar_linha_registro");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }
    }

    atualizar_dados_linha_copiada(params) {//comhttp,parametros){
        try{
            fnjs.logi(this.constructor.name,"atualizar_dados_linha_copiada");
            let novalinha = fnjs.obterJquery(params.comhttp.opcoes_retorno.seletor_local_retorno),
                corpotab = novalinha.closest('tbody'),
                tabelaest = corpotab.closest("table.tabdados"),
                cels = {},
                qtcels = 0,
                cont = 1,
                numcelini = 0,
                tipo = 'linha',
                titulotab = tabelaest.children('thead'),
                campostab = titulotab.children('tr.linhatitulos').children('th'),
                bloqueio = ' ',
                classe_sub_elementos_coluna = ' ',
                propriedades_sub_elementos_colunas='',
                propriedades = '',
                propriedades_sub = [],
                cont2 = 0,
                achou = false,
                campo = '',
                valor = '',
                ind_campo_dado = -1;
            cels = novalinha.children('td');
            qtcels = cels.length;
            for(let cont1 = 0; cont1 < params.comhttp.retorno.dados_retornados.dados.length; cont1++) {
                ind_campo_dado = -1;
                campo = params.comhttp.retorno.dados_retornados.dados[cont1].chave.trim().toLowerCase();
                ind_campo_dado = this.obter_indice_campo_db(tabelaest,campo);
                valor = params.comhttp.retorno.dados_retornados.dados[cont1].valor;
                if (ind_campo_dado > -1) {
                    cels.eq(ind_campo_dado).text(valor);
                }
                novalinha.attr(campo,valor);
            }
            novalinha.attr('status','normal');
            setTimeout(fnreq.carregando,15,{
                texto:'processo_concluido',
                acao:'esconder',
                id:params.comhttp.id_carregando||''
            });
            fnjs.logf(this.constructor.name,"atualizar_dados_linha_copiada");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    } 


    excluir_linha_registro(event,obj){
        try{
            fnjs.logi(this.constructor.name,"excluir_linha_registro");
            let linha=fnjs.obterJquery(obj).closest('tr'),
                tabelaest,
                aoexcluirlinha,
                aposexcluirlinha,
                status = '';
            event.preventDefault();
            event.stopImmediatePropagation();
            status = linha.attr('status')||'normal';
            tabelaest = linha.closest("table.tabdados");
            aoexcluirlinha = tabelaest.attr("aoexcluirlinha")||'';
            aposexcluirlinha = tabelaest.attr("aposexcluirlinha")||'';
            if (status.trim().toLowerCase().indexOf('inclusao') > -1) {
                if (confirm("Deseja REALMENTE CANCELAR A INCLUSÃO desta linha?")) {
                    if (linha.next("tr").length) {
                        if (linha.next("tr").hasClass("linha_sub")) {
                            linha.next("tr").remove();
                        }
                    }
                    linha.remove();
                    if (aposexcluirlinha.trim().length) {
                        eval(aposexcluirlinha.trim().replace('this','linha'));
                    }
                }
            } else {				
                if (confirm("Deseja REALMENTE EXCLUIR esta linha?")) {
                    linha.attr('status','emexclusao');
                    if (aoexcluirlinha.trim().length) {
                        eval(aoexcluirlinha.trim().replace('this','linha'));
                    }
                    if (linha.next("tr").length) {
                        if (linha.next("tr").hasClass("linha_sub")) {
                            linha.next("tr").remove();
                        }
                    }
                    linha.remove();					
                    if (aposexcluirlinha.trim().length) {
                        eval(aposexcluirlinha.trim().replace('this','linha'));
                    }
                }
            }
            fnjs.logf(this.constructor.name,"excluir_linha_registro");
            return;			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    excluir_dados_sql_padrao(params) { 	
        try{
            fnjs.logi(this.constructor.name,"excluir_dados_sql_padrao");
            params.elemento = fnjs.obterJquery(params.elemento||params.obj||params);
            let tabelaest = {},
                linhatitulos = {},
                celscampos = {},
                linha = {},
                celsdados = {},
                nometab = '',
                campos = [],
                campos_sem_tabela = [],
                valores = [],
                opcoes_exclusao = {},
                campos_chaves_primaria = [],
                campos_chaves_unica = [],
                parar = false,
                condicionantes = [],
                strtemp = '';
            linha = params.elemento.closest('tr');
            tabelaest = linha.closest("table.tabdados");
            nometab = tabelaest.attr("tabeladb");
            linhatitulos = tabelaest.children('thead').find('tr.linhatitulos');
            celscampos = linhatitulos.children('th:not(.cel_sub_tit):not(.cel_cmd_tit)');
            celsdados = linha.children('td:not(.cel_abre_sub):not(.cel_sub):not(.cel_cmd)');
            campos = this.obter_campos_db(tabelaest);
            campos = campos.camposdbsemtabela;
            $.each(celscampos,function(index,element){
                valores.push(celsdados.eq(index).text());
            });
            opcoes_exclusao.condicionantes = [];
            campos_chaves_primaria = tabelaest.attr('campos_chaves_primaria')||'';
            campos_chaves_primaria = campos_chaves_primaria.trim().toLowerCase().split(',');
            campos_chaves_unica = tabelaest.attr("campos_chaves_unica")||'';
            campos_chaves_unica = campos_chaves_unica.trim().toLowerCase().split(',');
            if (campos_chaves_primaria.length > 0) {
                $.each(campos_chaves_primaria,function(index,element){
                    if (campos.indexOf(element.toLowerCase()) > -1) {
                        condicionantes.push(element+'=' + "'"+valores[campos.indexOf(element.toLowerCase())]+"'");
                    } else {
                        parar = true;
                        return false;
                    }
                });
                if (parar) {
                    alert("Campos chaves nao existem");
                    return;					
                } else {
                    opcoes_exclusao.condicionantes.push(condicionantes.join(vars.sepn1));
                }
            } else if (campos_chaves_unica.length > 0) {
                $.each(campos_chaves_unica,function(index,element){
                    if (campos.indexOf(element.toLowerCase()) > -1) {
                        condicionantes.push(element+'=' + "'"+valores[campos.indexOf(element.toLowerCase())]+"'");
                    } else {
                        parar = true;
                        return false;
                    }
                });
                if (parar) {
                    alert("Campos chaves nao existem");
                    return;					
                } else {
                    opcoes_exclusao.condicionantes.push(condicionantes.join(vars.sepn1));
                }
            } else {
                alert("Campos chaves nao existem");
                return;
            }			
            opcoes_exclusao.tabela = nometab;
            opcoes_exclusao.campos = campos;
            opcoes_exclusao.valores = valores;
            fnreq.excluir_dados_sql({opcoes:opcoes_exclusao});
            fnjs.logf(this.constructor.name,"excluir_dados_sql_padrao");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    abrir_edicao_linha(event,obj) {
        try {
            fnjs.logi(this.constructor.name,"abrir_edicao_linha");
            let linha = $(obj).closest('tr'),
            tabelaest = linha.closest("table.tabdados"),
            linha_campos = tabelaest.find('tr.linhatitulos'),
            campos = [],
            cels_campos = {},			
            cels = {},
            campos_chaves_primaria = [],
            campos_chaves_unica = [],
            campos_bloqueados = [],
            campos_nao_editaveis = [],
            bloqueio = '',
            htmlaposinput = '',
            classe_sub_elementos_coluna = '',
            tamanhoinput = '',
            propriedades_sub = [],
            aposabriredicaolinha = '',
            classe_bloqueio = '',
            propriedades_sub_elementos_colunas = null,
            funcao_edicao = '';
            funcao_edicao = (tabelaest.attr('funcao_edicao')||'').trim();
            if (funcao_edicao.length > 0) {
                eval(funcao_edicao.replace('this','obj'));
                return;
            } 
            cels_campos = linha_campos.children('th:not(.cel_sub_tit):not(.cel_cmd_tit)');		
            cels = linha.children('td:not(.cel_abre_sub):not(.cel_sub):not(.cel_cmd)');
            campos_chaves_primaria = (linha.attr("campos_chaves_primaria")||"").split(',');
            campos_chaves_unica = (linha.attr("campos_chaves_unica")||"").split(',');
            campos_bloqueados = (tabelaest.attr("campos_bloqueados")||"").split(',')||[];
            $.each(cels_campos,function(index) {
                campos.push(cels_campos.eq(index).text().toLowerCase().trim());
            });
            if ((campos_chaves_primaria||[]).length>0) {
                $.each(campos_chaves_primaria,function(index) {					
                    campos_nao_editaveis.push(campos.indexOf(campos_chaves_primaria[index].trim().toLowerCase()));
                });
            }
            if ((campos_chaves_unica||[]).length>0) {
                $.each(campos_chaves_unica,function(index) {					
                    campos_nao_editaveis.push(campos.indexOf(campos_chaves_unica[index].trim().toLowerCase()));
                });
            }
            if ((campos_bloqueados||[]).length>0) {
                $.each(campos_bloqueados,function(index) {					
                    campos_nao_editaveis.push(campos.indexOf(campos_bloqueados[index].trim().toLowerCase()));
                });
            }
            linha.attr('status','emedicao');
            $.each(cels,function(index) {
                if (campos_nao_editaveis.indexOf(index) !== -1) {
                    cels.eq(index).attr("data-valor",cels.eq(index).text().trim());
                } else if (cels.eq(index).find("div.div_combobox").length) {
                } else if (cels.eq(index).attr('status') === 'emedicao') {
                } else {
                    cels.eq(index).attr("data-valor",cels.eq(index).text().trim());
                    classe_sub_elementos_coluna = ' ';
                    bloqueio = ' ';
                    if (cels.eq(index).hasClass("bloqueado")) {
                        bloqueio = 'disabled';
                        classe_bloqueio = ' bloqueado ';
                    }
                    htmlaposinput = '';
                    tamanhoinput = '98%';
                    if (typeof cels.eq(index).attr("classe_sub_elementos_coluna") !== 'undefined') {
                        classe_sub_elementos_coluna = cels.eq(index).attr("classe_sub_elementos_coluna").trim();
                        if (classe_sub_elementos_coluna.trim().toLowerCase().indexOf("div.input_combobox") > -1) {
                            tamanhoinput = 'calc(98% - 2em)';
                            htmlaposinput = '<button class="btn_abrir_pesquisa btn_input_combobox" style="width:2em;" title="Pesquisar" onclick="$(this).prevAll(\'div.input_combobox\').focus()">...</button>';
                        } else {
                            htmlaposinput = '';
                            tamanhoinput = '98%';
                        }
                    }
                    propriedades_sub = [];
                    if (typeof cels.eq(index).attr("propriedades_sub_elementos_coluna") !== 'undefined') {
                        propriedades_sub_elementos_colunas = cels.eq(index).attr("propriedades_sub_elementos_coluna").trim();
                        propriedades_sub_elementos_colunas = propriedades_sub_elementos_colunas.split(',');						
                        $.each(propriedades_sub_elementos_colunas,function(index2,element2){
                            propriedades_sub.push(' ' + element2 + '="' + cels.eq(index).attr(element2) + '" ');
                        });
                    }					
                    cels.eq(index).html('<input type="text" value="' + cels.eq(index).text().trim() + '" class="input_edicao_linha '+classe_sub_elementos_coluna+'" style="width:' + tamanhoinput + '" ' + propriedades_sub.join(' ') + ' " onkeyup="window.fnjs.verificar_tecla(this,event,{Escape:\'window.fnhtml.fntabdados.cancelar_edicao_linha(this)\',Enter:\'window.fnhtml.fntabdados.salvar_edicao_linha({event:event,elemento:this})\'})">' + htmlaposinput);
                }
            });
            linha.children('td:last').html('<img class="clicavel" src="/sjd/images/salvar.png" style="width:16px;" onclick="window.fnhtml.fntabdados.salvar_edicao_linha({event:event,elemento:this})" title="Salvar alteracoes"><img class="clicavel" src="/sjd/images/deletar1_32.png" style="width:16px" onclick="window.fnhtml.fntabdados.cancelar_edicao_linha(this);" title="Cancelar alteracoes">');
            aposabriredicaolinha = tabelaest.attr("aposabriredicaolinha");
            if (typeof aposabriredicaolinha !== 'undefined') {
                aposabriredicaolinha = aposabriredicaolinha.trim();
                if (aposabriredicaolinha.length > 0) {
                    eval(aposabriredicaolinha.replace(/this/g,'linha'));
                }
            }
            fnjs.logf(this.constructor.name,"abrir_edicao_linha");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }								
    }

    cancelar_edicao_linha(obj) {
        try {
            fnjs.logi(this.constructor.name,"cancelar_edicao_linha");
           let linha = fnjs.obterJquery(obj).closest('tr'),
                cels = linha.children('td:not(.cel_abre_sub):not(.cel_cmd)'),
               tabelaest = linha.closest("table.tabdados"),				
               mantercombobox = fnjs.como_booleano(tabelaest.attr("mantercombobox")||false);				
           if (window.confirm("Cancelar edicao?")) {
               $.each(cels,function(index) {
                   if (typeof cels.eq(index).attr("data-valor") !== 'undefined') {
                       if (cels.eq(index).children("div.div_combobox").length) {
                           if (mantercombobox === false) {
                               cels.eq(index).html(cels.eq(index).attr("data-valor").trim());
                           }
                       } else {
                           cels.eq(index).html(cels.eq(index).attr("data-valor").trim());
                       }
                   } else {
                       if (cels.eq(index).children("div.div_combobox").length) {
                           if (mantercombobox === false) {
                               cels.eq(index).html(cels.eq(index).attr("data-valor").trim());
                           }
                       } else {
                           if (cels.eq(index).children('input').length) {								
                               alert("Erro ao salvar");
                           } 
                       }
                   }
               });
               linha.children('td:last').html('');
               if (tabelaest.attr("edicao_ativa")==='true') {
                   linha.children('td:last').append('<img class="img_editar clicavel" src="/sjd/images/editar1_32.png" style="width:16px" title="Editar esta linha">');
               } 
               if (tabelaest.attr("exclusao_ativa")==='true') {
                   linha.children('td:last').append('<img class="img_excluir clicavel" src="/sjd/images/deletar1_32.png" style="width:16px" title="Excluir esta linha">');
               } 					
               if (tabelaest.attr("copiar_ativa")==='true') {
                   linha.children('td:last').append('<img class="img_copiar clicavel" src="/sjd/images/copiar1_32.png" style="width:16px" title="Copiar esta linha">');
               } 									
               linha.attr('status','normal');	
           }	
           fnjs.logi(this.constructor.name,"cancelar_edicao_linha");
       } catch(e) {
           console.log(e);
           alert(e.message || e);
       }
    }

    salvar_edicao_linha(params) { //event,obj) {
        try {
            fnjs.logi(this.constructor.name,"salvar_edicao_linha");
            let linha = fnjs.obterJquery(params.elemento).closest('tr'),
                tabelaest = linha.closest("table.tabdados"),
                aosalvaredicaolinha = tabelaest.attr("aosalvaredicaolinha"),
                cels = {},
                mantercombobox = false,
                valor = '';
            if (typeof params.event !== 'undefined') {
                params.event.preventDefault();
                params.event.stopImmediatePropagation();
            }
            mantercombobox = fnjs.como_booleano(tabelaest.attr("mantercombobox")||false);
            linha.attr('status',"salvandoedicao");
            if (aosalvaredicaolinha.trim().length) {
                eval(aosalvaredicaolinha.trim().replace(/this/g,'linha'));
            }
            cels = linha.children('td');
            $.each(cels,function(index,element){
                if (cels.eq(index).children("input[type=text]").length) {
                    cels.eq(index).html(cels.eq(index).children("input[type=text]").val());					
                } else if (cels.eq(index).children("div.div_combobox").length) {					
                    if (mantercombobox===false) {
                        valor = window.fnhtml.fncomboboxs.obter_valores_selecionados_combobox(cels.eq(index).children("div.div_combobox"));
                        cels.eq(index).html(valor);
                    }
                } else if (cels.eq(index).hasClass("cel_cmd")) {
                    cels.eq(index).html('');
                    if (tabelaest.attr("edicao_ativa")==='true') {
                        cels.eq(index).append('<img class="img_editar clicavel" src="/sjd/images/editar1_32.png" style="width:16px" title="Editar esta linha">');
                    } 
                    if (tabelaest.attr("exclusao_ativa")==='true') {
                        cels.eq(index).append('<img class="img_excluir clicavel" src="/sjd/images/deletar1_32.png" style="width:16px" title="Deletar esta linha">');
                    } 					
                    if (tabelaest.attr("copiar_ativa")==='true') {
                        cels.eq(index).append('<img class="img_copiar clicavel" src="/sjd/images/copiar1_32.png" style="width:16px" title="Copiar esta linha">');
                    } 									
                }
                cels.eq(index).attr('status','normal');
            });	
            linha.attr('status','normal');
            fnjs.logf(this.constructor.name,"salvar_edicao_linha");
            return;			
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }						
    }	

    atualizar_dados_sql_padrao(params) { //obj,processar_retorno_como) { 
        try{
            fnjs.logi(this.constructor.name,"atualizar_dados_sql_padrao");
            let tabelaest = {},
                linhatitulos = {},
                celscampos = {},
                linha = {},
                celsdados = {},
                nometab = '',
                campos = [],
                valores = [],
                opcoes_atualizacao = {},
                parar = false,
                camposnaolocalizados=[],
                condicionantes = [],
                campos_chaves_primaria = null,
                campos_chaves_unica = null,
                valortemp = '';
            params.elemento = fnjs.obterJquery(params.elemento||params.obj);
            linha = params.elemento.closest('tr');
            tabelaest = linha.closest("table.tabdados");
            nometab = tabelaest.attr("tabeladb");
            linhatitulos = tabelaest.children('thead').find('tr.linhatitulos');
            celscampos = linhatitulos.children('th:not(.cel_sub_tit):not(.cel_cmd_tit)');
            celsdados = linha.children('td:not(.cel_abre_sub):not(.cel_sub):not(.cel_cmd)');
            campos = this.obter_campos_db(tabelaest);
            campos = campos.camposdbsemtabela;
            $.each(celscampos,function(index,element){
                if (celsdados.eq(index).children('input').length) {
                    valores.push(celsdados.eq(index).find('input').val().replace(/\,/g,vars.subst_virg));
                } else if (celsdados.eq(index).children("div.div_combobox").length) {
                    valortemp = window.fnhtml.fncomboboxs.obter_valores_selecionados_combobox(celsdados.eq(index).children("div.div_combobox"));
                    if (valortemp.length) {
                        valortemp = valortemp[0].replace(/\,/g,vars.subst_virg)
                    } else {
                        valortemp = '';
                    }
                    valores.push(valortemp);
                } else {				
                    valores.push(celsdados.eq(index).text().replace(/\,/g,vars.subst_virg));
                }
            });
            opcoes_atualizacao.condicionantes = [];
            campos_chaves_primaria = tabelaest.attr("campos_chaves_primaria")||'';
            campos_chaves_primaria = campos_chaves_primaria.trim().toLowerCase().split(',');
            campos_chaves_unica = tabelaest.attr("campos_chaves_unica")||'';
            campos_chaves_unica = campos_chaves_unica.trim().toLowerCase().split(',');
            if (campos_chaves_primaria.length > 0) {
                $.each(campos_chaves_primaria,function(index,element){
                    if (campos.indexOf(element.toLowerCase()) > -1) {
                        condicionantes.push(element+'=' + "'"+valores[campos.indexOf(element.toLowerCase())]+"'");
                    } else {
                        camposnaolocalizados.push(element);
                        parar = true;
                        return false;
                    }
                });
                if (parar) {										
                    alert("Campo nao existem: " + camposnaolocalizados.join(','));
                    return;					
                } else {
                    opcoes_atualizacao.condicionantes.push(condicionantes.join(vars.sepn1));
                }
            } else if (campos_chaves_unica.length > 0) {
                $.each(campos_chaves_unica,function(index,element){
                    if (campos.indexOf(element.toLowerCase()) > -1) {
                        condicionantes.push(element+'=' + "'"+valores[campos.indexOf(element.toLowerCase())]+"'");
                    } else {
                        camposnaolocalizados.push(element);
                        parar = true;
                        return false;
                    }
                });
                if (parar) {										
                    alert("Campos nao existem: " + camposnaolocalizados.join(','));
                    return;					
                } else {
                    opcoes_atualizacao.condicionantes.push(condicionantes.join(vars.sepn1));
                }
            } else {
                alert("campos nao existem");
                return;
            }						
            opcoes_atualizacao.tabela = nometab;
            opcoes_atualizacao.campos = campos;
            opcoes_atualizacao.valores = valores;
            opcoes_atualizacao.processar_retorno_como = [] ; 
            if (typeof params.processar_retorno_como === 'string' ) {
                opcoes_atualizacao.processar_retorno_como.push({
                    arquivo:null,
                    funcao: params.processar_retorno_como
                });
            } else if (typeof params.processar_retorno_como === 'object') {
                opcoes_atualizacao.processar_retorno_como.push(params.processar_retorno_como);			
            } else {
                opcoes_atualizacao.processar_retorno_como.push({
                    arquivo:null,
                    funcao: 'window.fnreq.processar_retorno_como_mensagem'
                });
            }
            fnreq.atualizar_dados_sql({opcoes:opcoes_atualizacao});
            fnjs.logf(this.constructor.name,"atualizar_dados_sql_padrao");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }
    }
};

class FormsBootStrap{
    constructor(){
        try {
            this.default_placeholder = "Filtro";
            this.default_retornar_como = "HtmlText";
            this.classes = {
                btn_form:"btn btn-lg d-block m-auto",
                btn_outline_secondary: "btn btn-outline-secondary",
                form_check : "form-check",
                form_check_inline : "form-check-inline",
                form_check_input : "form-check-input",
                form_check_label : "form-check-label",
                form_control:"form-control",
                form_group:"form-group",
                form_row:"row",
                input_group:"input-group"                        
            }; 
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }
    }

    create_button(params){
        try {
            params = params || {};
            params.tag = "button";
            params.title = params.title || "(Button)";
            window.fnhtml.atribuir_classe(params,window.fnhtml.btstrp.forms.classes.btn_form);            
            return window.fnhtml.criar_elemento(params);
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }

    criar_select(params) {
        try {
            let retorno = null;
            params = params || {};
            window.fnhtml.atribuir_classe(params,window.fnhtml.btstrp.forms.classes.form_control);
            retorno = window.fnhtml.btstrp.criar_select(params);
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }
    
    criar_select_filtro_criterio(params) {
        try {
            params = params || {};
            params.tag = "select";
            let criterios = null;
            switch(params.type || "text") {
                case "text": case "string":
                    criterios = window.fnhtml.filtros.criterios.string
                    break;
                case "number": case "numeric": case "integer":
                    criterios = window.fnhtml.filtros.criterios.number
                    break;
                default:
                    throw "tipo de criterio nao esperado: " + params.type;
                    break;
            }
            params.content = params.content || params.items || params.itens || params.valuees || params.values || params.opcoes
                || criterios;
            return window.fnhtml.btstrp.forms.criar_select(params);
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }

    criar_div_input_group = function(params) {
        try {
            let retorno = null;
            params = params || {};
            params.tag = "div";
            params.content = params.content || params.input;
            if (window.fnjs.typeof(params.content) === "undefined" || params.content === null) {
    
                /*cria um input padrao caso nao tenha vindo como content da div input-group*/ 
                params.content = [
                    {
                        tag:"input",
                        class:window.fnhtml.btstrp.forms.classes.form_control,
                        type:"text",
                        placeholder: "(" + (params.title || window.fnhtml.btstrp.forms.default_placeholder) + ")",
                        retornar_como : params.retornar_como || window.fnhtml.btstrp.forms.default_retornar_como
                    }
                ]
            }
    
            /*cria os botoes a direita (right) caso venha nos params*/ 
            if (window.fnjs.typeof(params.buttons_right) === "array") {
                let q = params.buttons_right.length;
                for (let i = 0; i < q; i++) {
                    window.fnhtml.atribuir_classe(params.buttons_right[i],window.fnhtml.btstrp.forms.classes.btn_outline_secondary);
                    params.content.push(params.buttons_right[i]);
                }
            }
            window.fnhtml.atribuir_classe(params,window.fnhtml.btstrp.forms.classes.input_group);
            retorno = window.fnhtml.criar_elemento(params);
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }
    criar_form_row_input(params) {
        try {
            let retorno = null,
                params_temp = null,
                content_input_group = null;
            params = params || {};
            params.tag = "div";
            params.has_filter_criterion = window.fnjs.first_valid([params.has_filter_criterion,true]);
            window.fnhtml.atribuir_classe(params,window.fnhtml.btstrp.forms.classes.form_row);        
    
            params.content = '';
            if (params.has_filter_criterion === true) {
                let content_filtro_criterio = null;
                content_filtro_criterio = window.fnhtml.btstrp.forms.criar_select_filtro_criterio({
                    retornar_como:"HtmlText",
                    type:params.type || "text"
                }); 
                
                params_temp = {
                    tag:"div",
                    class:"col-3",
                    retornar_como:"HtmlText",
                    content:content_filtro_criterio
                };
                params.content = window.fnhtml.criar_elemento(params_temp);        
            }
            content_input_group = window.fnhtml.btstrp.forms.criar_div_input_group({
                retornar_como:"HtmlText",
                title:params.title||window.fnhtml.btstrp.forms.default_placeholder,
                buttons_right : params.buttons_right
            });
            params_temp = {
                tag:"div",
                class:"col",
                retornar_como:"HtmlText",
                content:content_input_group
            };
            params.content += window.fnhtml.criar_elemento(params_temp);   
            retorno = window.fnhtml.criar_elemento(params);
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }

    criar_form_group_input(params) {
        try {
            let retorno = null;
            params = params || {};
            params.tag = "div";        
            window.fnhtml.atribuir_classe(params,window.fnhtml.btstrp.forms.classes.form_group);        
            let form_row_input = window.fnhtml.btstrp.forms.criar_form_row_input({
                retornar_como:"HtmlText",
                title:params.title || window.fnhtml.btstrp.forms.default_placeholder, 
                type:params.type || "text",
                has_filter_criterion: params.has_filter_criterion,
                buttons_right: params.buttons_right
            });
            let params_temp = {
                tag:"label",
                class:"control-label",
                retornar_como:"HtmlText",
                content:params.title || window.fnhtml.btstrp.forms.default_placeholder
            };
            params.content = window.fnhtml.criar_elemento(params_temp);                
            params.content += form_row_input;
            retorno = window.fnhtml.criar_elemento(params);
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }
}

class FuncoesBootStrap{
    constructor(){
        try {
            this.forms = new FormsBootStrap();
        } catch (e) {
            console.log(e);
            alert(e.message || e);
        }
    }

    criar_select(params) {
        try {
            let retorno = null;
            params = params || {};
            params.tag = "select";
            params.content = params.content || params.items || params.itens || params.options || params.opcoes || params.values || params.valuees || [];			
            retorno = window.fnhtml.criar_elemento(params);
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message||e);
            return null;
        }
    }

}



/**Classe FuncoesHtml */
class FuncoesHtml{
    constructor(){
        try {
            fnjs.logi(this.constructor.name);
            this.nomes_variaveis =  {
                FuncoesHtml : "FuncoesHtml",
                fnhtml_pt : ""
            };
            this.nomes_variaveis.fnhtml_pt = this.nomes_variaveis.FuncoesHtml + '.';
            this.nomes_funcoes =  {
                destacar_legenda : "destacar_legenda",
                desdestacar_legenda : "desdestacar_legenda",
                elemento_alterado_dinamicamente : "elemento_alterado_dinamicamente",
                elemento_inserido_dinamicamente : "elemento_inserido_dinamicamente",			
                esmaecer : "esmaecer",
                htmlDecode : "htmlDecode",
                mostrar_esconder_senha : "mostrar_esconder_senha",
                setar_background_color : "setar_background_color"
            };
            this.nomes_completos_funcoes = {                    
                destacar_legenda : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.destacar_legenda,
                desdestacar_legenda : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.desdestacar_legenda,
                elemento_alterado_dinamicamente : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.elemento_alterado_dinamicamente,
                elemento_inserido_dinamicamente : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.elemento_inserido_dinamicamente,
                esmaecer : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.esmaecer,
                htmlDecode : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.htmlDecode,
                mostrar_esconder_senha : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.mostrar_esconder_senha,
                setar_background_color : this.nomes_variaveis.fnhtml_pt + this.nomes_funcoes.setar_background_color
            };
            this.propriedades_html = {
                background_color_bkp : "background-color_bkp",
                placeholder_bkp : "placeholder_bkp"
            };
            this.filtros = {
                criterios:{
                    string:["Contém","Não Contém","Igual","Diferente de","Começa com","Termina com"],
                    number:["Igual","Maior que","Menor que","Diferente de","Contém","Não Contém","Exato","Começa com","Termina com"]
                }
            };

            this.tags_fechamento_simples = [
                "br","img","input"
            ]; 
            this.posicao_inclusao = 'beforeend';
            this.tags_fechamento_simples = [
                "input",
                "br"
            ];
            /*nomes propriedades que podem vir fora de props (params.[prop]) e serem elegiveis a propriedade html*/
            this.props_elegiveis = [        
                "checked",
                "class",
                "id",
                "name",
                "onclick",
                "onkeyup",
                "onsubmit",
                "placeholder",
                "required",                        
                "src",
                "style",
                "title",
                "type",
                "value"            
            ];  
            
            this.dragSrcEl = null,
            this.cnjsmovs = [],
            this.idscnjsmovs = [],
            this.dataTransfer = null,
            this.strings={
                Text : "Text",
                text_html : "text/html"
            };
            this.nomes_variaveis = {
                FuncoesMover : "FuncoesMover"
            };
            this.nomes_variaveis.fnmov_pt = this.nomes_variaveis.FuncoesMover + '.';
            this.nomes_funcoes = {
                obter_indcnjmov : "obter_indcnjmov",
                transf_movivel : "transf_movivel"
            };
            this.nomes_completos_funcoes = {
                obter_indcnjmov : this.nomes_variaveis.fnmov_pt + this.nomes_funcoes.obter_indcnjmov,
                transf_movivel : this.nomes_variaveis.fnmov_pt + this.nomes_funcoes.transf_movivel
            };
            this.classes = {
                movendo : "movendo",
                movivel : "movivel",
                over : "over"
            };
            this.propriedades_html = {
                idcnjmov : "idcnjmov"
            };
            this.fndrop = new FuncoesDropdown();
            this.fncomboboxs = new FuncoesComboboxs();
            this.fncal = new FuncoesCalendario();
            this.fntabdados = new FuncoesTabDados();
            this.btstrp = new FuncoesBootStrap();
            fnjs.logf(this.constructor.name);
            fnjs.logf(this.constructor.name);
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    };

    obterPosicaoElementoHtml(obj) {
        try {
            fnjs.logi(this.constructor.name,"obterPosicaoElementoHtml");
            let curleft = 0, 
                curtop = 0;
            if (obj.offsetParent) {
                do {
                    curleft += obj.offsetLeft;
                    curtop += obj.offsetTop;
                } while (obj = obj.offsetParent);
                return { x: curleft, y: curtop };
            }
            fnjs.logf(this.constructor.name,"obterPosicaoElementoHtml");
            return undefined;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    obter_text_como_array(elementos) {
        try {
            fnjs.logi(this.constructor.name,"obter_text_como_array");
            let arr_text = [];
            $.each(elementos,function(index,element){
                arr_text.push(elementos.eq(index).text());
            });
            fnjs.logf(this.constructor.name,"obter_text_como_array");
            return arr_text;
        } catch(erro) {
            console.log(erro);
            alert(erro.message || erro);
        }
    }

    setar_background_color(params) {
        try {
            fnjs.logi(this.constructor.name,"setar_background_color");
            params.temporizador = params.temporizador || "1s";
            params.elemento = fnjs.obterJquery(params.elemento);
            params.elemento.css( '-moz-transition' , 'background-color ' + params.temporizador + ' ease');
            params.elemento.css( '-webkit-transition' , 'background-color ' + params.temporizador + ' ease');
            params.elemento.css( '-o-transition' , 'background-color ' + params.temporizador + ' ease');
            params.elemento.css( 'transition' , 'background-color ' + params.temporizador + ' ease');
            params.elemento.css( 'background' , params.background_color ) ;
            fnjs.logf(this.constructor.name,"setar_background_color");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }				
    } 
    elemento_alterado_dinamicamente(params) {
        try {
            fnjs.logi(this.constructor.name,"elemento_alterado_dinamicamente");
            let background_original ;
            params.temporizador_voltar_cor = params.temporizador_voltar_cor  || 200;
            params.elemento = fnjs.obterJquery(params.elemento);
            if (typeof params.elemento.attr('data-background_original') === 'undefined') {		
                params.elemento.attr('data-background_original', params.elemento.css('background-color') );				
            }
            background_original = params.elemento.attr('data-background_original');
            this.setar_background_color({elemento:params.elemento, background_color:'yellow' , temporizador:"0.2s"});
            setTimeout(this.setar_background_color , params.temporizador_voltar_cor  , {elemento:params.elemento, background_color:background_original});
            fnjs.logf(this.constructor.name,"elemento_alterado_dinamicamente");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }		
    } 
    elemento_inserido_dinamicamente(novo_elemento){
        try{
            fnjs.logi(this.constructor.name,"elemento_inserido_dinamicamente");
            let background_original ;
            background_original = fnjs.obterJquery( novo_elemento ).css( 'background-color' ) ;
            this.setar_background_color({elemento:novo_elemento,background_color:'gray' , temporizador:"0.3s"});
            setTimeout(this.setar_background_color , 200 , {elemento:novo_elemento, background_color:background_original});
            fnjs.logf(this.constructor.name,"elemento_inserido_dinamicamente");
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }		

    }	
    htmlDecode(value){
        try{
            fnjs.logi(this.constructor.name,"htmlDecode");
            fnjs.logf(this.constructor.name,"htmlDecode");
            return fnjs.obterJquery('<textarea>').html(value).text(); 
        }catch(e){
            console.log(e);
            alert(e.message || e);
        }			
    }	     
    destacar_legenda(elemento) {
        try {
            fnjs.logi(this.constructor.name,"destacar_legenda");
            let elemento_pai ;
            elemento = fnjs.obterJquery(elemento);
            if (elemento.length) {
                elemento_pai = fnjs.obterJquery(elemento).closest('fieldset');
                if (elemento_pai.length) {
                    if ((elemento_pai.attr(this.propriedades_html.background_color_bkp)||'').trim().length <= 0) {
                        elemento_pai.attr(this.propriedades_html.background_color_bkp,elemento_pai.css('background-color'));
                    }
                    elemento_pai.css('background-color','aliceblue');
                    elemento_pai.children('legend').css('display','block');
                }
                if (elemento.attr('placeholder').trim().length > 0) {
                    elemento.attr(this.propriedades_html.placeholder_bkp,elemento.attr('placeholder'));
                }
                elemento.attr('placeholder','');
            }
            fnjs.logf(this.constructor.name,"destacar_legenda");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }											
    }

    desdestacar_legenda(elemento,e) {
        try {
            fnjs.logi(this.constructor.name,"desdestacar_legenda");
            let elemento_pai ;
            console.log(e);
            elemento = fnjs.obterJquery(elemento);
            if (elemento.length) {
                elemento_pai = fnjs.obterJquery(elemento).closest('fieldset');
                if (elemento_pai.length) {
                    elemento_pai.css('background-color',elemento_pai.attr(this.propriedades_html.background_color_bkp));
                    if (elemento.val().trim().length > 0) {
                    } else {
                        elemento_pai.children('legend').css('display','none');
                    }
                }
                elemento.attr('placeholder',elemento.attr(this.propriedades_html.placeholder_bkp));
            }
            fnjs.logf(this.constructor.name,"desdestacar_legenda");
        } catch(er) {
            console.log(er);
            alert(er.message || er);
        }											
    }

    mostrar_esconder_senha(elemento) {
        try {
            fnjs.logi(this.constructor.name,"mostrar_esconder_senha");
            let elemento_senha = {},
                status = '';
            elemento = fnjs.obterJquery(elemento);
            
            if (elemento.length) {
                status = elemento.attr('status') || 'invisivel';
                elemento_senha = fnjs.obterJquery(elemento).prev('input');
                if (elemento_senha.length) {
                    if (status === 'invisivel') {
                        elemento_senha.attr('type','text');
                        elemento.attr('status','visivel');
                        elemento.attr('src',elemento.attr('src').replace('olho','esconder'));
                    } else {
                        elemento_senha.attr('type','password');
                        elemento.attr('status','invisivel');
                        elemento.attr('src',elemento.attr('src').replace('esconder','olho'));
                    }
                }				
            }
            fnjs.logf(this.constructor.name,"mostrar_esconder_senha");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }											
    }

    montar_box_padrao(params){
        try {
            fnjs.logi(this.constructor.name,"montar_box_padrao");
            let retorno = '';			
            params = params || {};
            params.classe = params.classe || '';
            params.titulo = params.titulo || {};
            params.titulo.texto = params.titulo.texto || '(Titulo)';
            params.corpo = params.corpo || {};
            params.corpo.classe = params.corpo.classe || '';
            retorno += '<div class="div_box '+ params.classe +' m-3">';
                retorno += '<div class="row row_div_box_cab rounded-top bg-tit-box">';
                    retorno += '<div class="col div_box_cab_col ">';
                        retorno += '<div class="div_box_cab_tit">';
                            retorno += '<div class="div_texto_titulo_opcoes_cab">';
                                retorno += '<text>';
                                retorno += params.titulo.texto;
                                retorno += '</text>';
                            retorno += '</div>';
                        retorno += '</div>';
                    retorno += '</div>';
                retorno += '</div>';
                retorno += '<div class="row row_div_box_corpo border">';
                    retorno += '<div class="col div_box_corpo '+params.corpo.classe+'">';
                    retorno += '</div>';
                retorno += '</div>';
            retorno += '</div>';
            fnjs.logf(this.constructor.name,"montar_box_padrao");
            return retorno;
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            return null;
        }											
    }

    esmaecer(elemento,tempo_duracao) {
        try {
            fnjs.logi(this.constructor.name,"esmaecer");
            let elemento_senha = {},
                status = '';
            elemento = fnjs.obterJquery(elemento);
            tempo_duracao = tempo_duracao || 3000;
            if (elemento.length) {
                elemento.fadeOut(tempo_duracao,function() { fnjs.obterJquery(this).remove(); });
            }
            fnjs.logf(this.constructor.name,"esmaecer");
        } catch(e) {
            console.log(e);
            alert(e.message || e);
        }											
    }
    
    /**
     * Obtem o ultimo elemento html incluido conforme params.posicao
     * @param {json object} params - o mesmo params da criacao do elemento ou que contenha pelo menos seu .parent
     * @returns {object} - o elemento encontrado
     */
    obter_ultimo_adicionado(params) {
        try {
            //fnjs.logi(this.constructor.name,"obter_ultimo_adicionado");
            let retorno = null;
            if (typeof params.parent === "object") {                       
                switch((params.posicao || this.posicao_inclusao).trim().toLowerCase()) {
                    case "beforeend":
                        retorno = params.parent.lastChild;
                        break;
                    case "afterbegin":
                        retorno = params.parent.firstChild;
                        break;
                    case "afterend":
                        retorno = params.parent.nextSibling;
                        break;
                    case "beforebegin":
                        retorno = params.parent.prevSibling;
                        break;
                    default:
                        throw 'Posicao nao esperada: ' + (params.posicao || this.posicao_inclusao);
                        break;                        
                }
            }  
            //fnjs.logf(this.constructor.name,"obter_ultimo_adicionado");
            return retorno;              
        } catch(e) {
            console.log(e);
            alert(e.message || e);
            return null;
        }         
    }

    atribuir_classe(params,p_classe){
        try {
            /*atribui a classe form-control*/ 
            params = params || {};
            let tipo_class = window.fnjs.typeof(params.class);
            if (tipo_class !== "undefined") {
                if (params.class !== null) {
                    if (tipo_class === "array") {
                        params.class.push(p_classe);
                    } else if (tipo_class === "string") {
                        params.class = p_classe + ' ' + params.class;
                    } else {
                        throw "tipo da class em params inesperado: " + tipo_class;
                    }
                } else {
                    params.class = p_classe;    
                }
            } else {
                params.class = p_classe;
            }
        } catch(e) {
            console.log(e);
            alert(e.message||e);
        }
    }

    /**
     * Cria um elemento html e retorna-o como texto ou DomObject, adicionalmente ja inserindo-o no html se passado 
     * params.parent nao nulo.
     * @param {json object | string} params - os parametros de criacao (json) ou a tag html(string)
     * @returns {object | string} - o elemento criado ou seu texto html (caso params.retornar_como = texto)
     */
    criar_elemento(params) {
        try {
            //fnjs.logi(this.constructor.name,"criar_elemento");
            let retorno = '';
            params = params || {};
            if (typeof params === "string") {
                params = {tag:params};
            }
            params.retornar_como = (params.retornar_como || 'string').toLowerCase().trim();
            if (typeof params.tag !== "undefined") {
                if (["string","text","texto","textohtml","texthtml","htmltext"].indexOf(params.retornar_como) !== -1) {
                    retorno += '<' + (params.tag || 'div');
                    let arr_props = [];

                    /*keys que vem fora de params.props mas sao elegiveis a propriedades html*/
                    let keys = Object.keys(params);
                    for(let i in keys) {
                        if (this.props_elegiveis.indexOf(keys[i]) > -1) {
                            if (params[keys[i]] !== null && params[keys[i]] !== "null") {
                                arr_props.push(keys[i] + '="' + params[keys[i]] + '"');
                            }
                        }
                    };


                    if (typeof params.demaiscampos !== "undefined" && params.demaiscampos !== null) {
                        let demaiscampos = params.demaiscampos.split(vars.sepn1);
                        for (let ind in demaiscampos) {
                            let campo = demaiscampos[ind].split("=");
                            if (campo[1] !== null && campo[1] !== "null") {
                                arr_props.push(campo[0] + '="' + campo[1] + '"');
                            }
                        }
                    }


                    if (typeof params.camposdata !== "undefined" && params.camposdata !== null) {
                        let camposdata = params.camposdata.split(vars.sepn1);
                        for (let ind in camposdata) {
                            let campo = camposdata[ind].split("=");
                            if (campo[1] !== null && campo[1] !== "null") {
                                arr_props.push(campo[0] + '="' + campo[1] + '"');
                            }
                        }
                    }


                    if (fnjs.typeof(params.props) === "array" && params.props.length) {

                        /*propriedades dentro de params.props */
                        for(let i in params.props) {
                            if (typeof params.props[i].value !== "undefined") {
                                if (params.props[i].value !== null && params.props[i].value !== "null") {
                                    arr_props.push(params.props[i].prop + '="' + params.props[i].value + '"');
                                }
                            } else {
                                arr_props.push(params.props[i].prop);
                            }
                        };                
                    }
                    if (arr_props.length > 0) {
                        retorno += ' ' + arr_props.join(' ');                
                    }
                    if (this.tags_fechamento_simples.indexOf(params.tag) > -1) {
                        retorno += '/>';
                    } else {
                        retorno += '>';
                        params.content_apos = fnjs.first_valid([params.content_apos,false]);
                        params.content = (params.content || params.conteudo || params.text || '');
                        if (fnjs.typeof(params.content) === "array") {
                            params.sub = params.sub || [];
                            if (fnjs.typeof(params.sub) !== "array") {
                                params.sub = [params.sub];
                            }
                            for(let i = 0; i < params.content.length; i++) {
                                params.sub.push(params.content[i]);
                            }
                            params.content = '';
                        }
                        if (!params.content_apos) {
                            retorno += params.content ;
                        }
                        retorno += '</'+ (params.tag || 'div') +'>';
                    }
                    
                    if (typeof params.parent === "object" && params.parent !== null) {                           
                        params.parent.insertAdjacentHTML(params.posicao || this.posicao_inclusao, retorno);
                        retorno = this.obter_ultimo_adicionado(params);
                        if (fnjs.typeof(params.sub) === "array") {                            
                            params.sub.parent = retorno;
                            this.criar_elemento(params.sub);
                        }
                    } else if (fnjs.typeof(params.sub) === "array") {    
                        params.sub.retornar_como = "texto";
                        params.sub.parent = null;
                        retorno = retorno.substr(0,Math.max(retorno.lastIndexOf('</'),retorno.lastIndexOf('/>')));                        
                        retorno += this.criar_elemento(params.sub);
                        if (this.tags_fechamento_simples.indexOf(params.tag) > -1) {
                            retorno += '/>';
                        } else {
                            params.content_apos = fnjs.first_valid([params.content_apos,false]); 
                            params.content = (params.content || params.conteudo || params.text || '');
                            if (params.content_apos) {
                                retorno += params.content ;
                            }
                            retorno += '</'+ (params.tag || 'div') +'>';
                        }
                    }
                } else {
                    retorno = document.createElement(params.tag);

                    /*keys que vem fora de params.props mas sao elegiveis a propriedades html*/
                    let keys = Object.keys(params);
                    for(let i in keys) {
                        if (this.props_elegiveis.indexOf(keys[i]) > -1) {
                            if (params[keys[i]] !== null && params[keys[i]] !== "null") {
                                retorno.setAttribute(keys[i], params[keys[i]]);
                            }
                        }
                    };

                    if (!(fnjs.typeof(params.props) === "array" && params.props.length)) {
                        params.props = [];
                    }

                    if (typeof params.demaiscampos !== "undefined" && params.demaiscampos !== null) {
                        let demaiscampos = params.demaiscampos.split(vars.sepn1);
                        for (let ind in demaiscampos) {
                            let campo = demaiscampos[ind].split("=");
                            if (campo[1] !== null && campo[1] !== "null") {
                                retorno.setAttribute(campo[0],campo[1]);
                            }
                        }
                    }

                    if (typeof params.camposdata !== "undefined" && params.camposdata !== null) {
                        let camposdata = params.camposdata.split(vars.sepn1);
                        for (let ind in camposdata) {
                            let campo = camposdata[ind].split("=");
                            if (campo[1] !== null && campo[1] !== "null") {
                                retorno.setAttribute(campo[0],campo[1]);
                            }
                        }
                    }
                    
                    if (fnjs.typeof(params.props) === "array" && params.props.length) {

                        /*propriedades dentro de params.props */
                        for(let i in params.props) {
                            if (typeof params.props[i].value !== "undefined") {
                                if (params.props[i].value !== null && params.props[i].value !== "null") {
                                    retorno.setAttribute(params.props[i].prop, params.props[i].value);
                                }
                            } else {
                                retorno.setAttribute(params.props[i].prop);
                            }
                        };
                    };

                    params.content_apos = fnjs.first_valid([params.content_apos,false]); 
                    params.content = (params.content || params.conteudo || params.text || '');
                    if (!params.content_apos) {
                        retorno.innerHTML += params.content ;
                    }

                    if (typeof params.parent === "object") {
                        params.parent.insertAdjacentElement(params.posicao || this.posicao_inclusao,retorno);                        
                    }

                    if (fnjs.typeof(params.sub) === "array") {                            
                        params.sub.parent = retorno;
                        this.criar_elemento(params.sub);
                        params.content_apos = fnjs.first_valid([params.content_apos,false]); 
                        params.content = (params.content || params.conteudo || params.text || '');
                        if (params.content_apos) {
                            retorno.innerHTML += params.content ;
                        }
                    }

                }
            } else {

                /*se params for array ou params.sub for array, recursa*/
                if (fnjs.typeof(params.sub) === "array") {
                    params.sub.retornar_como = params.retornar_como;
                    params.sub.parent = params.parent;
                    retorno = this.criar_elemento(params.sub);
                } else if (["array","object"].indexOf(fnjs.typeof(params))>-1) {
                    for(let ind in params) {
                        if (fnmat.isNumber(ind) && fnjs.typeof(params[ind]) === "object") {
                            params[ind].retornar_como = params[ind].retornar_como || params.retornar_como;
                            params[ind].parent = params[ind].parent || params.parent;
                            if (["string","text","texto","textohtml","texthtml","htmltext"].indexOf(params[ind].retornar_como) !== -1 && (typeof params[ind].parent === "undefined" || ((params[ind].parent || null) === null))) {
                                retorno += this.criar_elemento(params[ind]);
                            } else {
                                retorno = this.criar_elemento(params[ind]);
                            }
                        }
                    }
                }
            }
            //fnjs.logf(this.constructor.name,"criar_elemento");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        } 
    }

    criar_modal(params_modal) {
        try {
            fnjs.logi(this.constructor.name,"criar_modal");
            let retorno = null;
            params_modal = params_modal || {};
            params_modal.tag = "div";
            params_modal.class = "div_modal modal fade";
            params_modal.header = params_modal.header || {};
            params_modal.header.active = fnjs.first_valid([params_modal.header.active,true]);
            params_modal.header.content = params_modal.header.content || "";
            params_modal.header.sub = params_modal.header.sub || [];
            params_modal.header.hasBtnClose = fnjs.first_valid([params_modal.header.hasBtnClose,true]);
            params_modal.body = params_modal.body || {};
            params_modal.body.active = fnjs.first_valid([params_modal.body.active,true]);
            params_modal.body.content = params_modal.body.content || "";
            params_modal.body.sub = params_modal.body.sub || [];
            params_modal.foot = params_modal.foot || {};
            params_modal.foot.active = fnjs.first_valid([params_modal.foot.active,true]);
            params_modal.foot.content = params_modal.foot.content || "";
            params_modal.foot.sub = params_modal.foot.sub || [];
            params_modal.foot.hasBtnClose = fnjs.first_valid([params_modal.foot.hasBtnClose,true]);
            params_modal.props = params_modal.props || [];
            params_modal.props.push({
                prop:"aria-labelledby",
                value:"staticBackdropLabel"
            });
            params_modal.props.push({
                prop:"data-bs-backdrop",
                value:"static"
            });
            params_modal.props.push({
                prop:"data-bs-keyboard",
                value:"false"
            });
            params_modal.props.push({
                prop:"aria-hidden",
                value:"true"
            });
            params_modal.sub = params_modal.sub || [];
            params_modal.sub.push({
                tag:"div",
                class:"modal-dialog modal-dialog-centered",
                sub:[
                    {
                        tag:"div",
                        class:"modal-content",
                        sub:[]
                    }
                ]
            });
            
            if (params_modal.header.active === true) {

                if (params_modal.header.sub.length === 0) {
                    params_modal.header.sub.push({
                        tag:"h5",
                        class:"modal-title",
                        content:params_modal.header.content,
                    });
                    params_modal.header.content = '';
                }

                if (params_modal.header.hasBtnClose) {
                    params_modal.header.sub.push({
                        tag:"button",
                        class:"btn-close",
                        type:"button",
                        props:[
                            {
                                prop:"data-bs-dismiss",
                                value:"modal"
                            },
                            {
                                prop:"aria-label",
                                value:"Close"
                            }
                        ]
                    });
                    params_modal.header.content = '';
                }

                params_modal.sub[0].sub[0].sub.push({
                    tag:"div",
                    class:"modal-header",
                    content:params_modal.header.content,
                    sub:params_modal.header.sub
                });
            }
            if (params_modal.body.active === true) {
                params_modal.sub[0].sub[0].sub.push({
                    tag:"div",
                    class:"modal-body",
                    content:params_modal.body.content,
                    sub: params_modal.body.sub
                });
            }
            if (params_modal.foot.active === true) {
                if (params_modal.foot.hasBtnClose) {
                    params_modal.foot.sub.push({
                        tag:"button",
                        class:"btn btn-secondary",
                        content:"Fechar",
                        props:[
                            {
                                prop:"data-bs-dismiss",
                                value:"modal"
                            }
                        ]
                    });
                }
                params_modal.sub[0].sub[0].sub.push({
                    tag:"div",
                    class:"modal-footer",
                    content:params_modal.foot.content,
                    sub: params_modal.foot.sub
                });
            }

            retorno = this.criar_elemento(params_modal);
            fnjs.logf(this.constructor.name,"criar_modal");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        } 
    }


    criar_spinner(params_spinner) {
        try {
            fnjs.logi(this.constructor.name,"criar_spinner");
            let retorno = null;
            params_spinner = params_spinner || {};
            params_spinner.tag = "div";
            params_spinner.class = "spinner-border";
            params_spinner.props = params_spinner.props || [];
            params_spinner.props.push({
                prop:"role",
                value:"status"
            });
            params_spinner.sub = params_spinner.sub || [];
            params_spinner.sub.push({
                tag:"span",
                class:"visually-hidden",
                text:"Carregando..."
            });

            retorno = this.criar_elemento(params_spinner);
            fnjs.logf(this.constructor.name,"criar_spinner");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }


    criar_accordion_item_header(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_accordion_item_header");
            let retorno = null;
            params = params || {};
            params.tag = "h2";
            params.class = "accordion-header";
            params.open = fnjs.first_valid([params.open,params.aberto,false]);
            params.sub = [];
            params.sub.push({
                tag:"button",
                class:"accordion-button" + (params.open?"":" collapsed"),
                type:"button",
                text:params.text || params.titulo || params.title || "(titulo)",
                props:[
                    {
                        prop:"data-bs-toggle",
                        value:"collapse"
                    },
                    {
                        prop:"data-bs-target",
                        value:"#" + (params.id_target || params.id_destino || "")
                    },
                    {
                        prop:"aria-controls",
                        value:(params.id_target || params.id_destino || "")
                    },
                    {
                        prop:"aria-expanded",
                        value:params.open
                    }
                ]

            });
            params.text = null;
            retorno = this.criar_elemento(params);
            fnjs.logf(this.constructor.name,"criar_accordion_item_header");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }


    criar_accordion_item_body(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_accordion_item_body");
            let retorno = null;
            params = params || {};
            params.tag = "div";
            params.open = fnjs.first_valid([params.open,params.aberto,false]);
            params.class = "accordion-collapse collapse " + (params.open?" show ":"") + (params.class || "");            
            params.props = params.props || [];
            params.props.push({
                prop:"aria-labelledby",
                value:params.id_title || params.id_titulo || params.id_label || ""
            });

            /*se setar a propriedade parent em branco ocorre erro nao tratado no botstrap*/
            if (typeof (params.id_parent || params.id_accordion || params.id_parente || params.id_superior) !== "undefined" && (params.id_parent || params.id_accordion || params.id_parente || params.id_superior) !== null && (params.id_parent || params.id_accordion || params.id_parente || params.id_superior).length > 0) {
                params.props.push({
                    prop:"data-bs-parent",
                    value:"#" + (params.id_parent || params.id_accordion || params.id_parente || params.id_superior || "")
                });
            }            
            let sub_temp = params.sub || [];
            params.sub = [];
            params.sub.push({
                tag:"div",
                class:"accordion-body",
                text:params.text_body || params.content || params.conteudo || params.corpo || "",
                sub:sub_temp
            });

            retorno = this.criar_elemento(params);
            fnjs.logf(this.constructor.name,"criar_accordion_item_body");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }

    criar_accordion_item(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_accordion_item");
            let retorno = null;
            params = params || {};
            params.tag = "div";
            params.class = "accordion-item " + (params.class || "");
            params.props = params.props || [];
            params.open = fnjs.first_valid([params.open,params.aberto,false]);
            params.sub = params.sub || [];
            let id_title = params.id_title || params.id_header || params.id_titulo || fnjs.id_random();
            let id_target = params.id_target || params.id_body || params.id_destino || fnjs.id_random();
            let params_item_header = {
                id:id_title,
                title:params.title||params.titulo||"titulo",
                id_target: id_target,
                open:params.open
            };
            let params_item_body = {
                id:id_target,                
                id_title: id_title,
                text_body :params.text_body || params.body || params.content || params.corpo || params.text || "",
                id_accordion: params.id_accordion || params.id_parent || "",
                open:params.open,
                sub:params.sub
            };
            params.text = "";
            params.text += this.criar_accordion_item_header(params_item_header);
            params.text += this.criar_accordion_item_body(params_item_body);
            params.sub = [];

            
            retorno = this.criar_elemento(params);
            fnjs.logf(this.constructor.name,"criar_accordion_item");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }

    criar_accordion(params) {
        try {
            fnjs.logi(this.constructor.name,"criar_accordion");
            let retorno = null;
            params = params || {};
            params.tag = "div";
            params.id = params.id || fnjs.id_random();
            params.class = "accordion " + (params.class || "");
            params.props = params.props || [];            
            params.sub = params.sub || []; 
            params.items = params.items || [];
            params.text = "";
            let item = null;
            for (let i = 0; i < params.items.length; i++) {
                params.items[i].id_accordion = params.id;
                params.text += this.criar_accordion_item(params.items[i]);
            }
            retorno = this.criar_elemento(params);
            fnjs.logf(this.constructor.name,"criar_accordion");
            return retorno;
        } catch (e){
            console.log(e);
            alert(e.message || e);
            return null;
        }
    }

    /**
      * Foca num elemento html, passado no seletor de params.
      * @param {object} params - parametros
      * @returns {boolean} se conseguiu focar
      */
     focar_elemento(params) { 
        try{
           fnjs.logi(this.constructor.name,"focar_elemento");
           params.temponovatentativa = params.temponovatentativa || 500;
           params.qtmaxtentativas = params.qtmaxtentativas || vars.num_limite_recursoes || 100; 
           params.contadortentativas = params.contadortentativas || 0;
           
           if (fnjs.obterJquery(params.seletor).length) {
               fnjs.obterJquery(params.seletor)[0].focus();
               return  true;
           } else {
               if (params.temponovatentativa !== null) {
                   if (params.qtmaxtentativas !== null) {
                       if (params.contadortentativas !== null) {
                           params.contadortentativas++;
                       } else {
                           params.contadortentativas = 1;
                       }
                       if (params.contadortentativas > params.qtmaxtentativas) {
                           return false;
                       }
                   }
                   setTimeout(this.focar_elemento,params.temponovatentativa,params);
               }
           }
           fnjs.logf(this.constructor.name,"focar_elemento");
        } catch(e){
           console.log(e);
           alert(e.message || e);
        }				
    }


    handleDragStart(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDragStart");
            this.classList.add(this.classes.movendo);  
            this.dragSrcEl = this;
            e.dataTransfer.effectAllowed = 'move';
            if (vars.navegador === 'iexplorer') {
                e.dataTransfer.setData('Text', this.innerHTML);  
            } else {
                e.dataTransfer.setData('text/html', this.innerHTML);  
            }
            this.dataTransfer = e.dataTransfer;
            fnjs.logf(this.constructor.name,"handleDragStart");
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }

    handleDragOver(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDragOver");
          if (e.preventDefault) {
            e.preventDefault(); // Necessary. Allows us to drop.
          }
          e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
          fnjs.logf(this.constructor.name,"handleDragOver");
            return false;
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }

    handleDragEnter(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDragEnter");
            let idcnjmovdest = this.obter_idcnjmov(this);
            let idcnjmovorigem = this.obter_idcnjmov(this.dragSrcEl);
          if (idcnjmovorigem === idcnjmovdest) {
            this.classList.add(this.classes.over);
          } 
            fnjs.logf(this.constructor.name,"handleDragEnter");
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }

    handleDragLeave(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDragLeave");
            this.classList.remove(this.classes.over);  // this / e.target is previous target element.
            fnjs.logf(this.constructor.name,"handleDragLeave");
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }

    handleDrop(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDrop");

          if (e.stopPropagation) {
            e.stopPropagation(); // Stops some browsers from redirecting.
          }

          // Don't do anything if dropping the same column we're dragging.
          if (this.dragSrcEl != this) {
            // Set the source column's HTML to the HTML of the columnwe dropped on.
            let idcnjmovdest = this.obter_idcnjmov(this);
            let idcnjmovorigem = this.obter_idcnjmov(this.dragSrcEl);
            if (idcnjmovorigem === idcnjmovdest) {
                this.dragSrcEl.classList.remove(this.classes.movendo);
                this.classList.remove(this.classes.over);
                if (fnjs.obterJquery(this).index() > fnjs.obterJquery(this.dragSrcEl).index()) {
                    fnjs.obterJquery(this).after(fnjs.obterJquery(this.dragSrcEl));
                } else {
                    fnjs.obterJquery(this).before(fnjs.obterJquery(this.dragSrcEl));
                }
            } else {
                this.classList.remove(this.classes.movendo);
            }
          } else {
            this.classList.remove(this.classes.movendo);
          }
          fnjs.logf(this.constructor.name,"handleDrop");
            return false;
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }

    handleDragEnd(e) {
        try {
            fnjs.logi(this.constructor.name,"handleDragEnd");
            let indcnjmov = this.obter_indcnjmov(e.target);
            this.classList.remove(this.classes.movendo);
          [].forEach.call(this.cnjsmovs[indcnjmov], function (col) {
            col.classList.remove(this.classes.over);
            col.style.opacity = 1;
          });
            fnjs.logf(this.constructor.name,"handleDragEnd");
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }
    }
    obter_idcnjmov(el) {
        try{
            fnjs.logi(this.constructor.name,"obter_idcnjmov");
            if (fnjs.obterJquery(el).length) {
                let elsup = fnjs.obterJquery(el).parent();		
                let idcnj = elsup.attr(this.propriedades_html.idcnjmov);
                if (typeof idcnj === 'undefined') {
                    idcnj = fnjs.id_random();					
                    elsup.attr(this.propriedades_html.idcnjmov,idcnj);
                    this.idscnjsmovs.push(idcnj);
                    this.cnjsmovs.push([]);
                }
                return idcnj;
            }
            fnjs.logf(this.constructor.name,"obter_idcnjmov");
            return null;
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }		
    }
    obter_indcnjmov(el) {
        try{
            fnjs.logi(this.constructor.name,"obter_indcnjmov");
            if (fnjs.obterJquery(el).length) {
                let idcnj = this.obter_idcnjmov(el);
                let prms_array = {};
                let indcnj = -1;
                prms_array.array = this.idscnjsmovs;
                prms_array.valor = idcnj;
                indcnj = fnarr.procurar_array(prms_array);
                return indcnj;
            }
            fnjs.logf(this.constructor.name,"obter_indcnjmov");
            return null;
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }		
    }	
    transf_movivel(el) {
        try{
            fnjs.logi(this.constructor.name,"transf_movivel");
            if (fnjs.obterJquery(el).length) {
                let indcnj = this.obter_indcnjmov(el);
                this.cnjsmovs[indcnj] = el;
                [].forEach.call(this.cnjsmovs[indcnj], function(col) {
                    col.classList.add(fnhtml.classes.movivel);
                    col.setAttribute('draggable',true);
                    col.addEventListener('dragstart', fnhtml.handleDragStart, false);
                    col.addEventListener('dragenter', fnhtml.handleDragEnter, false);
                    col.addEventListener('dragover', fnhtml.handleDragOver, false);
                    col.addEventListener('dragleave', fnhtml.handleDragLeave, false);
                    col.addEventListener('drop', fnhtml.handleDrop, false);
                    col.addEventListener('dragend', fnhtml.handleDragEnd, false);
                });			
            }
            fnjs.logf(this.constructor.name,"transf_movivel");
        }catch(er){
            console.log(er);
            alert(er.message || er);
        }		
    }
};	

var fnhtml = new FuncoesHtml();

window.fnhtml = fnhtml;

export { fnhtml };