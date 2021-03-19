package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class FuncoesString extends FuncoesBase {
    private static String cnome = "FuncoesString";
    private static FuncoesString uFuncoesString;

    public FuncoesString(Context pContexto){
        super(pContexto);
        try {
            String fnome = "FuncoesString";
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

    public static synchronized FuncoesString getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesString getInstancia(Context pContexto) {
        try {
            if (uFuncoesString == null) {
                uFuncoesString = new FuncoesString(pContexto);
            }
            return uFuncoesString;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String aumentar_nivel_aspas_simples(String s) {
        try {
            String retorno = s;
            retorno = "'" + retorno.replace("'","''") + "'";
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return s;
        }
    }
}

