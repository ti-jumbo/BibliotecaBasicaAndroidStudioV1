package com.bibliotecas.bibliotecabasicav1.classesbasicas.graficos;

import android.content.Context;
import android.graphics.Color;
import android.view.View;
import android.view.ViewGroup;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.ConstraintSet;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesGrafico;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import org.json.JSONArray;

public class GraficoBase extends ConstraintLayout {
    private String cnome = "GraficoBase";
    public ConstraintLayout layout;
    public Float alturaTela;
    public Float larguraTela;
    public Float alturaGrafico;
    public Float larguraGrafico;
    public Float alturaInternaGrafico;
    public Float larguraInternaGrafico;
    public Float menorDimensao = 0f;
    public int menorDimensaoInt = 0;
    public Float espessuraContorno = 5f;
    public Float margemRetangular = 50f;
    public Integer cor_contorno = Color.BLACK;
    public Integer cor_fundo = Color.WHITE;
    public Integer cor_preenchimento = Color.BLACK;
    public ViewGroup viewContainer;
    public JSONArray matrizDados;
    public Tipos.TCnjChaveValor condicionantes_grafico = null;
    public ConstraintLayout layoutInterno;
    int maior = 0;
    float menor = 0;
    public ConstraintSet csLayoutInterno = null;
    protected ObjetosBasicos objs = null;
    protected Context contexto = null;
    protected FuncoesGrafico funcoesGrafico = null;

    public GraficoBase(Context context) {
        super(context);
        String fnome = "GraficoBase";
        contexto = context;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        this.funcoesGrafico = FuncoesGrafico.getInstancia(contexto);
        this.inicializar();
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public GraficoBase(Context context, ViewGroup view_container) {
        super(context);
        String fnome = "GraficoBase";
        objs.funcoesBasicas.logi(cnome,fnome);
        this.viewContainer = view_container;
        this.inicializar();
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public void inicializar(){
        String fnome = "inicializar";
        objs.funcoesBasicas.logi(cnome,fnome);
        this.setId(View.generateViewId());
        LayoutParams l = new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT);
        this.setLayoutParams(l);
        this.setBackgroundColor(Color.YELLOW);
        this.margemRetangular = 50f;
        this.espessuraContorno = 5f;
        this.cor_contorno = Color.BLACK;
        this.cor_fundo = Color.WHITE;
        this.cor_preenchimento = Color.RED;
        this.setBackgroundColor(this.cor_fundo);
        this.alturaTela = Float.valueOf(this.objs.funcoesTela.getScreenHeight());
        this.larguraTela = Float.valueOf(this.objs.funcoesTela.getScreenWidth());
        this.alturaGrafico = this.alturaTela - this.objs.variaveisBasicas.getActivityPrincipal().getActionBarHeight();//150; //ACTION BAR
        objs.funcoesBasicas.log("alturas: " + this.alturaGrafico + " " + this.alturaTela);
        this.larguraGrafico = this.larguraTela ;
        this.alturaInternaGrafico = this.alturaGrafico - (this.margemRetangular * 2);
        this.larguraInternaGrafico = this.larguraGrafico - (this.margemRetangular * 2);
        this.menorDimensao = this.objs.funcoesMatematica.menorValor(this.alturaInternaGrafico,this.larguraInternaGrafico);
        this.menorDimensaoInt = Math.round(this.menorDimensao);
        this.layout = this;
        objs.funcoesBasicas.logf(cnome,fnome);
    }
}
