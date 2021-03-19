package com.bibliotecas.bibliotecabasicav1.classesbasicas.treeview;

import android.content.Context;
import android.content.res.ColorStateList;
import android.graphics.Color;
import android.os.Build;
import android.util.TypedValue;
import android.view.Gravity;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.Checkable;
import android.widget.CompoundButton;
import android.widget.LinearLayout;
import android.widget.ScrollView;
import android.widget.TextView;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class TreeView extends LinearLayout {

    private boolean checavel = false;
    private TCnjChaveValorTree itens = null;
    private ScrollView scrollView = null;
    private LinearLayout layoutContainer = null;
    private CheckBox botaoSelecionarTodos = null;
    private MenuItem botaoSelecionarTodosMenuItem = null;
    private Checkable botaoSelecionarTodosCheckable = null;
    private static int tamanhoBotaoAbrir = 60;
    private int tamanhoTexto = 25;
    private boolean selecionarTodos = false;
    private boolean criacaoInicial = true;
    private boolean textoClicavel = true;
    private static boolean marcacaoHabilitada = true;
    protected ObjetosBasicos objs = null;

    public static class TChaveValorTree extends Tipos.TChaveValor implements OnClickListener, CompoundButton.OnCheckedChangeListener {
        public String texto = null;
        public boolean marcado = false;
        public boolean habilitado = true;
        public boolean aberto = false;
        public Method aoAbrir = null;
        public Object objetoAoAbrir = null;
        public Method metodoAoSelecionar = null;
        public Object objetoAoSelecionar = null;
        public Object dados = null;
        public LinearLayout layout = null;
        public LinearLayout layoutCab = null;
        public LinearLayout layoutCorpo = null;
        public TreeView treeView;
        public Button btnAbrir = null;
        public TCnjChaveValorTree itens = null;
        private CheckBox checkBox = null;
        private TChaveValorTree itemSup = null;

        public TChaveValorTree(String vchave, Object vvalor ) {
            super(vchave, vvalor);
            this.texto = vchave;
            this.itens = new TCnjChaveValorTree();
        }

        public void criarLinhaCorpo(){
            this.layoutCorpo = new LinearLayout(this.treeView.getContext());
            LayoutParams lp = new LayoutParams(LayoutParams.MATCH_PARENT,0);
            lp.setMargins(50,0,0,0);
            this.layoutCorpo.setLayoutParams(lp);
            this.layoutCorpo.setOrientation(LinearLayout.VERTICAL);
            this.layoutCorpo.setVisibility(View.INVISIBLE);
            this.layout.addView(this.layoutCorpo);

        }

        public void criarLinhaCab(){
            this.layoutCab = new LinearLayout(this.treeView.getContext());
            this.layoutCab.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT));
            this.layoutCab.setOrientation(LinearLayout.HORIZONTAL);
            this.layout.addView(this.layoutCab);
        }

        public void criarBotaoAbrirItem(){
            this.btnAbrir = new Button(this.treeView.getContext());
            this.btnAbrir.setTag("fechado");
            LayoutParams lp = new LayoutParams(TreeView.getTamanhoBotaoAbrir(), TreeView.getTamanhoBotaoAbrir());
            lp.gravity = Gravity.CENTER_VERTICAL;
            lp.setMargins(10,0,10,0);
            this.btnAbrir.setLayoutParams(lp);
            this.btnAbrir.setBackgroundResource(R.drawable.ic_add_black_24dp);
            this.btnAbrir.setOnClickListener(this);
            this.layoutCab.addView(this.btnAbrir);
        }

        public void criarCheckBoxItem(){
            CheckBox ch = new CheckBox(this.treeView.getContext());
            LayoutParams lp = new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT);
            lp.gravity = Gravity.CENTER_VERTICAL;
            lp.setMargins(10,0,10,0);
            ch.setLayoutParams(lp);
            ch.setChecked(this.marcado);
            if (this.habilitado) {
                ColorStateList colorStateList = new ColorStateList(
                        new int[][]{
                                new int[]{-android.R.attr.state_checked}, // unchecked
                                new int[]{android.R.attr.state_checked}  // checked
                        },
                        new int[]{
                                Color.RED,
                                Color.GRAY
                        }
                );
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                    ch.setButtonTintList(colorStateList);
                } else {
                    //ch.setButtonTintList(colorStateList); encontrar metodo correto para versoes api abaixo e 21
                }
            } else {
                ColorStateList colorStateList = new ColorStateList(
                        new int[][]{
                                new int[]{-android.R.attr.state_checked}, // unchecked
                                new int[]{android.R.attr.state_checked}  // checked
                        },
                        new int[]{
                                Color.RED,
                                Color.LTGRAY
                        }
                );
                if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
                    ch.setButtonTintList(colorStateList);
                } else {
                    //ch.setButtonTintList(colorStateList); encontrar metodo correto para versoes api abaixo e 21
                }
            }
            ch.setOnClickListener(this);
            ch.setOnCheckedChangeListener(this);
            ch.setEnabled(this.habilitado);
            this.layoutCab.addView(ch);
            this.checkBox = ch;
        }

        public void criarTextoItem(){
            TextView t = new TextView(this.treeView.getContext());
            LayoutParams lp = new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT);
            lp.gravity = Gravity.CENTER_VERTICAL;
            lp.setMargins(10,0,10,0);
            t.setLayoutParams(lp);
            t.setTextSize(TypedValue.COMPLEX_UNIT_SP, this.treeView.getTamanhoTexto());
            t.setText(this.chave);
            if (this.treeView.textoClicavel == true) {
                t.setOnClickListener(this);
            }
            this.layoutCab.addView(t);
        }

        public void preencher_linha_cab(){
            this.criarBotaoAbrirItem();
            this.criarCheckBoxItem();
            this.criarTextoItem();
        }

        public void criarLinhaItem(LinearLayout container){
            this.layout = new LinearLayout(this.treeView.getContext());
            this.layout.setOrientation(LinearLayout.VERTICAL);
            this.layout.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT,LayoutParams.WRAP_CONTENT));
            this.layout.setTag(this);
            this.criarLinhaCab();
            this.criarLinhaCorpo();
            this.preencher_linha_cab();
            container.addView(this.layout);
        }

        public void esconderSub(){
            LayoutParams lp = (LayoutParams) this.layoutCorpo.getLayoutParams();
            lp.height = 0;
            this.layoutCorpo.setLayoutParams(lp);
            this.layoutCorpo.setVisibility(View.INVISIBLE);
        }
        public void mostrarSub(){
            LayoutParams lp = (LayoutParams) this.layoutCorpo.getLayoutParams();
            lp.height = LayoutParams.WRAP_CONTENT;
            lp.setMargins(50,0,0,0);
            this.layoutCorpo.setLayoutParams(lp);
            this.layoutCorpo.setVisibility(View.VISIBLE);
            if (this.aoAbrir != null) {
                try {
                    this.aoAbrir.invoke(this.objetoAoAbrir,this);
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                } catch (InvocationTargetException e) {
                    e.printStackTrace();
                }
            }
        }

        public void processarAbrirFechar(){
            if (this.aberto == false) {
                this.aberto = true;
                this.btnAbrir.setBackgroundResource(R.drawable.ic_remove_black_24dp);
                this.mostrarSub();
            } else {
                this.aberto = false;
                this.btnAbrir.setBackgroundResource(R.drawable.ic_add_black_24dp);
                this.esconderSub();
            }
        }

        public void adicionarSub(TChaveValorTree itemSub) {
            itemSub.treeView = this.treeView;
            itemSub.criarLinhaItem(this.layoutCorpo);
            itemSub.itemSup = this;
            this.itens.add(itemSub);
        }

        @Override
        public void onClick(View v) {
            String c = v.getClass().getName().toLowerCase();
            if (c.contains("button")) {
                this.processarAbrirFechar();
            } else if (c.contains("textview") && this.treeView.textoClicavel == true && marcacaoHabilitada) {
                this.checkBox.performClick();
            } else if (c.contains("checkbox")) {
                this.treeView.verificarSelecionouTodos();
            }
        }

        public int contarSubElementosChecaveis(){
            int retorno = 0;
            int qt = this.itens.size();
            TChaveValorTree itemSub = null;
            for (int i = 0; i < qt; i++) {
                itemSub = (TChaveValorTree) this.itens.get(i);
                if (itemSub.checkBox.isEnabled()) {
                    retorno ++;
                }
            }
            return retorno;
        }

        public int contarSubElementosChecados(){
            int retorno = 0;
            int qt = this.itens.size();
            TChaveValorTree itemSub = null;
            for (int i = 0; i < qt; i++) {
                itemSub = (TChaveValorTree) this.itens.get(i);
                if (itemSub.checkBox.isEnabled()) {
                    if (itemSub.checkBox.isChecked()) {
                        retorno++;
                    }
                }
            }
            return retorno;
        }

        public void marcarSubs(boolean isChecked){
            int qt = this.itens.size();
            TChaveValorTree itemSub = null;
            for (int i = 0; i < qt; i++) {
                itemSub = (TChaveValorTree) this.itens.get(i);
                itemSub.checkBox.setTag("subordinado");
                itemSub.checkBox.setChecked(isChecked);
                itemSub.checkBox.setTag(null);
            }
        }

        public void processarSelecaoSuperior(boolean isChecked) {
            if (this.itemSup != null) {
                if (isChecked == true) {
                    if (this.itemSup.contarSubElementosChecados() < this.itemSup.contarSubElementosChecaveis()) {
                        this.itemSup.checkBox.setTag("superior");
                        this.itemSup.checkBox.setChecked(false);
                        this.itemSup.checkBox.setTag(null);
                    } else {
                        this.itemSup.checkBox.setTag("superior");
                        this.itemSup.checkBox.setChecked(isChecked);
                        this.itemSup.checkBox.setTag(null);
                    }
                } else {
                    this.itemSup.checkBox.setTag("superior");
                    this.itemSup.checkBox.setChecked(false);
                    this.itemSup.checkBox.setTag(null);
                }
            }
        }

        public void processarSelecao(CompoundButton buttonView, boolean isChecked, boolean processarSubs, boolean processarSups ) {
            if (processarSubs == true) {
                this.marcarSubs(isChecked);
            }
            if (processarSups == true) {
                this.processarSelecaoSuperior(isChecked);
            }
        }

        public void desabilitarSubs(){
            int qt = this.itens.size();
            TChaveValorTree itemSub = null;
            for (int i = 0; i < qt; i++) {
                itemSub = (TChaveValorTree) this.itens.get(i);
                itemSub.btnAbrir.setEnabled(false);
                itemSub.checkBox.setEnabled(false);
                itemSub.desabilitarSubs();
            }
        }

        public void habilitarSubs(){
            int qt = this.itens.size();
            TChaveValorTree itemSub = null;
            for (int i = 0; i < qt; i++) {
                itemSub = (TChaveValorTree) this.itens.get(i);
                itemSub.btnAbrir.setEnabled(true);
                itemSub.checkBox.setEnabled(true);
                itemSub.habilitarSubs();
            }
        }

        @Override
        public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
            this.marcado = isChecked;
            if (buttonView.getTag() == null) {
                buttonView.setTag("processando");
                this.processarSelecao(buttonView, isChecked, true, true);
                buttonView.setTag(null);
            } else if (buttonView.getTag().toString().equals("superior")) {
                this.processarSelecao(buttonView, isChecked, false, true);
                buttonView.setTag(null);
            } else if (buttonView.getTag().toString().equals("subordinado")) {
                this.processarSelecao(buttonView, isChecked, true, false);
                buttonView.setTag(null);
            } else if (buttonView.getTag().toString().equals("selecionar todos")) {
                //this.marcarElementos(this, isChecked);
            }
            if (this.metodoAoSelecionar != null) {
                try {
                    this.metodoAoSelecionar.invoke(this.objetoAoSelecionar,this);
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                } catch (InvocationTargetException e) {
                    e.printStackTrace();
                }
            }
        }
    }

    public static class TCnjChaveValorTree extends Tipos.TCnjChaveValor {
        public TCnjChaveValorTree() {
            super();
        }
    }

    public TreeView(Context context, ViewGroup container) {
        super(context);
        this.setId(objs.funcoesObjeto.gerarIdView());
        objs = ObjetosBasicos.getInstancia(context);
        this.layoutContainer = new LinearLayout(getContext());
        this.layoutContainer.setId(objs.funcoesObjeto.gerarIdView());
        this.layoutContainer.setOrientation(LinearLayout.VERTICAL);
        this.layoutContainer.setLayoutParams(new ConstraintLayout.LayoutParams(ConstraintLayout.LayoutParams.MATCH_PARENT,ConstraintLayout.LayoutParams.MATCH_PARENT));
        container.addView(this.layoutContainer);

        this.scrollView = new ScrollView(getContext());
        this.scrollView.setId(objs.funcoesObjeto.gerarIdView());
        this.scrollView.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT));
        this.layoutContainer.addView(this.scrollView);

        this.setOrientation(LinearLayout.VERTICAL);
        this.setLayoutParams(new ScrollView.LayoutParams(ScrollView.LayoutParams.MATCH_PARENT,ScrollView.LayoutParams.WRAP_CONTENT));
        this.scrollView.addView(this);
        this.itens = new TCnjChaveValorTree();
    }

    /*Inicio Area de getters e setters*/

    public boolean isChecavel() {
        return checavel;
    }

    public void setChecavel(boolean checavel) {
        this.checavel = checavel;
    }

    public TCnjChaveValorTree getItens() {
        return itens;
    }

    public void setItens(TCnjChaveValorTree itens) {
        this.itens = itens;
    }

    public static int getTamanhoBotaoAbrir() {
        return tamanhoBotaoAbrir;
    }

    public void setTamanhoBotaoAbrir(int tamanhoBotaoAbrir) {
        this.tamanhoBotaoAbrir = tamanhoBotaoAbrir;
    }

    public int getTamanhoTexto() {
        return tamanhoTexto;
    }

    public void setTamanhoTexto(int tamanhoTexto) {
        this.tamanhoTexto = tamanhoTexto;
    }

    public void setSelecionarTodos(boolean selecionarTodos) {
        this.selecionarTodos = selecionarTodos;
    }

    public boolean getSelecionarTodos() {
        return selecionarTodos;
    }

    public CheckBox getBotaoSelecionarTodos() {
        return botaoSelecionarTodos;
    }

    public void setBotaoSelecionarTodos(CheckBox botaoSelecionarTodos,boolean checkado) {
        botaoSelecionarTodos.setTag("selecionar todos");
        botaoSelecionarTodos.setOnClickListener(new OnClickListener() {
            @Override
            public void onClick(View v) {
                if (marcacaoHabilitada == true) {
                    CheckBox ch = (CheckBox) v;
                    boolean checado = ch.isChecked();
                    marcarElementos(checado);
                }
            }
        });
        this.botaoSelecionarTodos = botaoSelecionarTodos;
        botaoSelecionarTodos.setChecked(checkado);
    }

    public void setBotaoSelecionarTodos(MenuItem botaoSelecionarTodos, boolean checkado) {
        if (botaoSelecionarTodos != null) {
            botaoSelecionarTodos.getActionView().setOnClickListener(new OnClickListener() {
                @Override
                public void onClick(View v) {
                    if (marcacaoHabilitada == true) {
                        CheckBox ch = (CheckBox) v;
                        boolean checado = ch.isChecked();
                        marcarElementos(checado);
                    }
                }
            });
            this.botaoSelecionarTodosMenuItem = botaoSelecionarTodos;
            botaoSelecionarTodos.setChecked(checkado);
        } else {
        }
    }

    public int contarElementosChecaveis() {
        int retorno = 0;
        if (this.isChecavel()) {
            retorno = this.itens.size();
        }
        return retorno;
    }

    public int contarElementosChecados() {
        int retorno = 0;
        if (this.isChecavel()) {
            int qt = this.itens.size();
            for (int i = 0; i < qt; i++) {
                if (((TChaveValorTree) this.itens.get(i)).marcado == true) {
                    retorno ++;
                }
            }
        }
        return retorno;
    }

    public void verificarSelecionouTodos(){
        if (this.contarElementosChecaveis() == this.contarElementosChecados()) {
            if (this.botaoSelecionarTodos != null) {
                this.botaoSelecionarTodos.setChecked(true);
            } else if (this.botaoSelecionarTodosMenuItem != null) {
                ((CheckBox)this.botaoSelecionarTodosMenuItem.getActionView()).setChecked(true);
            }
        } else {
            if (this.botaoSelecionarTodos != null) {
                this.botaoSelecionarTodos.setChecked(false);
            } else if (this.botaoSelecionarTodosMenuItem != null) {
                ((CheckBox)this.botaoSelecionarTodosMenuItem.getActionView()).setChecked(false);
            }
        }
    }

    public void marcarElementos(boolean status) {
        if (this.isChecavel()) {
            int qt = this.itens.size();
            for (int i = 0; i < qt; i++) {
                ((TChaveValorTree)this.itens.get(i)).checkBox.setChecked(status);
            }
        }
    }

    public void adicionarItem(TChaveValorTree itemSup, TChaveValorTree item) {
        LinearLayout container = null;
        if (itemSup == null) {
            container = this;
        } else {
            container = itemSup.layout;
        }
        item.treeView = this;
        item.criarLinhaItem(container);
        this.itens.add(item);
    }

    public static boolean isMarcacaoHabilitada() {
        return marcacaoHabilitada;
    }

    public static void setMarcacaoHabilitada(boolean marcacaoHabilitada) {
        TreeView.marcacaoHabilitada = marcacaoHabilitada;
    }

    private void _desabilitarBotoes(){
        this.marcacaoHabilitada = false;
        if (this.botaoSelecionarTodos != null) {
            this.botaoSelecionarTodos.setEnabled(false);
        }
        if (this.botaoSelecionarTodosMenuItem != null) {
            this.botaoSelecionarTodosMenuItem.setVisible(false);
        }
        int qt = this.getItens().size();
        for (int i = 0 ; i < qt; i++) {
            ((TChaveValorTree)this.itens.get(i)).btnAbrir.setEnabled(false);
            ((TChaveValorTree)this.itens.get(i)).checkBox.setEnabled(false);
            ((TChaveValorTree)this.itens.get(i)).desabilitarSubs();
        }
    }

    public void desabilitarBotoes() {
        _desabilitarBotoes();
    }

    public void _habilitarBotoes() {
        this.marcacaoHabilitada = true;
        if (this.botaoSelecionarTodos != null) {
            this.botaoSelecionarTodos.setEnabled(true);
        }
        if (this.botaoSelecionarTodosMenuItem != null) {
            this.botaoSelecionarTodosMenuItem.setVisible(true);
            this.verificarSelecionouTodos();
        }
        int qt = this.getItens().size();
        for (int i = 0 ; i < qt; i++) {
            ((TChaveValorTree)this.itens.get(i)).btnAbrir.setEnabled(true);
            ((TChaveValorTree)this.itens.get(i)).checkBox.setEnabled(true);
            ((TChaveValorTree)this.itens.get(i)).habilitarSubs();
        }
    }

    public void habilitarBotoes() {
        try {
            this.objs.variaveisBasicas.getActivityPrincipal().executar_ui(this.getClass().getMethod("_habilitarBotoes"),this);
        } catch (NoSuchMethodException e) {
            e.printStackTrace();
        }
    }
}
