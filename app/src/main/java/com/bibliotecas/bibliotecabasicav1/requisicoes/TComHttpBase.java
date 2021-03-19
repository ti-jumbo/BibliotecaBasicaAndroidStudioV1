package com.bibliotecas.bibliotecabasicav1.requisicoes;

import android.content.Context;
import android.os.AsyncTask;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONObject;

import java.net.HttpURLConnection;
import java.net.URL;

public abstract class TComHttpBase extends AsyncTask<URL, Integer, Long> {
    private String cnome = "TComHttpBase";
    protected ObjetosBasicos objs = null;
    protected Context contexto;
    public String response = "";
    protected Boolean passaParams = true;
    protected String metodoReq = "POST";
    public JSONObject req;
    HttpURLConnection client = null;
    int responseCode = 0;

    public TComHttpBase(Context pContexto) {
        super();
        try {
            String fnome = "TComHttpBase";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            if (contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logi(cnome,fnome);
            this.passaParams = true;
            this.metodoReq = "POST";
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}
