package com.bibliotecas.bibliotecabasicav1.classesbasicas.carregando;

import android.content.Context;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.constraintlayout.widget.ConstraintSet;

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
            this.setId(objs.funcoesObjeto.gerarIdView());
            objs.funcoesBasicas.logi(cnome,fnome);
            if (parent != null) {
                objs = ObjetosBasicos.getInstancia(parent.getContext());
                parent.addView(this, 0);
            } else {
                objs = ObjetosBasicos.getInstancia();
            }

            ConstraintLayout.LayoutParams lp = new ConstraintLayout.LayoutParams(ConstraintLayout.LayoutParams.MATCH_PARENT, ConstraintLayout.LayoutParams.MATCH_PARENT);
            this.setLayoutParams(lp);
            this.setBackgroundColor(getResources().getColor(R.color.cinzatransp));
            if (parent != null && parent instanceof ConstraintLayout) {

                /*previne de existir childview em parent que nao tenha id definido, o que geraria erro no processo .clone do ConstraintSet*/
                int qt = parent.getChildCount();
                for (int i = 0; i < qt; i++) {
                    if (parent.getChildAt(i).getId() == -1) {
                        parent.getChildAt(i).setId(objs.funcoesObjeto.gerarIdView());
                    }
                }

                ConstraintSet cs = new ConstraintSet();
                cs.clone((ConstraintLayout) parent);
                cs.connect(parent.getId(), ConstraintSet.TOP, this.getId(), ConstraintSet.TOP, 0);
                cs.connect(parent.getId(), ConstraintSet.LEFT, this.getId(), ConstraintSet.LEFT, 0);
                cs.connect(parent.getId(), ConstraintSet.RIGHT, this.getId(), ConstraintSet.RIGHT, 0);
                cs.connect(parent.getId(), ConstraintSet.BOTTOM, this.getId(), ConstraintSet.BOTTOM, 0);
                cs.applyTo((ConstraintLayout) parent);
            }

            this.setVisibility(View.INVISIBLE);

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
            String fnome = "_mostrarUI";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.setVisibility(View.VISIBLE);
            this.bringToFront();
            this.requestLayout();
            this.invalidate();
            if (this.getParent() != null) {
                this.getParent().bringChildToFront(this);
                this.getParent().requestLayout();
                ((ViewGroup)this.getParent()).invalidate();
                this.getParent().bringChildToFront(this);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void mostrar(){
        try {
            String fnome = "mostrar";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.getVisibility() != View.VISIBLE) {
                if (this.processoMostrarUI == null) {
                    this.processoMostrarUI  = new Runnable() {
                        @Override
                        public void run() {
                            _mostrarUI();
                        }
                    };
                }
                if (this.processoMostrarUI != null) {
                    this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(this.processoMostrarUI);
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    private void _esconderUI(){
        try {
            String fnome = "_esconderUI";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.setVisibility(View.INVISIBLE);
            if (this.getParent() != null) {
                ((ViewGroup) this.getParent()).removeView(this);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void esconder(){
        try {
            String fnome = "esconder";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.getVisibility() == View.VISIBLE) {
                if (this.processoEsconderUI == null) {
                    this.processoEsconderUI  = new Runnable() {
                        @Override
                        public void run() {
                            _esconderUI();
                        }
                    };
                }
                this.objs.variaveisBasicas.getActivityPrincipal().runOnUiThread(this.processoEsconderUI);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

}
