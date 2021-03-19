package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.Rect;
import android.view.View;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class ViewDesenhoCirculoTexto extends View {
    public int width = 0;
    public int height = 0;
    public int anguloInicio = 0;
    public int anguloFim = 0;
    public int larguraArco = 0;
    public int corArco = 0;
    public String texto = null;
    protected ObjetosBasicos objs = null;

    public ViewDesenhoCirculoTexto(Context context, int width, int height, int anguloInicio, int anguloFim, int larguraArco, int corArco, String texto ) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
        this.setId(View.generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.width = width;
        this.height = height;
        this.anguloInicio = anguloInicio;
        this.anguloFim = anguloFim;
        this.larguraArco = larguraArco;
        this.corArco = corArco;
        this.texto = texto;
    }

    @Override
    protected void onDraw(Canvas canvas) {
        super.onDraw(canvas);
        int metadeLargArco = Math.round(this.larguraArco / 2);
        Paint p = new Paint();
        p.setAntiAlias(true);
        p.setStyle(Paint.Style.STROKE);
        p.setStrokeWidth(this.larguraArco);
        p.setColor(this.corArco);
        canvas.drawArc(metadeLargArco,metadeLargArco,this.width - metadeLargArco,this.height - metadeLargArco,this.anguloInicio,this.anguloFim,false,p);
        Float anguloFinal = (float)this.anguloFim;
        Float anguloInicial = (float)this.anguloInicio;
        int quadrante = 0;
        Float seno1 = 0f;
        Float seno2 = 0f;
        Float coseno1 = 0f;
        Float coseno2 = 0f;
        Float px0 = 0f;
        Float py0 = 0f;
        Float raio = 0f;
        if (anguloFinal > 360 ) {
            anguloFinal = anguloFinal % 360;
        }
        if (anguloFinal < -360) {
            anguloFinal = anguloFinal % 360;
        }
        anguloInicial = anguloFinal - 12;
        if ((anguloInicial >= 0 && anguloInicial <= 90) || (anguloInicial > -360 && anguloInicial <= -270)) {
            quadrante = 1;
        } else if ((anguloInicial > 90 && anguloInicial <= 180) || (anguloInicial > -270 && anguloInicial <= -180)) {
            quadrante = 2;
        } else if ((anguloInicial > 180 && anguloInicial <= 270) || (anguloInicial > -180 && anguloInicial <= -90)) {
            quadrante = 3;
        } else if ((anguloInicial > 270 && anguloInicial <= 360) || (anguloInicial > -90 && anguloInicial < 0)) {
            quadrante = 4;
        }
        seno1 = (float) Math.sin(Math.toRadians(anguloInicial));
        seno2 = (float) Math.sin(Math.toRadians(anguloFinal));
        coseno1 = (float) Math.cos(Math.toRadians(anguloInicial));
        coseno2 = (float) Math.cos(Math.toRadians(anguloFinal));
        px0 = (this.width / 2) - 15f;
        py0 = (this.height / 2) - 15f;
        raio = px0;
        objs.funcoesBasicas.log("texto:",this.texto, "px0",px0,"py0",py0,"raio",raio,"anguloInicial",anguloInicial,"final" , anguloFinal,"seno1",seno1,"seno2",seno2,"coseno1",coseno1,"coseno2",coseno2);
        px0 += (raio * coseno1);
        py0 += (raio * seno1);
        if (coseno1 > 0) {
            px0 -=20f;
        } else {
            px0 += 20f;
        }
        if (seno1 > 0) {
            py0 -= 20f; //a base do drawtext e a base do texto
        } else {
            py0 += 25f; //a base do drawtext e a base do texto
        }
        p.setStyle(Paint.Style.FILL);
        p.setAntiAlias(true);
        p.setTextAlign(Paint.Align.CENTER);
        p.setColor(Color.BLACK);
        p.setTextSize(12f);
        Rect textBound = new Rect();
        p.getTextBounds(this.texto, 0, this.texto.length(), textBound);
        p.setTextSize(p.getTextSize() * (1 + (1 - (textBound.right ) / this.width)));
        canvas.drawText(this.texto,px0,py0,p);
    }
}
