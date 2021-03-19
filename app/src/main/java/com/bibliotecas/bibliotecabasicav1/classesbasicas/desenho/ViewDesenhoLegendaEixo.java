package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.view.View;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class ViewDesenhoLegendaEixo extends View {
    String texto = null;
    int width = 0;
    int tamanhoTexto = 15;
    int corTexto = Color.BLACK;
    int posBaseY = tamanhoTexto + 2;
    protected ObjetosBasicos objs = null;

    public ViewDesenhoLegendaEixo(Context context, int width, int height, int corFundo, String texto) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
        this.setId(View.generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.setBackgroundColor((corFundo));
        this.width = width;
        this.texto = texto;
    }
    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        objs.variaveisEstaticas.paint.setColor(this.corTexto);
        objs.variaveisEstaticas.paint.setStyle(Paint.Style.FILL);
        objs.variaveisEstaticas.paint.setTextAlign(Paint.Align.CENTER);
        objs.variaveisEstaticas.paint.setTextSize(this.tamanhoTexto);
        objs.variaveisEstaticas.paint.setAntiAlias(true);
        canvas.drawText(this.texto,(int) (this.width / 2) ,this.posBaseY, objs.variaveisEstaticas.paint);
    }
}