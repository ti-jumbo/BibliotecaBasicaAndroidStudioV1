package com.bibliotecas.bibliotecabasicav1.classesbasicas.graficos;

import android.content.Context;
import android.graphics.Color;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.HorizontalScrollView;
import android.widget.LinearLayout;
import android.widget.ScrollView;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.ConstraintSet;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenho;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoBarraTexto;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoLegendaEixo;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoLinha;

import org.json.JSONArray;

import java.util.ArrayList;

public class GraficoBarras extends GraficoBase {
    private String cnome = "GraficoBarras";
    public Float areaEsquerdaUtilizada = 0f;
    public Float areaDireitaUtilizada = 0f;
    public Float areaSuperiorUtilizada = 0f;
    public Float espacoEsquerdoEixoY = 50f;
    public Float espacoInferiorEixoX = 50f;
    public Float espacoSuperiorEixoSuperior = 50f;
    public Float espacoEntreBarras = 20f;
    public int espacoEntreBarrasInt = 20;
    public Float larguraCnjBarra = 20f;
    public Float larguraBarra = 20f;
    public Float larguraMinBarra = 45f;
    public int larguraBarraInt = 0;
    public Integer corBarra = Color.BLUE;
    public Integer qtBarras = 0;
    public ViewDesenho eixoX;
    public ViewDesenho eixoY;
    public int idUltBarraCriada;
    public int orientacao = 0;
    public int gravidade = 0;
    public int espessuraLinhaGrade = 2;
    public int corLinhaGrade = getResources().getColor(R.color.cinzatransp);
    public HorizontalScrollView scrollHorizontall;
    public ScrollView scrollVertical;
    public FrameLayout scroll;
    public LinearLayout layoutScroll;
    public int extensao;
    public int posBaseBarras = 0;
    public Float espacoInternoBarras = 0f;

