package com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;

import java.lang.reflect.Method;

public class CaixaDialogoCheckBox extends CaixaDialogoPadrao {
    private String cnome = "CaixaDialogoCheckBox";
    private String textoBotaoPositivo = "OK";
    protected DialogInterface.OnClickListener eventoBotaoPositivo = null;
    protected String[] opcoes;
    protected boolean[] checados;
    protected Method metodoAoSelecionarOpcao = null;
    protected Object objetoAoSelecionarOpcao = null;


    public CaixaDialogoCheckBox(Context pContexto){
        super(pContexto);
        try {
            String fnome = "CaixaDialogoCheckBox";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @NonNull
    @Override
    public Dialog onCreateDialog(@Nullable Bundle savedInstanceState) {
        try {
            String fnome = "onCreateDialog";
            objs.funcoesBasicas.logi(cnome,fnome);
            AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
            if (this.titulo != null) {
                builder.setTitle(this.titulo);
            }
            if (this.idLayoutView != 0) {
                builder.setView(this.idLayoutView);
            }
            if (this.mensagem != null) {
                builder.setMessage(this.mensagem);
            }
            if (this.botoesPadraoVisiveis) {
                builder.setNegativeButton(null, null);
                builder.setPositiveButton(this.textoBotaoPositivo, this.eventoBotaoPositivo);
            }
            builder.setMultiChoiceItems(opcoes, checados, new DialogInterface.OnMultiChoiceClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i, boolean b) {
                    clicouOpcao(i,b);
                }
            });
            objs.funcoesBasicas.logf(cnome,fnome);
            return builder.create();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    @Override
    public void onHiddenChanged(boolean hidden) {
        try {
            String fnome = "onHiddenChanged";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.objs.variaveisBasicas.setCaixaDialogoPadraoVisivel(this.caixaDialogoPadraoAnterior);
            super.onHiddenChanged(hidden);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public CaixaDialogoCheckBox mostrar(){
        try {
            String fnome = "mostrar";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.show(this.objs.variaveisBasicas.getActivityAtual().getSupportFragmentManager(),"dialog");
            this.caixaDialogoPadraoAnterior = this.objs.variaveisBasicas.getCaixaDialogoPadraoVisivel();
            this.objs.variaveisBasicas.setCaixaDialogoPadraoVisivel(this);
            objs.funcoesBasicas.logf(cnome,fnome);
            return this;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public void clicouOpcao(int i, boolean b) {
        try {
            String fnome = "clicouOpcao";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.metodoAoSelecionarOpcao != null) {
                this.metodoAoSelecionarOpcao.invoke(this.objetoAoSelecionarOpcao, i, b);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public Method getMetodoAoSelecionarOpcao() {
        return metodoAoSelecionarOpcao;
    }

    public void setMetodoAoSelecionarOpcao(Method metodoAoSelecionarOpcao) {
        this.metodoAoSelecionarOpcao = metodoAoSelecionarOpcao;
    }

    public Object getObjetoAoSelecionarOpcao() {
        return objetoAoSelecionarOpcao;
    }

    public void setObjetoAoSelecionarOpcao(Object objetoAoSelecionarOpcao) {
        this.objetoAoSelecionarOpcao = objetoAoSelecionarOpcao;
    }

    public String[] getOpcoes() {
        return opcoes;
    }

    public void setOpcoes(String[] opcoes) {
        this.opcoes = opcoes;
    }

    public boolean[] getChecados() {
        return checados;
    }

    public void setChecados(boolean[] checados) {
        this.checados = checados;
    }
}