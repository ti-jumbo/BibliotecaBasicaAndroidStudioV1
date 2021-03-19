package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;

import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;

import java.lang.reflect.InvocationTargetException;
import java.lang.reflect.Method;
import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.Arrays;

public class FuncoesPermissao extends FuncoesBase {
    private static String cnome = "FuncoesPermissao";
    private static FuncoesPermissao uFuncoesPermissao;
    public static final int CODIGO_RESPOSTA_PERMISSAO = 1;
    public static Context contexto = null;
    public static Object objeto = null;
    public static Method metodo = null;
    public static Object[] args = null;
    public static Object retorno = null;
    public static Type tipoRetornoGenerico = null;
    public static Class<?> tipoRetornoObjeto = null;
    private static Tipos.TCnjChaveValor<Tipos.TChaveValor<Tipos.TMetodoRetorno>> cnjMetodosRetornoPermissoes = null;
    private static ArrayList<String> listaTodasPermissoes = null;
    private static ArrayList<String> listaPermissoesManifest = null;

    public FuncoesPermissao(Context vContexto){
        super(vContexto);
        try {
            String fnome = "FuncoesPermissao";
            contexto = vContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            inicializar();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesPermissao getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesPermissao getInstancia(Context vContexto) {
        try {
            if (uFuncoesPermissao == null) {
                uFuncoesPermissao = new FuncoesPermissao(vContexto);
            }
            return uFuncoesPermissao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    private static void inicializarListaPermissoes(){
        try {
            String fnome = "inicializarListaPermissoes";
            objs.funcoesBasicas.logi(cnome,fnome);
            cnjMetodosRetornoPermissoes = new Tipos.TCnjChaveValor<Tipos.TChaveValor<Tipos.TMetodoRetorno>>();
            listaTodasPermissoes = new ArrayList<String>();

            int qt = Manifest.permission.class.getFields().length;
            for (int i = 0; i < qt; i ++) {
                listaTodasPermissoes.add(String.valueOf(Manifest.permission.class.getFields()[i].get(contexto)));
            }
            PackageInfo info = contexto.getPackageManager().getPackageInfo(contexto.getPackageName(), PackageManager.GET_PERMISSIONS);
            String[] permissions = info.requestedPermissions;//This array contains the requested permissions.

            listaPermissoesManifest = new ArrayList<String>(Arrays.asList(permissions));

            objs.funcoesBasicas.log(listaTodasPermissoes);
            objs.funcoesBasicas.log(listaPermissoesManifest);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void inicializar() {
        try {
            String fnome = "inicializar";
            objs.funcoesBasicas.logi(cnome,fnome);
            inicializarListaPermissoes();
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Boolean checarPermissao(String permissao) {
        try {
            String fnome = "checarPermissao";
            objs.funcoesBasicas.logi(cnome,fnome);
            Boolean retorno = true;
            if (ContextCompat.checkSelfPermission(contexto, permissao) != PackageManager.PERMISSION_GRANTED) {
                // Permission is not granted
                retorno = false;
            }
            objs.funcoesBasicas.log("checando permissao para: " + permissao + "=" + String.valueOf(retorno));
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public static void solicitarPermissao(String permissao, int requestCode) {
        try {
            String fnome = "solicitarPermissao";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.variaveisBasicas.getActivityPrincipal().solicitarPermissao(permissao,requestCode);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void solicitarPermissoes(String[] permissoes, int requestCode, Object pObjetoRetorno, Method pMetodoRetorno) {
        try {
            String fnome = "solicitarPermissao";
            objs.funcoesBasicas.logi(cnome,fnome);
            objs.variaveisBasicas.getActivityPrincipal().solicitarPermissoes(permissoes,requestCode, pObjetoRetorno,pMetodoRetorno);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public void executar() {
        String fnome = "executar";
        objs.funcoesBasicas.log("Inicio " + this.cnome + "." + fnome);

        try {
            objs.funcoesBasicas.log(" executando: " + metodo.getName() + ":" + metodo.getReturnType().getName() + " em " + objeto.getClass().getName());
            tipoRetornoObjeto = metodo.getReturnType();
            if (tipoRetornoObjeto != null) {
                objs.funcoesBasicas.log("" + tipoRetornoObjeto.getName());
                if (tipoRetornoObjeto.getName() != "void") {
                    retorno = metodo.invoke(objeto, args);
                } else {
                    metodo.invoke(objeto, args);
                }
            } else {
                tipoRetornoGenerico = metodo.getGenericReturnType();
                if (tipoRetornoGenerico != null) {
                    retorno = metodo.invoke(objeto, args);
                } else {
                    metodo.invoke(objeto, args);
                }
            }
        } catch (IllegalAccessException var3) {
            var3.printStackTrace();
        } catch (InvocationTargetException var4) {
            var4.printStackTrace();
        }

        objs.funcoesBasicas.log("Fim " + this.cnome + "." + fnome);
    }

    public void executar_se_permitido(String permissao, Context contexto, Object objeto, Method methodo, Object... args) {
        int permissionCheck = ContextCompat.checkSelfPermission(contexto, permissao);
        setContexto(contexto);
        setObjeto(objeto);
        setMetodo(methodo);
        setArgs(args);
        if (permissionCheck != 0) {
            ActivityCompat.requestPermissions(objs.variaveisBasicas.getActivityAtual(), new String[]{permissao}, 1);
        } else {
            objs.funcoesBasicas.log("Permissao " + permissao + " existente");
            this.executar();
        }
    }

    public static void setContexto(Context pContexto) {
        FuncoesPermissao.contexto = pContexto;
    }

    public static void setObjeto(Object pObjeto) {
        FuncoesPermissao.objeto = pObjeto;
    }

    public static void setMetodo(Method pMetodo) {
        FuncoesPermissao.metodo = pMetodo;
    }

    public static void setArgs(Object[] pArgs) {
        FuncoesPermissao.args = pArgs;
    }

    public static ArrayList<String> getListaTodasPermissoes() {
        return listaTodasPermissoes;
    }

    public static void setListaTodasPermissoes(ArrayList<String> pListaTodasPermissoes) {
        FuncoesPermissao.listaTodasPermissoes = pListaTodasPermissoes;
    }

    public static ArrayList<String> getListaPermissoesManifest() {
        return listaPermissoesManifest;
    }

    public static void setListaPermissoesManifest(ArrayList<String> pListaPermissoesManifest) {
        FuncoesPermissao.listaPermissoesManifest = pListaPermissoesManifest;
    }
}

