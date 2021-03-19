package com.bibliotecas.bibliotecabasicav1.requisicoes;

import android.content.Context;
import android.text.Html;

import com.bibliotecas.bibliotecabasicav1.classesbasicas.async.BaseTarefaAssincrona;
import com.bibliotecas.bibliotecabasicav1.classesbasicas.objetosbasicos.ObjetosBasicos;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.lang.reflect.Method;
import java.net.ConnectException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import javax.net.ssl.HttpsURLConnection;

public class TComHttpSimples extends TComHttpBase {
    private String cnome = "TComHttpSimples";
    private int statusRequisicao = 0;
    /*
    0 - nao requisitada
    1 - requisitada
    2 - aguardando resposta
    3 - recebida com sucesso
    4 - recebida com retorno invalido
    5 - conexao perdida
    6 - sem conexao
    7 - requisicao cancelada
    9 - falha
     */
    private Object objetoRetorno = null;
    private Method metodoRetorno = null;
    private Object objetoRetornoFalha = null;
    private Method metodoRetornoFalha = null;
    private Object objetoRetornoSemConexao = null;
    private Method metodoRetornoSemConexao = null;
    private Object objetoRetornoConexaoPerdida = null;
    private Method metodoRetornoConexaoPerdida = null;
    private Object objetoRetornoRequisicaoCancelada = null;
    private Method metodoRetornoRequisicaoCancelada = null;
    private Object objetoRetornoRetornoRequsicaoInvalido = null;
    private Method metodoRetornoRetornoRequsicaoInvalido = null;
    private boolean temConexao = false;
    private boolean conexaoInterrompida = false;
    public ArrayList<String> mensagensErroServidor = null;
    private int timeOut = 0;
    private Object dados = null;
    public boolean async = false;

