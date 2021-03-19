package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;
import android.webkit.WebView;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.sql.TSql;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import java.lang.reflect.Method;

public class Variaveis extends ClasseBase {
    private static String cnome = "Variaveis";
    private static Variaveis uvariaveis;
    private static Integer codTabConsultar;
    private static String codusur ;
    private static Method funcretreq;
    private static Method funcretreqLoc;
    private static WebView imagemCarregandoAtual;
    private static Boolean logado;
    private static Method metodo_esconder_carregando;
    private static Object objretreq;
    private static Object objretreqLocal;
    private static TSql sql;
    private static Object objetodadosestprod = null;
    public static String sepn1 = "_1N_,_N1_";
    public static String sepn2 = "_2N_,_N2_";
    public static Tipos.TCnjChaveValor dados = null;
    public static Tipos.TDadosUsuario dadosUsuario = null;
    public static String[] visoesDisponiveis = null;

    private Variaveis(Context pContexto){
        super(pContexto);
        try {
            String fnome = "Variaveis";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            this.logado = false;
            this.codTabConsultar = 0;
            this.sql = new TSql(this.contexto);
            this.dados = new Tipos.TCnjChaveValor();
            this.dadosUsuario = new Tipos.TDadosUsuario();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized Variaveis getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized Variaveis getInstancia(Context vContexto){
        try {
            if (uvariaveis == null) uvariaveis = new Variaveis(vContexto);
            return uvariaveis;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized String getCodusur(){
        try {
            if (Variaveis.getInstancia(contexto).codusur != null) {
                return Variaveis.getInstancia(contexto).codusur;
            } else {
                return "";
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Object getObjretreqLocal() {
        try {
            return objretreqLocal;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Method getFuncretreqLoc() {
        try {
            return funcretreqLoc;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static synchronized Method getFuncRetReq(){
        try {
            return Variaveis.getInstancia(contexto).funcretreq;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static synchronized Object getObjRetReq(){
        try {
            return Variaveis.getInstancia(contexto).objretreq;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static TSql getSql(Context pContexto) {
        try {
            return Variaveis.getInstancia(pContexto).sql;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static void setLogado(Boolean pLogado) {
        try {
            String fnome = "setLogado";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).logado = pLogado;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setCodusur(String pCodurus){
        try {
            String fnome = "setCodusur";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).codusur = pCodurus;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setObjRetReq(Object pObjretreq){
        try {
            String fnome = "setObjRetReq";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).objretreq = pObjretreq;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setObjretreqLocal(Object pObjretreqLocal) {
        try {
            String fnome = "setObjretreqLocal";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).objretreqLocal = pObjretreqLocal;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setFuncRetReq(Method pFuncretreq){
        try {
            String fnome = "setFuncRetReq";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).funcretreq = pFuncretreq;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setFuncretreqLoc(Method pFuncretreqLoc) {
        try {
            String fnome = "setFuncretreqLoc";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).funcretreqLoc = pFuncretreqLoc;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Boolean getLogado() {
        try {
            String fnome = "getLogado";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.funcoesBasicas.log("logado", Variaveis.getInstancia(contexto).logado);
            objs.funcoesBasicas.logf(cnome,fnome);
            return Variaveis.getInstancia(contexto).logado;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }
    public static void setCodTabConsultar(Integer pCodTabConsultar){
        try {
            String fnome = "setCodTabConsultar";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).codTabConsultar = pCodTabConsultar;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static synchronized Integer getCodTabConsultar(){
        try {
            return Variaveis.getInstancia(contexto).codTabConsultar;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return -1;
        }
    }

    public static Object getObjetodadosestprod() {
        try {
            return Variaveis.getInstancia(contexto).objetodadosestprod;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public static void setObjetodadosestprod(Object pObjetodadosestprod) {
        try {
            String fnome = "setObjetodadosestprod";
            objs.funcoesBasicas.logi(cnome,fnome);
            Variaveis.getInstancia(contexto).objetodadosestprod = pObjetodadosestprod;
            objs.funcoesBasicas.logi(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
}
