package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public abstract class FuncoesBase extends ClasseBase {
    private String cnome = "FuncoesBase";

    public FuncoesBase(Context vContexto) {
        super(vContexto);
        try {
            String fnome = "FuncoesBase";
            contexto = vContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public FuncoesBase(Context vContexto,String pNomeAppDB) {
        super(vContexto, pNomeAppDB);
        try {
            String fnome = "FuncoesBase";
            contexto = vContexto;
            objs = ObjetosBasicos.getInstancia(contexto, pNomeAppDB);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}
