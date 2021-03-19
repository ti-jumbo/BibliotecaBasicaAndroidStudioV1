package com.bibliotecas.bibliotecabasicav1.requisicoes;

import android.content.Context;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import javax.net.ssl.HttpsURLConnection;

public class TComHttp extends TComHttpBase {
    private static String cnome = "TComHttp";
    Boolean interromper = false;

    public TComHttp(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "TComHttp";
            contexto = pContexto;
            objs = ObjetosBasicos.getInstancia(contexto);
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.contexto != null) {
                System.out.println("contexto recebido de: " + this.contexto.getPackageName());
            } else {
                System.out.println("contexto recebido de: nulo");
            }
            this.passaParams = true;
            this.metodoReq = "POST";
            JSONObject qual = new JSONObject();
            qual.put("comando","");
            qual.put("tipo_objeto","");
            qual.put("objeto","");
            qual.put("tabela","");
            qual.put("campo","");
            qual.put("valor","");
            qual.put("codusur","");
            qual.put("condicionantes",new ArrayList<String>());
            JSONObject requisitar = new JSONObject();
            requisitar.put("oque","");
            requisitar.put("qual",qual);
            JSONObject requisicao = new JSONObject();
            requisicao.put("requisitar",requisitar);
            this.req = new JSONObject();
            this.req.put("requisicao",requisicao);
            JSONObject dados_retornados = new JSONObject();
            dados_retornados.put("conteudo_html","");
            JSONObject retorno = new JSONObject();
            retorno.put("dados_retornados",dados_retornados);
            this.req.put("retorno",retorno);
            this.interromper = false;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    private String getPostDataString(HashMap<String, String> params) throws UnsupportedEncodingException {
        try {
            String fnome = "getPostDataString";
            objs.funcoesBasicas.logi(cnome,fnome);
            StringBuilder feedback = new StringBuilder();
            boolean first = true;
            if (params != null) {
                for (Map.Entry<String, String> entry : params.entrySet()) {
                    if (first)
                        first = false;
                    else
                        feedback.append("&");

                    feedback.append(URLEncoder.encode(entry.getKey(), "UTF-8"));
                    feedback.append("=");
                    feedback.append(URLEncoder.encode(entry.getValue(), "UTF-8"));
                }
            }
            objs.funcoesBasicas.log("PARAMETROS: " + params.toString());
            objs.funcoesBasicas.logf(cnome,fnome);
            return feedback.toString();
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }
    public void getData(URL... urls) throws IOException {
        try {
            String fnome = "getData";
            objs.funcoesBasicas.logi(cnome,fnome);
            HashMap<String, String> params = new HashMap<>();
            this.req.getJSONObject("requisicao").getJSONObject("requisitar").getJSONObject("qual").put("codusur",objs.variaveis.getCodusur());
            //String requisicao = objs.variaveisBasicas.gson.toJson(this.req.requisicao);
            String requisicao = this.req.getJSONObject("requisicao").toString();

            objs.funcoesBasicas.log(requisicao);
            params.put("requisicao", requisicao);
            URL url = null;
            objs.funcoesInternet.atualizar_ip_webservice();
            if (objs.funcoesInternet.getConectado() == true ) {
                this.interromper = false;
                if (urls == null || urls.length == 0) {
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService());
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService().toString().matches("[0-9]"));
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}"));
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}."));
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}"));
                    objs.funcoesBasicas.log(objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{1,5}"));
                    if (objs.funcoesInternet.getIpWebService() != null && (objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}") || objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{1,5}")) ) {
                        url = new URL("http://" + objs.funcoesInternet.getIpWebService() + "/SisJD/php/funcoes/requisicao/requisicaows.php");
                    } else {
                        this.interromper = true;
                        objs.funcoesBasicas.log("ipexterno invalido: " + objs.funcoesInternet.getIpWebService());
                        objs.funcoesBasicas.mostrarmsg("ipexterno invalido: " + objs.funcoesInternet.getIpWebService());
                    }
                } else {
                    objs.funcoesBasicas.log(urls);
                    url = urls[0];
                }
                objs.funcoesBasicas.log("ipwebservice: " + objs.funcoesInternet.getIpWebService());
                objs.funcoesBasicas.log("requisitando a: " + url);
                client = null;
                try {
                    client = (HttpURLConnection) url.openConnection();
                    client.setRequestMethod(this.metodoReq);
                    client.setDoOutput(true);
                    int timeout = Integer.parseInt(objs.funcoesSisBib.obter_opcao_banco("tempo_espera_requisicoes","15000"));
                    client.setConnectTimeout(timeout);
                    OutputStream os = client.getOutputStream();
                    BufferedWriter writer = new BufferedWriter(
                            new OutputStreamWriter(os, "UTF-8"));
                    if (this.passaParams == true) {
                        writer.write(getPostDataString(params));
                    } else {
                        writer.write(getPostDataString(null));
                    }
                    writer.flush();
                    writer.close();
                    os.close();
                    objs.funcoesBasicas.log("" + String.valueOf(writer));
                    objs.funcoesBasicas.log("" + "CODIGO DE RESPOSTA: " + this.getRespCode());
                    if (this.getRespCode() == HttpsURLConnection.HTTP_OK) {
                        String line;
                        BufferedReader br = new BufferedReader(new InputStreamReader(client.getInputStream()));
                        while ((line = br.readLine()) != null) {
                            response += line;
                        }
                    } else {
                        response = "";
                    }
                    objs.funcoesBasicas.log("resposta: " + response);
                } catch (Exception e) {
                    objs.funcoesBasicas.log(e);
                    e.printStackTrace();
                    objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                    objs.funcoesBasicas.mostrarmsg("Erro ao efetuar requisicao:  " + e.getMessage(),1000);
                } finally {
                    if (client != null) // Make sure the connection is not null.
                        client.disconnect();
                }
            } else {
                this.interromper = true;
                try {
                    objs.variaveis.getFuncretreqLoc().invoke(objs.variaveis.getObjretreqLocal(), this,null,0);
                } catch (Exception e) {
                    objs.funcoesBasicas.log(e);
                    e.printStackTrace();
                    objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                    objs.funcoesBasicas.log("Erro ao invocar methodo de retorno local:  " + objs.variaveis.getFuncretreqLoc().getName() + " " + e.getMessage());
                }
            }
            objs.funcoesBasicas.log("CODIGO DE RESPOSTA: " + this.getRespCode());
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    @Override
    protected Long doInBackground(URL... urls) {
        try {
            String fnome = "doInBackground";
            objs.funcoesBasicas.logi(cnome,fnome);
            try {
                getData(urls);
            } catch(java.net.SocketException e) {
                if (this.getRespCode() == 0 ) {
                    //PERCA DE CONEXAO
                    this.interromper = true;
                }
                e.printStackTrace();
            } catch (Exception e) {
                objs.funcoesBasicas.log(e);
                e.printStackTrace();
                objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                objs.funcoesBasicas.mostrarmsg("Erro ao requisitar dados:  " + e.getMessage(),1000);
            }
            // This counts how many bytes were downloaded
            final byte[] result = response.getBytes();
            Long numOfBytes = Long.valueOf(result.length);
            objs.funcoesBasicas.logf(cnome,fnome);
            return numOfBytes;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return null;
        }
    }

    protected void onPostExecute(Long result) {
        try {
            String fnome = "onPostExecute";
            objs.funcoesBasicas.logi(cnome,fnome);
            try {
                if (this.interromper == false) {
                    // This is just printing it to the console for now.
                    Integer pinijson = 0;
                    pinijson = response.indexOf("{");
                    if (pinijson > -1) {
                        response = response.substring(pinijson);
                        objs.funcoesBasicas.log("transformando respota json",response);
                        this.req = new JSONObject(response);//objs.variaveisBasicas.gson.fromJson(response, TReq.class);
                        try {
                            objs.funcoesBasicas.log("objetoretorno: " + objs.variaveis.getObjRetReq().getClass().getName());
                            objs.funcoesBasicas.log("funcaoretorno: " + objs.variaveis.getFuncRetReq().getName());
                            objs.variaveis.getFuncRetReq().invoke(objs.variaveis.getObjRetReq(), this, null, 0);
                        } catch (Exception e) {
                            objs.funcoesBasicas.log(e);
                            e.printStackTrace();
                            objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                            objs.funcoesBasicas.mostrarmsg("Erro ao invacar metodo de retorno: metodo: " + objs.variaveis.getFuncRetReq().getName()+ " " + e.getMessage(),1000);
                        }
                    } else {
                        if (this.getRespCode() == 0) {
                            this.interromper = true;
                            objs.funcoesBasicas.mostrarmsg("conexao perdida");
                            objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                        } else {
                            objs.funcoesBasicas.log("" + "retorno invalido, sem chave de abertura de json:" + response + " responseCode: " + responseCode);
                            objs.funcoesBasicas.mostrarmsg(response);
                            objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                        }
                    }
                } else {
                    objs.funcoesBasicas.mostrarmsg("sem conexao");
                    objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                }
            } catch(Exception e) {
                objs.funcoesBasicas.log(e);
                objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                objs.funcoesBasicas.mostrarmsg(e.getMessage(),1000);
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public int getRespCode(){
        try {
            String fnome = "getRespCode";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (this.client != null) {
                try {
                    this.responseCode = this.client.getResponseCode();
                } catch (Exception e) {
                    objs.funcoesBasicas.log(e);
                    e.printStackTrace();
                    objs.funcoesTela.esconder_carregando(objs.variaveis.getObjRetReq());
                    objs.funcoesBasicas.mostrarmsg("Erro ao receber retorno de requisicao:  " + e.getMessage(),1000);
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return this.responseCode;
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            return 0;
        }
    }
}
