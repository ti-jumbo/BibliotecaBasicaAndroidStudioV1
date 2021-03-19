package com.bibliotecas.bibliotecabasicav1.classesbasicas.graficos;

import android.content.Context;
import android.view.ViewGroup;

import androidx.constraintlayout.widget.ConstraintSet;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenho;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoBarra;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoLegendaEixo;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoLinha;

import org.json.JSONArray;

public class GraficoDesvio extends GraficoBarras {
    private String cnome = "GraficoDesvio";
    public ViewDesenho eixo0;
    public ViewDesenho eixoSuperior;
    public ViewDesenho eixoYLegendas;
    public Float posicao_eixo0;

    public GraficoDesvio(Context context, ViewGroup view_container, int orientacao, int gravidade) {
        super(context, view_container,orientacao,gravidade);
        this.espacoEsquerdoEixoY = 125f;
    }

    public ViewDesenho criarEixo0(){
        Float px1 = this.larguraInternaGrafico + this.margemRetangular;// - (this.menor * this.larguraInternaGrafico / this.extensao) + this.margemRetangular;
        px1 = px1 - ((this.menor * -1) * (this.larguraInternaGrafico + this.margemRetangular - this.espacoEsquerdoEixoY) / this.extensao);
        this.posicao_eixo0 = (px1 - this.margemRetangular) + (this.espessuraContorno / 2);
        objs.funcoesBasicas.log("posicao_eixo0: " + String.valueOf(px1));
        this.eixo0 = new ViewDesenho(getContext(), 5 ,(int) (this.alturaGrafico - 10),this.cor_contorno);
        this.layout.addView(this.eixo0);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(this.eixo0.getId(), ConstraintSet.BOTTOM,this.layout.getId(), ConstraintSet.BOTTOM,5);
        cs.connect(this.eixo0.getId(), ConstraintSet.LEFT,this.layout.getId(), ConstraintSet.LEFT,px1.intValue());
        cs.applyTo(this.layout);
        return this.eixo0;
    }

    public ViewDesenho criarEixoSuperior(){
        this.eixoSuperior = new ViewDesenho(getContext(), (int) (this.larguraGrafico - 10),this.espessuraContorno.intValue() ,this.cor_contorno);
        this.layout.addView(this.eixoSuperior);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(this.eixoSuperior.getId(), ConstraintSet.TOP,this.layout.getId(), ConstraintSet.TOP,espacoSuperiorEixoSuperior.intValue());
        cs.connect(this.eixoSuperior.getId(), ConstraintSet.LEFT,this.layout.getId(), ConstraintSet.LEFT,5);
        cs.applyTo(this.layout);
        return this.eixoSuperior;
    }

    public ViewDesenho criarEixoYLegendas(){
        this.eixoY = new ViewDesenho(getContext(), 5 ,(int) (this.alturaGrafico - 10),this.cor_contorno);
        this.layout.addView(this.eixoY);
        ConstraintSet cs = new ConstraintSet();
        cs.clone(this.layout);
        cs.connect(this.eixoY.getId(), ConstraintSet.LEFT,this.layout.getId(), ConstraintSet.LEFT,this.espacoEsquerdoEixoY.intValue());
        cs.connect(this.eixoY.getId(), ConstraintSet.BOTTOM,this.layout.getId(), ConstraintSet.BOTTOM,5);
        cs.applyTo(this.layout);
        return this.eixoY;
    }

