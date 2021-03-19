package com.bibliotecas.bibliotecabasicav1.classesbasicas.desenho;

import android.content.Context;

import androidx.constraintlayout.widget.ConstraintLayout;

public class ViewDesenhoBarra extends ViewDesenhoBase {

    public ViewDesenhoBarra(Context context, int width, int height, int corFundo) {
        super(context);
        this.setId(generateViewId());
        this.setLayoutParams(new ConstraintLayout.LayoutParams(width,height));
        this.setBackgroundColor((corFundo));
    }

}
