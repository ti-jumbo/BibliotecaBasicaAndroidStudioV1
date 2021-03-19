package com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.DialogFragment;
import androidx.fragment.app.FragmentManager;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class CaixaDialogoPadrao extends DialogFragment {
    private String cnome = "CaixaDialogoPadrao";
    protected String titulo = null;
    protected String mensagem = null;
    protected String textoBotaoNegativo = "NÃO";
    protected String textoBotaoPositivo = "SIM";
    protected int idLayoutView = 0;
    protected DialogInterface.OnClickListener eventoBotaoNegativo = null;
    protected DialogInterface.OnClickListener eventoBotaoPositivo = null;
    protected Method eventoDismiss = null;
    protected Method eventoCancelar = null;
    protected Object objetoDismiss = null;
    protected Object objetoCancelar = null;
    protected CaixaDialogoPadrao caixaDialogoPadraoAnterior = null;
    protected boolean botoesPadraoVisiveis = true;
    protected boolean botaoNegativoVisivel = true;
    protected boolean botaoPositivoVisivel = true;
    protected boolean cancelavel = true;
    protected ObjetosBasicos objs = null;
    boolean mIsStateAlreadySaved = false;
    boolean mPendingShowDialog = false;
    protected Context contexto = null;

    public CaixaDialogoPadrao(Context pContexto){
        super();
        try{
            String fnome = "CaixaDialogoPadrao";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
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
            super.onCreateDialog(savedInstanceState);
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
                if (this.botaoNegativoVisivel == false) {
                    builder.setNegativeButton(null,null);
                } else {
                    builder.setNegativeButton(this.textoBotaoNegativo, this.eventoBotaoNegativo);
                }
                builder.setPositiveButton(this.textoBotaoPositivo, this.eventoBotaoPositivo);
            }
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
            objs.funcoesBasicas.logi(cnome, fnome);
            this.objs.variaveisBasicas.setCaixaDialogoPadraoVisivel(this.caixaDialogoPadraoAnterior);
            super.onHiddenChanged(hidden);
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    /*@Override
    public void show(FragmentManager manager, String tag) {
        try {
            String fnome = "show";
            objs.funcoesBasicas.logi(cnome, fnome);
            FragmentTransaction ft = manager.beginTransaction();
            ft.add(this, tag).addToBackStack(null);
            ft.commitAllowingStateLoss();
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }*/

    @Override
    public void onResume() {
        try{
            String fnome = "onResume";
            objs.funcoesBasicas.logi(cnome, fnome);
            onResumeFragments();
            super.onResume();
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public void onResumeFragments(){
        try{
            String fnome = "onResumeFragments";
            objs.funcoesBasicas.logi(cnome, fnome);
            mIsStateAlreadySaved = false;
            if(mPendingShowDialog){
                mPendingShowDialog = false;
                showSnoozeDialog();
            }
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onPause() {
        try{
            String fnome = "onPause";
            objs.funcoesBasicas.logi(cnome, fnome);
            super.onPause();
            mIsStateAlreadySaved = true;
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void showSnoozeDialog() {
        try {
            String fnome = "showSnoozeDialog";
            objs.funcoesBasicas.logi(cnome, fnome);
            if(mIsStateAlreadySaved){
                mPendingShowDialog = true;
            }else{
                FragmentManager fm = objs.variaveisBasicas.getActivityAtual().getSupportFragmentManager();
                CaixaDialogoPadrao snoozeDialog = new CaixaDialogoPadrao(contexto);
                snoozeDialog.show(fm, "CaixaDialogoPadrao");
            }
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public CaixaDialogoPadrao mostrar(){
        try {
            String fnome = "mostrar";
            objs.funcoesBasicas.logi(cnome, fnome);

            if (objs.variaveisBasicas.getActivityAtual() != null) {
                objs.funcoesBasicas.log("tem activity: "  + objs.variaveisBasicas.getActivityAtual().getClass().getName());
                objs.variaveisBasicas.getActivityAtual().executar_ui(
                        this.objs.variaveisBasicas.getActivityAtual().getSupportFragmentManager().getClass().getMethod("executePendingTransactions"),
                        this.objs.variaveisBasicas.getActivityAtual().getSupportFragmentManager());

                this.show(objs.variaveisBasicas.getActivityAtual().getSupportFragmentManager(), "CaixaDialogoPadrao");
                this.caixaDialogoPadraoAnterior = this.objs.variaveisBasicas.getCaixaDialogoPadraoVisivel();
                this.objs.variaveisBasicas.setCaixaDialogoPadraoVisivel(this);
            } else {
                objs.funcoesBasicas.log("activity atual retornou nulo");
            }
            objs.funcoesBasicas.logf(cnome, fnome);
            return this;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    @Override
    public void onDismiss(@NonNull DialogInterface dialog) {
        try {
            String fnome = "onDismiss";
            objs.funcoesBasicas.logi(cnome, fnome);
            super.onDismiss(dialog);
            if (this.eventoDismiss != null) {
                try {
                    this.eventoDismiss.invoke(this.objetoDismiss);
                } catch (IllegalAccessException e) {
                    e.printStackTrace();
                } catch (InvocationTargetException e) {
                    e.printStackTrace();
                }
            }
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onCancel(@NonNull DialogInterface dialog) {
        try {
            String fnome = "onCancel";
            objs.funcoesBasicas.logi(cnome, fnome);
            super.onCancel(dialog);
            objs.funcoesBasicas.logf(cnome, fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public String getTitulo() {
        return titulo;
    }

    public void setTitulo(String pTitulo) {
        this.titulo = pTitulo;
    }

    public String getMensagem() {
        return mensagem;
    }

    public void setMensagem(String pMensagem) {
        this.mensagem = pMensagem;
    }

    public String getTextoBotaoNegativo() {
        return textoBotaoNegativo;
    }

    public void setTextoBotaoNegativo(String pTextoBotaoNegativo) {
        this.textoBotaoNegativo = pTextoBotaoNegativo;
    }

    public String getTextoBotaoPositivo() {
        return textoBotaoPositivo;
    }

    public void setTextoBotaoPositivo(String pTextoBotaoPositivo) {
        this.textoBotaoPositivo = pTextoBotaoPositivo;
    }

    public DialogInterface.OnClickListener getEventoBotaoNegativo() {
        return eventoBotaoNegativo;
    }

    public void setEventoBotaoNegativo(DialogInterface.OnClickListener pEventoBotaoNegativo) {
        this.eventoBotaoNegativo = pEventoBotaoNegativo;
    }

    public DialogInterface.OnClickListener getEventoBotaoPositivo() {
        return eventoBotaoPositivo;
    }

    public void setEventoBotaoPositivo(DialogInterface.OnClickListener pEventoBotaoPositivo) {
        this.eventoBotaoPositivo = pEventoBotaoPositivo;
    }

    public int getIdLayoutView() {
        return idLayoutView;
    }

    public void setIdLayoutView(int pIdLayoutView) {
        this.idLayoutView = pIdLayoutView;
    }

    public boolean isBotoesPadraoVisiveis() {
        return botoesPadraoVisiveis;
    }

    public void setBotoesPadraoVisiveis(boolean pBotoesPadraoVisiveis) {
        this.botoesPadraoVisiveis = pBotoesPadraoVisiveis;
    }

    public void setBotaoNegativoInvisivel(){
        this.botaoNegativoVisivel = false;
    }

    public boolean isBotaoNegativoVisivel() {
        return botaoNegativoVisivel;
    }

    public void setBotaoNegativoVisivel(boolean pBotaoNegativoVisivel) {
        this.botaoNegativoVisivel = pBotaoNegativoVisivel;
    }

    public boolean isCancelavel() {
        return cancelavel;
    }

    public void setCancelavel(boolean pCancelavel) {
        this.cancelavel = pCancelavel;
    }

    public Method getEventoDismiss() {
        return eventoDismiss;
    }

    public void setEventoDismiss(Method pEventoDismiss) {
        this.eventoDismiss = pEventoDismiss;
    }

    public Method getEventoCancelar() {
        return eventoCancelar;
    }

    public void setEventoCancelar(Method pEventoCancelar) {
        this.eventoCancelar = pEventoCancelar;
    }

    public Object getObjetoDismiss() {
        return objetoDismiss;
    }

    public void setObjetoDismiss(Object pObjetoDismiss) {
        this.objetoDismiss = pObjetoDismiss;
    }

    public Object getObjetoCancelar() {
        return objetoCancelar;
    }

    public void setObjetoCancelar(Object pObjetoCancelar) {
        this.objetoCancelar = pObjetoCancelar;
    }
}