    public TComHttpSimples(Context pContexto) {
        super(pContexto);
        try {
            String fnome = "getRespCode";
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
            this.req = new JSONObject();
            this.req.put("a","");
            this.req.put("b","");
            this.req.put("c","");
            this.req.put("r",null);
            this.temConexao = false;
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }
    private String getPostDataString(HashMap<String, String> params) throws UnsupportedEncodingException {
        try {
            String fnome = "getPostDataString";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (!isCancelled()) {
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
                objs.funcoesBasicas.logf(cnome,fnome);
                return feedback.toString();
            } else {
                invocarMetodoRetornoRequisicaoCancelada();
                objs.funcoesBasicas.logf(cnome,fnome);
                return null;
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            invocarMetodoFalha();
            return null;
        }
    }

    /*
        @Description Executada primeiro, quando chamado o meto onExecute da classe
     */
    @Override
    protected Long doInBackground(URL... urls) {
        try {
            String fnome = "doInBackground";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (!isCancelled()) {
                try {
                    getData(urls);
                } catch (java.net.SocketException e) {
                    if (this.getRespCode() == 0) {
                        //PERCA DE CONEXAO
                        this.conexaoInterrompida = true;
                    }
                    e.printStackTrace();
                } catch (Exception e) {
                    objs.funcoesBasicas.log(e);
                    e.printStackTrace();
                    invocarMetodoFalha();
                }
                // This counts how many bytes were downloaded
                final byte[] result = response.getBytes();
                Long numOfBytes = Long.valueOf(result.length);
                objs.funcoesBasicas.logf(cnome,fnome);
                return numOfBytes;
            } else {
                invocarMetodoRetornoRequisicaoCancelada();
                objs.funcoesBasicas.logf(cnome,fnome);
                return null;
            }
        } catch (Exception e) {
            invocarMetodoFalha();
            return null;
        }
    }

    /*
        @Description executada por doInBackground, é a conexao efetivamente
     */

    public void getData(URL... urls) throws IOException {
        try {
            String fnome = "getData";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (!isCancelled()) {
                HashMap<String, String> params = new HashMap<>();
                String requisicao = this.req.toString();//objs.variaveisBasicas.gson.toJson(this.req);
                params.put("r", requisicao);
                URL url = null;
                objs.funcoesInternet.atualizar_ip_webservice();
                if (objs.funcoesInternet.getConectado() == true) {
                    this.temConexao = true;
                    this.conexaoInterrompida = false;
                    if (urls == null || urls.length == 0) {
                        if (objs.funcoesInternet.getIpWebService() != null && (objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}") || objs.funcoesInternet.getIpWebService().toString().matches("[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}:[0-9]{1,5}"))) {
                            url = new URL("http://" + objs.funcoesInternet.getIpWebService() + "/SisJD/php/funcoes/requisicao/requisicao_simples.php");
                        } else {
                            this.temConexao = false;
                            objs.funcoesBasicas.log("ipexterno invalido: " + objs.funcoesInternet.getIpWebService());
                            objs.funcoesBasicas.mostrarmsg("ipexterno invalido: " + objs.funcoesInternet.getIpWebService());
                        }
                    } else {
                        url = urls[0];
                    }
                    objs.funcoesBasicas.log("requisitando a: " , url);
                    objs.funcoesBasicas.log("parametros: " , params);
                    client = null;
                    try {
                        client = (HttpURLConnection) url.openConnection();
                        client.setRequestMethod(this.metodoReq);
                        client.setDoOutput(true);
                        if (this.timeOut > 0) {
                            client.setConnectTimeout(this.timeOut);
                        } else {
                            int timeout = Integer.parseInt(objs.funcoesSisBib.getInstancia(contexto).obter_opcao_banco("tempo_espera_requisicoes", String.valueOf(objs.variaveisValoresPadrao.tempo_espera_requisicoes)));
                            client.setConnectTimeout(timeout);
                        }
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
                        if (this.getRespCode() == HttpsURLConnection.HTTP_OK) {
                            String line;
                            BufferedReader br = new BufferedReader(new InputStreamReader(client.getInputStream()));
                            while ((line = br.readLine()) != null) {
                                response += line;
                            }
                        } else {
                            response = "";
                        }
                    } catch (ConnectException e) {
                        this.conexaoInterrompida = true;
                        objs.funcoesBasicas.log(e);
                        e.printStackTrace();
                        if (e.getMessage().contains("REFUSED")) {
                            objs.funcoesBasicas.mostrarErro(e,"O servidor está recusando conexoes");
                        }
                    } catch (Exception e) {
                        objs.funcoesBasicas.log(e);
                        e.printStackTrace();
                        if (e.getMessage().contains("REFUSED")) {
                            objs.funcoesBasicas.mostrarErro(e,"O servidor está recusando conexoes");
                        }
                    } finally {
                        if (client != null) // Make sure the connection is not null.
                            client.disconnect();
                    }
                } else {
                    this.temConexao = false;
                }
            } else {
                invocarMetodoRetornoRequisicaoCancelada();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            invocarMetodoFalha();
        }
    }

    /*
        @Description exeuctada ao receber o retorno da requisicao ou se sem conexao imediatamente apos get data
     */
    protected void onPostExecute(Long result) {
        try {
            String fnome = "onPostExecute";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (!isCancelled()) {
                try {
                    objs.funcoesBasicas.log(response);
                    if (this.temConexao == true ) {
                        if (this.conexaoInterrompida == false) {
                            // This is just printing it to the console for now.
                            Integer pinijson = 0;
                            pinijson = response.indexOf("{");
                            if (pinijson > -1) {
                                response = response.substring(pinijson);
                                response = Html.fromHtml(response).toString(); //converte caracteres &Ntilde para caracteres acentuados correspondentes
                                //this.req.r = objs.variaveisBasicas.gson.fromJson(response, Object.class);
                                this.req.put("r",new JSONObject(response));
                                objs.funcoesBasicas.log(this.req.getJSONObject("r"));
                                //objs.funcoesBasicas.log(this.req.r.getJSONObject("dados"));
                                //objs.funcoesBasicas.log(this.req.r.getJSONObject("dados").getJSONObject("tabela"));
                                //objs.funcoesBasicas.log(this.req.r.getJSONObject("dados").getJSONObject("tabela").getJSONObject("titulo"));
                                //objs.funcoesBasicas.log(this.req.r.getJSONObject("dados").getJSONObject("tabela").getJSONObject("titulo").getJSONArray("arr_tit"));
                                //objs.funcoesBasicas.log(this.req.r.getJSONObject("dados").getJSONObject("tabela").getJSONArray("dados"));
                                try {
                                    invocarMetodoRetorno();
                                } catch (Exception e) {
                                    objs.funcoesBasicas.log(e);
                                    e.printStackTrace();
                                    objs.funcoesTela.esconder_carregando(this.getObjetoRetorno());
                                    objs.funcoesBasicas.mostrarAlert("Erro ao invacar metodo de retorno: metodo: " + this.getMetodoRetorno().getName() + " " + e.getMessage());
                                }
                            } else {
                                /*
                                    O retorno veio sem abertura de json {
                                */
                                if (this.getRespCode() == 0) {
                                    this.conexaoInterrompida = true;
                                    objs.funcoesBasicas.log("invocando 1");
                                    this.invocarMetodoRetornoConexaoPerdida();
                                } else {
                                    objs.funcoesBasicas.log("" + "retorno invalido, sem chave de abertura de json:" + response + " responseCode: " + responseCode);
                                    /*
                                        provavel ocorrencia de erro esperado no servidor php, impresso com a funcao 'mostrar_erro_e_sair',
                                        que imprime um array com os dados do erro, tentar converter essa impressao para json para ler aqui e mostrar ao usuario e gravar na
                                        tabela de erros.
                                    */
                                    objs.funcoesBasicas.log(response);
                                    this.decodificar_erro_servidor();
                                    invocarMetodoRetornoRetornoRequisicaoInvalido();
                                }
                            }
                        } else {
                            objs.funcoesBasicas.log("invocando 2");
                            this.invocarMetodoRetornoConexaoPerdida();//invocarMetodoRetornoLocal();
                        }
                    } else {
                        this.invocarMetodoRetornoSemConexao();//invocarMetodoRetornoLocal();
                    }
                } catch (Exception e) {
                    objs.funcoesBasicas.log(e);
                    this.invocarMetodoFalha();
                }
            } else {
                this.invocarMetodoRetornoRequisicaoCancelada();
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
            this.invocarMetodoFalha();
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
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
            return this.responseCode;
        } catch (Exception e) {
            return 0;
        }
    }

    private void decodificar_erro_servidor() {
        try {
            if (response.trim().length() > 0) {
                if (response.indexOf("<pre>") > -1 && response.indexOf("[") > -1) {
                    response = response.trim();
                    response = response.replace("<pre>", "").replace("</pre>", "");
                    response = response.substring(0, response.length() - 1);
                    response = response.replace("Array(", "");
                    response = response.replaceAll("(\\[)([\\w\\s\\:\\_\\-\\d]+)(\\]\\s+\\=\\>)", "\",\"$2\":\"");
                    response = response.trim();
                    response = "{" + response.substring(response.indexOf("\",") + 2) + "\"" + "}";
                    response = response.replace("\\", "\\\\");
                    //ObjectMapper omap = new ObjectMapper();
                    //omap.configure(JsonParser.Feature.ALLOW_UNQUOTED_CONTROL_CHARS, true);
                    //Map objmap = null;
                    //objmap = omap.readValue(response, Map.class);
                    //Set set = objmap.keySet();
                    //Object[] cnjKeys = set.toArray();
                    /*int qt = cnjKeys.length;
                    this.mensagensErroServidor = new ArrayList<String>();
                    String chave = null;
                    for (int i = 0; i < qt; i++) {
                        chave = cnjKeys[i].toString();*/
                    this.mensagensErroServidor = new ArrayList<String>();
                    this.mensagensErroServidor.add(response);
                    //}
                }
            }
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodo(Method metodo, Object objeto){
        try {
            String fnome = "invocarMetodo";
            objs.funcoesBasicas.logi(cnome,fnome);
            if (metodo != null) {
                if (this.async == false) {
                    metodo.invoke(objeto, this);
                } else {
                    BaseTarefaAssincrona tf = new BaseTarefaAssincrona(contexto);
                    tf.setMetodoExecutar(metodo);
                    tf.setObjetoExecutar(objeto);
                    tf.setObjetoParametro(new Object[]{this});
                    tf.execute(this);
                }
            }
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoRetorno(){
        try {
            String fnome = "invocarMetodoRetorno";
            objs.funcoesBasicas.logi(cnome,fnome);
            /*
            0 - nao requisitada
            1 - requisitada
            2 - aguardando resposta
            3 - recebida com sucesso
            4 - recebida com retorno invalido
            5 - conexao perdida
            6 - sem conexao
            7 - requisicao cancelada
            9 - falha
             */
            this.statusRequisicao = 3;
            this.invocarMetodo(this.metodoRetorno,this.objetoRetorno);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoFalha(){
        try {
            String fnome = "invocarMetodoFalha";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.statusRequisicao = 9;
            this.invocarMetodo(this.metodoRetornoFalha,this.objetoRetornoFalha);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoRetornoSemConexao(){
        try {
            String fnome = "invocarMetodoRetornoSemConexao";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.statusRequisicao = 6;
            this.invocarMetodo(this.metodoRetornoSemConexao,this.objetoRetornoSemConexao);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoRetornoConexaoPerdida(){
        try {
            String fnome = "invocarMetodoRetornoConexaoPerdida";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.statusRequisicao = 5;
            this.invocarMetodo(this.metodoRetornoConexaoPerdida,this.objetoRetornoConexaoPerdida);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoRetornoRetornoRequisicaoInvalido(){
        try {
            String fnome = "invocarMetodoRetornoRetornoRequisicaoInvalido";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.statusRequisicao = 4;
            this.invocarMetodo(this.metodoRetornoRetornoRequsicaoInvalido,this.objetoRetornoRetornoRequsicaoInvalido);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    private void invocarMetodoRetornoRequisicaoCancelada(){
        try {
            String fnome = "invocarMetodoRetornoRequisicaoCancelada";
            objs.funcoesBasicas.logi(cnome,fnome);
            this.statusRequisicao = 7;
            this.invocarMetodo(this.metodoRetornoRequisicaoCancelada,this.objetoRetornoRequisicaoCancelada);
            objs.funcoesBasicas.logf(cnome,fnome);
        } catch (Exception e) {
            objs.funcoesBasicas.mostrarErro(e);
        }
    }

    public Object getObjetoRetorno() {
        return objetoRetorno;
    }

    private void setObjetosRetorno(Object pObjetoRetorno){
        if (this.objetoRetorno == null) {
            this.objetoRetorno = pObjetoRetorno;
        }
        if (this.objetoRetornoFalha == null) {
            this.objetoRetornoFalha = objetoRetorno;
        }
        if (this.objetoRetornoConexaoPerdida == null) {
            this.objetoRetornoConexaoPerdida = objetoRetorno;
        }
        if (this.objetoRetornoRequisicaoCancelada == null) {
            this.objetoRetornoRequisicaoCancelada = objetoRetorno;
        }
        if (this.objetoRetornoRetornoRequsicaoInvalido == null) {
            this.objetoRetornoRetornoRequsicaoInvalido = objetoRetorno;
        }
        if (this.objetoRetornoSemConexao == null) {
            this.objetoRetornoSemConexao = objetoRetorno;
        }
    }

    private void setMetodosRetorno(Method pMetodoRetorno) {
        if (this.metodoRetorno == null) {
            this.metodoRetorno = pMetodoRetorno;
        }
        if (this.metodoRetornoFalha == null) {
            this.metodoRetornoFalha = metodoRetorno;
        }
        if (this.metodoRetornoConexaoPerdida == null) {
            this.metodoRetornoConexaoPerdida = metodoRetorno;
        }
        if (this.metodoRetornoRequisicaoCancelada == null) {
            this.metodoRetornoRequisicaoCancelada = metodoRetorno;
        }
        if (this.metodoRetornoRetornoRequsicaoInvalido == null) {
            this.metodoRetornoRetornoRequsicaoInvalido = metodoRetorno;
        }
        if (this.metodoRetornoSemConexao == null) {
            this.metodoRetornoSemConexao = metodoRetorno;
        }
    }

    public void setObjetoRetorno(Object pObjetoRetorno) {
        this.objetoRetorno = pObjetoRetorno;
        this.setObjetosRetorno(objetoRetorno);
    }

    public Method getMetodoRetorno() {
        return metodoRetorno;
    }

    public void setMetodoRetorno(Method pMetodoRetorno) {
        this.metodoRetorno = pMetodoRetorno;
        this.setMetodosRetorno(metodoRetorno);
    }

    public Object getObjetoRetornoSemConexao() {
        return objetoRetornoSemConexao;
    }

    public void setObjetoRetornoSemConexao(Object pObjetoRetornoSemConexao) {
        objetoRetornoSemConexao = pObjetoRetornoSemConexao;
        this.setObjetosRetorno(objetoRetornoSemConexao);
    }

    public Method getMetodoRetornoSemConexao() {
        return metodoRetornoSemConexao;
    }

    public void setMetodoRetornoSemConexao(Method pMetodoRetornoSemConexao) {
        metodoRetornoSemConexao = pMetodoRetornoSemConexao;
        this.setMetodosRetorno(metodoRetornoSemConexao);
    }

    public Object getObjetoRetornoFalha() {
        return objetoRetornoFalha;
    }

    public void setObjetoRetornoFalha(Object pObjetoRetornoFalha) {
        objetoRetornoFalha = pObjetoRetornoFalha;
        this.setObjetosRetorno(objetoRetornoFalha);
    }

    public Method getMetodoRetornoFalha() {
        return metodoRetornoFalha;
    }

    public void setMetodoRetornoFalha(Method pMetodoRetornoFalha) {
        metodoRetornoFalha = pMetodoRetornoFalha;
        this.setMetodosRetorno(metodoRetornoFalha);
    }

    public Object getObjetoRetornoConexaoPerdida() {
        return objetoRetornoConexaoPerdida;
    }

    public void setObjetoRetornoConexaoPerdida(Object pObjetoRetornoConexaoPerdida) {
        objetoRetornoConexaoPerdida = pObjetoRetornoConexaoPerdida;
        this.setObjetosRetorno(objetoRetornoConexaoPerdida);
    }

    public Method getMetodoRetornoConexaoPerdida() {
        return metodoRetornoConexaoPerdida;
    }

    public void setMetodoRetornoConexaoPerdida(Method pMetodoRetornoConexaoPerdida) {
        metodoRetornoConexaoPerdida = pMetodoRetornoConexaoPerdida;
        this.setMetodosRetorno(metodoRetornoConexaoPerdida);
    }

    public Object getObjetoRetornoRequisicaoCancelada() {
        return objetoRetornoRequisicaoCancelada;
    }

    public void setObjetoRetornoRequisicaoCancelada(Object pObjetoRetornoRequisicaoCancelada) {
        objetoRetornoRequisicaoCancelada = pObjetoRetornoRequisicaoCancelada;
        this.setObjetosRetorno(objetoRetornoRequisicaoCancelada);
    }

    public Method getMetodoRetornoRequisicaoCancelada() {
        return metodoRetornoRequisicaoCancelada;
    }

    public void setMetodoRetornoRequisicaoCancelada(Method pMetodoRetornoRequisicaoCancelada) {
        metodoRetornoRequisicaoCancelada = pMetodoRetornoRequisicaoCancelada;
        this.setMetodosRetorno(metodoRetornoRequisicaoCancelada);
    }

    public Object getObjetoRetornoRetornoRequsicaoInvalido() {
        return objetoRetornoRetornoRequsicaoInvalido;
    }

    public void setObjetoRetornoRetornoRequsicaoInvalido(Object pObjetoRetornoRetornoRequsicaoInvalido) {
        objetoRetornoRetornoRequsicaoInvalido = pObjetoRetornoRetornoRequsicaoInvalido;
        this.setObjetosRetorno(objetoRetornoRetornoRequsicaoInvalido);
    }

    public Method getMetodoRetornoRetornoRequsicaoInvalido() {
        return metodoRetornoRetornoRequsicaoInvalido;
    }

    public void setMetodoRetornoRetornoRequsicaoInvalido(Method pMetodoRetornoRetornoRequsicaoInvalido) {
        metodoRetornoRetornoRequsicaoInvalido = pMetodoRetornoRetornoRequsicaoInvalido;
        this.setMetodosRetorno(metodoRetornoRetornoRequsicaoInvalido);
    }

    public Object getDados() {
        return dados;
    }

    public void setDados(Object pDados) {
        this.dados = pDados;
    }

    public int getStatusRequisicao() {
        return statusRequisicao;
    }

    public void setStatusRequisicao(int pStatusRequisicao) {
        this.statusRequisicao = pStatusRequisicao;
    }

    public int getTimeOut() {
        return timeOut;
    }

    public void setTimeOut(int pTimeOut) {
        this.timeOut = pTimeOut;
    }
}
