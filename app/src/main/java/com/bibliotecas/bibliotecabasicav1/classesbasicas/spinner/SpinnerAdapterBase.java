package com.bibliotecas.bibliotecabasicav1.classesbasicas.spinner;

import android.content.Context;
import android.graphics.Color;
import android.text.TextUtils;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Spinner;
import android.widget.TextView;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.util.ArrayList;
import java.util.Arrays;

public class SpinnerAdapterBase extends ArrayAdapter<String> {
    Context context;
    protected ArrayList<ArrayList<String>> items = new ArrayList<ArrayList<String>>();
    protected boolean temSelecaoEmBranco = true;
    protected static String textoSelecaoEmBranco = "(Nao Selecionado)";
    protected Spinner spinner = null;
    protected ObjetosBasicos objs = null;
    protected int corItemSelecaoNula = 0;
    protected int corItemSelecionado = 0;

    public SpinnerAdapterBase(Spinner spinner, Context context,int layoutResourceId, int textViewResourceId) {
        super(context, layoutResourceId,textViewResourceId);
        objs = ObjetosBasicos.getInstancia(context);
        this.corItemSelecaoNula = this.objs.variaveisBasicas.getActivityPrincipal().getResources().getColor(R.color.cinzatransp);
        this.corItemSelecionado = this.objs.variaveisBasicas.getActivityPrincipal().getResources().getColor(R.color.verdetransp);

        this.items = new ArrayList<ArrayList<String>>();
        if (this.temSelecaoEmBranco == true) {
            this.criar_item_selecao_em_branco();
        }
        this.context = context;
        this.spinner = spinner;
    }

    public SpinnerAdapterBase(Spinner spinner, Context context, int layoutResourceId, int textViewResourceId, ArrayList objetcts) {
        super(context, layoutResourceId,textViewResourceId,objetcts);
        this.items = objetcts;
        if (this.temSelecaoEmBranco == true) {
            this.criar_item_selecao_em_branco();
        }
        this.context = context;
        this.spinner = spinner;
    }

    @Override
    public View getDropDownView(int position, View convertView,
                                ViewGroup parent) {
        if (convertView == null) {
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(
                    R.layout.spinner_item_padrao, parent, false);
        }
        TextView tv = convertView.findViewById(R.id.textViewSpinner);
        tv.setText(items.get(position).get(0));
        tv.setTextColor(Color.GRAY);
        tv.setTextSize(16);
        if (position == 0 && this.temSelecaoEmBranco) {
            tv.setTextColor(corItemSelecaoNula);
        }
        return convertView;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View v = super.getView(position, convertView, parent);
        TextView tv = ((TextView) v.findViewById(R.id.textViewSpinner));
        tv.setText(items.get(position).get(0));
        tv.setTextColor(Color.GRAY);
        tv.setSingleLine();
        tv.setEllipsize(TextUtils.TruncateAt.END);
        tv.setTextSize(20);
        tv.setGravity(Gravity.LEFT);
        if (position == 0 && this.temSelecaoEmBranco) {
            tv.setTextColor(corItemSelecaoNula);
        }
        return tv;
    }

    public void criar_item_selecao_em_branco(){
        if (this.items == null) {
            this.items = new ArrayList<ArrayList<String>>();
        }
        this.items.add(0,new ArrayList<String>(Arrays.asList(this.textoSelecaoEmBranco)));
        this.notifyDataSetChanged();
    }

    public void setItemSelecaoNula(ArrayList<String> pItemSelecaoNula){
        this.items.set(0,pItemSelecaoNula);
        this.notifyDataSetChanged();
    }

    public ArrayList<ArrayList<String>> getItems() {
        return items;
    }

    public void setItems(ArrayList<ArrayList<String>> pItems) {
        this.items = pItems;
    }

    public boolean isTemSelecaoEmBranco() {
        return temSelecaoEmBranco;
    }

    public void setTemSelecaoEmBranco(boolean pTemSelecaoEmBranco) {
        this.temSelecaoEmBranco = pTemSelecaoEmBranco;
        if (this.temSelecaoEmBranco == true) {
            this.criar_item_selecao_em_branco();
        }
    }

    public static String getTextoSelecaoEmBranco() {
        return textoSelecaoEmBranco;
    }

    public void setTextoSelecaoEmBranco(String pTextoSelecaoEmBranco) {
        this.textoSelecaoEmBranco = pTextoSelecaoEmBranco;
    }

}
