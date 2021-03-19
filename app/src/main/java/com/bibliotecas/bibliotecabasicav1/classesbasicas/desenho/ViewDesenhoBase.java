package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.view.View;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONArray;

public class ViewDesenhoBase extends View {
    public JSONArray dados = null;
    protected ObjetosBasicos objs = null;
    public ViewDesenhoBase(Context context) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
    }
}
