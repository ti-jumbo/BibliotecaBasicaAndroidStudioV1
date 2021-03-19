package com.bibliotecas.bibliotecabasicav1.classesbasicas.graficos;

import android.content.Context;
import android.graphics.Color;
import android.view.ViewGroup;

import androidx.constraintlayout.widget.ConstraintSet;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoBarraTexto;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoRetanguloTexto;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoTexto;

import org.json.JSONArray;

public class GraficoBarrasEscalonadas extends GraficoBarras {

    private String cnome = "GraficoBarrasEscalonadas";
    public Float espessuraContornoBarraEscalonada = 4f;

    public GraficoBarrasEscalonadas(Context context, ViewGroup view_container, int orientacao, int gravidade) {
        super(context, view_container,orientacao,gravidade);
        this.corBarra = getResources().getColor(R.color.azultransp);
    }

    public ViewDesenhoBarraTexto criarBarraEscalonada(int pValor, String legenda, JSONArray dados, int indiceBarra, int corBarra, ViewDesenhoRetanguloTexto retanguloRef) {
        ViewDesenhoBarraTexto retorno = null;
        int vValor = Math.round(pValor - this.espessuraContornoBarraEscalonada);
        if (vValor <0 ) {
            vValor = 0;
        }
        retorno = new ViewDesenhoBarraTexto(getContext(),Math.round(this.larguraBarraInt - (this.espessuraContornoBarraEscalonada * 2)), vValor,corBarra,legenda);
        this.layoutInterno.addView(retorno);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.BOTTOM,retanguloRef.getId(), ConstraintSet.BOTTOM, this.espessuraContornoBarraEscalonada.intValue());
        this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, retanguloRef.getId(), ConstraintSet.LEFT, this.espessuraContornoBarraEscalonada.intValue());
        this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.RIGHT, retanguloRef.getId(), ConstraintSet.RIGHT, this.espessuraContornoBarraEscalonada.intValue());
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = retorno.getId();
        retorno.dados = dados;
        return retorno;
    }

    public ViewDesenhoRetanguloTexto criarRetanguloEscalonadoTexto(int pValor, String legenda, int indiceBarra, int corBarra, int corFundo) {
        ViewDesenhoRetanguloTexto retorno = null;
        retorno = new ViewDesenhoRetanguloTexto(getContext(),this.larguraBarraInt, pValor,Math.round(this.espessuraContornoBarraEscalonada),this.corBarra,corFundo,legenda);
        this.layoutInterno.addView(retorno);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.BOTTOM,this.layoutInterno.getId(), ConstraintSet.BOTTOM, this.posBaseBarras);
        if (indiceBarra == 0) {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.LEFT, this.espacoEntreBarrasInt);
        } else {
            this.csLayoutInterno.connect(retorno.getId(), ConstraintSet.LEFT, this.idUltBarraCriada, ConstraintSet.RIGHT, Math.round(this.espacoEntreBarrasInt + this.espessuraContornoBarraEscalonada));
        }
        this.csLayoutInterno.applyTo(this.layoutInterno);
        this.idUltBarraCriada = retorno.getId();
        return retorno;
    }

    public void criarLegendaSuperior(String legenda, ViewDesenhoRetanguloTexto retanguloRef, int corFundo) {
        ViewDesenhoTexto v = null;
        v = new ViewDesenhoTexto(getContext(),this.larguraBarraInt, 20,15, Color.BLACK,corFundo,legenda);
        this.layoutInterno.addView(v);
        this.csLayoutInterno.clone(this.layoutInterno);
        this.csLayoutInterno.connect(v.getId(), ConstraintSet.BOTTOM,retanguloRef.getId(), ConstraintSet.TOP, 0);
        this.csLayoutInterno.connect(v.getId(), ConstraintSet.LEFT, retanguloRef.getId(), ConstraintSet.LEFT, 0);
        this.csLayoutInterno.applyTo(this.layoutInterno);
    }

    public void criarGraficoBarrasEscalonadas(JSONArray matrizDados) {
        try {
            String fnome = "criarGraficoBarrasEscalonadas";
            objs.funcoesBasicas.logi(cnome, fnome);
            int valorReal = 0;
            int valorEscala = 0;
            int cor = 0;
            float perc = 0;

            /*
                A matriz de dados deve vir com as seguintes colunas:
                0 - o codigo unico identificador da linha que sera mostrado na legenda do eixo X geralmente menor que 5 caracteres
                1 - uma descricao mais detalhada do item, que podera ser mostrado ao clicar no item
                2 - o valor representativo da escala do item, ou seja um valor a ser o objetivo do proximo valor
                3 - o valor representativo do item que indicara o tamanho da barra de atingimento
                4 - o valor em percentual representando quando o 3 campo atingiu do 2 campo
                5 - uma observacao que podera ser mostrada no item ao clicar ou utilizada para outros fins dentro do codigo especifico
             */

            int indCampoId = 0;
            int indCampoValorEscala = 2;
            int indCampoValorBarra = 3;
            int indCampoPerc = 4;

            this.matrizDados = matrizDados;
            this.qtBarras = matrizDados.length() - 1;
            int maiorCol1 = Integer.parseInt(matrizDados.getJSONArray(this.qtBarras).get(indCampoValorEscala).toString()); //ultima linha, deve conter soma ou maior
            int maiorCol2 = Integer.parseInt(matrizDados.getJSONArray(this.qtBarras).get(indCampoValorBarra).toString()); //ultima linha, deve conter soma ou maior
            this.maior = this.objs.funcoesMatematica.maiorValor(maiorCol1, maiorCol2);
            this.extensao = this.maior;
            this.espacoInternoBarras = (this.alturaInternaGrafico - (this.espessuraContorno + this.margemRetangular));//(this.alturaInternaGrafico - (this.espessuraContorno * 2) - 20f)

            int primeiro = Math.round(this.objs.funcoesArray.maiorValorColuna(matrizDados, indCampoPerc, 0));
            int segundo = Math.round(this.objs.funcoesArray.maiorValorColuna(matrizDados, indCampoPerc, 1));
            int ultimo = Math.round(this.objs.funcoesArray.menorValorColuna(matrizDados, indCampoPerc, 0));
            int penultimo = Math.round(this.objs.funcoesArray.menorValorColuna(matrizDados, indCampoPerc, 1));

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
            ViewDesenhoRetanguloTexto retangulo = null;
            if (matrizDados.length() > 0) {
                for (int i = 0; i < this.qtBarras; i++) {
                    linha = matrizDados.getJSONArray(i);
                    valorString = linha.get(indCampoValorEscala).toString();
                    valorReal = Integer.parseInt(valorString);
                    valorEscala = (int) (valorReal * multiplicador);
                    retangulo = this.criarRetanguloEscalonadoTexto(valorEscala, valorString, i, Color.BLUE, Color.TRANSPARENT);
                    valorString = linha.get(indCampoValorBarra).toString();
                    valorReal = Integer.parseInt(valorString);
                    valorEscala = (int) (valorReal * multiplicador);
                    this.criarBarraEscalonada(valorEscala, valorString, matrizDados.getJSONArray(i), i, corBarra, retangulo);
                    valorString = linha.get(indCampoPerc).toString();
                    valorReal = Integer.parseInt(valorString);
                    cor = Color.YELLOW;
                    if (valorReal == primeiro || valorReal == segundo) {
                        cor = Color.GREEN;
                    }
                    if (valorReal == ultimo || valorReal == penultimo) {
                        cor = Color.RED;
                    }
                    this.criarLegendaSuperior(valorString + "%", retangulo, cor);
                }
            }
            this.scroll.bringToFront();
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
