package com.bibliotecas.bibliotecabasicav1.classesbasicas.carregando;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import androidx.constraintlayout.widget.ConstraintLayout;

import com.bibliotecas.bibliotecabasicav1.R;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class ViewCarregando extends ProgressBar {

    private String cnome = "ViewCarregando";
    public Runnable processoEsconderUI = null;
    public Runnable processoMostrarUI = null;
    private Context contexto = null;
    private ObjetosBasicos objs = null;


    public ViewCarregando(ViewGroup parent, Context pContexto) {
        super(pContexto);
        try {
            String fnome = "ViewCarregando";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (parent != null) {
                objs = ObjetosBasicos.getInstancia(parent.getContext());
            } else {
                objs = ObjetosBasicos.getInstancia();
            }
            ConstraintLayout.LayoutParams lp = new ConstraintLayout.LayoutParams(ConstraintLayout.LayoutParams.MATCH_PARENT, ConstraintLayout.LayoutParams.MATCH_PARENT);
            this.setLayoutParams(lp);
            this.setBackgroundColor(getResources().getColor(R.color.cinzatransp));
            this.setVisibility(View.INVISIBLE);
            parent.addView(this, 0);
            this.processoEsconderUI  = new Runnable() {
                @Override
                public void run() {
                    _esconderUI();
                }
            };
            this.processoMostrarUI  = new Runnable() {
                @Override
                public void run() {
                    _mostrarUI();
                }
            };
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void _mostrarUI(){
        try {
            this.setVisibility(View.VISIBLE);
            this.bringToFront();
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void mostrar(){
        try {
            if (this.getVisibility() == View.INVISIBLE) {
                if (this.processoMostrarUI != null) {
                    this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(this.processoMostrarUI);
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void _esconderUI(){
        try {
            this.setVisibility(View.INVISIBLE);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void esconder(){
        try {
            if (this.getVisibility() == View.VISIBLE) {
                this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(this.processoEsconderUI);
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

}
