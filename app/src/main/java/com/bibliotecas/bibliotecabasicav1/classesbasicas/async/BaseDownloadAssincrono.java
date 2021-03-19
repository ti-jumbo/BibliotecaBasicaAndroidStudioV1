package com.bibliotecas.bibliotecabasicav1.classesbasicas.async;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

public class BaseDownloadAssincrono extends BaseTarefaAssincrona {
    private String cnome = "BaseDownloadAssincrono";
    private String caminhoOrigem = null;
    private String caminhoDestino = null;
    public BaseDownloadAssincrono(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "BaseDownloadAssincrono";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public String getCaminhoOrigem() {
        return caminhoOrigem;
    }

    public void setCaminhoOrigem(String pCaminhoOrigem) {
        this.caminhoOrigem = pCaminhoOrigem;
    }

    public String getCaminhoDestino() {
        return caminhoDestino;
    }

    public void setCaminhoDestino(String pCaminhoDestino) {
        this.caminhoDestino = pCaminhoDestino;
    }
}
