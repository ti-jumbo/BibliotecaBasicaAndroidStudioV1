package com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class CaixaAlertaDialogo extends CaixaDialogoPadrao {
    private String cnome = "CaixaAlertaDialogo";
    private String textoBotaoPositivo = "OK";
    protected DialogInterface.OnClickListener eventoBotaoPositivo = null;

    public CaixaAlertaDialogo(Context pContexto){
        super(pContexto);
        String fnome = "CaixaAlertaDialogo";
        contexto = pContexto;
        objs = ObjetosBasicos.getInstancia(contexto);
        objs.funcoesBasicas.logi(cnome,fnome);
        objs.funcoesBasicas.logf(cnome,fnome);
    }

    @NonNull
    @Override
    public Dialog onCreateDialog(@Nullable Bundle savedInstanceState) {
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
            if (this.botaoPositivoVisivel) {
                builder.setPositiveButton(this.textoBotaoPositivo, this.eventoBotaoPositivo);
            } else {
                builder.setPositiveButton(null, null);
            }
        }
        objs.funcoesBasicas.logf(cnome,fnome);
        return builder.create();
    }

}