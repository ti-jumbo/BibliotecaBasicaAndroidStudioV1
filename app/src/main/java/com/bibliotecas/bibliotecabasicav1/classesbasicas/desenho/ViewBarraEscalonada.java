package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.view.View;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONArray;

public class ViewBarraEscalonada extends ViewDesenhoBaseLinLayout {
    int width = 0;
    int height = 0;
    int espessuraContorno = 0;
    int metadeEspessuraContorno = 0;
    int corContorno = Color.BLACK;
    int corFundo = Color.TRANSPARENT;
    String texto = null;
    int tamanhoTexto = 15;
    int corTexto = Color.BLACK;
    int posBaseY = tamanhoTexto + 2;
    int valorBarraInterna = 0;
    String legendaBarraInterna = null;
    int corBarraInterna = 0;

    protected ObjetosBasicos objs = null;

    public ViewBarraEscalonada(
                Context context,
                int width,
                int height,
                int espessuraContorno,
                int corContorno,
                int corFundo,
                String texto,
                int pValorBarraInterna,
                String plegendaBarraInterna,
                int pcorBarraInterna) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
        this.setId(objs.funcoesObjeto.gerarIdView());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.setBackgroundColor((corFundo));
        this.width = width;
        this.height = height;
        this.espessuraContorno = espessuraContorno;
        this.metadeEspessuraContorno = Math.round(this.espessuraContorno / 2);
        this.corContorno = corContorno;
        this.corFundo = corFundo;
        this.texto = texto;
        this.valorBarraInterna = pValorBarraInterna;
        this.legendaBarraInterna = plegendaBarraInterna;
        this.corBarraInterna = pcorBarraInterna;
    }
    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);

        /*barra pricipal (continente)*/
        objs.variaveisEstaticas.paint.setColor(this.corContorno);
        objs.variaveisEstaticas.paint.setStyle(Paint.Style.STROKE);
        objs.variaveisEstaticas.paint.setStrokeWidth(this.espessuraContorno);
        canvas.drawRect(this.metadeEspessuraContorno,this.metadeEspessuraContorno,this.width - this.metadeEspessuraContorno,this.height -  this.metadeEspessuraContorno,objs.variaveisEstaticas.paint);

        /*barra interna (contida)*/
        objs.variaveisEstaticas.paint.setColor(this.corBarraInterna);
        objs.variaveisEstaticas.paint.setStyle(Paint.Style.FILL);
        objs.variaveisEstaticas.paint.setStrokeWidth(this.espessuraContorno);
        canvas.drawRect(
                this.espessuraContorno,
                this.height - this.valorBarraInterna,
                this.width - this.espessuraContorno,
                this.height -  this.espessuraContorno,
                objs.variaveisEstaticas.paint);

        /*texto barra principal*/
        objs.variaveisEstaticas.paint.setColor(this.corTexto);
        objs.variaveisEstaticas.paint.setStyle(Paint.Style.FILL);
        objs.variaveisEstaticas.paint.setTextAlign(Paint.Align.CENTER);
        objs.variaveisEstaticas.paint.setTextSize(this.tamanhoTexto);
        canvas.drawText(this.texto,(int) (this.width / 2) ,this.posBaseY, objs.variaveisEstaticas.paint);


        /*texto barra contida*/
        objs.variaveisEstaticas.paint.setColor(this.corTexto);
        objs.variaveisEstaticas.paint.setStyle(Paint.Style.FILL);
        objs.variaveisEstaticas.paint.setTextAlign(Paint.Align.CENTER);
        objs.variaveisEstaticas.paint.setTextSize(this.tamanhoTexto);
        objs.variaveisEstaticas.paint.setAntiAlias(true);
        canvas.drawText(this.legendaBarraInterna,(int) (this.width / 2) ,(this.height - this.valorBarraInterna) + this.posBaseY, objs.variaveisEstaticas.paint);

    }
}