package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class VariaveisNomesClasses extends ClasseBase {
    private static String cnome = "VariaveisNomesClasses";
    private static VariaveisNomesClasses uVariaveisNomesClasses = null;
    public static String ncl_lt_itens_menu_suspenso = "android.widget.LinearLayout";

    public VariaveisNomesClasses(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "VariaveisNomesClasses";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized VariaveisNomesClasses getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized VariaveisNomesClasses getInstancia(Context pContexto) {
        try {
            if (uVariaveisNomesClasses == null) uVariaveisNomesClasses = new VariaveisNomesClasses(pContexto);
            return uVariaveisNomesClasses;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}
