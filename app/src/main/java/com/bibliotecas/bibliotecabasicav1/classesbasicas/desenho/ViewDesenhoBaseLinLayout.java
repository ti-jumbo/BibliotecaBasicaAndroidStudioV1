package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.view.View;
import android.widget.LinearLayout;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONArray;

public class ViewDesenhoBaseLinLayout extends LinearLayout {
    public JSONArray dados = null;
    protected ObjetosBasicos objs = null;
    public ViewDesenhoBaseLinLayout(Context context) {
        super(context);
        objs = ObjetosBasicos.getInstancia(context);
    }
}

