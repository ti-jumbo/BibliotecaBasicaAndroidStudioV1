package com.bibliotecas.bibliotecabasicav1.classesbasicas.graficos;

import android.annotation.SuppressLint;
import android.content.Context;
import android.graphics.Color;
import android.view.Gravity;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.ConstraintSet;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoCirculoTexto;

import org.json.JSONArray;

public class GraficoProgressoCircular extends GraficoBase {

    private String cnome = "GraficoProgressoCircular";
    public int qtItems = 0;
    public int[] cores = null;
    public String[] legendas = null;
    public String[] legendas2 = null;

    public GraficoProgressoCircular(Context context, ViewGroup view_container) {
        super(context);
        this.layoutInterno = new ConstraintLayout(this.getContext());
        this.layoutInterno.setId(generateViewId());
        this.layoutInterno.setLayoutParams(new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT,LinearLayout.LayoutParams.MATCH_PARENT));
        this.layout.addView(this.layoutInterno);
    }

    public void criarLegendas(){
        LinearLayout l = new LinearLayout(getContext());
        l.setId(generateViewId());
        l.setLayoutParams(new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
        l.setOrientation(LinearLayout.VERTICAL);
        this.layout.addView(l);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(l.getId(),ConstraintSet.TOP,this.layout.getId(),ConstraintSet.TOP,5);
        cs.connect(l.getId(),ConstraintSet.RIGHT,this.layout.getId(),ConstraintSet.RIGHT,10);
        cs.applyTo(this.layout);
        for (int i = 0; i < this.cores.length; i++) {
            LinearLayout li = new LinearLayout(getContext());
            li.setId(generateViewId());
            li.setLayoutParams(new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
            li.setOrientation(LinearLayout.HORIZONTAL);
            li.setGravity(Gravity.CENTER_VERTICAL);
            View v = new View(getContext());
            v.setId(generateViewId());
            v.setBackgroundColor(this.cores[i]);
            v.setLayoutParams(new LayoutParams(10, 10));
            li.addView(v);
            TextView tv = new TextView(getContext());
            tv.setId(generateViewId());
            tv.setText(this.legendas[i]);
            li.addView(tv);
            l.addView(li);
        }

        l = new LinearLayout(getContext());
        l.setId(generateViewId());
        l.setLayoutParams(new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
        l.setOrientation(LinearLayout.VERTICAL);
        this.layout.addView(l);
        cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(l.getId(),ConstraintSet.TOP,this.layout.getId(),ConstraintSet.TOP,5);
        cs.connect(l.getId(),ConstraintSet.LEFT,this.layout.getId(),ConstraintSet.LEFT,10);
        cs.applyTo(this.layout);

        for (int i = this.cores.length - 2; i >= 0; i--) {
            LinearLayout li = new LinearLayout(getContext());
            li.setId(generateViewId());
            li.setLayoutParams(new LayoutParams(LayoutParams.WRAP_CONTENT, LayoutParams.WRAP_CONTENT));
            li.setOrientation(LinearLayout.HORIZONTAL);
            li.setGravity(Gravity.CENTER_VERTICAL);
            View v = new View(getContext());
            v.setId(generateViewId());
            v.setBackgroundColor(this.cores[i]);
            v.setLayoutParams(new LayoutParams(10, 10));
            li.addView(v);
            TextView tv = new TextView(getContext());
            tv.setId(generateViewId());
            tv.setText(this.legendas2[i]);
            li.addView(tv);
            l.addView(li);
        }
    }

    public void criarArcoTexto(int pValor, int pLargura, String legenda, int corFundo, int corArco) {
        ViewDesenhoCirculoTexto v = new ViewDesenhoCirculoTexto(getContext(),this.menorDimensaoInt,this.menorDimensaoInt,0,pValor,pLargura,corArco,legenda);
        this.layoutInterno.addView(v);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(v.getId(),ConstraintSet.TOP,this.layoutInterno.getId(),ConstraintSet.TOP,0);
        this.csLayoutInterno.connect(v.getId(),ConstraintSet.LEFT,this.layoutInterno.getId(),ConstraintSet.LEFT,0);
        this.csLayoutInterno.connect(v.getId(),ConstraintSet.RIGHT,this.layoutInterno.getId(),ConstraintSet.RIGHT,0);
        this.csLayoutInterno.connect(v.getId(),ConstraintSet.BOTTOM,this.layoutInterno.getId(),ConstraintSet.BOTTOM,0);
        this.csLayoutInterno.applyTo(this.layoutInterno);
    }

    @SuppressLint("Range")
    public void criarProgressoCircular(JSONArray matrizDados) {
        try {
            String fnome = "criarProgressoCircular";
            objs.funcoesBasicas.logi(cnome, fnome);
            int valorReal = 0;
            int valorEscala = 0;

            /*
                A matriz de dados deve vir com as seguintes colunas:
                0 - o codigo unico identificador da linha que sera mostrado na legenda do eixo X geralmente menor que 5 caracteres
                1 - uma descricao mais detalhada do item, que podera ser mostrado ao clicar no item
                2 - o valor representativo do item que indicara o tamanho da barra
                3 - uma observacao que podera ser mostrada no item ao clicar ou utilizada para outros fins dentro do codigo especifico
                4 - a cor no formato #rrggbb do item
                5 - a legenda deste item
                obs : os dados so fazem sentido se vierem ordenados na coluna 2 do maior para o menor, o maior sera o circulo base, os demais irao se desenhando ordenadamente
             */
            int indCampoId = 0;
            int indCampoValorBarra = 2;
            int indCampoCor = 4;
            int indCampoLegenda1 = 5;
            int indCampoLegenda2 = 6;
            int valorInicioEscala = 0;
            int corBarra = 0;
            Float fator = 0f;
            String strTemp = "";

            this.matrizDados = matrizDados;
            this.qtItems = matrizDados.length();
            this.csLayoutInterno = new ConstraintSet();
            this.csLayoutInterno.clone(this.layoutInterno);

            JSONArray linha = null;
            String valorString = "";

            if (matrizDados.length() > 0) {
                this.cores = new int[matrizDados.length()];
                this.legendas = new String[matrizDados.length()];
                this.legendas2 = new String[matrizDados.length()];

                linha = matrizDados.getJSONArray(0);
                valorString = linha.get(indCampoValorBarra).toString();
                valorReal = Integer.parseInt(valorString);
                valorEscala = 360;
                strTemp = linha.get(indCampoCor).toString();
                corBarra = Color.parseColor(strTemp);
                this.cores[0] = corBarra;
                this.legendas[0] = linha.get(indCampoLegenda1).toString();
                this.legendas2[0] = linha.get(indCampoLegenda2).toString();
                this.maior = valorReal;
                int larguraBarra = 100;
                strTemp = linha.get(indCampoCor).toString().toUpperCase();
                objs.funcoesBasicas.log("parseando cor", strTemp);
                corBarra = Color.parseColor(strTemp);
                this.criarArcoTexto(valorEscala, larguraBarra, valorString, Color.TRANSPARENT, corBarra);
                for (int i = 1; i < this.qtItems; i++) {
                    linha = matrizDados.getJSONArray(i);
                    valorString = linha.get(indCampoValorBarra).toString();
                    valorReal = Integer.parseInt(valorString);
                    valorEscala = Math.round((float) valorReal * 360f / (float) this.maior);
                    fator = Float.valueOf(larguraBarra) * (1f - (20f / 100f * Float.valueOf(i)));
                    strTemp = linha.get(indCampoCor).toString();
                    corBarra = Color.parseColor(strTemp);
                    this.cores[i] = corBarra;
                    this.legendas[i] = linha.get(indCampoLegenda1).toString();
                    this.legendas2[i] = linha.get(indCampoLegenda2).toString();
                    objs.funcoesBasicas.log("valorReal", valorReal, "valorescala", valorEscala, i, i * 10, i * 10 / 100, (1 - (i * 10 / 100)), Math.round((1 - (i * 10 / 100)) * larguraBarra), (1 - (i * 10 / 100)) * larguraBarra, fator);
                    this.criarArcoTexto(valorEscala, fator.intValue(), valorString, Color.TRANSPARENT, corBarra);
                    valorInicioEscala += valorEscala;
                }
            }
            this.criarLegendas();

            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
