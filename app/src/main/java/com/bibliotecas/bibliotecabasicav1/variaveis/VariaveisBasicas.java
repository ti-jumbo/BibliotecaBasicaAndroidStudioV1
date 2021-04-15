package com.bibliotecas.bibliotecabasicav1.variaveis;

import android.content.Context;
import android.widget.ListAdapter;

import androidx.navigation.NavController;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.ClasseBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.dialogo.CaixaDialogoPadrao;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.menu.MenuBase;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;
import com.bibliotecas.bibliotecabasicav1.telas.TelaBase;
import com.bibliotecas.bibliotecabasicav1.telas.fragmentos.FragmentoBase;
import com.bibliotecas.bibliotecabasicav1.tipos.Tipos;
import com.google.android.gms.location.FusedLocationProviderClient;

import java.util.ArrayList;

public class VariaveisBasicas extends ClasseBase {
    private static String cnome = "VariaveisBasicas";
    private static VariaveisBasicas uVariaveisBasicas = null;
    private static TelaBase activityAtual;
    private static TelaBase activityPrincipal;
    private static TelaBase ultimaActivity;
    private static ArrayList<TelaBase> arrActivitys;
    private static boolean sair;
    private static Tipos.TCnjChaveValor<Tipos.TChaveValor<ListAdapter>> listAdapters;
    private static Boolean escolhendousuario = false;
    private static Tipos.TCnjChaveValor<Tipos.TChaveValor<TelaBase>> cnjActitys = null;
    private static Tipos.TCnjChaveValor<Tipos.TChaveValor<FragmentoBase>> cnjFragmentos = null;
    private static FragmentoBase fragmentoCarregamentoInicio;
    private static FragmentoBase fragmentoAtual;
    private static FragmentoBase fragmentoInicio;
    private static FragmentoBase fragmentoLogin;
    private static FragmentoBase fragmentoSincronizar;
    private static NavController navControllerPrincipal = null;
    private static String idSessao = null;
    private static MenuBase menuBaseVisivel = null;
    private static CaixaDialogoPadrao caixaDialogoPadraoVisivel = null;
    private static Tipos.TCnjChaveValor<Tipos.TChaveValor> opcoes;
    private static boolean verificandoSincronizacao = false;
    private static ArrayList<ArrayList<String>> dadosConversa = null;
    private boolean layoutEnviarMensagemVisivel = true;
    private static ArrayList<String> dadosConversaSelecionada = null;
    //private static ArrayList<Integer> indexAtalhosPadrao = new ArrayList<Integer>(Arrays.asList(1));
    private static FusedLocationProviderClient ultimaLocalizacao;

    private static ArrayList<Object> objetos = null;

    public VariaveisBasicas(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "VariaveisBasicas";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.objetos == null) {
                this.objetos = new ArrayList<Object>();
            }
            this.objetos.add(this);
            cnjActitys = new Tipos.TCnjChaveValor<Tipos.TChaveValor<TelaBase>>();
            cnjFragmentos = new Tipos.TCnjChaveValor<Tipos.TChaveValor<FragmentoBase>>();

            //activityAtual = null;
            this.arrActivitys = new ArrayList<TelaBase>();
            this.sair = false;
            this.listAdapters = new Tipos.TCnjChaveValor<Tipos.TChaveValor<ListAdapter>>();
            this.opcoes = new Tipos.TCnjChaveValor<Tipos.TChaveValor>();
            this.inicializarDadosTelas();
            this.inicializarDadosFragmentos();

            //ultimaLocalizacao = LocationServices.getFusedLocationProviderClient(this.contexto);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }



