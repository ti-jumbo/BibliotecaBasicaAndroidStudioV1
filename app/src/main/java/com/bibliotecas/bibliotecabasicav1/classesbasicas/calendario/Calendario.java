package com.bibliotecas.bibliotecabasicav1.classesbasicas.calendario;

import android.app.DatePickerDialog;
import android.content.Context;
import android.view.Gravity;
import android.view.View;
import android.widget.DatePicker;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import java.util.Calendar;
import java.util.Date;

public class Calendario extends DatePickerDialog {
    public Calendario(@NonNull Context context, @Nullable OnDateSetListener listener, int year, int month, int dayOfMonth) {
        super(context, listener, year, month, dayOfMonth);
    }


    public Calendario(Context context, final View v, Date d) {
        super(context ,android.R.style.Theme_Holo_Light_Dialog_MinWidth,new OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                ((TextView) v).setText(String.format("%02d",(month+1)) + "/" + String.format("%04d",year));
            }
        },d.getYear(),d.getMonth(),d.getDate());

        LinearLayout ltCalendario = (LinearLayout) this.getDatePicker().getChildAt(0);
        ltCalendario = (LinearLayout) ltCalendario.getChildAt(0);
        LinearLayout l = (LinearLayout) ltCalendario.getChildAt(0);
        l.setVisibility(View.INVISIBLE);
        l = (LinearLayout) ltCalendario.getChildAt(1);
        l.setGravity(Gravity.LEFT);
    }

    public Calendario(Context context, final View v, Calendar c) {
        super(context ,android.R.style.Theme_Holo_Light_Dialog_MinWidth,new OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker view, int year, int month, int dayOfMonth) {
                ((TextView) v).setText(String.format("%02d",(month+1)) + "/" + String.format("%04d",year));
            }
        },c.get(Calendar.YEAR),c.get(Calendar.MONTH),c.get(Calendar.DAY_OF_MONTH));

        LinearLayout ltCalendario = (LinearLayout) this.getDatePicker().getChildAt(0);
        ltCalendario = (LinearLayout) ltCalendario.getChildAt(0);
        LinearLayout l = (LinearLayout) ltCalendario.getChildAt(0);
        l.setVisibility(View.INVISIBLE);
        l = (LinearLayout) ltCalendario.getChildAt(1);
        l.setGravity(Gravity.LEFT);
    }
}
