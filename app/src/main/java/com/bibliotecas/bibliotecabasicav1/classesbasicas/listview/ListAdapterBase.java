package com.bibliotecas.bibliotecabasicav1.classesbasicas.listview;

import android.content.Context;
import android.widget.ArrayAdapter;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.util.ArrayList;

public class ListAdapterBase<T> extends ArrayAdapter<T> {
    private String cnome = "ListAdapterBase";
    protected ObjetosBasicos objs = null;
    protected Context contexto = null;
    public ListAdapterBase(Context pContexto, ArrayList<T> listaitens){
        super(pContexto,0,listaitens);
        String fnome = "ListAdapterBase";
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesBasicas.logf(cnome,fnome);
    }
}