    public static void inicializarDadosTelas(){
        try {
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }




    public static void inicializarDadosFragmentos(){
        try {

        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Tipos.TCnjChaveValor<Tipos.TChaveValor<ListAdapter>> getAdapters() {
        try {
            String fnome = "getAdapters";
            return listAdapters;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized VariaveisBasicas getInstancia(){
        try {
            return getInstancia(contexto);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized VariaveisBasicas getInstancia(Context vContexto){
        try {
            if (uVariaveisBasicas == null) uVariaveisBasicas = new VariaveisBasicas(vContexto);
            return uVariaveisBasicas;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Tipos.TCnjChaveValor<Tipos.TChaveValor<FragmentoBase>> getCnjFragmentos() {
        try {
            return cnjFragmentos;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Tipos.TCnjChaveValor<Tipos.TChaveValor<TelaBase>> getCnjActitys() {
        try {
            return cnjActitys;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static TelaBase getActivityAtual() {
        try {
            return activityAtual;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static TelaBase getActivityPrincipal() {
        try {
            return activityPrincipal;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public static void setActivityAtual(TelaBase pActivityAtual) {
        try {
            String fnome = "setActivityAtual";
            objs.funcoesBasicas.logi(cnome,fnome);
            setUltActivity(getActivityAtual());
            activityAtual = pActivityAtual;
            setElArrActivitys(activityAtual);
            if (activityAtual != null) {
                objs.funcoesBasicas.log("setado activity atual como: " + activityAtual.getClass().getName());
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setActivityPrincipal(TelaBase pActivityPrincipal) {
        try {
            String fnome = "setActivityPrincipal";
            objs.funcoesBasicas.logi(cnome,fnome);
            activityPrincipal = pActivityPrincipal;
            if (activityPrincipal != null) {
                objs.funcoesBasicas.log("setado activity principal como: " + activityPrincipal.getClass().getName());
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setElArrActivitys(TelaBase pElArrActivity) {
        try {
            String fnome = "setElArrActivitys";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (procurar_activity(pElArrActivity) == null)
                arrActivitys.add(pElArrActivity);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setUltActivity(TelaBase pUltActivity) {
        try {
            String fnome = "setUltActivity";
            objs.funcoesBasicas.logi(cnome,fnome);
            ultimaActivity = pUltActivity;
            if (pUltActivity != null) {
                objs.funcoesBasicas.log("setado ultactivity como: " + pUltActivity.getClass().getName());
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static FragmentoBase procurar_fragmento(String nomeClassElProcurar){
        try {
            String fnome = "procurar_fragmento";
            objs.funcoesBasicas.logi(cnome,fnome);
            FragmentoBase elEncontrado = null;
            if (cnjFragmentos != null) {
                Tipos.TChaveValor<FragmentoBase> objeto = cnjFragmentos.procurar(nomeClassElProcurar);
                if (objeto != null) {
                    elEncontrado = (FragmentoBase) objeto.valor;
                } else {
                    objs.funcoesBasicas.mostrarmsg("Fragmento nao encontrado: " + nomeClassElProcurar);
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return elEncontrado;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static TelaBase procurar_activity(TelaBase elProcurar){
        try {
            String fnome = "procurar_activity";
            objs.funcoesBasicas.logi(cnome,fnome);
            TelaBase elEncontrado = null;
            if (arrActivitys != null) {
                for (TelaBase el : arrActivitys) {
                    if (el == elProcurar) {
                        elEncontrado = el;
                        break;
                    }
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return elEncontrado;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Boolean getEscolhendousuario() {
        try {
            return escolhendousuario;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public static void setEscolhendousuario(Boolean pEscolhendousuario) {
        try {
            VariaveisBasicas.escolhendousuario = pEscolhendousuario;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setFragmentoAtual(FragmentoBase pFragmentoAtual) {
        try {
            VariaveisBasicas.fragmentoAtual = pFragmentoAtual;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static FragmentoBase getFragmentoAtual(){
        try {
            return VariaveisBasicas.fragmentoAtual;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setFragmentoInicio(FragmentoBase pFragmentoInicio) {
        try {
            VariaveisBasicas.fragmentoInicio = pFragmentoInicio;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    public static void setFragmentoLogin(FragmentoBase pFragmentoLogin) {
        try {
            VariaveisBasicas.fragmentoLogin = pFragmentoLogin;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static FragmentoBase getFragmentoInicio(){
        try {
            return VariaveisBasicas.fragmentoInicio;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static FragmentoBase getFragmentoLogin(){
        try {
            return VariaveisBasicas.fragmentoLogin;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setNavControllerPrincipal(NavController pNavControllerPrincipal) {
        try {
            VariaveisBasicas.navControllerPrincipal = pNavControllerPrincipal;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setIdSessao(String pIdSessao) {
        try {
            VariaveisBasicas.idSessao = pIdSessao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static String getIdSessao() {
        try {
            return idSessao;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static MenuBase getMenuBaseVisivel() {
        return menuBaseVisivel;
    }

    public static void setMenuBaseVisivel(MenuBase pMenuBaseVisivel) {
        VariaveisBasicas.menuBaseVisivel = pMenuBaseVisivel;
    }

    public static CaixaDialogoPadrao getCaixaDialogoPadraoVisivel() {
        return caixaDialogoPadraoVisivel;
    }

    public static void setCaixaDialogoPadraoVisivel(CaixaDialogoPadrao pCaixaDialogoPadraoVisivel) {
        VariaveisBasicas.caixaDialogoPadraoVisivel = pCaixaDialogoPadraoVisivel;
    }

    public static FragmentoBase getFragmentoSincronizar() {
        return fragmentoSincronizar;
    }

    public static FragmentoBase getFragmentoCarregamentoInicio() {
        return fragmentoCarregamentoInicio;
    }

    public static void setFragmentoSincronizar(FragmentoBase pFragmentoSincronizar) {
        VariaveisBasicas.fragmentoSincronizar = pFragmentoSincronizar;
    }

    public static void setFragmentoCarregamentoInicio(FragmentoBase pFragmentoCarregamentoInicio) {
        VariaveisBasicas.fragmentoCarregamentoInicio = pFragmentoCarregamentoInicio;
    }

    public static Tipos.TCnjChaveValor<Tipos.TChaveValor> getOpcoes() {
        return opcoes;
    }

    public static boolean isVerificandoSincronizacao() {
        return verificandoSincronizacao;
    }

    public static void setVerificandoSincronizacao(boolean pVerificandoSincronizacao) {
        VariaveisBasicas.verificandoSincronizacao = pVerificandoSincronizacao;
    }

    public static Object procurar_objeto(String nomeCompletoClasse) {
        try {
            String fnome = "procurar_objeto";
            objs.funcoesBasicas.logi(cnome,fnome);
            Object retorno = null;
            if (nomeCompletoClasse != null) {
                nomeCompletoClasse = nomeCompletoClasse.trim();
                if (nomeCompletoClasse.length() > 0) {
                    if (objetos != null) {
                        int qt = objetos.size();
                        if (qt > 0) {
                            for (int i = 0; i < qt; i++) {
                                if (objetos.get(i).getClass().getName().trim().equalsIgnoreCase(nomeCompletoClasse)) {
                                    retorno = objetos.get(i);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void adicionarObjeto(Object objeto) {
        if (objetos == null) {
            objetos = new ArrayList<Object>();
        }
        objetos.add(objeto);
    }




}
