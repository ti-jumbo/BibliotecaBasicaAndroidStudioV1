package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;

import androidx.constraintlayout.widget.ConstraintLayout;

public class ViewDesenhoBarraTexto extends ViewDesenhoBase {
    String texto = null;
    int width = 0;
    int tamanhoTexto = 13;
    int corTexto = Color.BLACK;
    int posBaseY = tamanhoTexto + 2;

    public ViewDesenhoBarraTexto(Context context, int width, int height, int corFundo, String texto) {
        super(context);
        this.setId(generateViewId());
        if (height == 0) {
            height = 1;
            corFundo = Color.TRANSPARENT;
        }
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
        canvas.drawText(this.texto,(int) (this.width / 2) ,this.posBaseY, objs.variaveisEstaticas.paint);
    }
}