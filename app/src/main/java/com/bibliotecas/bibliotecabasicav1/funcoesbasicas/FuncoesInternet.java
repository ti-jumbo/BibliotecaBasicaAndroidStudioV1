package com.bibliotecas.bibliotecabasicav1.funcoesbasicas;

import android.Manifest;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.StrictMode;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.async.BaseDownloadAssincrono;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.lang.reflect.Method;
import java.util.ArrayList;

public class FuncoesInternet extends FuncoesBase {
    private static String cnome = "FuncoesInternet";
    private static FuncoesInternet uFuncoesInternet;
    private static String tipoConexaoAtual = "";
    private static String ipExterno = "";
    private static ArrayList<String> ipsWebServicesExternos = null;
    private static String ipWebService = "";
    private static String ipWebServiceInterno = "";
    private static String ipWebServiceExterno = "";
    private static Boolean conectado = false;


    private FuncoesInternet(Context pContexto, ArrayList<String> pIpsWebServiceExternos, String pIpWebServiceExterno, String pIpWebServiceInterno) {
        super(pContexto);
        try {
            String fnome = "FuncoesInternet";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
            this.ipsWebServicesExternos = pIpsWebServiceExternos;
            this.ipWebServiceExterno = pIpWebServiceExterno;
            this.ipWebServiceInterno = pIpWebServiceInterno;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static synchronized FuncoesInternet getInstancia() {
        try {
            return getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesInternet getInstancia(Context pContexto) {
        try {
            return getInstancia(pContexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static synchronized FuncoesInternet getInstancia(Context vContexto, ArrayList<String> pIpsWebServiceExternos, String pIpWebServiceExterno, String pIpWebServiceInterno) {
        try {
            if (uFuncoesInternet == null) {
                uFuncoesInternet = new FuncoesInternet(vContexto, pIpsWebServiceExternos, pIpWebServiceExterno, pIpWebServiceInterno);
            } else {
                if (pIpsWebServiceExternos != null && pIpsWebServiceExternos.size() > 0) {
                    ipsWebServicesExternos = pIpsWebServiceExternos;
                }
                if (pIpWebServiceExterno != null && pIpWebServiceExterno.length() > 0) {
                    ipWebServiceExterno = pIpWebServiceExterno;
                }
                if (pIpWebServiceInterno != null && pIpWebServiceInterno.length() > 0) {
                    ipWebServiceInterno = pIpWebServiceInterno;
                }
            }

            return uFuncoesInternet;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static Boolean VerificarConexao() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).VerificarConexao(false);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public static Boolean VerificarConexao(Boolean atualizar_ip_externo) {
        try {
            Boolean retorno = false;
            if (contexto != null) {
                ConnectivityManager cm = (ConnectivityManager) contexto.getSystemService(Context.CONNECTIVITY_SERVICE);
                if (cm != null) {
                    NetworkInfo ni = cm.getActiveNetworkInfo();
                    retorno = ni != null && ni.isConnected();
                    if (retorno == true) {
                        //objs.funcoesBasicas.log("" + ni.getType() + " " + ConnectivityManager.TYPE_WIFI + " " + FuncoesInternet.getTipoConexaoAtual());
                        FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setConectado(true);
                        if (ni.getType() == ConnectivityManager.TYPE_WIFI) {
                            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setTipoConexaoAtual("wifi");
                        } else {
                            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setTipoConexaoAtual("dados_moveis");
                        }
                        if (atualizar_ip_externo == true || FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipExterno == "") {
                            try {
                                FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).atualizar_ip_externo();
                            } catch (IOException e) {
                                e.printStackTrace();
                            } catch (NoSuchMethodException e) {
                                e.printStackTrace();
                            }
                        }

                    } else {
                        FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setConectado(false);
                        FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setTipoConexaoAtual("sem conexao");
                    }
                } else {
                    FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setConectado(false);
                    FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setTipoConexaoAtual("sem conexao");
                }
            } else {
                FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setConectado(false);
                FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setTipoConexaoAtual("sem conexao");
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }
    public static String atualizar_ip_externo() throws IOException, NoSuchMethodException {
        try {
            String retorno = null;
            try {
                if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getConectado() == true) {
                    if (!FuncoesPermissao.getInstancia(contexto).checarPermissao(Manifest.permission.INTERNET)) {
                        objs.funcoesBasicas.mostrarmsg("tem internet");
                    }
                    Document document = (Document) Jsoup.connect("http://ipinfo.io/ip").get();
                    Elements corpo = document.getElementsByTag("body");
                    retorno = corpo.text();
                    String mascara = "\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}";
                    if (retorno.matches(mascara)) {
                        FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setIpExterno(corpo.text());
                    } else {
                        retorno = null;
                        FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setIpExterno("");
                    }
                    document = null;
                    corpo = null;
                    mascara = null;
                } else {
                    FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setIpExterno("");
                }
            } catch (Exception e) {
                FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setIpExterno("");
                objs.funcoesBasicas.log("a verificacao de ipexterno falhou:" + e.getMessage());
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String getIpExterno() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipExterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setIpExterno(String pIpExterno) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipExterno = pIpExterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setIpWebServiceExterno(String pIpWebServiceExterno) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebServiceExterno = pIpWebServiceExterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setIpWebServiceInterno(String pIpWebServiceInterno) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebServiceInterno = pIpWebServiceInterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static void setTipoConexaoAtual(String pTipoConexaoAtual) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).tipoConexaoAtual = pTipoConexaoAtual;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static String getTipoConexaoAtual() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).tipoConexaoAtual;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setConectado(Boolean pConectado) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).conectado = pConectado;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static Boolean getConectado() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).conectado;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

    public void atualizar_ip_webservice() {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).VerificarConexao(true);
            String ipwebservice = "";
            if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getConectado()==true){
                if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getTipoConexaoAtual() == "dados_moveis") {
                    ipwebservice = FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpWebServiceExterno();
                } else if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getTipoConexaoAtual() == "wifi") {
                    if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpsWebServicesExternos() != null &&
                            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpsWebServicesExternos().indexOf(FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpExterno()) > -1) {
                        ipwebservice = FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpWebServiceInterno();
                    } else {
                        ipwebservice = FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getIpWebServiceExterno();
                    }
                } else {

                }
            }
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).setIpWebService(ipwebservice);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static ArrayList<String> getIpsWebServicesExternos() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipsWebServicesExternos;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static String getIpWebServiceInterno() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebServiceInterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static void setIpWebService(String pIpWebService) {
        try {
            FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebService = pIpWebService;//FuncoesInternet.getInstancia(contexto).getIpExterno();//ipWebService;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public static String getIpWebServiceExterno() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebServiceExterno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static String getIpWebService() {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).ipWebService;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Elements obter_conteudo_html(String endereco) {
        try {
            return FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).obter_conteudo_html(endereco,false);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public static Elements obter_conteudo_html(String endereco, Boolean checar_conexao){
        try {
            Elements retorno = new Elements();
            if (checar_conexao == true) {
                FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).VerificarConexao();
            }
            if (FuncoesInternet.getInstancia(contexto,ipsWebServicesExternos,ipWebServiceExterno,ipWebServiceInterno).getConectado() == true) {
                Document document = null;
                try {
                    document = (Document) Jsoup.connect(endereco).get();
                } catch (IOException e) {
                    e.printStackTrace();
                }
                if (document != null) {
                    retorno = document.getElementsByTag("body");
                }
            }
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    public static boolean efetuar_download(String endereco, String destino, Object objetoAoConcluir, Method metodoAoConcluir){
        try {
            String fnome = "efetuar_download";
            objs.funcoesBasicas.logi(cnome,fnome);
            boolean retorno = false;
            objs.funcoesBasicas.log("efetuando download de " + endereco + " para " + destino);
            //DownloadFileFromURL download = new DownloadFileFromURL();
            BaseDownloadAssincrono download = new BaseDownloadAssincrono(contexto);
            download.setCaminhoOrigem(endereco);
            download.setCaminhoDestino(destino);
            download.setObjetoExecutarAoConcluir(objetoAoConcluir);
            download.setMetodoExecutarAoConcluir(metodoAoConcluir);
            download.execute(endereco);
            objs.funcoesBasicas.logf(cnome,fnome);
            return retorno;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return false;
        }
    }

}