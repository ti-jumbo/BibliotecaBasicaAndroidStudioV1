package com.bibliotecas.bibliotecabasicav1.classesbasicas.menu;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.cardview.widget.CardView;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class MenuBase extends ClasseBase {
    private String cnome = "MenuBase";
    public ViewGroup layoutViewMenu = null;
    public CardView cardView = null;
    public TextView textViewTitMenu = null;
    public LinearLayout layoutItens = null;
    private MenuBase menuBaseVisivelAnterior = null;

    public MenuBase(Context pContexto, ViewGroup parent) {
        super(pContexto);
        String fnome = "MenuBase";
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        LayoutInflater inflater = LayoutInflater.from(pContexto);
        this.layoutViewMenu = (ViewGroup) inflater.inflate(R.layout.base_menu,parent,false);
        this.layoutViewMenu.setId(View.generateViewId());
        parent.addView(this.layoutViewMenu);
        this.esconder();
        this.layoutViewMenu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                v.setVisibility(View.INVISIBLE);
            }
        });
        this.cardView = this.layoutViewMenu.findViewById(R.id.layout_base_menu_interno);
        this.textViewTitMenu = this.layoutViewMenu.findViewById(R.id.text_view_tit_menu);
        this.layoutItens = this.layoutViewMenu.findViewById(R.id.layout_itens_menu);
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void setTitulo(String pTitulo) {
        String fnome = "setTitulo";
        objs.funcoesBasicas.logi(cnome,fnome);
        if (this.textViewTitMenu != null) {
            this.textViewTitMenu.setText(pTitulo);
        }
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void adicionar_item(View item) {
        this.adicionar_item(item,this.layoutItens.getChildCount());
    }

    public void adicionar_item(View item, int indice) {
        String fnome = "adicionar_item";
        objs.funcoesBasicas.logi(cnome,fnome);
        if (this.layoutItens != null) {
            this.layoutItens.addView(item,indice);
        }
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void mostrar(){
        String fnome = "mostrar";
        objs.funcoesBasicas.logi(cnome,fnome);
        this.layoutViewMenu.setVisibility(View.VISIBLE);
        this.layoutViewMenu.bringToFront();
        this.layoutItens.setVisibility(View.VISIBLE);
        this.layoutItens.bringToFront();
        this.layoutViewMenu.getParent().bringChildToFront(this.layoutViewMenu);
        this.layoutItens.getParent().bringChildToFront(this.layoutItens);
        ((View)layoutViewMenu.getParent()).requestLayout();
        ((View)layoutViewMenu.getParent()).invalidate();
        this.menuBaseVisivelAnterior = this.objs.variaveisBasicas.getMenuBaseVisivel();
        this.objs.variaveisBasicas.setMenuBaseVisivel(this);
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void esconder(){
        String fnome = "esconder";
        objs.funcoesBasicas.logi(cnome,fnome);
        this.layoutViewMenu.setVisibility(View.INVISIBLE);
        this.objs.variaveisBasicas.setMenuBaseVisivel(this.menuBaseVisivelAnterior);
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public int getVisivel(){
        return this.layoutViewMenu.getVisibility();
    }

    public LinearLayout getLayoutItens(){
        return this.layoutItens;
    }
    public void setMargens(int mLeft,int mTop,int mRight,int mBottom){
        FrameLayout.LayoutParams fl = new FrameLayout.LayoutParams(FrameLayout.LayoutParams.MATCH_PARENT,FrameLayout.LayoutParams.MATCH_PARENT);
        fl.setMargins(mLeft,mTop,mRight,mBottom);
        this.cardView.setLayoutParams(fl);
    }
}