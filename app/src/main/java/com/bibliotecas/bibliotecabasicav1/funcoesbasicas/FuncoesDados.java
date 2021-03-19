package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.content.Context;
import android.database.Cursor;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONObject;

public class FuncoesDados extends FuncoesBase {
    private static String cnome = "FuncoesDados";
    private static FuncoesDados uFuncoesDados;

    public FuncoesDados(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "FuncoesDados";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesDados getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesDados getInstancia(Context pContexto) {
        try {
            if (uFuncoesDados == null) {
                uFuncoesDados = new FuncoesDados(pContexto);
            }
            return uFuncoesDados;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void fecharCursor(Cursor cursor) {
        try {
            if (cursor != null) {
                if (!cursor.isClosed()) {
                    cursor.close();
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static JSONObject registroComoJsonObject(Cursor pCursorDados) {
        try {
            JSONObject retorno = null;
            if (pCursorDados != null) {
                int qtCols = pCursorDados.getColumnCount();
                if (qtCols > 0) {
                    retorno = new JSONObject();
                    for (int i = 0; i < qtCols; i++) {
                        retorno.put(pCursorDados.getColumnName(i), pCursorDados.getString(i));
                    }
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
}