    public ViewDesenhoBarra criarBarraDesvio(int pValor, String legenda, JSONArray dados, int indiceBarra, int corBarra) {
        ViewDesenhoBarra retorno = null;
        int vValor = pValor;
        if (vValor < 0) {
            vValor = vValor * -1;
        }
        if (vValor == 0) {
            vValor = 1;
        }
        retorno = new ViewDesenhoBarra(getContext(), vValor,this.larguraBarraInt,corBarra);
        this.layoutInterno.addView(retorno);
        this.csLayoutInterno.clone(this.layoutInterno);

        if (indiceBarra == 0) {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.TOP, this.idUltBarraCriada, ConstraintSet.TOP, this.espacoEntreBarrasInt);
        } else {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.TOP,this.idUltBarraCriada, ConstraintSet.BOTTOM, this.espacoEntreBarrasInt);
        }
        if (pValor > 0) {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.RIGHT, this.layoutInterno.getId(), ConstraintSet.RIGHT, Math.round(this.larguraInternaGrafico - this.posicao_eixo0 + (this.espessuraContorno /2)));
        } else {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, this.layoutInterno.getId(), ConstraintSet.LEFT, Math.round(this.posicao_eixo0 + this.margemRetangular + (this.espessuraContorno/2)));
        }
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = retorno.getId();
        retorno.dados = dados;
        //objs.funcoesBasicas.log(pValor + " " + TextUtils.join(",",dados));
        ViewDesenhoLinha vl = new ViewDesenhoLinha(getContext(),this.larguraGrafico.intValue(),this.espessuraLinhaGrade,this.corLinhaGrade);
        this.layoutInterno.addView(vl);
        csLayoutInterno.clone(this.layoutInterno);
        csLayoutInterno.connect(vl.getId(), ConstraintSet.LEFT,this.layoutInterno.getId(), ConstraintSet.LEFT,5);
        csLayoutInterno.connect(vl.getId(), ConstraintSet.BOTTOM,retorno.getId(), ConstraintSet.TOP, Math.round((this.espacoEntreBarras / 2)-(this.espessuraLinhaGrade / 2)));
        csLayoutInterno.applyTo(this.layoutInterno);

        return retorno;
    }

    public void criarLegendaEixoY(String legenda, int indiceBarra) {
        ViewDesenhoLegendaEixo v = null;
        v = new ViewDesenhoLegendaEixo(getContext(),this.espacoEsquerdoEixoY.intValue() - 10, 20,getResources().getColor(R.color.azultransp),legenda);
        this.layoutInterno.addView(v);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(v.getId(), ConstraintSet.LEFT,this.layoutInterno.getId(), ConstraintSet.LEFT, 5);
        if (indiceBarra == 0) {
            this.csLayoutInterno.connect(v.getId(), ConstraintSet.TOP, this.idUltBarraCriada, ConstraintSet.TOP, this.espacoEntreBarrasInt + (Math.round(this.larguraBarra / 2) - 10));
        } else {
            this.csLayoutInterno.connect(v.getId(), ConstraintSet.TOP, this.idUltBarraCriada, ConstraintSet.BOTTOM, this.espacoEntreBarrasInt + (this.larguraBarraInt - 20));
        }
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = v.getId();
    }

    public void criarLegendasEixoSuperior() {
        int qtCaractMaiorInt = 0;
        int multiplicadorEscala = 0;
        int maiorEscala = 0;
        int valorEscala = 1;
        int multiplicanteEscala = 1;
        int qtEscalas = 0;
        int qtMenores = 0;
        int qtMaiores = 0;
        Float larguraRealExtensaoEscala = 0f;
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
        qtMenores = Math.round((this.menor * -1) / this.extensao  * qtEscalas);
        qtMaiores = qtEscalas - qtMenores;
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
        larguraRealExtensaoEscala = qtEscalas * valorEscala * multiplicanteEscala * (this.espacoInternoBarras) / this.extensao;
        Float larguraEscala = larguraRealExtensaoEscala / qtEscalas;
        objs.funcoesBasicas.log("maiorInt",this.extensao,"maiorEscala",maiorEscala,"multiplicadorEscala",multiplicadorEscala,"strgrauescala",strGrauEscala,"multiplicante",multiplicanteEscala,"valorescala",valorEscala,"qtEscalas",qtEscalas,"extensao",extensao,"largurainterna",(this.larguraInternaGrafico - this.margemRetangular),"alturareal",larguraRealExtensaoEscala);
        ViewDesenhoLegendaEixo v = null;
        ViewDesenhoLinha vl = null;
        int corFundo = getResources().getColor(R.color.azultransp);
        int corLinhaGrade = getResources().getColor(R.color.cinzatransp);
        ConstraintSet cs = new ConstraintSet();
        String texto = "";
        for (int i = 1; i <= qtMaiores + 1; i++) {
            texto = "-"+String.valueOf(Math.round(valorEscala) * i)  + strGrauEscala;
            v = new ViewDesenhoLegendaEixo(getContext(), 30,20,corFundo,texto);
            this.layout.addView(v);
            cs.clone(this.layout);
            cs.connect(v.getId(), ConstraintSet.BOTTOM,this.eixoSuperior.getId(), ConstraintSet.TOP,0);
            cs.connect(v.getId(), ConstraintSet.RIGHT,this.eixo0.getId(), ConstraintSet.LEFT, Math.round(i * (larguraRealExtensaoEscala / qtEscalas)) - 10);
            cs.applyTo(this.layout);
            vl = new ViewDesenhoLinha(getContext(),this.espessuraLinhaGrade,this.alturaInternaGrafico.intValue(),this.corLinhaGrade);
            this.layout.addView(vl);
            cs.clone(this.layout);
            cs.connect(vl.getId(), ConstraintSet.TOP,this.eixoSuperior.getId(), ConstraintSet.BOTTOM,0);
            cs.connect(vl.getId(), ConstraintSet.RIGHT,this.eixo0.getId(), ConstraintSet.LEFT, Math.round((i * (larguraRealExtensaoEscala / qtEscalas)) - (this.espessuraLinhaGrade / 2)));
            cs.applyTo(this.layout);
        }
        for (int i = 1; i <= qtMenores + 1; i++) {
            texto = String.valueOf(Math.round(valorEscala) * i)  + strGrauEscala;
            v = new ViewDesenhoLegendaEixo(getContext(), 30,20,corFundo,texto);
            this.layout.addView(v);
            cs.clone(this.layout);
            cs.connect(v.getId(), ConstraintSet.BOTTOM,this.eixoSuperior.getId(), ConstraintSet.TOP,0);
            cs.connect(v.getId(), ConstraintSet.LEFT,this.eixo0.getId(), ConstraintSet.LEFT, Math.round(i * (larguraRealExtensaoEscala / qtEscalas)) - 10);
            cs.applyTo(this.layout);
            vl = new ViewDesenhoLinha(getContext(),this.espessuraLinhaGrade,this.alturaInternaGrafico.intValue(),this.corLinhaGrade);
            this.layout.addView(vl);
            cs.clone(this.layout);
            cs.connect(vl.getId(), ConstraintSet.TOP,this.eixoSuperior.getId(), ConstraintSet.BOTTOM,0);
            cs.connect(vl.getId(), ConstraintSet.LEFT,this.eixo0.getId(), ConstraintSet.LEFT, Math.round((i * (larguraRealExtensaoEscala / qtEscalas)) + this.espessuraContorno));
            cs.applyTo(this.layout);
        }
    }

    public void criarGraficoDesvio(JSONArray matrizDados) {
        try {
            String fnome = "criarGraficoDesvio";
            objs.funcoesBasicas.logi(cnome, fnome);
            int valorReal = 0;
            int valorEscala = 0;

            /*
                A matriz de dados deve vir com as seguintes colunas:
                0 - o codigo unico identificador da linha que sera mostrado na legenda do eixo X geralmente menor que 5 caracteres
                1 - uma descricao mais detalhada do item, que podera ser mostrado ao clicar no item
                2 - o valor representativo o desvio ou o tamanho da barra
                3 - uma observacao que podera ser mostrada no item ao clicar ou utilizada para outros fins dentro do codigo especifico
             */

            int indCampoId = 0;
            int indCampoValorBarra = 2;

            this.matrizDados = matrizDados;
            this.qtBarras = matrizDados.length() - 2; //2ultimas linha deve vir os totalizadores ou maximos e minimos
            this.maior = Integer.parseInt(matrizDados.getJSONArray(this.qtBarras).get(indCampoValorBarra).toString()); //ultima linha, deve conter soma ou maior

            this.menor = Integer.parseInt(matrizDados.getJSONArray(this.qtBarras + 1).get(indCampoValorBarra).toString()); //ultima linha, deve conter soma ou maior

            if (this.menor > 0) {
                this.menor = 0;
            }

            this.extensao = (int) (this.maior + (this.menor * -1));
            this.espacoInternoBarras = (this.larguraInternaGrafico - this.espacoEsquerdoEixoY - 10f);

            objs.funcoesBasicas.log("maior", this.maior, "menor", this.menor, "extensao", this.extensao);
            objs.funcoesBasicas.log("maior:" + String.valueOf(maior));
            objs.funcoesBasicas.log("extensao:" + String.valueOf(extensao));
            this.larguraCnjBarra = this.alturaInternaGrafico / this.qtBarras;
            this.larguraBarra = this.larguraCnjBarra * .7f;
            this.larguraBarra = objs.funcoesMatematica.maiorValor(this.larguraBarra, this.larguraMinBarra);
            this.larguraBarraInt = Math.round(this.larguraBarra);
            this.espacoEntreBarras = this.larguraBarra * 0.3f / .7f;
            this.espacoEntreBarrasInt = Math.round(this.espacoEntreBarras);

            objs.funcoesBasicas.log("laguraBarra: ", this.larguraBarra, this.larguraBarraInt, "espaco", this.espacoEntreBarras, this.espacoEntreBarrasInt);

            this.eixo0 = this.criarEixo0();
            this.eixoSuperior = this.criarEixoSuperior();
            this.eixoY = this.criarEixoYLegendas();
            this.eixoYLegendas = this.eixoY;

            this.criarLegendasEixoSuperior();
            this.csLayoutInterno = new ConstraintSet();
            this.csLayoutInterno.clone(this.layoutInterno);
            int corBarra = getResources().getColor(R.color.vermelhotransp);
            int corBarraPositiva = getResources().getColor(R.color.verdetransp);
            int corBarraNegativa = getResources().getColor(R.color.vermelhotransp);

            String valorString = "";
            objs.funcoesBasicas.log("dividindo", this.espacoInternoBarras, this.extensao);
            Float multiplicador = this.espacoInternoBarras / this.extensao;
            objs.funcoesBasicas.log("multiplicador", multiplicador);

            JSONArray linha = null;

            this.idUltBarraCriada = this.layoutInterno.getId();

            if (matrizDados.length() > 0) {
                for (int i = 0; i < this.qtBarras; i++) {
                    linha = matrizDados.getJSONArray(i);
                    this.criarLegendaEixoY(linha.get(indCampoId).toString(), i);
                }
            }

            this.posBaseBarras = Math.round(this.posicao_eixo0);
            this.idUltBarraCriada = this.layoutInterno.getId();

            if (matrizDados.length() > 0) {
                for (int i = 0; i < this.qtBarras; i++) {
                    linha = matrizDados.getJSONArray(i);
                    valorString = linha.get(indCampoValorBarra).toString();
                    valorReal = Integer.parseInt(valorString);
                    valorEscala = Math.round(valorReal * multiplicador);
                    objs.funcoesBasicas.log("valorReal: " + String.valueOf(valorReal) + " maior: " + String.valueOf(this.maior) + " altgraf: " + String.valueOf(this.alturaInternaGrafico) + " valorEscala: " + String.valueOf(valorEscala), "extensao", this.extensao, "posicao eixo0", this.posicao_eixo0);
                    if (valorReal > 0) {
                        corBarra = corBarraNegativa;
                    } else {
                        corBarra = corBarraPositiva;
                    }
                    this.criarBarraDesvio(valorEscala, valorString, matrizDados.getJSONArray(i), i, corBarra);
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
