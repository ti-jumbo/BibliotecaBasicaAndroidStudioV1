package com.bibliotecas.bibliotecabasicav1.classesbasicas.async;

import android.content.Context;
import android.os.AsyncTask;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;

public class BaseTarefaAssincrona extends AsyncTask<Object,Integer,Long> {
    private String cnome = "BaseTarefaAssincrona";
    protected ObjetosBasicos objs = null;
    private Object objetoExecutar = null;
    private Method metodoExecutar = null;
    private Object objetoParametro = null;
    private Object objetoExecutarAoConcluir = null;
    private Method metodoExecutarAoConcluir = null;
    private Object objetoParametroAoConcluir = null;
    protected Context contexto = null;

    public BaseTarefaAssincrona(Context pContexto){
        super();
        try {
            String fnome = "BaseTarefaAssincrona";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    @Override
    protected Long doInBackground(Object... objects) {
        try {
            String fnome = "doInBackground";
            objs.funcoesBasicas.logi(cnome,fnome);
            try {
                if (this.metodoExecutar != null) {
                    objs.funcoesBasicas.log("Tarefa assincrona chamando metodo: " + this.metodoExecutar.getName());
                    if (objects != null) {
                        if (objects.length > 0) {
                            objs.funcoesBasicas.log("object parametros tamanho " + objects.length);
                            this.metodoExecutar.invoke(this.objetoExecutar, objects);
                        } else {
                            objs.funcoesBasicas.log("object parametros tamanho 0");
                            this.metodoExecutar.invoke(this.objetoExecutar);
                        }
                    } else {
                        objs.funcoesBasicas.log("object parametros nulo");
                        this.metodoExecutar.invoke(this.objetoExecutar);
                    }
                }
            } catch (IllegalAccessException e) {
                e.printStackTrace();
            } catch (InvocationTargetException e) {
                e.printStackTrace();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return null;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    @Override
    protected void onPostExecute(Long aLong) {
        try {
            String fnome = "onPostExecute";
            objs.funcoesBasicas.logi(cnome,fnome);
            super.onPostExecute(aLong);
            try {
                if (this.metodoExecutarAoConcluir != null) {
                    objs.funcoesBasicas.log("Tarefa assincrona chamando metodo ao concluir: " + this.metodoExecutarAoConcluir.getName());
                    if (this.objetoParametroAoConcluir != null) {
                        objs.funcoesBasicas.log("tem parametros");
                        this.metodoExecutarAoConcluir.invoke(this.objetoExecutarAoConcluir,this.objetoParametroAoConcluir);
                    } else {
                        objs.funcoesBasicas.log("nao tem parametros");
                        this.metodoExecutarAoConcluir.invoke(this.objetoExecutarAoConcluir);
                    }
                }
            } catch (IllegalAccessException e) {
                e.printStackTrace();
            } catch (InvocationTargetException e) {
                e.printStackTrace();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }


    public Object getObjetoExecutar() {
        return objetoExecutar;
    }

    public void setObjetoExecutar(Object pObjetoExecutar) {
        this.objetoExecutar = pObjetoExecutar;
    }

    public Method getMetodoExecutar() {
        return metodoExecutar;
    }

    public void setMetodoExecutar(Method pMetodoExecutar) {
        this.metodoExecutar = pMetodoExecutar;
    }

    public Object getObjetoParametro() {
        return objetoParametro;
    }

    public void setObjetoParametro(Object pObjetoParametro) {
        this.objetoParametro = objetoParametro;
    }

    public Object getObjetoExecutarAoConcluir() {
        return objetoExecutarAoConcluir;
    }

    public void setObjetoExecutarAoConcluir(Object pObjetoExecutarAoConcluir) {
        this.objetoExecutarAoConcluir = pObjetoExecutarAoConcluir;
    }

    public Method getMetodoExecutarAoConcluir() {
        return metodoExecutarAoConcluir;
    }

    public void setMetodoExecutarAoConcluir(Method pMetodoExecutarAoConcluir) {
        this.metodoExecutarAoConcluir = pMetodoExecutarAoConcluir;
    }

    public Object getObjetoParametroAoConcluir() {
        return objetoParametroAoConcluir;
    }

    public void setObjetoParametroAoConcluir(Object pObjetoParametroAoConcluir) {
        this.objetoParametroAoConcluir = pObjetoParametroAoConcluir;
    }
}
