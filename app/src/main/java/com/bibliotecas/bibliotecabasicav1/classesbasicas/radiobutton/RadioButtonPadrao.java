package com.bibliotecas.bibliotecabasicav1.classesbasicas.radiobutton;

import android.content.Context;
import android.view.View;
import android.widget.RadioGroup;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho.ViewDesenhoLinha;

public class RadioButtonPadrao extends androidx.appcompat.widget.AppCompatRadioButton {

    public RadioButtonPadrao(Context context, RadioGroup parent, String texto, int tamanhoTexto) {
        super(context);
        this.setId(View.generateViewId());
        RadioGroup.LayoutParams lp = new RadioGroup.LayoutParams(RadioGroup.LayoutParams.MATCH_PARENT,RadioGroup.LayoutParams.WRAP_CONTENT);
        lp.setMargins(10,10,10,10);
        this.setLayoutParams(lp);
        this.setTextSize(tamanhoTexto);
        this.setText(texto);
        if (parent.getChildCount() > 0) {
            parent.addView(new ViewDesenhoLinha(context, RadioGroup.LayoutParams.MATCH_PARENT, 2, getResources().getColor(R.color.cinzatransp)));
        }
        parent.addView(this);
    }
}
