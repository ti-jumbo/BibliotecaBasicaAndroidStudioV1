package com.bibliotecas.bibliotecabasicav1.classesbasicas;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public abstract class ClasseBase {
    private String cnome = "ClasseBase";
    protected static ObjetosBasicos objs = null;
    protected static Context contexto = null;

    public ClasseBase(Context pContexto) {
        try {
            String fnome = "ClasseBase";
            System.out.println("Inicio " + cnome + "." + fnome);
            contexto = contexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.variaveisBasicas.adicionarObjeto(this);
            System.out.println("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public ClasseBase(Context pContexto, String pNomeAppDB) {
        try {
            String fnome = "ClasseBase";
            System.out.println("Inicio " + cnome + "." + fnome);
            contexto = contexto;
            objs = ObjetosBasicos.getInstancia(contexto,pNomeAppDB);
            objs.variaveisBasicas.adicionarObjeto(this);
            System.out.println("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
