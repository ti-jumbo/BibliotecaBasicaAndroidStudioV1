package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.graphics.Canvas;
import android.graphics.Color;
import android.view.View;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class ViewDesenho extends View {
    public Method metodoDesenho;
    public Object objetoDesenho;
    public Tipos.TDadosDesenho dadosDesenho;
    public int tipoDesenho = 0;
    public int cor_fundo = Color.BLACK;
    protected ObjetosBasicos objs = null;
    protected Context contexto = null;

    public ViewDesenho(Context pContexto, Method metodoDesenho, Object objetoDesenho, Tipos.TDadosDesenho dadosDesenho) {
        super(pContexto);
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        this.setId(View.generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(dadosDesenho.tamanho_externo.width.intValue(),dadosDesenho.tamanho_externo.height.intValue()));
        this.metodoDesenho = metodoDesenho;
        this.objetoDesenho = objetoDesenho;
        this.dadosDesenho = dadosDesenho;
    }

    public ViewDesenho(Context context, int width, int height, int cor_fundo) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
        this.setId(View.generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.setBackgroundColor(cor_fundo);
    }

    @Override
    public void onDraw(Canvas canvas){
        super.onDraw(canvas);
        if (this.tipoDesenho == 0) {

        } else {
            try {
                if (this.metodoDesenho != null) {
                    if (this.objetoDesenho != null) {
                        this.metodoDesenho.invoke(this.objetoDesenho, this, canvas, this.dadosDesenho);
                    } else {
                        objs.funcoesBasicas.mostrarmsg("Objeto de desenho nulo");
                    }
                } else {
                    objs.funcoesBasicas.mostrarmsg("Methodo de desenho nulo");
                }
            } catch (IllegalAccessException e) {
                e.printStackTrace();
            } catch (InvocationTargetException e) {
                e.printStackTrace();
            }
        }
    }

}
