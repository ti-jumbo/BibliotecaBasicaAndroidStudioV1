package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.app.Activity;
import android.content.Context;
import android.graphics.Point;
import android.util.DisplayMetrics;
import android.util.Log;
import android.view.Display;
import android.view.View;
import android.view.inputmethod.InputMethodManager;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.telas.TelaBase;
import com.bibliotecas.bibliotecabasicav1.telas.fragmentos.FragmentoBase;

public class FuncoesTela extends FuncoesBase {
    private static String cnome = "FuncoesTela";
    private static FuncoesTela uFuncoesTela = null;
    private static DisplayMetrics displayMetrics = new DisplayMetrics();

    public FuncoesTela(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesTela";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesTela getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesTela getInstancia(Context pContexto){
        try {
            if (uFuncoesTela == null) uFuncoesTela = new FuncoesTela(pContexto);
            return uFuncoesTela;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void mostrar_carregando(){
        try {
            objs.variaveisBasicas.getActivityAtual().mostrar_carregando();
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void esconder_carregando(){
        try {
            TelaBase telaBase = objs.variaveisBasicas.getActivityAtual();
            if (telaBase != null) {
                telaBase.esconder_carregando();
                if (telaBase.fragmentoConteudo != null) {
                    objs.funcoesBasicas.mostrarmsg(telaBase.getSupportFragmentManager().getPrimaryNavigationFragment().getClass().getName());

                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void esconder_carregando(Object obj){
        try {
            if (obj != null){
                if (obj instanceof FragmentoBase) {
                    ((FragmentoBase) obj).esconder_carregando();
                } else if (obj instanceof TelaBase) {
                    ((TelaBase) obj).esconder_carregando();
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static DisplayMetrics getDisplayMetrics(Activity pTela) {
        try {
            if (pTela != null) {
                displayMetrics = new DisplayMetrics();
                pTela.getWindowManager().getDefaultDisplay().getMetrics(displayMetrics);
            }
            return displayMetrics;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setDisplayMetrics(DisplayMetrics pDisplayMetrics) {
        try {
            FuncoesTela.displayMetrics = pDisplayMetrics;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Integer getScreenHeight(){
        try {
            Display display = objs.variaveisBasicas.getActivityAtual().getWindowManager().getDefaultDisplay();
            Point size = new Point();
            display.getSize(size);
            int width = size.x;
            int height = size.y;
            Log.e("Width", "" + width);
            Log.e("height", "" + height);
            return height;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public static Integer getScreenWidth(){
        try {
            Display display = objs.variaveisBasicas.getActivityAtual().getWindowManager().getDefaultDisplay();
            Point size = new Point();
            display.getSize(size);
            int width = size.x;
            int height = size.y;
            Log.e("Width", "" + width);
            Log.e("height", "" + height);
            return width;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }

    public static void mostrarmsg_nulo(Object o,String msg_nao_nulo, String msg_nulo) {
        try {
            if (o != null) {
                objs.funcoesBasicas.mostrarmsg(msg_nao_nulo);
            } else {
                objs.funcoesBasicas.mostrarmsg(msg_nulo);
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void esconderTeclado(Activity tela, View v) {
        try {
            String fnome = "esconderTeclado";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (tela != null && v != null) {
                InputMethodManager imm = (InputMethodManager) tela.getSystemService(Context.INPUT_METHOD_SERVICE);
                imm.hideSoftInputFromWindow(v.getWindowToken(), 0);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}

