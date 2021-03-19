package com.bibliotecas.bibliotecabasicav1.classesbasicas.listview;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.util.ArrayList;

public class ListAdapter2linhas extends ListAdapterBase<ItemListView2linhas> {
    private String cnome = "ListAdapter2linhas";
    private Context contexto;
    private ArrayList<ItemListView2linhas> listaitens;

    public ListAdapter2linhas(Context pContexto, ArrayList<ItemListView2linhas> listaitens){
        super(pContexto,listaitens);
        String fnome = "ListAdapter2linhas";
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        this.listaitens = listaitens;
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemListView2linhas itemposicao = this.listaitens.get(position);
        convertView = LayoutInflater.from(this.contexto).inflate(R.layout.itemlistview2linhas,null);
        TextView textviewlinha1 = convertView.findViewById(R.id.textviewlinha1);
        textviewlinha1.setText(itemposicao.getLinha1());
        TextView textviewlinha2 = convertView.findViewById(R.id.textviewlinha2);
        textviewlinha2.setText(itemposicao.getLinha2());
        return convertView;
    }

}
