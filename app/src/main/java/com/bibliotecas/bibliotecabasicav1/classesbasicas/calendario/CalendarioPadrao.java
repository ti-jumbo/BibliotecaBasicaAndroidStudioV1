package com.bibliotecas.bibliotecabasicav1.classesbasicas.calendario;

import android.app.DatePickerDialog;
import android.content.Context;
import android.view.View;
import android.widget.DatePicker;
import android.widget.TextView;

import androidx.annotation.NonNull;

import java.util.Calendar;
import java.util.Date;

public class CalendarioPadrao extends DatePickerDialog {
    protected View viewDest = null;

    public CalendarioPadrao(@NonNull Context context, final View viewDest, Calendar c) {
        super(context, new OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                ((TextView)viewDest).setText(String.format("%02d",dayOfMonth) + "/" + String.format("%02d",(month+1)) + "/" + String.format("%04d",year));
            }
        },c.get(Calendar.YEAR),c.get(Calendar.MONTH),c.get(Calendar.DAY_OF_MONTH));
        setViewDest(viewDest);
    }

    public void setViewDest(View v) {
        this.viewDest = v;
        if (v instanceof TextView) { //textview|edittext|button
            ((TextView)v).setOnFocusChangeListener(new TextView.OnFocusChangeListener() {
                @Override
                public void onFocusChange(View v, boolean hasFocus) {
                    if (hasFocus) {
                        if (!getInstancia().isShowing()) {
                            mostrar();
                        }
                    } else {
                        getInstancia().hide();
                    }
                }
            });
        }
        v.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (!getInstancia().isShowing()) {
                    mostrar();
                }
            }
        });
    }

    public CalendarioPadrao getInstancia(){
        return this;
    }

    public View getViewDest(){
        return this.viewDest;
    }

    public void mostrar(){
        String dataDest = ((TextView)this.getViewDest()).getText().toString();
        Date dataAtual = new Date();
        if (dataDest != null) {
            if (dataDest.trim().length() > 0) {
                String[] itensData = dataDest.split("/");
                Calendar c = Calendar.getInstance();
                c.set(Calendar.YEAR,Integer.parseInt(itensData[2]));
                c.set(Calendar.MONTH,Integer.parseInt(itensData[1])-1);
                c.set(Calendar.DAY_OF_MONTH, Integer.parseInt(itensData[0]));
                this.updateDate(c.get(Calendar.YEAR),c.get(Calendar.MONTH),c.get(Calendar.DAY_OF_MONTH));
            } else {
                Calendar c = Calendar.getInstance();
                this.updateDate(c.get(Calendar.YEAR),c.get(Calendar.MONTH),c.get(Calendar.DAY_OF_MONTH));
            }
        } else {
            Calendar c = Calendar.getInstance();
            this.updateDate(c.get(Calendar.YEAR),c.get(Calendar.MONTH),c.get(Calendar.DAY_OF_MONTH));
        }
        this.show();
    }

}
