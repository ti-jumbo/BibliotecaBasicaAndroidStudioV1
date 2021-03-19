package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class FuncoesGrafico extends ClasseBase {
    private static String cnome = "FuncoesGrafico";
    private static FuncoesGrafico uFuncoesGrafico;

    private FuncoesGrafico(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesGrafico";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(pContexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.variaveisBasicas.adicionarObjeto(this);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesGrafico getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesGrafico getInstancia(Context pContexto) {
        try {
            if (uFuncoesGrafico == null) {
                uFuncoesGrafico = new FuncoesGrafico(pContexto);
            }
            return uFuncoesGrafico;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}