    public GraficoBarras(Context context, ViewGroup view_container, int orientacao, int gravidade) {
        super(context,view_container);
        String fnome = "GraficoBarras";
        objs.funcoesBasicas.logi(cnome,fnome);
        this.areaEsquerdaUtilizada = 0f;
        this.espacoEsquerdoEixoY = 50f;
        this.espacoInferiorEixoX = 50f;
        this.espacoEntreBarras = 20f;
        this.larguraBarra = 20f;
        this.corBarra = Color.BLUE;
        this.orientacao = orientacao;
        this.gravidade = gravidade;
        this.layoutScroll = new LinearLayout(this.getContext());
        this.layoutScroll.setId(View.generateViewId());
        this.layoutScroll.setOrientation(orientacao);
        this.layoutScroll.setGravity(gravidade);
        this.layoutInterno = new ConstraintLayout(this.getContext());
        this.layoutInterno.setId(View.generateViewId());
        if (orientacao == LayoutParams.HORIZONTAL) {
            this.scrollHorizontall = new HorizontalScrollView(this.getContext());
            this.scrollHorizontall.setId(View.generateViewId());
            this.scrollHorizontall.setForegroundGravity(gravidade);
            this.scrollHorizontall.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT));
            this.scroll = this.scrollHorizontall;
            this.layoutScroll.setLayoutParams(new ScrollView.LayoutParams(ScrollView.LayoutParams.WRAP_CONTENT,ScrollView.LayoutParams.MATCH_PARENT));
            this.layoutInterno.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.WRAP_CONTENT,LinearLayout.LayoutParams.MATCH_PARENT));
        } else {
            this.scrollVertical = new ScrollView(this.getContext());
            this.scrollVertical.setId(View.generateViewId());
            this.scrollVertical.setForegroundGravity(gravidade);
            this.scrollVertical.setLayoutParams(new LayoutParams(LayoutParams.MATCH_PARENT, LayoutParams.MATCH_PARENT));
            this.scroll = this.scrollVertical;
            this.layoutScroll.setLayoutParams(new ScrollView.LayoutParams(ScrollView.LayoutParams.MATCH_PARENT,ScrollView.LayoutParams.WRAP_CONTENT));
            this.layoutInterno.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT,LinearLayout.LayoutParams.WRAP_CONTENT));
        }

        this.layoutScroll.addView(this.layoutInterno);
        this.layoutScroll.bringToFront();
        this.layoutInterno.bringToFront();

        if (orientacao == LayoutParams.HORIZONTAL) {
            this.scrollHorizontall.addView(this.layoutScroll);
            this.addView(this.scrollHorizontall);

            ConstraintSet cs = new ConstraintSet();
            cs.clone(this);
            cs.connect(this.scrollHorizontall.getId(), ConstraintSet.TOP, this.getId(), ConstraintSet.TOP, this.margemRetangular.intValue());
            cs.connect(this.scrollHorizontall.getId(), ConstraintSet.LEFT, this.getId(), ConstraintSet.LEFT, this.margemRetangular.intValue());
            cs.connect(this.scrollHorizontall.getId(), ConstraintSet.RIGHT, this.getId(), ConstraintSet.RIGHT, this.margemRetangular.intValue());
            cs.connect(this.scrollHorizontall.getId(), ConstraintSet.BOTTOM, this.getId(), ConstraintSet.BOTTOM, 0);
            cs.applyTo(this);
        } else {
            this.scrollVertical.addView(this.layoutScroll);
            this.addView(this.scrollVertical);

            ConstraintSet cs = new ConstraintSet();
            cs.clone(this);
            cs.connect(this.scrollVertical.getId(), ConstraintSet.TOP, this.getId(), ConstraintSet.TOP, this.margemRetangular.intValue());
            cs.connect(this.scrollVertical.getId(), ConstraintSet.LEFT, this.getId(), ConstraintSet.LEFT, 0);
            cs.connect(this.scrollVertical.getId(), ConstraintSet.RIGHT, this.getId(), ConstraintSet.RIGHT, this.margemRetangular.intValue());
            cs.connect(this.scrollVertical.getId(), ConstraintSet.BOTTOM, this.getId(), ConstraintSet.BOTTOM, this.margemRetangular.intValue());
            cs.applyTo(this);
        }
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    public ViewDesenho criarEixoY(){
        this.eixoY = new ViewDesenho(getContext(), 5 ,(int) (this.alturaGrafico - 10),this.cor_contorno);
        this.layout.addView(this.eixoY);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(this.eixoY.getId(), ConstraintSet.LEFT,this.layout.getId(), ConstraintSet.LEFT,this.espacoEsquerdoEixoY.intValue());
        cs.connect(this.eixoY.getId(), ConstraintSet.BOTTOM,this.layout.getId(), ConstraintSet.BOTTOM,5);
        cs.applyTo(this.layout);
        return this.eixoY;
    }

    public ViewDesenho criarEixoX(){
        this.eixoX = new ViewDesenho(getContext(), (int) (this.larguraGrafico - 10),this.espessuraContorno.intValue() ,this.cor_contorno);
        this.layout.addView(this.eixoX);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(this.eixoX.getId(), ConstraintSet.LEFT,this.layout.getId(), ConstraintSet.LEFT,5);
        cs.connect(this.eixoX.getId(), ConstraintSet.BOTTOM,this.layout.getId(), ConstraintSet.BOTTOM,this.espacoInferiorEixoX.intValue());
        cs.applyTo(this.layout);
        this.posBaseBarras = (int) (this.espacoInferiorEixoX + this.espessuraContorno);
        return this.eixoX;
    }

    public ViewDesenhoBarraTexto criarBarra(int pValor, String legenda, JSONArray dados, int indiceBarra, int corBarra) {
        ViewDesenhoBarraTexto retorno = null;
        retorno = new ViewDesenhoBarraTexto(getContext(),this.larguraBarraInt, pValor,corBarra,legenda);
        this.layoutInterno.addView(retorno);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.BOTTOM,this.layoutInterno.getId(), ConstraintSet.BOTTOM, this.posBaseBarras);
        if (indiceBarra == 0) {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.LEFT, this.espacoEntreBarrasInt);
        } else {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.RIGHT, this.espacoEntreBarrasInt);
        }
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = retorno.getId();
        retorno.dados = dados;
        return retorno;
    }

    public void criarLegendaEixoX(String legenda, int indiceBarra) {
        ViewDesenhoLegendaEixo v = null;
        v = new ViewDesenhoLegendaEixo(getContext(),this.larguraBarraInt, 20,getResources().getColor(R.color.azultransp),legenda);
        this.layoutInterno.addView(v);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(v.getId(), ConstraintSet.BOTTOM,this.layoutInterno.getId(), ConstraintSet.BOTTOM, this.posBaseBarras);
        if (indiceBarra == 0) {
            this.csLayoutInterno.connect(v.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.LEFT, this.espacoEntreBarrasInt);
        } else {
            this.csLayoutInterno.connect(v.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.RIGHT, this.espacoEntreBarrasInt);
        }
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = v.getId();
    }

    public void criarLegendasEixoY() {
        String fnome = "criarLegendasEixoY";
        objs.funcoesBasicas.logi(cnome,fnome);
        int qtCaractMaiorInt = 0;
        int multiplicadorEscala = 0;
        int maiorEscala = 0;
        int valorEscala = 1;
        int multiplicanteEscala = 1;
        int qtEscalas = 0;
        Float alturaRealMaiorEscala = 0f;
        ViewDesenho leg = null;
        qtCaractMaiorInt = String.valueOf(this.extensao).length();
        multiplicadorEscala = qtCaractMaiorInt / 3;
        if (multiplicadorEscala * 3 == qtCaractMaiorInt ) {
            multiplicadorEscala = multiplicadorEscala - 1;
        }
        objs.funcoesBasicas.log("maiorInt",this.extensao,String.valueOf(this.extensao),qtCaractMaiorInt,multiplicadorEscala);
        maiorEscala = Integer.valueOf(String.valueOf(this.extensao).substring(0,qtCaractMaiorInt - (multiplicadorEscala * 3)));

        if (maiorEscala <= 10 ) {
            valorEscala = 1;
        } else if (maiorEscala < 60) {
            valorEscala = (maiorEscala / 10) + 1;
        } else if (maiorEscala <= 100 ) {
            valorEscala = 10;
        } else if (maiorEscala < 600) {
            valorEscala = (maiorEscala / 10) + 10;
        } else {
            valorEscala = 100;
        }
        qtEscalas = Math.round(maiorEscala / valorEscala);

        String strGrauEscala = "";
        switch (multiplicadorEscala) {
            case 1:
                multiplicanteEscala = 1000;
                strGrauEscala = "k";
                break;
            case 2:
                multiplicanteEscala = 1000000;
                strGrauEscala = "M";
                break;
            default:
                multiplicanteEscala = 1;
                strGrauEscala = "";
                break;
        }
        alturaRealMaiorEscala = qtEscalas * valorEscala * multiplicanteEscala * (this.espacoInternoBarras) / this.extensao;
        Float alturaEscala = alturaRealMaiorEscala / qtEscalas;
        objs.funcoesBasicas.log("maiorInt",this.extensao,"maiorEscala",maiorEscala,"multiplicadorEscala",multiplicadorEscala,"strgrauescala",strGrauEscala,"multiplicante",multiplicanteEscala,"valorescala",valorEscala,"qtEscalas",qtEscalas,"extensao",extensao,"alturaintena",(this.alturaInternaGrafico - this.margemRetangular),"alturareal",alturaRealMaiorEscala);
        ViewDesenhoLegendaEixo v = null;
        ViewDesenhoLinha vl = null;
        int corFundo = getResources().getColor(R.color.azultransp);

        ConstraintSet cs = new ConstraintSet();
        String texto = "";
        for (int i = 1; i <= qtEscalas + 1; i++) {
            texto = String.valueOf(Math.round(valorEscala) * i)  + strGrauEscala;
            v = new ViewDesenhoLegendaEixo(getContext(), this.espacoEsquerdoEixoY.intValue(),20,corFundo,texto);
            this.layout.addView(v);
            cs.clone(this.layout);
            cs.connect(v.getId(), ConstraintSet.RIGHT,this.eixoY.getId(), ConstraintSet.LEFT,0);
            cs.connect(v.getId(), ConstraintSet.BOTTOM,this.eixoX.getId(), ConstraintSet.TOP,Math.round(i * alturaEscala) - 8);
            cs.applyTo(this.layout);
            vl = new ViewDesenhoLinha(getContext(),this.larguraInternaGrafico.intValue(),this.espessuraLinhaGrade,this.corLinhaGrade);
            this.layout.addView(vl);
            cs.clone(this.layout);
            cs.connect(vl.getId(), ConstraintSet.LEFT,this.eixoY.getId(), ConstraintSet.RIGHT,0);
            cs.connect(vl.getId(), ConstraintSet.BOTTOM,this.eixoX.getId(), ConstraintSet.TOP, Math.round(i * alturaEscala) - this.espessuraLinhaGrade);
            cs.applyTo(this.layout);
        }
    }

    public void criarGraficoBarras(JSONArray matrizDados) {
        try {
            String fnome = "criarGraficoBarras";
            objs.funcoesBasicas.logi(cnome, fnome);
            int valorReal = 0;
            int valorEscala = 0;

            /*
                A matriz de dados deve vir com as seguintes colunas:
                0 - o codigo unico identificador da linha que sera mostrado na legenda do eixo X geralmente menor que 5 caracteres
                1 - uma descricao mais detalhada do item, que podera ser mostrado ao clicar no item
                2 - o valor representativo do item que indicara o tamanho da barra
                3 - uma observacao que podera ser mostrada no item ao clicar ou utilizada para outros fins dentro do codigo especifico

                **********O ultimo registro deve conder na coluna de valor o maior dos valores e nao deve conter mais dados e nao sera usada como barra**********
             */
            int indCampoId = 0;
            int indCampoValorBarra = 2;

            this.matrizDados = matrizDados;
            this.qtBarras = matrizDados.length() - 1; //ultima linha deve vir os totalizadores ou maximos e minimos
            this.maior = Integer.parseInt(matrizDados.getJSONArray(this.qtBarras).get(indCampoValorBarra).toString()); //ultima linha, deve conter soma ou maior
            this.extensao = this.maior;
            objs.funcoesBasicas.log("extensao", this.extensao);
            this.espacoInternoBarras = (this.alturaInternaGrafico - (this.espessuraContorno + this.margemRetangular));
            objs.funcoesBasicas.log("espacointernobarras", this.espacoInternoBarras);
            this.larguraCnjBarra = this.larguraInternaGrafico / this.qtBarras;
            this.larguraBarra = this.larguraCnjBarra * .7f;
            this.larguraBarra = this.objs.funcoesMatematica.maiorValor(this.larguraBarra, this.larguraMinBarra);
            this.larguraBarraInt = this.larguraBarra.intValue();
            this.espacoEntreBarras = this.larguraBarra * 0.3f / .7f;
            this.espacoEntreBarrasInt = this.espacoEntreBarras.intValue();
            this.eixoX = this.criarEixoX();
            this.eixoY = this.criarEixoY();
            this.idUltBarraCriada = this.eixoY.getId();
            this.criarLegendasEixoY();
            this.csLayoutInterno = new ConstraintSet();
            this.csLayoutInterno.clone(this.layoutInterno);
            int corBarra = getResources().getColor(R.color.verdetransp);
            String valorString = "";
            objs.funcoesBasicas.log("dividindo", this.espacoInternoBarras, this.extensao);
            Float multiplicador = this.espacoInternoBarras / this.extensao;
            objs.funcoesBasicas.log("multiplicador", multiplicador);

            JSONArray linha = null;

            this.posBaseBarras = this.posBaseBarras - 20; //PARA OS CONSTRAINT SET DAS AS LEGENDAS DO EIXO X
            this.idUltBarraCriada = this.layoutInterno.getId();
            if (matrizDados.length() > 0) {
                for (int i = 0; i < this.qtBarras; i++) {
                    linha = matrizDados.getJSONArray(i);
                    this.criarLegendaEixoX(linha.get(indCampoId).toString(), i);
                }
            }

            this.posBaseBarras = this.posBaseBarras + 20;
            this.idUltBarraCriada = this.layoutInterno.getId();
            if (matrizDados.length() > 0) {
                for (int i = 0; i < this.qtBarras; i++) {
                    linha = matrizDados.getJSONArray(i);
                    valorString = linha.get(indCampoValorBarra).toString();
                    valorReal = Integer.parseInt(valorString);
                    valorEscala = (int) (valorReal * multiplicador);
                    objs.funcoesBasicas.log("valorReal: " + String.valueOf(valorReal) + " maior: " + String.valueOf(this.maior) + " altgraf: " + String.valueOf(this.alturaInternaGrafico) + " valorEscala: " + String.valueOf(valorEscala));
                    this.criarBarra(valorEscala, valorString, linha, i, corBarra);
                }
            }
            this.csLayoutInterno.applyTo(this.layoutInterno);
            this.scroll.bringToFront();
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
