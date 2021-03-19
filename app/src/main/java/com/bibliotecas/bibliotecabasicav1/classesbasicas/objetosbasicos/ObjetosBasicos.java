package com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesArray;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesBasicas;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesConversao;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesDados;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesData;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesHardware;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesInternet;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesLocalizacao;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesMatematica;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesObjeto;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesPermissao;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesRequisicao;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesSisBib;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesSpinner;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesString;
import com.bibliotecas.bibliotecabasicav1.funcoesbasicas.FuncoesTela;
import com.bibliotecas.bibliotecabasicav1.sql.TSql;
import com.bibliotecas.bibliotecabasicav1.variaveis.Variaveis;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisBasicas;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisEstaticas;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisNomesClasses;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisNomesSql;
import com.bibliotecas.bibliotecabasicav1.variaveis.VariaveisValoresPadrao;

public class ObjetosBasicos {
    private static String cnome = "ObjetosBasicos";
    private static ObjetosBasicos uObjetosBasicos;
    public static FuncoesBasicas funcoesBasicas;
    public static VariaveisEstaticas variaveisEstaticas = null;
    public static VariaveisNomesClasses variaveisNomesClasses = null;
    public static VariaveisNomesSql variaveisNomesSql = null;
    public static VariaveisBasicas variaveisBasicas = null;
    public static VariaveisValoresPadrao variaveisValoresPadrao = null;
    public static Variaveis variaveis = null;
    public static TSql sql = null;
    public static FuncoesSisBib funcoesSisBib = null;
    public static FuncoesRequisicao funcoesRequisicao = null;
    public static FuncoesSpinner funcoesSpinner = null;
    public static FuncoesMatematica funcoesMatematica = null;
    public static FuncoesTela funcoesTela = null;
    public static FuncoesData funcoesData = null;
    public static FuncoesArray funcoesArray = null;
    public static FuncoesObjeto funcoesObjeto = null;
    public static FuncoesConversao funcoesConversao = null;
    public static FuncoesLocalizacao funcoesLocalizacao = null;
    public static FuncoesDados funcoesDados = null;
    public static FuncoesPermissao funcoesPermissao = null;
    public static FuncoesHardware funcoesHardware = null;
    public static FuncoesString funcoesString = null;
    public static FuncoesInternet funcoesInternet = null;
    private static boolean estaEmInicializacao = false;
    private static String nomeAppDB = "sis";
    protected static Context contexto = null;


    public ObjetosBasicos(Context pContexto) {
        try {
            String fnome = "ObjetosBasicos";
            FuncoesBasicas.log("Inicio " + cnome + "." + fnome);
            inicializarObjetos(this,pContexto);
            FuncoesBasicas.log("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public ObjetosBasicos(Context pContexto,String pNomeAppDB) {
        try {
            String fnome = "ObjetosBasicos";
            FuncoesBasicas.log("Inicio " + cnome + "." + fnome);
            nomeAppDB = pNomeAppDB;
            inicializarObjetos(this,pContexto);
            FuncoesBasicas.log("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static synchronized ObjetosBasicos getInstancia() {
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized ObjetosBasicos getInstancia(Context vContexto) {
        try {
            if (uObjetosBasicos == null) {
                uObjetosBasicos = new ObjetosBasicos(vContexto);
            }
            return uObjetosBasicos;
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(e);
            return null;
        }
    }

    /*este eh o metodo que deve ser chamado externamente, pois a variavel nomeappdb eh utilizada em muitas consultas padrao sql*/
    public static synchronized ObjetosBasicos getInstancia(Context vContexto, String pNomeAppDB) {
        try {
            VariaveisNomesSql.nomeappdb = pNomeAppDB;
            if (uObjetosBasicos == null) {
                uObjetosBasicos = new ObjetosBasicos(vContexto, pNomeAppDB);
                uObjetosBasicos.variaveisNomesSql.nomeappdb = pNomeAppDB;
                uObjetosBasicos.variaveisNomesSql.getInstancia(vContexto,pNomeAppDB).nomeappdb = pNomeAppDB;
            }
            return uObjetosBasicos;
        } catch (Exception e) {
            FuncoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void inicializarObjetos(ObjetosBasicos pThis, Context pContexto){
        try {
            String fnome = "inicializarObjetos";
            FuncoesBasicas.log("Inicio " + cnome + "." + fnome);
            contexto = pContexto;
            uObjetosBasicos = pThis;
            if (estaEmInicializacao == false) {
                estaEmInicializacao = true;
                if (funcoesBasicas == null) {
                    funcoesBasicas = FuncoesBasicas.getInstancia(contexto);
                }
                if (variaveisEstaticas == null) {
                    variaveisEstaticas = VariaveisEstaticas.getInstancia(contexto);
                }
                if (variaveisEstaticas == null) {
                    variaveisEstaticas = VariaveisEstaticas.getInstancia(contexto);
                }
                if (variaveisNomesClasses == null) {
                    variaveisNomesClasses = VariaveisNomesClasses.getInstancia(contexto);
                }
                if (variaveisNomesSql == null) {
                    variaveisNomesSql = VariaveisNomesSql.getInstancia(contexto,nomeAppDB);
                }
                if (variaveisBasicas == null) {
                    variaveisBasicas = VariaveisBasicas.getInstancia(contexto);
                }
                if (variaveisValoresPadrao == null) {
                    variaveisValoresPadrao = VariaveisValoresPadrao.getInstancia(contexto);
                }

                if (variaveis == null) {
                    variaveis = Variaveis.getInstancia(contexto);
                }
                if (sql == null) {
                    sql = variaveis.getSql(contexto);
                }
                if (funcoesSisBib == null) {
                    funcoesSisBib = funcoesSisBib.getInstancia(contexto);
                }
                if (funcoesRequisicao == null) {
                    funcoesRequisicao = FuncoesRequisicao.getInstancia(contexto);
                }
                if (funcoesSpinner == null) {
                    funcoesSpinner = FuncoesSpinner.getInstancia(contexto);
                }
                if (funcoesMatematica == null) {
                    funcoesMatematica = FuncoesMatematica.getInstancia(contexto);
                }
                if (funcoesTela == null) {
                    funcoesTela = FuncoesTela.getInstancia(contexto);
                }
                if (funcoesData == null) {
                    funcoesData = FuncoesData.getInstancia(contexto);
                }
                if (funcoesArray == null) {
                    funcoesArray = FuncoesArray.getInstancia(contexto);
                }
                if (funcoesObjeto == null) {
                    funcoesObjeto = FuncoesObjeto.getInstancia(contexto);
                }
                if (funcoesConversao == null) {
                    funcoesConversao = FuncoesConversao.getInstancia(contexto);
                }
                if (funcoesLocalizacao == null) {
                    funcoesLocalizacao = FuncoesLocalizacao.getInstancia(contexto);
                }
                if (funcoesDados == null) {
                    funcoesDados = FuncoesDados.getInstancia(contexto);
                }
                if (funcoesPermissao == null) {
                    funcoesPermissao = FuncoesPermissao.getInstancia(contexto);
                }
                if (funcoesHardware == null) {
                    funcoesHardware = FuncoesHardware.getInstancia(contexto);
                }
                if (funcoesString == null) {
                    funcoesString = FuncoesString.getInstancia(contexto);
                }
                if (funcoesInternet == null) {
                    funcoesInternet = FuncoesInternet.getInstancia(contexto);
                }
                estaEmInicializacao = false;
            }
            FuncoesBasicas.log("Fim " + cnome + "." + fnome);
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

}
