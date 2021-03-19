package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class VariaveisValoresPadrao extends ClasseBase {
    private static String cnome = "VariaveisValoresPadrao";
    private static VariaveisValoresPadrao uVariaveisValoresPadrao = null;
    public static int tempo_espera_requisicoes = 15000;

    public VariaveisValoresPadrao(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "VariaveisValoresPadrao";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome, fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static synchronized VariaveisValoresPadrao getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static synchronized VariaveisValoresPadrao getInstancia(Context pContexto){
        try {
            if (uVariaveisValoresPadrao == null) uVariaveisValoresPadrao = new VariaveisValoresPadrao(pContexto);
            return uVariaveisValoresPadrao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}
