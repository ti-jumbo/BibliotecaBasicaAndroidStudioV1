package com.bibliotecas.bibliotecabasicav1.classesbasicas.spinner;

import android.content.Context;
import android.graphics.Color;
import android.text.TextUtils;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Spinner;
import android.widget.TextView;

import com.bibliotecas.bibliotecabasicav1.R;

import java.util.ArrayList;

public class SpinnerAdapter2Linhas extends SpinnerAdapterBase {
    int indColDados = 0;
    int indColDadosL0 = 0;
    int indColDadosL1 = 1;
    public SpinnerAdapter2Linhas(Spinner spinner, Context context, int layoutResourceId, int textViewResourceId) {
        super(spinner, context, layoutResourceId, textViewResourceId);
    }
    public SpinnerAdapter2Linhas(Spinner spinner, Context context, int layoutResourceId, int textViewResourceId, ArrayList objetcts) {
        super(spinner, context, layoutResourceId, textViewResourceId, objetcts);
    }
    @Override
    public View getDropDownView(int position, View convertView,
                                ViewGroup parent) {
        if (convertView == null) {
            LayoutInflater inflater = LayoutInflater.from(context);
            convertView = inflater.inflate(
                    R.layout.spinner_item_2linhas, parent, false);
        }
        TextView tv = convertView.findViewById(R.id.textViewSpinner);
        if (position == 0 && this.temSelecaoEmBranco) {
            tv.setText(items.get(position).get(0));
            tv.setTextColor(corItemSelecaoNula);
            tv.setTextSize(16);
            tv = convertView.findViewById(R.id.textViewSpinnerLinha2);
            tv.setText(null);
        } else {
            tv.setText(items.get(position).get(this.indColDadosL0));
            tv.setTextColor(Color.GRAY);
            tv.setTextSize(16);
            tv = convertView.findViewById(R.id.textViewSpinnerLinha2);
            tv.setText(items.get(position).get(this.indColDadosL1));
            tv.setTextColor(Color.GRAY);
            tv.setTextSize(12);
        }
        return convertView;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View v = super.getView(position, convertView, parent);
        TextView tv = ((TextView) v.findViewById(R.id.textViewSpinner));
        if (position == 0 && this.temSelecaoEmBranco) {
            tv.setText(this.items.get(position).get(0));
            tv.setTextColor(corItemSelecaoNula);
            tv.setSingleLine();
            tv.setEllipsize(TextUtils.TruncateAt.END);
            tv.setTextSize(20);
            tv.setGravity(Gravity.LEFT);
        } else {
            tv.setText(this.items.get(position).get(this.indColDados));
            tv.setTextColor(Color.GRAY);
            tv.setSingleLine();
            tv.setEllipsize(TextUtils.TruncateAt.END);
            tv.setTextSize(20);
            tv.setGravity(Gravity.LEFT);
        }
        return tv;
    }

    public void setIndColDados(int pIndColDados) {
        this.indColDados = pIndColDados;
    }

    public void setIndColDadosL0(int pIndColDadosL0) {
        this.indColDadosL0 = pIndColDadosL0;
    }

    public void setIndColDadosL1(int pIndColDadosL1) {
        this.indColDadosL1 = pIndColDadosL1;
    }
}
