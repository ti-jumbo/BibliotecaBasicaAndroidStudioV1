package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;
import android.view.View;

import androidx.constraintlayout.widget.ConstraintLayout;

public class ViewDesenhoLinha extends View {

    public ViewDesenhoLinha(Context context, int width, int height, int corFundo) {
        super(context);
        this.setId(View.generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.setBackgroundColor((corFundo));
    }
}
